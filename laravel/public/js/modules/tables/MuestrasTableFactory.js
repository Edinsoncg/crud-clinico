// Factory para crear configuraciones de tabla específicas de muestras
export class MuestrasTableFactory {

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

        return $('#muestrasTable').DataTable({
            ...config,
            ajax: {
                url: '/muestras/listado/json',
                dataSrc: 'data',
            },
            columns: [
                { data: 'id' },
                { data: 'codigo_muestra' },
                {
                    data: null,
                    render: row => (row.paciente ? `${row.paciente.apellidos} ${row.paciente.nombres}` : '')
                },
                {
                    data: null,
                    render: row => (
                        row.personal_salud ? `${row.personal_salud.apellidos} ${row.personal_salud.nombres}` :
                        (row.personalSalud ? `${row.personalSalud.apellidos} ${row.personalSalud.nombres}` : '')
                    )
                },
                { data: row => row.tipo ? row.tipo.nombre : '' },
                { data: row => row.estado ? row.estado.nombre : '' },
                { data: row => (row.fecha_recoleccion ? String(row.fecha_recoleccion).slice(0,10) : '') },
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
                url: '/muestras/inactivos',
                dataSrc: 'data'
            },
            columns: [
                { data: 'id' },
                { data: 'codigo_muestra' },
                {
                    data: row => row.paciente ? `${row.paciente.apellidos} ${row.paciente.nombres}` : ''
                },
                { data: row => row.tipo ? row.tipo.nombre : '' },
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
        return `
            <div class="btn-group btn-group-sm">
                <button class="btn btn-outline-primary crud-edit"
                        data-id="${row.id}"
                        data-codigo="${row.codigo_muestra}"
                        data-edit-url="/muestras/${row.id}/editar"
                        data-load-message="Cargando datos de ${row.codigo_muestra}..."
                        data-scroll-to-form="true">
                    <i class="bi bi-pencil"></i> Editar
                </button>
                <button class="btn btn-outline-danger crud-delete"
                        data-id="${row.id}"
                        data-codigo="${row.codigo_muestra}"
                        data-delete-url="/muestras/${row.id}"
                        data-confirm-title="Eliminar muestra"
                        data-confirm-message="¿Deseas eliminar la muestra <strong>${row.codigo_muestra}</strong>?"
                        data-success-message="Muestra ${row.codigo_muestra} eliminada correctamente">
                    <i class="bi bi-trash"></i> Eliminar
                </button>
            </div>
        `
    }

    static renderInactiveActions(row) {
        return `
            <div class="btn-group btn-group-sm">
                <button class="btn btn-outline-success crud-restore"
                        data-id="${row.id}"
                        data-codigo="${row.codigo_muestra}"
                        data-restore-url="/muestras/${row.id}/restaurar"
                        data-confirm-title="Restaurar muestra"
                        data-confirm-message="¿Deseas restaurar la muestra <strong>${row.codigo_muestra}</strong>?"
                        data-success-message="Muestra ${row.codigo_muestra} restaurada correctamente">
                    <i class="bi bi-arrow-counterclockwise"></i> Restaurar
                </button>
                <button class="btn btn-outline-danger crud-force-delete"
                        data-id="${row.id}"
                        data-codigo="${row.codigo_muestra}"
                        data-force-delete-url="/muestras/${row.id}/destruir"
                        data-confirm-title="Eliminar definitivamente"
                        data-confirm-message="¿Deseas eliminar definitivamente la muestra <strong>${row.codigo_muestra}</strong>? Esta acción no se puede deshacer."
                        data-success-message="Muestra ${row.codigo_muestra} eliminada definitivamente">
                    <i class="bi bi-x-circle"></i> Eliminar definitivo
                </button>
            </div>
        `
    }
}
