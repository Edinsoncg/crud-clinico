import { setupAjaxCsrf } from '../modules/helpers.js'
import { loadSelectOptions } from '../modules/selectsOptionsPacientes.js'
import { PacientesTableFactory } from '../modules/tables/PacientesTableFactory.js'
import { CrudManager } from '../general/crud-generico.js'

// Inicializar todo cuando el DOM esté listo
$(function () {
    // Configurar CSRF para AJAX
    setupAjaxCsrf()

    // Cargar opciones de selects y después inicializar tabla y CRUD
    loadSelectOptions().then(() => {
        // Inicializar tabla
        const table = PacientesTableFactory.createActiveTable()

        // Inicializar el manager CRUD genérico
        const crudManager = new CrudManager({
            table: table,
            formSelector: '#pacientesForm',
            baseUrl: '/pacientes'
        })

    }).catch(error => {
        console.error('Error al cargar opciones de selects:', error)
    })
})
