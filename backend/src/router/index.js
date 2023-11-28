import { createRouter, createWebHistory } from 'vue-router'

import Dashboard from '../views/Dashboard.vue'
import Login from '../views/Login.vue'
import RequestPassword from '../views/RequestPassword.vue'
import ResetPassword from '../views/ResetPassword.vue'
import AppLayout from "../components/AppLayout.vue";
import Products from "../views/Products.vue";

const routes = [
    {
        path: '/app',
        name: 'app',
        component: AppLayout,
        children: [
            {
                path: 'dashboard',
                name: 'app.dashboard',
                component: Dashboard,
            },
            {
                path: 'products',
                name: 'app.products',
                component: Products,
            },
            {
                path: 'user',
                name: 'app.user',
                component: Dashboard,
            },
            {
                path: 'reports',
                name: 'app.reports',
                component: Dashboard,
            },
        ]
    },
    {
        path: '/login',
        name: 'Login',
        component: Login,
    },
    {
        path: '/request-password',
        name: 'RequestPassword',
        component: RequestPassword,
    },
    {
        path: '/reset-password/:token',
        name: 'ResetPassword',
        component: ResetPassword,
    },
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

export default router
