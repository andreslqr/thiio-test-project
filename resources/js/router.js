import { createRouter, createWebHistory } from 'vue-router'

const Layout = () => import('./layouts/app.vue')

const AuthLogin = () => import('./pages/auth/login.vue')
const AuthRegister = () => import('./pages/auth/register.vue')

const UsersIndex = () => import('./pages/users/index.vue')


const routes = [
    {
        path: '/',
        component: Layout,
        name: 'Layout',
        children: [
            { path: '/',            name: 'Home',       redirect: '/users' },
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