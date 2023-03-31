import './bootstrap';

import { createApp } from 'vue'
import App from './component/app.vue'
import Router from './router.js'
import {Calendar} from 'v-calendar'

import 'v-calendar/dist/style.css';


const app = createApp(App)
app.use(Router);
app.component('DatePicker', Calendar)
app.mount('#app');
