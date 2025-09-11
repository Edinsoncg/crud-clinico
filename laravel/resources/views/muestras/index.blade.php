@extends('layouts.app')
@section('title','Muestras biológicas (SPA)')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-3">Muestras biológicas</h1>
    <div class="d-flex gap-2">
        <a href="{{ route('muestras.inactivos') }}" class="btn btn-secondary">
            Muestras Inactivas
        </a>
    </div>
</div>

<div class="card mb-3">
    <div class="card-body">
        <form id="muestrasForm" class="crud-form">
            @csrf
            @include('muestras._form')
            <div class="mt-3 d-flex gap-2">
                <button type="submit"
                        class="btn btn-success crud-save"
                        data-confirm-title="Guardar muestra"
                        data-confirm-message="¿Deseas guardar esta muestra?"
                        data-success-message="Muestra guardada correctamente"
                        data-error-message="Error al guardar la muestra">
                    <i class="bi bi-save"></i> Guardar
                </button>
                <button type="button"
                        class="btn btn-secondary crud-reset"
                        data-form-selector="#muestrasForm">
                    <i class="bi bi-arrow-clockwise"></i> Limpiar
                </button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <table id="muestrasTable" class="table table-striped w-100">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Código</th>
                    <th>Paciente</th>
                    <th>Personal</th>
                    <th>Tipo</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection

@push('scripts')
    <script type="module" src="{{ asset('js/pages/muestras-spa.js') }}"></script>
@endpush
