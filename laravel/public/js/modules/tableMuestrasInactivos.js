/* global $, bootstrap */
import { showFlash, getCsrf } from './helpers.js'

let inactivosTable = null

export function initInactivosTable () {
    inactivosTable = $('#inactivosTable').DataTable({
        ajax: {
        url: '/muestras/inactivos',   // el controlador devuelve JSON cuando es AJAX
        dataSrc: 'data'
        },
        processing: true,
        responsive: true,
        columns: [
            { data: 'id' },
            { data: 'codigo_muestra' },
            { data: row => row.paciente ? `${row.paciente.apellidos} ${row.paciente.nombres}` : '' },
            { data: row => row.tipo ? row.tipo.nombre : '' },
            { data: row => row.deleted_at ? String(row.deleted_at).slice(0,16).replace('T',' ') : '' },
            {
                data: null,
                className: 'text-center',
                orderable: false,
                render: row => `
                <div class="btn-group btn-group-sm">
                    <button class="btn btn-outline-success btn-restore" data-id="${row.id}" data-codigo="${row.codigo_muestra}">
                    <i class="bi bi-arrow-counterclockwise"></i> Restaurar
                    </button>
                    <button class="btn btn-outline-danger btn-force" data-id="${row.id}" data-codigo="${row.codigo_muestra}">
                    <i class="bi bi-x-circle"></i> Eliminar definitivo
                    </button>
                </div>
                `
            }
        ],
        order: [[0, 'desc']],
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.8/i18n/es-ES.json'
        }
    })

    // Restaurar
    $('#inactivosTable').on('click', '.btn-restore', async function () {
        const id = $(this).data('id')
        const codigo = $(this).data('codigo')

        const ok = await window.askConfirm({
            title: 'Restaurar muestra',
            message: `¿Deseas restaurar la muestra <strong>${codigo}</strong>?`,
            okClass: 'btn-success',
            okText: 'Sí, restaurar'
        })
        if (!ok) return

        $.ajax({
            url: `/muestras/${id}/restaurar`,
            method: 'POST',
            data: { _method: 'PATCH', _token: getCsrf() }, // opcional si ya tienes ajaxSetup
            dataType: 'json'
        })
        .done(response => {
            showFlash(response.message || 'Muestra restaurada.', 'success')
            reloadInactivosTable(false)
        })
        .fail(xhr => {
            showFlash('No se pudo restaurar la muestra.', 'danger', 4500)
            console.error(xhr.responseText)
        })
    })

  // Eliminar definitivo
    $('#inactivosTable').on('click', '.btn-force', async function () {
        const id = $(this).data('id')
        const codigo = $(this).data('codigo')

        const ok = await window.askConfirm({
        title: 'Eliminar muestra',
        message: `¿Deseas eliminar la muestra <strong>${codigo}</strong> definitivamente?`,
        okClass: 'btn-danger',
        okText: 'Sí, eliminar'
        })
        if (!ok) return

        $.ajax({
            url: `/muestras/${id}/destruir`,
            method: 'POST',
            data: { _method: 'DELETE', _token: getCsrf() }, // opcional si ya tienes ajaxSetup
            dataType: 'json'
        })
        .done(response => {
            showFlash(response.message || 'Eliminada definitivamente.', 'success')
            reloadInactivosTable(false)
        })
        .fail(xhr => {
            showFlash('No se pudo eliminar definitivamente.', 'danger', 4500)
            console.error(xhr.responseText)
        })
    })
}

export function reloadInactivosTable (resetPaging = false) {
    if (inactivosTable) inactivosTable.ajax.reload(null, resetPaging)
}
