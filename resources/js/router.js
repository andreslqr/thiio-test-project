import { createRouter, createWebHistory } from 'vue-router'

import Layout from './layouts/app.vue'

import AuthLogin from './pages/auth/login.vue'
import AuthRegister from './pages/auth/register.vue'

import UsersIndex from './pages/users/index.vue'


const routes = [
    {
        path: '/',
        component: Layout,
        name: 'Layout',
        children: [
            { path: '/register',    name: 'Register',   component: AuthRegister },
            { path: '/login',       name: 'Login',      component: AuthLogin },
            { path: '/users',       name: 'Users',      component: UsersIndex, }
        ]
    },
]

const router = createRouter({
    history: createWebHistory(),
    routes
})


export default router