@extends('layouts.app')
@section('title','Editar muestra')

@section('content')
<h1 class="h4 mb-3">Editar muestra #{{ $muestra->id }}</h1>

<form id="form-actualizar" method="POST" action="{{ route('muestras.actualizar', $muestra->id) }}">
  @csrf
  @method('PUT')

  @include('muestras._form', ['muestra' => $muestra])

  <div class="mt-3 d-flex gap-2">
    <x-confirm-button
      text="Actualizar"
      variant="warning"
      form="form-actualizar"
      title="Actualizar muestra"
      message="¿Guardar los cambios?" />
    <a href="{{ route('muestras.listar') }}" class="btn btn-secondary">Cancelar</a>
  </div>
</form>
@endsection
