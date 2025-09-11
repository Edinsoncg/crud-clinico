// Manejo de eventos para acciones CRUD
export class EventHandler {
    constructor(crudActions) {
        this.crudActions = crudActions;
        this.setupEventListeners();
    }

    setupEventListeners() {
        document.addEventListener('click', this.handleClick.bind(this));
        document.addEventListener('submit', this.handleSubmit.bind(this));
    }

    async handleClick(event) {
        const target = event.target.closest('button, a');
        if (!target) return;

        const actions = {
            'crud-save': () => this.crudActions.save(target),
            'crud-edit': () => this.crudActions.edit(target),
            'crud-delete': () => this.crudActions.delete(target),
            'crud-restore': () => this.crudActions.restore(target),
            'crud-force-delete': () => this.crudActions.forceDelete(target),
            'crud-reset': () => this.crudActions.reset(target)
        };

        for (const [className, handler] of Object.entries(actions)) {
            if (target.classList.contains(className)) {
                event.preventDefault();
                await handler();
                break;
            }
        }
    }

    async handleSubmit(event) {
        const form = event.target;
        if (!form.matches('.crud-form')) return;

        event.preventDefault();

        const submitBtn = form.querySelector('.crud-save');
        if (submitBtn) {
            await this.crudActions.save(submitBtn);
        }
    }
}
