// Utilidades centralizadas
import { showFlash } from '../helpers.js';

export class DataExtractor {
    static extractFromElement(element) {
        const data = { ...element.dataset };

        Object.keys(data).forEach(key => {
            if (data[key] === 'true') data[key] = true;
            if (data[key] === 'false') data[key] = false;
        });

        return data;
    }

    static extractEntityData(response) {
        const possibleKeys = ['data'];

        for (const key of possibleKeys) {
            if (response[key]) return response[key];
        }

        return response;
    }
}

export class ErrorHandler {
    static handle(xhr, defaultMessage) {
        console.error('Error AJAX:', xhr);

        let message = defaultMessage;

        if (xhr.responseJSON?.errors) {
            const errorList = Object.values(xhr.responseJSON.errors)
                .flat()
                .map(error => `<li>${error}</li>`)
                .join('');
            message = `<strong>Revisa los errores:</strong><ul class="mb-0">${errorList}</ul>`;
        } else if (xhr.responseJSON?.message) {
            message = xhr.responseJSON.message;
        } else if (xhr.status === 0) {
            message = 'Error de conexión. Verifica tu conexión a internet.';
        } else if (xhr.status === 404) {
            message = 'Endpoint no encontrado (404). Verifica la URL.';
        } else if (xhr.status === 500) {
            message = 'Error interno del servidor (500).';
        }

        showFlash(message, 'danger', 6000);
    }
}

export class ConfirmDialog {
    static async ask(title, message, buttonClass = 'btn-primary', buttonText = 'Sí, continuar') {
        if (typeof window.askConfirm === 'function') {
            return window.askConfirm({
                title,
                message,
                okClass: buttonClass,
                okText: buttonText
            });
        }

        return confirm(`${title}\n${message.replace(/<[^>]*>/g, '')}`);
    }
}
