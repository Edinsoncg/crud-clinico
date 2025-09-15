@php
    $isEdit = isset($paciente) && $paciente?->exists;
@endphp

{{-- ID oculto para distinguir crear vs actualizar --}}
<input type="hidden" id="paciente_id" name="id" value="" data-id-field>

<div class="row g-3">
    <div class="col-12 col-md-6">
        <label class="form-label">Nombres</label>
        <input type="text" id="nombres" name="nombres" class="form-control"
            value="" required maxlength="100">
    </div>

    <div class="col-12 col-md-6">
        <label class="form-label">Apellidos</label>
        <input type="text" id="apellidos" name="apellidos" class="form-control"
            value="" required maxlength="120">
    </div>

    <div class="col-12 col-md-4">
        <label class="form-label">Tipo de documento</label>
        <select id="tipo_documento_id" name="tipo_documento_id" class="form-select" required>
            <option value="">-- Selecciona --</option>
            {{-- opciones por AJAX --}}
        </select>
    </div>

    <div class="col-12 col-md-4">
        <label class="form-label">Número de documento</label>
        <input type="text" id="numero_documento" name="numero_documento" class="form-control"
            value="" required maxlength="20">
    </div>

    <div class="col-12 col-md-4">
        <label class="form-label">Fecha de nacimiento</label>
        <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" class="form-control"
            value="">
    </div>

    <div class="col-12 col-md-6">
        <label class="form-label">Género</label>
        <select id="genero_id" name="genero_id" class="form-select">
            <option value="">-- Selecciona --</option>
            {{-- opciones por AJAX --}}
        </select>
    </div>

    <div class="col-12 col-md-6">
        <label class="form-label">Teléfono</label>
        <input type="text" id="telefono" name="telefono" class="form-control"
            value="" maxlength="20">
    </div>

    <div class="col-12">
        <label class="form-label">Dirección</label>
        <input type="text" id="direccion" name="direccion" class="form-control"
            value="" maxlength="255">
    </div>
</div>
