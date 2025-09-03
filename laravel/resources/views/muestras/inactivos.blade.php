@extends('layouts.app')
@section('title', 'Inactivos muestras Biologicas (SPA)')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Inactivos muestras biologicas</h1>
    <div class="d-flex gap-2">
        <a href="{{ route('muestras.listar') }}" class="btn btn-secondary">
            ← Volver a activas
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
      <table id="inactivosTable" class="table table-striped w-100">
        <thead>
            <tr>
                <th>ID</th>
                <th>Código</th>
                <th>Paciente</th>
                <th>Tipo</th>
                <th>Eliminada</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>
      </table>
    </div>
</div>
@endsection

@push('scripts')
    <script type="module" src="{{ asset('js/pages/muestras-inactivos-spa.js') }}"></script>
@endpush
