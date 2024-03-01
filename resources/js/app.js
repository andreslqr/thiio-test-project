import { createApp } from 'vue/dist/vue.esm-bundler';
import { createPinia } from 'pinia'

import router from './router'

const app = createApp({})
const pinia = createPinia()

app.use(router)
app.use(pinia)

app.mount('#app')