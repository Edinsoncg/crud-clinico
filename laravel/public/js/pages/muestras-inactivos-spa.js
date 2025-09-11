import { setupAjaxCsrf } from '../modules/helpers.js'
import { MuestrasTableFactory } from '../modules/tables/MuestrasTableFactory.js'
import { CrudManager } from '../general/crud-generico.js'

// Inicializar todo cuando el DOM esté listo
$(function () {
    // Configurar CSRF para AJAX
    setupAjaxCsrf()

    // Inicializar tabla de inactivos
    const inactivosTable = MuestrasTableFactory.createInactiveTable()

    // Inicializar el manager CRUD genérico para inactivos
    const crudManager = new CrudManager({
        table: inactivosTable,
        baseUrl: '/muestras'
    })

})
