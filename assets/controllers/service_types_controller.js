import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['serviceSelect', 'typeField', 'locationField'];

    async loadOptions() {
        const serviceId = this.serviceSelectTarget.value;
        if (!serviceId) return;

        const response = await fetch(`/api/services/${serviceId}`);
        const data = await response.json();

        this.updateSelect(this.typeFieldTarget, data.typesAsArray);
        this.updateSelect(this.locationFieldTarget, data.locationsAsArray);
    }

    updateSelect(select, values) {
        select.innerHTML = '<option value=""></option>';
        for (const v of values) {
            const opt = document.createElement('option');
            opt.value = v;
            opt.textContent = v;
            select.append(opt);
        }
    }
}
