import {ref} from "vue";

const state = {
    user: {
        token: sessionStorage.getItem('TOKEN'),
        data: {}
    },
    products: {
        loading: false,
        data: [],
        links: [],
        from: null,
        to: null,
        page: 1,
        limit: null,
        total: null,
    },
    orders: {
        loading: false,
        data: [],
        links: [],
        from: null,
        to: null,
        page: 1,
        limit: null,
        total: null
    },
    users: {
        loading: false,
        data: [],
        links: [],
        from: null,
        to: null,
        page: 1,
        limit: null,
        total: null
    },
    customers: {
        loading: false,
        data: [],
        links: [],
        from: null,
        to: null,
        page: 1,
        limit: null,
        total: null
    },
    toast: {
        show: false,
        message: '',
        type: '',
        delay: 5000
    },
    countries: [],
    dateOptions: [
        {key: '1d', text: 'Last day'},
        {key: '1w', text: 'Last week'},
        {key: '2w', text: 'Last 2 weeks'},
        {key: '1m', text: 'Last month'},
        {key: '3m', text: 'Last 3 months'},
        {key: '6m', text: 'Last 6 months'},
        {key: 'all', text: 'All time'},
    ],
}

export default state
