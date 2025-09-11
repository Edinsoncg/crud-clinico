// Servicio HTTP para operaciones AJAX
import { getCsrf } from '../helpers.js';

export class HttpService {
    constructor(config) {
        this.config = config;
    }

    async makeRequest(url, method, data = {}) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url,
                method,
                data,
                dataType: 'json'
            })
            .done(resolve)
            .fail(reject);
        });
    }

    buildUrl(endpoint, params = {}) {
        let url = this.config.baseUrl + endpoint;

        Object.keys(params).forEach(key => {
            url = url.replace(`{${key}}`, params[key]);
        });

        return url;
    }

    preparePayload(formData, method = 'POST') {
        const payload = { ...formData, _token: getCsrf(this.config.selectors?.form) };

        if (method === 'PUT' || method === 'PATCH' || method === 'DELETE') {
            payload._method = method;
        }

        return payload;
    }
}
