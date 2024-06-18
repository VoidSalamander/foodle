import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import { createVuetify } from 'vuetify';
import 'vuetify/styles';
import '@mdi/font/css/materialdesignicons.css';
import store from './store';

const vuetify = createVuetify();

createApp(App)
  .use(store) // 使用store
  .use(router)
  .use(vuetify)
  .mount('#app');
