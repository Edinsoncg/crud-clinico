// Carga las opciones de selects por AJAX
export function loadSelectOptions() {
    return $.getJSON('/muestras/opciones/json').then(({ tipos, estados, pacientes, personal }) => {

        const $tipo = $('#tipo_muestra_id').empty().append(`<option value="">-- Selecciona --</option>`)
        tipos.forEach(tipo => $tipo.append(`<option value="${tipo.id}">${tipo.nombre}</option>`))

        const $estado = $('#estado_muestra_id').empty().append(`<option value="">-- Selecciona --</option>`)
        estados.forEach(estado => $estado.append(`<option value="${estado.id}">${estado.nombre}</option>`))

        const $paciente = $('#paciente_id').empty().append(`<option value="">-- Selecciona --</option>`)
        pacientes.forEach(paciente => $paciente.append(`<option value="${paciente.id}">${paciente.apellidos} ${paciente.nombres}</option>`))

        const $personal = $('#personal_salud_id').empty().append(`<option value="">-- Selecciona --</option>`)
        personal.forEach(personalSalud => $personal.append(`<option value="${personalSalud.id}">${personalSalud.apellidos} ${personalSalud.nombres}</option>`))
    })
}
