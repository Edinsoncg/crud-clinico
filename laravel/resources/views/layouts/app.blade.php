<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>@yield('title','App')</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- (Opcional) Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

  <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
    <div class="container">
      <a class="navbar-brand" href="{{ url('/') }}">Clínico</a>
      <a class="nav-link text-white" href="{{ route('muestras.listar') }}">Muestras</a>
    </div>
  </nav>

  <main class="container">
    @include('partials.flash')
    @yield('content')
  </main>

  <!-- Modal de confirmación global -->
  <div class="modal fade" id="confirmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="confirmTitle">Confirmar acción</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body" id="confirmBody">¿Deseas continuar?</div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-primary" id="confirmOkBtn">Sí, continuar</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script>
  // Auto-dismiss de alerts
  document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.alert.auto-dismiss').forEach(el => {
      const ms = parseInt(el.dataset.timeout || '4000', 10);
      setTimeout(() => {
        if (window.bootstrap && bootstrap.Alert) {
          bootstrap.Alert.getOrCreateInstance(el).close();
        } else {
          el.classList.remove('show');
          setTimeout(() => el.remove(), 150);
        }
      }, ms);
    });
  });

  // Confirmación global para formularios (.js-confirm) y botones (.js-confirm-btn)
  (() => {
    let pendingForm = null;
    const modalEl = document.getElementById('confirmModal');
    const modal   = new bootstrap.Modal(modalEl);
    const titleEl = document.getElementById('confirmTitle');
    const bodyEl  = document.getElementById('confirmBody');
    const okBtn   = document.getElementById('confirmOkBtn');

    // Formularios con .js-confirm
    document.addEventListener('submit', (e) => {
      const form = e.target.closest('form.js-confirm');
      if (!form) return;
      if (form.dataset.confirmed === 'true') return;

      e.preventDefault();
      pendingForm = form;

      titleEl.textContent = form.dataset.confirmTitle || 'Confirmar acción';
      bodyEl.textContent  = form.dataset.confirmText  || '¿Deseas continuar?';
      okBtn.className     = 'btn ' + (form.dataset.confirmOkClass || 'btn-primary');
      modal.show();
    });

    // Botones reutilizables .js-confirm-btn
    document.addEventListener('click', (e) => {
      const btn = e.target.closest('.js-confirm-btn');
      if (!btn) return;

      e.preventDefault();
      const formId = btn.dataset.targetForm;
      const form = formId ? document.getElementById(formId) : btn.closest('form');
      if (!form) return console.warn('No se encontró <form> para el confirm-button');

      pendingForm = form;
      titleEl.textContent = btn.dataset.confirmTitle || 'Confirmar acción';
      bodyEl.textContent  = btn.dataset.confirmText  || '¿Deseas continuar?';
      okBtn.className     = 'btn ' + (btn.dataset.confirmOkClass || 'btn-primary');
      modal.show();
    });

    okBtn.addEventListener('click', () => {
      if (pendingForm) {
        pendingForm.dataset.confirmed = 'true';
        pendingForm.submit();
        pendingForm = null;
        modal.hide();
      }
    });
  })();
  </script>

  @stack('scripts')
</body>
</html>
