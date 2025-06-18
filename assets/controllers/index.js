import { Application } from '@hotwired/stimulus'
import ServiceTypesController from './service_types_controller'

const application = Application.start()
application.register('service-types', ServiceTypesController);
