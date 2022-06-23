import './bootstrap';

import { createApp } from 'vue'
import App from './vue/AppComponent'
import Router from './vue/router'
import Store from './vue/store'

createApp(App)
    .use(Router)
    .use(Store)
    .mount('#app')