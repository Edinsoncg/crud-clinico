import { setupAjaxCsrf } from '../modules/helpers.js'
import { initInactivosTable } from '../modules/tableMuestrasInactivos.js'

window.addEventListener('DOMContentLoaded', () => {
    // Header global X-CSRF-TOKEN para todas las peticiones AJAX
    setupAjaxCsrf()
    initInactivosTable()
})
