// Carga las opciones de selects por AJAX para pacientes
export function loadSelectOptions() {
    return $.getJSON('/pacientes/opciones/json').then(({ tipos_documento, generos }) => {

        const $tipoDocumento = $('#tipo_documento_id').empty().append(`<option value="">-- Selecciona --</option>`)
        tipos_documento.forEach(tipo => $tipoDocumento.append(`<option value="${tipo.id}">${tipo.nombre}</option>`))

        const $genero = $('#genero_id').empty().append(`<option value="">-- Selecciona --</option>`)
        generos.forEach(genero => $genero.append(`<option value="${genero.id}">${genero.nombre}</option>`))
    })
}
