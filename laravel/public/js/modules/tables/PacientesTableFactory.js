// Factory para crear configuraciones de tabla específicas de pacientes
export class PacientesTableFactory {

    static getCommonConfig() {
        return {
            processing: true,
            responsive: true,
            order: [[0, 'desc']],
            language: {
                // Configuración en español directa (sin archivo externo)
                decimal: ",",
                thousands: ".",
                search: "Buscar:",
                lengthMenu: "Mostrar _MENU_ registros",
                info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                infoEmpty: "Mostrando 0 a 0 de 0 registros",
                infoFiltered: "(filtrado de _MAX_ registros totales)",
                infoPostFix: "",
                loadingRecords: "Cargando...",
                zeroRecords: "No se encontraron registros coincidentes",
                emptyTable: "No hay datos disponibles en la tabla",
                paginate: {
                    first: "Primero",
                    last: "Último",
                    next: "Siguiente",
                    previous: "Anterior"
                },
                aria: {
                    sortAscending: ": activar para ordenar la columna ascendente",
                    sortDescending: ": activar para ordenar la columna descendente"
                },
                processing: "Procesando..."
            }
        }
    }

    static createActiveTable() {
        const config = this.getCommonConfig()

        return $('#pacientesTable').DataTable({
            ...config,
            ajax: {
                url: '/pacientes/listado/json',
                dataSrc: 'data',
            },
            columns: [
                { data: 'id' },
                { data: 'nombres' },
                { data: 'apellidos' },
                {
                    data: null,
                    render: row => {
                        const tipoDoc = row.tipo_documento ? row.tipo_documento.nombre :
                                        (row.tipoDocumento ? !row.tipoDocumento.nombre : '');
                        return tipoDoc;
                    }
                },
                { data: 'numero_documento'},
                { data: 'telefono', defaultContent: '' },
                { data: row => row.genero ? row.genero.nombre : '' },
                { data: row => (row.fecha_nacimiento ? String(row.fecha_nacimiento).slice(0,10) : '') },
                {
                    data: null,
                    className: 'text-center',
                    orderable: false,
                    render: row => this.renderActiveActions(row)
                }
            ]
        })
    }

    static createInactiveTable() {
        const config = this.getCommonConfig()

        return $('#inactivosTable').DataTable({
            ...config,
            ajax: {
                url: '/pacientes/inactivos',
                dataSrc: 'data'
            },
            columns: [
                { data: 'id' },
                { data: 'nombres' },
                { data: 'apellidos' },
                {
                    data: null,
                    render: row => {
                        const tipoDoc = row.tipo_documento ? row.tipo_documento.nombre :
                                        (row.tipoDocumento ? row.tipoDocumento.nombre : '');
                        return tipoDoc;
                    }
                },
                { data: 'numero_documento'},
                {
                    data: row => row.deleted_at ? String(row.deleted_at).slice(0,16).replace('T',' ') : ''
                },
                {
                    data: null,
                    className: 'text-center',
                    orderable: false,
                    render: row => this.renderInactiveActions(row)
                }
            ]
        })
    }

    static renderActiveActions(row) {
        const nombreCompleto = `${row.nombres} ${row.apellidos}`;
        return `
            <div class="btn-group btn-group-sm">
                <button class="btn btn-outline-primary crud-edit"
                        data-id="${row.id}"
                        data-nombre="${nombreCompleto}"
                        data-edit-url="/pacientes/${row.id}/editar"
                        data-load-message="Cargando datos de ${nombreCompleto}..."
                        data-scroll-to-form="true">
                    <i class="bi bi-pencil"></i> Editar
                </button>
                <button class="btn btn-outline-danger crud-delete"
                        data-id="${row.id}"
                        data-nombre="${nombreCompleto}"
                        data-delete-url="/pacientes/${row.id}"
                        data-confirm-title="Eliminar paciente"
                        data-confirm-message="¿Deseas eliminar el paciente <strong>${nombreCompleto}</strong>?"
                        data-success-message="Paciente ${nombreCompleto} eliminado correctamente">
                    <i class="bi bi-trash"></i> Eliminar
                </button>
            </div>
        `
    }

    static renderInactiveActions(row) {
        const nombreCompleto = `${row.nombres} ${row.apellidos}`;
        return `
            <div class="btn-group btn-group-sm">
                <button class="btn btn-outline-success crud-restore"
                        data-id="${row.id}"
                        data-nombre="${nombreCompleto}"
                        data-restore-url="/pacientes/${row.id}/restaurar"
                        data-confirm-title="Restaurar paciente"
                        data-confirm-message="¿Deseas restaurar el paciente <strong>${nombreCompleto}</strong>?"
                        data-success-message="Paciente ${nombreCompleto} restaurado correctamente">
                    <i class="bi bi-arrow-counterclockwise"></i> Restaurar
                </button>
                <button class="btn btn-outline-danger crud-force-delete"
                        data-id="${row.id}"
                        data-nombre="${nombreCompleto}"
                        data-force-delete-url="/pacientes/${row.id}/destruir"
                        data-confirm-title="Eliminar definitivamente"
                        data-confirm-message="¿Deseas eliminar definitivamente el paciente <strong>${nombreCompleto}</strong>? Esta acción no se puede deshacer."
                        data-success-message="Paciente ${nombreCompleto} eliminado definitivamente">
                    <i class="bi bi-x-circle"></i> Eliminar definitivo
                </button>
            </div>
        `
    }
}
