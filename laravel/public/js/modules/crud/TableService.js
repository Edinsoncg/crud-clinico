// Servicio para tablas
export class TableService {
    constructor(config) {
        this.config = config;
    }

    reload(resetPaging = false) {
        if (this.config.tableInstance?.ajax) {
            this.config.tableInstance.ajax.reload(null, resetPaging);
        }
    }

    setInstance(tableInstance) {
        this.config.tableInstance = tableInstance;
    }
}
