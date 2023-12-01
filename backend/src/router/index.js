import {createRouter, createWebHistory} from 'vue-router'
import store from '../store'

import Dashboard from '../views/Dashboard.vue'
import Login from '../views/Login.vue'
import RequestPassword from '../views/RequestPassword.vue'
import ResetPassword from '../views/ResetPassword.vue'
import AppLayout from "../components/AppLayout.vue";
import Products from "../views/Products/Products.vue";
import NotFound from "../views/NotFound.vue";

const routes = [
    {
        path: '/app',
        name: 'app',
        component: AppLayout,
        meta: {
            requiresAuth: true,
        },
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
        meta: {
            isGuest: true,
        },
    },
    {
        path: '/request-password',
        name: 'RequestPassword',
        component: RequestPassword,
        meta: {
            isGuest: true,
        },
    },
    {
        path: '/reset-password/:token',
        name: 'ResetPassword',
        component: ResetPassword,
        meta: {
            isGuest: true,
        },
    },
    {
        path: '/:pathMatch(.*)',
        name: 'notfound',
        component: NotFound,
    },
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

router.beforeEach((to, from, next) => {
    if (to.meta.requiresAuth && !store.state.user.token) {
        next({name: 'Login'})
    } else if (to.meta.isGuest && store.state.user.token) {
        next({name: 'app.dashboard'})
    } else {
        next()
    }
})

export default router
