import {createApp} from 'vue';
import Storages from './Storages.vue';

const app = createApp({});

app.component('storages', Storages);

app.mount('#app');
