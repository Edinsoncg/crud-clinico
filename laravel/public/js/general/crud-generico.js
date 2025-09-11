// Sistema genérico mejorado para manejar operaciones CRUD usando clases CSS y data attributes

import { CrudConfig } from '../modules/crud/CrudConfig.js';
import { HttpService } from '../modules/crud/HttpService.js';
import { FormService } from '../modules/crud/FormService.js';
import { TableService } from '../modules/crud/TableService.js';
import { CrudActions } from '../modules/crud/CrudActions.js';
import { EventHandler } from '../modules/crud/EventHandler.js';

export class CrudManager {
    constructor(options = {}) {
        // Mantener compatibilidad con la API existente
        this.config = new CrudConfig(options);

        // Inicializar servicios
        this.httpService = new HttpService(this.config);
        this.formService = new FormService(this.config);
        this.tableService = new TableService(this.config);

        // Inicializar acciones
        this.crudActions = new CrudActions(
            this.config,
            this.httpService,
            this.formService,
            this.tableService
        );

        // Inicializar manejador de eventos
        this.eventHandler = new EventHandler(this.crudActions);
    }

    // API pública compatible con tu código actual
    setTable(tableInstance) {
        this.tableService.setInstance(tableInstance);
        return this;
    }

    addHook(hookName, callback) {
        this.config.hooks[hookName] = callback;
        return this;
    }

    updateConfig(newConfig) {
        Object.assign(this.config, newConfig);
        return this;
    }
}
