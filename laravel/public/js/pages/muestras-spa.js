import { showFlash, getCsrf } from '../modules/helpers.js'
import { loadSelectOptions } from '../modules/selectsOptionsMuestras.js'
import { initTable, reloadTable } from '../modules/tableMuestras.js'

// Form: crear/actualizar por AJAX
function getFormData() {
    return {
        codigo_muestra: $('#codigo_muestra').val(),
        paciente_id: $('#paciente_id').val(),
        personal_salud_id: $('#personal_salud_id').val(),
        tipo_muestra_id: $('#tipo_muestra_id').val(),
        estado_muestra_id: $('#estado_muestra_id').val(),
        fecha_recoleccion: $('#fecha_recoleccion').val(),
        hora_recoleccion: $('#hora_recoleccion').val(),
        lugar_recoleccion: $('#lugar_recoleccion').val(),
        recolectado_por: $('#recolectado_por').val(),
        observaciones: $('#observaciones').val(),
    }
}

// Limpia el formulario y el id oculto
function resetForm() {
    $('#muestra_id').val('')
    $('#muestrasForm')[0].reset()
}

// Asocia eventos de submit/limpiar y envía create/update por AJAX
function initForm() {
    $('#btnReset').on('click', resetForm)

    $('#muestrasForm').on('submit', function (event) {
        event.preventDefault()
        const id = $('#muestra_id').val()
        const data = getFormData()
        const token = getCsrf()

        let url = '/muestras'
        let method = 'POST'
        let extraFields = {}

        if (id) {
            url = `/muestras/${id}`
            method = 'POST'
            extraFields = { _method: 'PUT' }
        }

    // Confirmación antes de enviar
    askConfirm({
        title: id ? 'Actualizar muestra' : 'Guardar muestra',
        message: id
            ? '¿Deseas actualizar la información de esta muestra?'
            : '¿Deseas registrar esta nueva muestra?',
        okClass: 'btn-success',
        okText: 'Sí, confirmar'
    }).then((confirmed) => {
        if (!confirmed) return

        $.ajax({
            url,
            method,
            data: Object.assign({}, data, extraFields, { _token: token }),
            dataType: 'json'
        })
            .done(response => {
            showFlash(response.message || (id ? 'Actualizada.' : 'Creada.'), 'success')
            reloadTable(null, !id) // si fue create, reposiciona
            if (!id) resetForm()
            })
            .fail(xhr => {
            let msg = 'Error al guardar.'
            const { responseJSON } = xhr
            if (responseJSON?.errors) {
                const lista = Object.values(responseJSON.errors)
                .flat()
                .map(m => `<li>${m}</li>`)
                .join('')
                msg = `<strong>Revisa los errores:</strong><ul class="mb-0">${lista}</ul>`
            }
            showFlash(msg, 'danger', 6000)
            console.error(xhr.responseText)
            })
        })
    })
}


// ========= Ready =========
$(function () {
    loadSelectOptions().then(() => {
        initTable()
        initForm()
    })
})
