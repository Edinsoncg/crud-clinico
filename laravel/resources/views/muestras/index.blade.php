@extends('layouts.app')

@section('title','Muestras biológicas')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h1 class="h3">Muestras biológicas</h1>
  <a href="{{ route('muestras.crear') }}" class="btn btn-primary">Crear muestra</a>
</div>

<div class="card">
  <div class="table-responsive">
    <table class="table table-striped align-middle mb-0">
      <thead>
        <tr>
          <th>ID</th>
          <th>Código</th>
          <th>Paciente</th>
          <th>Personal de Salud</th>
          <th>Tipo</th>
          <th>Estado</th>
          <th>Fecha</th>
          <th class="text-center">Acciones</th>
        </tr>
      </thead>
      <tbody>
        @forelse($muestras as $m)
          <tr>
            <td>{{ $m->id }}</td>
            <td>{{ $m->codigo_muestra }}</td>
            <td>{{ optional($m->paciente)->apellidos }} {{ optional($m->paciente)->nombres }}</td>
            <td>{{ optional($m->personalSalud)->apellidos }} {{ optional($m->personalSalud)->nombres }}</td>
            <td>{{ optional($m->tipo)->nombre }}</td>
            <td>{{ optional($m->estado)->nombre }}</td>
            <td >{{ \Illuminate\Support\Carbon::parse($m->fecha_recoleccion)->format('Y-m-d') }}</td>
            <td class="text-center">

                <a href="{{ route('muestras.editar',$m) }}" class="btn btn-sm btn-outline-primary">Editar</a>

                <form id="del-{{ $m->id }}" method="POST" action="{{ route('muestras.eliminar', $m->id) }}" class="d-inline">
                    @csrf @method('DELETE')
                    <x-confirm-button
                        text="Eliminar"
                        variant="danger"
                        size="sm"
                        form="del-{{ $m->id }}"
                        title="Eliminar muestra"
                        message=" ¿Desea eliminar esta muestra?"
                        icon="bi bi-trash"
                    />
                </form>

            </td>
          </tr>
        @empty
          <tr><td colspan="7" class="text-center text-muted">Sin registros</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="card-footer">
    {{ $muestras->links() }}
  </div>
</div>
@endsection
