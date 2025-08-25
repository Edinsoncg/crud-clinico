{{-- resources/views/muestras/papelera.blade.php --}}
@extends('layouts.app')
@section('title','Papelera')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h1 class="h3">Papelera (muestras eliminadas)</h1>
  <a href="{{ route('muestras.listar') }}" class="btn btn-secondary">Volver a activas</a>
</div>

<div class="card">
  <div class="table-responsive">
    <table class="table table-striped align-middle mb-0">
      <thead>
        <tr>
          <th>ID</th>
          <th>Código</th>
          <th>Paciente</th>
          <th>Tipo</th>
          <th>Eliminada</th>
          <th class="text-end">Acciones</th>
        </tr>
      </thead>
      <tbody>
        @forelse($muestras as $m)
          <tr>
            <td>{{ $m->id }}</td>
            <td>{{ $m->codigo_muestra }}</td>
            <td>{{ optional($m->paciente)->apellidos }} {{ optional($m->paciente)->nombres }}</td>
            <td>{{ optional($m->tipo)->nombre }}</td>
            <td>{{ optional($m->deleted_at)?->format('Y-m-d H:i') }}</td>
            <td class="text-end">
              <form id="rest-{{ $m->id }}" method="POST" action="{{ route('muestras.restaurar', $m->id) }}" class="d-inline">
                @csrf @method('PATCH')
                <x-confirm-button text="Restaurar" variant="success" form="rest-{{ $m->id }}"
                  title="Restaurar" message="¿Restaurar esta muestra?" icon="bi bi-arrow-counterclockwise"/>
              </form>

              <form id="force-{{ $m->id }}" method="POST" action="{{ route('muestras.destruir', $m->id) }}" class="d-inline">
                @csrf @method('DELETE')
                <x-confirm-button text="Eliminar definitivo" variant="danger" form="force-{{ $m->id }}"
                  title="Eliminar definitivamente" message="Esta acción no se puede deshacer. ¿Continuar?" icon="bi bi-x-circle"/>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="6" class="text-center text-muted">No hay elementos en la papelera</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div class="card-footer">{{ $muestras->links() }}</div>
</div>
@endsection
