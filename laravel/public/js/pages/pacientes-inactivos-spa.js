import { setupAjaxCsrf } from '../modules/helpers.js'
import { PacientesTableFactory } from '../modules/tables/PacientesTableFactory.js'
import { CrudManager } from '../general/crud-generico.js'

// Inicializar todo cuando el DOM esté listo
$(function () {
    // Configurar CSRF para AJAX
    setupAjaxCsrf()

    // Inicializar tabla de inactivos
    const inactivosTable = PacientesTableFactory.createInactiveTable()

    // Inicializar el manager CRUD genérico para inactivos
    const crudManager = new CrudManager({
        table: inactivosTable,
        baseUrl: '/pacientes'
    })

})
