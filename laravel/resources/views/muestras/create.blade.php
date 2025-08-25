@extends('layouts.app')
@section('title','Crear muestra')

@section('content')
<h1 class="h4 mb-3">Crear muestra</h1>

<form id="form-crear" method="POST" action="{{ route('muestras.guardar') }}">
  @csrf

  @include('muestras._form')

  <div class="mt-3 d-flex gap-2">
    <x-confirm-button
      text="Crear"
      variant="success"
      form="form-crear"
      title="Crear muestra"
      message="¿Deseas crear esta muestra?" />
    <a href="{{ route('muestras.listar') }}" class="btn btn-secondary">Cancelar</a>
  </div>
</form>
@endsection
