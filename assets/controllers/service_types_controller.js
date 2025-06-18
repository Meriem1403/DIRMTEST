import { Controller } from '@hotwired/stimulus'
import "core-js/modules/web.url-search-params.js";

export default class extends Controller {
    static targets = ['serviceSelect', 'typeSelect', 'locationSelect']

    // Quand on change de service
    async render() {
        const serviceId = this.serviceSelectTarget?.value
        if (!serviceId) return

        try {
            const response = await fetch(`/api/services/${serviceId}`)
            if (!response.ok) throw new Error('Failed to fetch service data')

            const data = await response.json()
            const types = data.types || []
            const locations = data.locations || []

            this.loadData(this.typeSelectTarget, types)
            this.loadData(this.locationSelectTarget, locations)
        } catch (error) {
            console.error('Error fetching service data:', error)
        }
    }

    // Si on veut forcer un rechargement manuel des types (facultatif)
    loadTypeData() {
        const serviceId = this.serviceSelectTarget?.value
        if (!serviceId) return

        fetch(`/api/services/${serviceId}`)
            .then(res => res.json())
            .then(data => {
                this.loadData(this.typeSelectTarget, data.types || [])
            })
            .catch(err => console.error('Type fetch error:', err))
    }

    // Idem pour les locations
    loadLocationData() {
        const serviceId = this.serviceSelectTarget?.value
        if (!serviceId) return

        fetch(`/api/services/${serviceId}`)
            .then(res => res.json())
            .then(data => {
                this.loadData(this.locationSelectTarget, data.locations || [])
            })
            .catch(err => console.error('Location fetch error:', err))
    }

    // Génère dynamiquement les cases à cocher
    loadData(target, values) {
        target.innerHTML = ''
        values.forEach(value => {
            const id = `${target.id}_${value}`

            const checkbox = document.createElement('input')
            checkbox.type = 'checkbox'
            checkbox.name = target.getAttribute('name') || ''
            checkbox.value = value
            checkbox.id = id
            checkbox.classList.add('mr-2')

            const label = document.createElement('label')
            label.setAttribute('for', id)
            label.textContent = value
            label.classList.add('inline-block', 'mb-1')

            const div = document.createElement('div')
            div.classList.add('mb-2')
            div.appendChild(checkbox)
            div.appendChild(label)

            target.appendChild(div)
        })
    }
}
