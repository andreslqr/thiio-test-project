import { createApp } from 'vue/dist/vue.esm-bundler';
import { createPinia } from 'pinia'
import { navigationStore } from './store/navigation'

import vuetify from './vuetify'

import router from './router'


const app = createApp({})
const pinia = createPinia()

app.use(pinia)

const navigation = navigationStore()

router.beforeEach((to, from) => {
    if(to.meta.navigation) {
        navigation.pushNavigation({
            ...to.meta.navigation,
            route: to.path
        })
    }
})

app.use(router)
app.use(vuetify)

app.mount('#app')