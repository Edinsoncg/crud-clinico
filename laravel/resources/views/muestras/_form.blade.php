@php
  $isEdit = isset($muestra) && $muestra?->exists;
@endphp

{{-- ID oculto para distinguir crear vs actualizar --}}
<input type="hidden" id="muestra_id" name="id" value="">

<div class="row g-3">
    <div class="col-12 col-md-4">
        <label class="form-label">Código de muestra</label>
        <input type="text" id="codigo_muestra" name="codigo_muestra" class="form-control"
            value="" required maxlength="50">
    </div>

    <div class="col-12 col-md-4">
        <label class="form-label">Paciente</label>
        <select id="paciente_id" name="paciente_id" class="form-select" required>
        <option value="">-- Selecciona --</option>
        {{-- opciones por AJAX --}}
        </select>
    </div>

    <div class="col-12 col-md-4">
        <label class="form-label">Personal de salud</label>
        <select id="personal_salud_id" name="personal_salud_id" class="form-select" required>
        <option value="">-- Selecciona --</option>
        {{-- opciones por AJAX --}}
        </select>
    </div>

    <div class="col-12 col-md-4">
        <label class="form-label">Tipo de muestra</label>
        <select id="tipo_muestra_id" name="tipo_muestra_id" class="form-select" required>
        <option value="">-- Selecciona --</option>
        {{-- opciones por AJAX --}}
        </select>
    </div>

    <div class="col-12 col-md-4">
        <label class="form-label">Estado</label>
        <select id="estado_muestra_id" name="estado_muestra_id" class="form-select" required>
        <option value="">-- Selecciona --</option>
        {{-- opciones por AJAX --}}
        </select>
    </div>

    <div class="col-12 col-md-4">
        <label class="form-label">Fecha recolección</label>
        <input type="date" id="fecha_recoleccion" name="fecha_recoleccion" class="form-control" required>
    </div>

    <div class="col-12 col-md-4">
        <label class="form-label">Hora recolección</label>
        <input type="time" id="hora_recoleccion" name="hora_recoleccion" class="form-control" required>
    </div>

    <div class="col-12 col-md-4">
        <label class="form-label">Lugar de recolección</label>
        <input type="text" id="lugar_recoleccion" name="lugar_recoleccion" class="form-control"
            required maxlength="150">
    </div>

    <div class="col-12 col-md-4">
        <label class="form-label">Recolectado por</label>
        <input type="text" id="recolectado_por" name="recolectado_por" class="form-control" maxlength="100">
    </div>

    <div class="col-12">
        <label class="form-label">Observaciones</label>
        <textarea id="observaciones" name="observaciones" rows="4" class="form-control"></textarea>
    </div>
</div>
