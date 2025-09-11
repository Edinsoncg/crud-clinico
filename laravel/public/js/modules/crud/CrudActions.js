// Acciones CRUD
import { showFlash } from '../helpers.js';
import { DataExtractor, ErrorHandler, ConfirmDialog } from './Utils.js';

export class CrudActions {
    constructor(config, httpService, formService, tableService) {
        this.config = config;
        this.httpService = httpService;
        this.formService = formService;
        this.tableService = tableService;
    }

    async save(button) {
        const data = DataExtractor.extractFromElement(button);
        const formData = this.formService.getFormData(data.formSelector);

        if (this.config.hooks.beforeSave) {
            const shouldContinue = await this.config.hooks.beforeSave(formData, data);
            if (shouldContinue === false) return;
        }

        const idField = this.formService.getIdField(data.formSelector);
        const isUpdate = !!idField.value;
        const operation = isUpdate ? 'update' : 'create';

        const config = {
            url: data.saveUrl || this.httpService.buildUrl(
                this.config.endpoints[operation],
                { id: idField?.value }
            ),
            method: 'POST',
            confirmTitle: data.confirmTitle || (isUpdate ? 'Actualizar registro' : 'Guardar registro'),
            confirmMessage: data.confirmMessage || this.config.messages[operation].confirm,
            successMessage: data.successMessage || this.config.messages[operation].success,
            errorMessage: data.errorMessage || this.config.messages[operation].error
        };

        const confirmed = await ConfirmDialog.ask(config.confirmTitle, config.confirmMessage, 'btn-success');
        if (!confirmed) return;

        const payload = this.httpService.preparePayload(formData, isUpdate ? 'PUT' : 'POST');

        try {
            const response = await this.httpService.makeRequest(config.url, config.method, payload);
            showFlash(response.message || config.successMessage, 'success');

            if (this.config.hooks.afterSave) {
                await this.config.hooks.afterSave(response, operation, formData);
            }

            this.tableService.reload(!isUpdate);

            if (!isUpdate) {
                this.formService.resetForm(data.formSelector);
            }

        } catch (error) {
            ErrorHandler.handle(error, config.errorMessage);
        }
    }

    async edit(button) {
        const data = DataExtractor.extractFromElement(button);

        if (this.config.hooks.beforeEdit) {
            const shouldContinue = await this.config.hooks.beforeEdit(data);
            if (shouldContinue === false) return;
        }

        const config = {
            url: data.editUrl || this.httpService.buildUrl(this.config.endpoints.edit, { id: data.id }),
            loadMessage: data.loadMessage || this.config.messages.load.success
        };

        try {
            const response = await this.httpService.makeRequest(config.url, 'GET');
            const entityData = DataExtractor.extractEntityData(response);

            this.formService.populateForm(entityData, data.formSelector);
            showFlash(config.loadMessage, 'info', 2500);

            if (this.config.hooks.afterEdit) {
                await this.config.hooks.afterEdit(response, entityData);
            }

            if (data.scrollToForm !== 'false') {
                this.formService.scrollToForm(data.formSelector);
            }

        } catch (error) {
            ErrorHandler.handle(error, 'No se pudieron cargar los datos para editar');
        }
    }

    async delete(button) {
        await this.executeGenericAction(button, 'delete', 'DELETE');
    }

    async restore(button) {
        await this.executeGenericAction(button, 'restore', 'PATCH');
    }

    async forceDelete(button) {
        await this.executeGenericAction(button, 'forceDelete', 'DELETE');
    }

    async executeGenericAction(button, action, httpMethod) {
        const data = DataExtractor.extractFromElement(button);
        const messages = this.config.messages[action];

        const hookName = `before${action.charAt(0).toUpperCase() + action.slice(1)}`;
        if (this.config.hooks[hookName]) {
            const shouldContinue = await this.config.hooks[hookName](data);
            if (shouldContinue === false) return;
        }

        const config = {
            url: data[`${action}Url`] || this.httpService.buildUrl(this.config.endpoints[action], { id: data.id }),
            confirmTitle: data.confirmTitle || messages.confirm.split('?')[0],
            confirmMessage: data.confirmMessage || this.buildConfirmMessage(messages.confirm, data),
            successMessage: data.successMessage || messages.success
        };

        const confirmed = await ConfirmDialog.ask(
            config.confirmTitle,
            config.confirmMessage,
            action === 'restore' ? 'btn-success' : 'btn-danger',
            action === 'restore' ? 'Sí, restaurar' : 'Sí, eliminar'
        );

        if (!confirmed) return;

        try {
            const payload = this.httpService.preparePayload({}, httpMethod);
            const response = await this.httpService.makeRequest(config.url, 'POST', payload);

            showFlash(response.message || config.successMessage, 'success');

            const afterHookName = `after${action.charAt(0).toUpperCase() + action.slice(1)}`;
            if (this.config.hooks[afterHookName]) {
                await this.config.hooks[afterHookName](response, data);
            }

            this.tableService.reload(false);

        } catch (error) {
            ErrorHandler.handle(error, messages.error);
        }
    }

    buildConfirmMessage(template, data) {
        const identifier = data.codigo || data.nombre || data.title || data.id;
        return template.replace('{identifier}', identifier);
    }

    reset(button) {
        const data = DataExtractor.extractFromElement(button);
        const formSelector = data.formSelector;

        this.formService.resetForm(formSelector);
        showFlash(this.config.messages.reset.success, 'info', 2000);
    }
}
