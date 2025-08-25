@php
  $isEdit = isset($muestra) && $muestra?->exists;
@endphp

<div class="row g-3">
  <div class="col-12 col-md-4">
    <label class="form-label">Código de muestra</label>
    <input type="text" name="codigo_muestra" class="form-control"
           value="{{ old('codigo_muestra', $muestra->codigo_muestra ?? '') }}"
           required maxlength="50">
  </div>

  <div class="col-12 col-md-4">
    <label class="form-label">Paciente</label>
    <select name="paciente_id" class="form-select" required>
      <option value="">-- Selecciona --</option>
      @foreach($pacientes as $p)
        <option value="{{ $p->id }}" @selected(old('paciente_id', $muestra->paciente_id ?? '') == $p->id)>
          {{ $p->apellidos }} {{ $p->nombres }}
        </option>
      @endforeach
    </select>
  </div>

  <div class="col-12 col-md-4">
    <label class="form-label">Personal de salud</label>
    <select name="personal_salud_id" class="form-select" required>
      <option value="">-- Selecciona --</option>
      @foreach($personal as $ps)
        <option value="{{ $ps->id }}" @selected(old('personal_salud_id', $muestra->personal_salud_id ?? '') == $ps->id)>
          {{ $ps->apellidos }} {{ $ps->nombres }}
        </option>
      @endforeach
    </select>
  </div>

  <div class="col-12 col-md-4">
    <label class="form-label">Tipo de muestra</label>
    <select name="tipo_muestra_id" class="form-select" required>
      <option value="">-- Selecciona --</option>
      @foreach($tipos as $t)
        <option value="{{ $t->id }}" @selected(old('tipo_muestra_id', $muestra->tipo_muestra_id ?? '') == $t->id)>
          {{ $t->nombre }}
        </option>
      @endforeach
    </select>
  </div>

  <div class="col-12 col-md-4">
    <label class="form-label">Estado</label>
    <select name="estado_muestra_id" class="form-select" required>
      <option value="">-- Selecciona --</option>
      @foreach($estados as $e)
        <option value="{{ $e->id }}" @selected(old('estado_muestra_id', $muestra->estado_muestra_id ?? '') == $e->id)>
          {{ $e->nombre }}
        </option>
      @endforeach
    </select>
  </div>

  <div class="col-12 col-md-4">
    <label class="form-label">Fecha recolección</label>
    <input type="date" name="fecha_recoleccion" class="form-control"
           value="{{ old('fecha_recoleccion', $muestra->fecha_recoleccion?->format('Y-m-d')) }}" required>
  </div>

  <div class="col-12 col-md-4">
    <label class="form-label">Hora recolección</label>
    <input type="time" name="hora_recoleccion" class="form-control"
           value="{{ old('hora_recoleccion', $muestra->hora_recoleccion ?? '') }}" required>
  </div>

  <div class="col-12 col-md-4">
    <label class="form-label">Lugar de recolección</label>
    <input type="text" name="lugar_recoleccion" class="form-control"
           value="{{ old('lugar_recoleccion', $muestra->lugar_recoleccion ?? '') }}"
           required maxlength="150">
  </div>

  <div class="col-12 col-md-4">
    <label class="form-label">Recolectado por</label>
    <input type="text" name="recolectado_por" class="form-control"
           value="{{ old('recolectado_por', $muestra->recolectado_por ?? '') }}"
           maxlength="100">
  </div>

  <div class="col-12">
    <label class="form-label">Observaciones</label>
    <textarea name="observaciones" rows="4" class="form-control">{{ old('observaciones', $muestra->observaciones ?? '') }}</textarea>
  </div>

  </div>
</div>
