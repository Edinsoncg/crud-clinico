import { showFlash, getCsrf, toHHmm } from './helpers.js'

let table = null

export function initTable() {
    table = $('#muestrasTable').DataTable({
        ajax: {
        url: '/muestras/listado/json',
        dataSrc: 'data',
        },
        processing: true,
        responsive: true,
        columns: [
            { data: 'id' },
            { data: 'codigo_muestra' },
            { data: null, render: row => (row.paciente ? `${row.paciente.apellidos} ${row.paciente.nombres}` : '') },
            { data: null, render: row => (row.personal_salud ? `${row.personal_salud.apellidos} ${row.personal_salud.nombres}` : (row.personalSalud ? `${row.personalSalud.apellidos} ${row.personalSalud.nombres}` : '')) },
            { data: row => row.tipo ? row.tipo.nombre : '' },
            { data: row => row.estado ? row.estado.nombre : '' },
            { data: row => (row.fecha_recoleccion ? String(row.fecha_recoleccion).slice(0,10) : '') },
            {
                data: null,
                className: 'text-center',
                orderable: false,
                render: row => `
                <div class="btn-group btn-group-sm">
                    <button class="btn btn-outline-primary btn-edit" data-id="${row.id}" data-codigo="${row.codigo_muestra}">
                    <i class="bi bi-pencil"></i> Editar</button>
                    <button class="btn btn-outline-danger btn-del" data-id="${row.id}" data-codigo="${row.codigo_muestra}">
                    <i class="bi bi-trash"></i> Eliminar</button>
                </div>
                `
            }
        ],
        order: [[0, 'desc']],
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.8/i18n/es-ES.json'
        }
    })

    // Acción editar (cargar datos)
    $('#muestrasTable').on('click', '.btn-edit', function () {
        const id = $(this).data('id')
        $.getJSON(`/muestras/${id}/editar`, function (response) {
            const muestra = response.muestra || response // por si devuelves directamente el modelo
            $('#muestra_id').val(muestra.id)
            $('#codigo_muestra').val(muestra.codigo_muestra)
            $('#paciente_id').val(muestra.paciente_id)
            $('#personal_salud_id').val(muestra.personal_salud_id)
            $('#tipo_muestra_id').val(muestra.tipo_muestra_id)
            $('#estado_muestra_id').val(muestra.estado_muestra_id)
            $('#fecha_recoleccion').val(String(muestra.fecha_recoleccion).slice(0,10))
            $('#hora_recoleccion').val(toHHmm(muestra.hora_recoleccion))
            $('#lugar_recoleccion').val(muestra.lugar_recoleccion || '')
            $('#recolectado_por').val(muestra.recolectado_por || '')
            $('#observaciones').val(muestra.observaciones || '')
            showFlash('Formulario cargado para edición.', 'info', 2500)
            window.scrollTo({ top: 0, behavior: 'smooth' })
        }).fail(xhr => {
            showFlash('No se pudo cargar la muestra para editar.', 'danger', 4500)
            console.error(xhr.responseText)
        })
    })

    // Acción eliminar
    $('#muestrasTable').on('click', '.btn-del', async function () {
        const id = $(this).data('id')
        const codigo = $(this).data('codigo')

        const ok = await window.askConfirm({
            title: 'Eliminar muestra (soft delete)',
            message: `¿Deseas eliminar la muestra <strong>${codigo}</strong>?`,
            okClass: 'btn-danger',
            okText: 'Sí, eliminar'
        })
        if (!ok) return

        $.ajax({
            url: `/muestras/${id}`,
            method: 'POST',
            data: { _method: 'DELETE', _token: getCsrf() },
            dataType: 'json'
        })
        .done(resp => {
            showFlash(resp.message || 'Muestra eliminada.', 'success')
            table.ajax.reload(null, false)
        })
        .fail(xhr => {
            showFlash('No se pudo eliminar la muestra.', 'danger', 4500)
            console.error(xhr.responseText)
        })
    })
}

export function reloadTable(resetPaging = false) {
    if (table) table.ajax.reload(null, resetPaging)
}
