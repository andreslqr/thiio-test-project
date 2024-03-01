import { createApp } from 'vue/dist/vue.esm-bundler';
import router from './router'

const app = createApp({})

app.use(router)

app.mount('#app')