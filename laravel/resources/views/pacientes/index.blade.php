@extends('layouts.app')
@section('title','Pacientes (SPA)')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-3">Pacientes</h1>
    <div class="d-flex gap-2">
        <a href="{{ route('pacientes.inactivos') }}" class="btn btn-secondary">
            Pacientes Inactivos
        </a>
    </div>
</div>

<div class="card mb-3">
    <div class="card-body">
        <form id="pacientesForm" class="crud-form">
            @csrf
            @include('pacientes._form')
            <div class="mt-3 d-flex gap-2">
                <button type="submit"
                        class="btn btn-success crud-save"
                        data-confirm-title="Guardar paciente"
                        data-confirm-message="¿Deseas guardar este paciente?"
                        data-success-message="Paciente guardado correctamente"
                        data-error-message="Error al guardar el paciente">
                    <i class="bi bi-save"></i> Guardar
                </button>
                <button type="button"
                        class="btn btn-secondary crud-reset"
                        data-form-selector="#pacientesForm">
                    <i class="bi bi-arrow-clockwise"></i> Limpiar
                </button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <table id="pacientesTable" class="table table-striped w-100">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>T. Documento</th>
                    <th>N. Documento</th>
                    <th>Teléfono</th>
                    <th>Género</th>
                    <th>F. Nacimiento</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection

@push('scripts')
    <script type="module" src="{{ asset('js/pages/pacientes-spa.js') }}"></script>
@endpush
