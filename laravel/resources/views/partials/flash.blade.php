@if(session('success'))
  <div class="alert alert-success alert-dismissible fade show auto-dismiss"
       role="alert" data-timeout="3500">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
  </div>
@endif

@if($errors->any())
  <div class="alert alert-danger alert-dismissible fade show auto-dismiss"
       role="alert" data-timeout="6000">
    <strong>Revisa los errores:</strong>
    <ul class="mb-0">
      @foreach($errors->all() as $e)
        <li>{{ $e }}</li>
      @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
  </div>
@endif
