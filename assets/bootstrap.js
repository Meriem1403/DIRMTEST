import { startStimulusApp } from '@symfony/stimulus-bridge';

const app = startStimulusApp(
    require.context(
        './controllers',
        true,
        /\.[jt]sx?$/
    )
);

export { app };
