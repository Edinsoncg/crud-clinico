// confirm-modal.js
document.addEventListener('DOMContentLoaded', () => {
    const modalElement   = document.getElementById('confirmModal')
    if (!modalElement) return

    const modalInstance  = new bootstrap.Modal(modalElement)
    const modalTitleElement   = document.getElementById('confirmTitle')
    const modalBodyElement    = document.getElementById('confirmBody')
    const modalOkBtn     = document.getElementById('confirmOkBtn')

    // API global para confirmar acciones AJAX
    window.askConfirm = function ({
        title   = 'Confirmar acción',
        message = '¿Deseas continuar?',
        okClass = 'btn-primary',
        okText  = 'Sí, continuar',
    } = {}) {
        return new Promise((resolve) => {
        let confirmed = false   // flag para diferenciar aceptar vs cancelar

        const onOk = () => {
            confirmed = true
            cleanup()
            modalInstance.hide()   // cerrar modal al confirmar
            resolve(true)          // resolvemos como "sí"
        }

        const onHide = () => {
            cleanup()
            if (!confirmed) {
            resolve(false)       // solo resolvemos "no" si NO se confirmó
            }
        }

        function cleanup () {
            modalOkBtn.removeEventListener('click', onOk)
            modalElement.removeEventListener('hidden.bs.modal', onHide)
        }

        // Configurar modal dinámicamente
        modalTitleElement.textContent   = title
        modalBodyElement.innerHTML      = message
        modalOkBtn.className            = 'btn ' + okClass
        modalOkBtn.textContent          = okText

        modalOkBtn.addEventListener('click', onOk, { once: true })
        modalElement.addEventListener('hidden.bs.modal', onHide, { once: true })

        modalInstance.show()
        })
    }
})
