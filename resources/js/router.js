import { createRouter, createWebHistory } from 'vue-router'

const AppLayout = () => import('./layouts/app.vue')
const GuestLayout = () => import('./layouts/guest.vue')

const AuthLogin = () => import('./pages/auth/login.vue')
const AuthRegister = () => import('./pages/auth/register.vue')

const UsersIndex = () => import('./pages/users/index.vue')


const routes = [
    {
        path: '/',
        component: GuestLayout,
        name: 'Guest Layout',
        children: [
            { path: '/',            name: 'Home',       redirect: '/users', meta: {
                
            } },
            { path: '/register',    name: 'Register',   component: AuthRegister },
            { path: '/login',       name: 'Login',      component: AuthLogin },
        ]
    },
    {
        path: '/',
        component: AppLayout,
        name: 'App Layout',
        children: [
            { path: '/',            name: 'Home',       redirect: '/users' },
            { path: '/users',       name: 'Users',      component: UsersIndex , meta: {
                navigation: {
                    name: 'Users',
                    icon: 'mdi-account-group'
                }
            }}
        ]
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})


export default router