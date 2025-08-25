@props([
  'text' => 'Guardar',
  'variant' => 'primary',   // primary | warning | danger | success...
  'size' => null,           // sm | lg (opcional)
  'form' => null,           // id del <form> al que enviará
  'title' => 'Confirmar acción',
  'message' => '¿Deseas continuar?',
  'icon' => null,           // ej: 'bi bi-trash'
  'class' => '',            // clases extra
])

<button type="button"
  {{ $attributes->merge([
    'class' => 'btn btn-'.$variant.' '.($size ? 'btn-'.$size : '').' js-confirm-btn '.$class
  ]) }}
  data-confirm-title="{{ $title }}"
  data-confirm-text="{{ $message }}"
  data-confirm-ok-class="btn-{{ $variant }}"
  @if($form) data-target-form="{{ $form }}" @endif
>
  @if($icon)
    <i class="{{ $icon }}"></i>
  @endif
  {{ $text }}
</button>
