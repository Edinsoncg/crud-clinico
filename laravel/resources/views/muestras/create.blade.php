<!doctype html>
<html>
<body>
<h1>Crear muestra</h1>

@if ($errors->any())
  <div style="color:red">
    <ul>
      @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
    </ul>
  </div>
@endif

<form method="POST" action="{{ route('muestras.guardar') }}">
  @csrf

  <label>Código</label>
  <input name="codigo_muestra" value="{{ old('codigo_muestra') }}" required maxlength="50">

  <label>Paciente</label>
  <select name="paciente_id" required>
    <option value="">-- Seleccione --</option>
    @foreach($pacientes as $p)
      <option value="{{ $p->id }}">{{ $p->apellidos }}, {{ $p->nombres }}</option>
    @endforeach
  </select>

  <label>Personal de salud</label>
  <select name="personal_salud_id" required>
    <option value="">-- Seleccione --</option>
    @foreach($personal as $ps)
      <option value="{{ $ps->id }}">{{ $ps->apellidos }}, {{ $ps->nombres }}</option>
    @endforeach
  </select>

  <label>Tipo de muestra</label>
  <select name="tipo_muestra_id" required>
    <option value="">-- Seleccione --</option>
    @foreach($tipos as $t)
      <option value="{{ $t->id }}">{{ $t->nombre }}</option>
    @endforeach
  </select>

  <label>Estado</label>
  <select name="estado_muestra_id" required>
    <option value="">-- Seleccione --</option>
    @foreach($estados as $e)
      <option value="{{ $e->id }}">{{ $e->nombre }}</option>
    @endforeach
  </select>

  <label>Fecha recolección</label>
  <input type="date" name="fecha_recoleccion" required value="{{ old('fecha_recoleccion') }}">

  <label>Hora recolección</label>
  <input type="time" name="hora_recoleccion" required value="{{ old('hora_recoleccion') }}">

  <label>Lugar recolección</label>
  <input name="lugar_recoleccion" required maxlength="150" value="{{ old('lugar_recoleccion') }}">

  <label>Recolectado por</label>
  <input name="recolectado_por" required maxlength="100" value="{{ old('recolectado_por') }}">

  <label>Observaciones</label>
  <textarea name="observaciones">{{ old('observaciones') }}</textarea>

  <button type="submit">Guardar</button>
</form>
</body>
</html>
