@extends('layouts.app')
@section('title', 'Inactivos Pacientes (SPA)')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Inactivos Pacientes</h1>
    <div class="d-flex gap-2">
        <a href="{{ route('pacientes.listar') }}" class="btn btn-secondary">
            ← Volver a activos
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <table id="inactivosTable" class="table table-striped w-100">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>T. Documento</th>
                    <th>N. Documento</th>
                    <th>Eliminado</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection

@push('scripts')
    <script type="module" src="{{ asset('js/pages/pacientes-inactivos-spa.js') }}"></script>
@endpush
