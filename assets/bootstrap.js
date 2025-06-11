import { startStimulusApp } from '@symfony/stimulus-bridge';
import { definitionsFromContext } from '@hotwired/stimulus-webpack-helpers';

// Initialise Stimulus
const app = startStimulusApp();

// Charge automatiquement tous les fichiers `.js` dans `assets/controllers/`
app.load(definitionsFromContext(require.context('./controllers', true, /\.js$/)));
