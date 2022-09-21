import { createApp } from 'vue';

const app = createApp({});

import ExampleComponent from './ExampleComponent.vue';
app.component('example-component', ExampleComponent);

app.mount('#app');
