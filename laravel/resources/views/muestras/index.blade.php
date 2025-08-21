<!doctype html>
<html>
<body>
<h1>Muestras</h1>

<a href="{{ route('muestras.crear') }}">Crear</a>

<table border="1" cellpadding="6">
  <thead>
    <tr>
      <th>ID</th><th>Código</th><th>Paciente</th><th>Tipo</th><th>Estado</th><th>Acciones</th>
    </tr>
  </thead>
  <tbody>
  @foreach($muestras as $m)
    <tr>
      <td>{{ $m->id }}</td>
      <td>{{ $m->codigo_muestra }}</td>
      <td>{{ optional($m->paciente)->apellidos }}, {{ optional($m->paciente)->nombres }}</td>
      <td>{{ optional($m->tipo)->nombre }}</td>
      <td>{{ optional($m->estado)->nombre }}</td>
      <td>
        <a href="{{ route('muestras.editar',$m) }}">Editar</a>
        <form action="{{ route('muestras.eliminar',$m) }}" method="POST" style="display:inline">
          @csrf @method('DELETE')
          <button type="submit">Eliminar</button>
        </form>
      </td>
    </tr>
  @endforeach
  </tbody>
</table>

{{ $muestras->links() }}
</body>
</html>
