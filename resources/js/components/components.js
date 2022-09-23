import {createApp} from 'vue';
import Storages from './Storages.vue';
import Brands from './Brands.vue';
import EditStorageProducts from './EditStorageProducts.vue';

const app = createApp({});

app.component('storages', Storages);
app.component('brands', Brands);
app.component('edit-storage-products', EditStorageProducts);

app.mount('#app');
