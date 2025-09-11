import { setupAjaxCsrf } from '../modules/helpers.js'
import { loadSelectOptions } from '../modules/selectsOptionsMuestras.js'
import { MuestrasTableFactory } from '../modules/tables/MuestrasTableFactory.js'
import { CrudManager } from '../general/crud-generico.js'

// Inicializar todo cuando el DOM esté listo
$(function () {
    // Configurar CSRF para AJAX
    setupAjaxCsrf()

    // Cargar opciones de selects y después inicializar tabla y CRUD
    loadSelectOptions().then(() => {
        // Inicializar tabla
        const table = MuestrasTableFactory.createActiveTable()

        // Inicializar el manager CRUD genérico
        const crudManager = new CrudManager({
            table: table,
            formSelector: '#muestrasForm',
            baseUrl: '/muestras'
        })

    }).catch(error => {
        console.error('Error al cargar opciones de selects:', error)
    })
})
