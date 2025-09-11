// Muestra alertas de Bootstrap de manera temporal
export function showFlash(message, type = 'success', timeoutMs = 3500) {
    const container = document.querySelector('main.container') || document.body

    // Verificar si ya hay una alerta activa
    let alertDiv = container.querySelector('.alert.auto-dismiss')

    if (!alertDiv) {
        alertDiv = document.createElement('div')
        alertDiv.className = `alert alert-${type} alert-dismissible fade show auto-dismiss`
        alertDiv.setAttribute('role', 'alert')
        alertDiv.innerHTML = `
            <span class="alert-message">${message}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        `
        container.prepend(alertDiv)
    } else {
        // Si ya existe, solo actualizamos el texto y el tipo
        alertDiv.className = `alert alert-${type} alert-dismissible fade show auto-dismiss`
        alertDiv.querySelector('.alert-message').textContent = message
    }

    // Reiniciar temporizador
    clearTimeout(alertDiv.dismissTimer)
    alertDiv.dismissTimer = setTimeout(() => {
        if (window.bootstrap && bootstrap.Alert) {
            bootstrap.Alert.getOrCreateInstance(alertDiv).close()
        } else {
            alertDiv.classList.remove('show')
            setTimeout(() => alertDiv.remove(), 150)
        }
    }, timeoutMs)
}

// Obtener token CSRF desde meta tag o formulario
export function getCsrf(formSelector = null) {
    // Primero intentar desde formulario específico
    if (formSelector) {
        const input = document.querySelector(`${formSelector} input[name="_token"]`)
        if (input?.value) return input.value
    }

    // Luego desde cualquier formulario
    const input = document.querySelector('input[name="_token"]')
    if (input?.value) return input.value

    // Finalmente desde meta tag
    const meta = document.querySelector('meta[name="csrf-token"]')
    return meta ? meta.getAttribute('content') : ''
}

export function setupAjaxCsrf() {
    const token = getCsrf()
    if (window.$ && token) {
        window.$.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': token }
        })
    }
}
