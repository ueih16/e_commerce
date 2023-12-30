import {createRouter, createWebHistory} from 'vue-router'
import store from '../store'

import Dashboard from '../views/Dashboard.vue'
import Login from '../views/Login.vue'
import RequestPassword from '../views/RequestPassword.vue'
import ResetPassword from '../views/ResetPassword.vue'
import AppLayout from "../components/AppLayout.vue";
import Products from "../views/Products/Products.vue";
import Users from "../views/Users/Users.vue";
import NotFound from "../views/NotFound.vue";
import Orders from "../views/Orders/Orders.vue";
import OrderView from "../views/Orders/OrderView.vue";
import Customers from "../views/Customers/Customers.vue";
import CustomerView from "../views/Customers/CustomerView.vue";
import Report from "../views/Reports/Report.vue";
import OrdersReport from "../views/Reports/OrdersReport.vue";
import CustomersReport from "../views/Reports/CustomersReport.vue";

const routes = [
    {
        path: '/',
        redirect: '/login',
    },
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
                meta: {title: 'Dashboard'},
            },
            {
                path: 'products',
                name: 'app.products',
                component: Products,
                meta: {title: 'Products Index'},
            },
            {
                path: 'users',
                name: 'app.users',
                component: Users,
                meta: {title: 'Users Index'},
            },
            {
                path: 'orders',
                name: 'app.orders',
                component: Orders,
                meta: {title: 'Orders Index'},
            },
            {
                path: 'customers',
                name: 'app.customers',
                component: Customers,
                meta: {title: 'Customers Index'},
            },
            {
                path: 'orders/:id',
                name: 'app.orders.view',
                component: OrderView,
                meta: {title: 'Orders View'},
            },
            {
                path: 'customers/:id',
                name: 'app.customers.view',
                component: CustomerView,
                meta: {title: 'Customers View'},
            },
            {
                path: '/report',
                name: 'reports',
                redirect: '/report/orders',
                component: Report,
                meta: {title: 'Reports'},
                children: [
                    {
                        path: 'orders',
                        name: 'reports.orders',
                        component: OrdersReport,
                        meta: {title: 'Orders Report'},
                    },
                    {
                        path: 'customers',
                        name: 'reports.customers',
                        component: CustomersReport,
                        meta: {title: 'Customers Report'},
                    },
                ]
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

router.afterEach((to, from) => {
    document.title = to.meta.title
})

export default router
