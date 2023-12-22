import { createApp } from 'vue'
import './style.css'
import App from './App.vue'
import store from './store'
import router from './router'
import VueApexCharts from 'vue3-apexcharts'
import CKEditor from '@ckeditor/ckeditor5-vue'

createApp(App)
    .use(store)
    .use(router)
    .use(VueApexCharts)
    .use(CKEditor)
    .mount('#app')
