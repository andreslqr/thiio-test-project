import { createApp } from 'vue/dist/vue.esm-bundler';
import { createPinia } from 'pinia'

import vuetify from './vuetify'

import router from './router'


const app = createApp({})
const pinia = createPinia()

app.use(router)
app.use(vuetify)
app.use(pinia)

app.mount('#app')