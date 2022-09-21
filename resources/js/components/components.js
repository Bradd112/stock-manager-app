import {createApp} from 'vue';
import Storages from './Storages.vue';
import Brands from './Brands.vue';

const app = createApp({});

app.component('storages', Storages);
app.component('brands', Brands);

app.mount('#app');
