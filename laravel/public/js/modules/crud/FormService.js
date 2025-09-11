// Servicio de formularios
export class FormService {
    constructor(config) {
        this.config = config;
    }

    getFormData(formSelector = null) {
        const form = this.getForm(formSelector);
        if (!form) return;

        const formData = new FormData(form);
        const data = {};

        for (const [key, value] of formData.entries()) {
            if (key === '_token') continue;

            if (data[key]) {
                if (Array.isArray(data[key])) {
                    data[key].push(value);
                } else {
                    data[key] = [data[key], value];
                }
            } else {
                data[key] = value;
            }
        }

        // Agregar checkboxes no marcados como false
        form.querySelectorAll('input[type="checkbox"]:not(:checked)').forEach(checkbox => {
            if (!data[checkbox.name]) {
                data[checkbox.name] = false;
            }
        });

        return data;
    }

    populateForm(data, formSelector = null) {
        const form = this.getForm(formSelector);
        if (!form) return;

        Object.keys(data).forEach(key => {
            const field = form.querySelector(`#${key}`) ||
                          form.querySelector(`[name="${key}"]`);

            if (field) {
                this.setFieldValue(field, key, data[key]);
            }
        });

        const idField = this.getIdField(formSelector);
        if (idField && data.id) {
            idField.value = data.id;
        }
    }

    resetForm(formSelector = null) {
        const form = this.getForm(formSelector);
        if (form) {
            form.reset();
            const idField = this.getIdField(formSelector);
            if (idField) {
                idField.value = '';
            }
        }
    }

    getForm(formSelector = null) {
        return formSelector ?
               document.querySelector(formSelector) :
               document.querySelector(this.config.selectors.form);
    }

    getIdField(formSelector = null) {
        const form = this.getForm(formSelector);
        if (!form) return null;

        return form.querySelector(this.config.selectors.idField) ||
               form.querySelector('[name="id"]') ||
               form.querySelector('#id');
    }

    setFieldValue(field, fieldName, value) {
        if (field.type === 'checkbox') {
            field.checked = !!value;
        } else if (field.type === 'radio') {
            field.checked = field.value == value;
        } else {
            field.value = this.formatFieldValue(fieldName, value);
        }
    }

    formatFieldValue(fieldName, value) {
        if (!value) return '';

        for (const [pattern, formatter] of Object.entries(this.config.fieldFormatters)) {
            if (fieldName.includes(pattern)) {
                return formatter(value);
            }
        }

        return value;
    }

    scrollToForm(formSelector = null) {
        const form = this.getForm(formSelector);
        if (form) {
            form.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }
}
