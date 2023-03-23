import './bootstrap';

import { createApp } from 'vue'
import App from './component/app.vue'
import Router from './router.js'
import {DatePicker} from 'v-calendar'
import 'v-calendar/dist/style.css';


const app = createApp(App)
app.use(Router);
app.component('DatePicker', DatePicker)
app.mount('#app');
