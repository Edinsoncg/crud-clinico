// Configuraciones centralizadas del CRUD
export class CrudConfig {
    constructor(options = {}) {
        this.baseUrl = options.baseUrl || '';
        this.endpoints = {
            list: '',
            create: '',
            edit: '/{id}/editar',
            update: '/{id}',
            delete: '/{id}',
            restore: '/{id}/restaurar',
            forceDelete: '/{id}/destruir',
            ...options.endpoints
        };

        this.selectors = {
            form: options.formSelector || '.crud-form',
            idField: options.idFieldSelector || '[data-id-field]',
            ...options.selectors
        };

        this.messages = {
            create: {
                confirm: '¿Deseas guardar este nuevo registro?',
                success: 'Registro creado correctamente',
                error: 'Error al crear el registro'
            },
            update: {
                confirm: '¿Deseas actualizar este registro?',
                success: 'Registro actualizado correctamente',
                error: 'Error al actualizar el registro'
            },
            delete: {
                confirm: '¿Deseas eliminar este registro?',
                success: 'Registro eliminado correctamente',
                error: 'No se pudo eliminar el registro'
            },
            restore: {
                confirm: '¿Deseas restaurar este registro?',
                success: 'Registro restaurado correctamente',
                error: 'No se pudo restaurar el registro'
            },
            forceDelete: {
                confirm: '¿Deseas eliminar definitivamente este registro? Esta acción no se puede deshacer.',
                success: 'Registro eliminado definitivamente',
                error: 'No se pudo eliminar definitivamente'
            },
            reset: { success: 'Formulario limpiado' },
            load: { success: 'Datos cargados correctamente' },
            ...options.messages
        };

        this.fieldFormatters = {
            fecha: (value) => value ? value.slice(0, 10) : '',
            hora: (value) => value ? value.slice(0, 5) : '',
            datetime: (value) => value ? value.slice(0, 16).replace('T', ' ') : '',
            ...options.fieldFormatters
        };

        this.hooks = options.hooks || {};
        this.tableInstance = options.table || null;
    }
}
