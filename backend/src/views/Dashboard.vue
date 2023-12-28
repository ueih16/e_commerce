<template>
    <div class="flex items-center justify-between mb-2">
        <h1 class="text-3xl font-semibold">Dashboard</h1>
        <div class="flex justify-center items-center">
            <div class="mr-2">Date Period</div>
            <CustomInput type="select" v-model="chosenDate" @change="onDatePickerChange" :select-options="dateOptions"/>
        </div>
    </div>
    <div class="grid grid-cols-1 gap-3 mb-4 md:grid-cols-4">
        <!--    Total Income -->
        <div
            class="flex flex-col items-center px-5 py-6 bg-white rounded-lg shadow animate-fade-in-down"
            style="animation-delay: 0.3s"
        >
            <label class="block mb-2 text-lg font-semibold">Total Income</label>
            <template v-if="!loading.totalIncome">
                <span class="text-3xl font-semibold">${{ formatPrice(totalIncome) }}</span>
            </template>
            <Spinner v-else text="" class=""/>
        </div>
        <!--/    Total Income -->

        <!--    Active Customers-->
        <div
            class="flex flex-col items-center justify-center px-5 py-6 bg-white rounded-lg shadow animate-fade-in-down"
        >
            <label class="block mb-2 text-lg font-semibold">Active Customers</label>
            <template v-if="!loading.customersCount">
                <span class="text-3xl font-semibold">{{ customersCount }}</span>
            </template>
            <Spinner v-else text="" class=""/>
        </div>
        <!--/    Active Customers-->

        <!--    Active Products -->
        <div
            class="flex flex-col items-center justify-center px-5 py-6 bg-white rounded-lg shadow animate-fade-in-down"
            style="animation-delay: 0.1s"
        >
            <label class="block mb-2 text-lg font-semibold">Active Products</label>
            <template v-if="!loading.productsCount">
                <span class="text-3xl font-semibold">{{ productsCount }}</span>
            </template>
            <Spinner v-else text="" class=""/>
        </div>
        <!--/    Active Products -->

        <!--    Paid Orders -->
        <div
            class="flex flex-col items-center justify-center px-5 py-6 bg-white rounded-lg shadow animate-fade-in-down"
            style="animation-delay: 0.2s"
        >
            <label class="block mb-2 text-lg font-semibold">Paid Orders</label>
            <template v-if="!loading.paidOrders">
                <span class="text-3xl font-semibold">{{ paidOrders }}</span>
            </template>
            <Spinner v-else text="" class=""/>
        </div>
        <!--/    Paid Orders -->
    </div>

    <div class="grid grid-rows-1 md:grid-rows-2 md:grid-flow-col grid-cols-1 md:grid-cols-3 gap-3">
        <div class="col-span-1 md:col-span-2 row-span-1 md:row-span-2 bg-white py-6 px-5 rounded-lg shadow">
            <label class="text-lg font-semibold block mb-2">Latest Orders</label>
            <template v-if="!loading.latestOrders && latestOrders.length">
                <div v-for="o of latestOrders" :key="o.id" class="py-2 px-3 hover:bg-gray-50">
                    <p>
                        <router-link :to="{name: 'app.orders.view', params: {id: o.id}}"
                                     class="text-indigo-700 font-semibold">
                            Order #{{ o.id }}
                        </router-link>
                        created {{ o.created_at }}. {{ o.items }} items
                    </p>
                    <p class="flex justify-between">
                        <span>{{ o.first_name }} {{ o.last_name }}</span>
                        <span>${{ formatPrice(o.total_price) }}</span>
                    </p>
                </div>
            </template>
            <p v-else-if="!loading.latestOrders && !latestOrders.length" class="py-8 text-center text-gray-700">
                There are no orders
            </p>
            <Spinner v-else text="" class=""/>
        </div>
        <div class="flex flex-col items-center justify-center px-1 py-2 bg-white rounded-lg shadow">
            <label class="block mb-2 text-lg font-semibold">Order by country</label>
            <template v-if="!loading.ordersByCountry && options.series.length">
                <apexchart type="donut" :options="options" :series="options.series" class="w-full"></apexchart>
            </template>
            <p v-else-if="!loading.ordersByCountry && !options.series.length" class="py-8 text-center text-gray-700">
                There are no orders
            </p>
            <Spinner v-else text="" class=""/>
        </div>
        <div class="px-5 py-6 bg-white rounded-lg shadow">
            <label class="block mb-2 text-lg font-semibold">Latest Customers</label>
            <template v-if="!loading.latestCustomers && latestCustomers.length">
                <router-link :to="{name: 'app.customers.view', params:{id: c.id}}" v-for="c of latestCustomers"
                             :key="c.id" class="flex items-center mb-3 flex-start">
                    <div class="flex items-center justify-center w-12 h-12 mr-2 bg-gray-200 rounded-full">
                        <UserIcon class="w-5"/>
                    </div>
                    <div>
                        <h3>{{ c.full_name }}</h3>
                        <p>{{ c.email }}</p>
                    </div>
                </router-link>
            </template>
            <p v-else-if="!loading.latestCustomers && !latestCustomers.length" class="py-8 text-center text-gray-700">
                There are no customers
            </p>
            <Spinner v-else text="" class=""/>
        </div>
    </div>
</template>

<script setup>
import {computed, onMounted, ref} from 'vue'
import axiosClient from '../axios.js'
import Spinner from '../components/core/Spinner.vue'
import {UserIcon} from "@heroicons/vue/24/outline";
import CustomInput from "../components/core/CustomInput.vue";
import store from '../store/index.js'

const loading = ref({
    customersCount: true,
    productsCount: true,
    paidOrders: true,
    totalIncome: true,
    ordersByCountry: true,
    latestCustomers: true,
    latestOrders: true,
})

const customersCount = ref(0)
const productsCount = ref(0)
const paidOrders = ref(0)
const totalIncome = ref(0)
const latestCustomers = ref([])
const latestOrders = ref([])

const options = ref({
    type: 'donut',
    series: [],
    labels: [],
    animations: {
        enabled: true,
    }
})

const dateOptions = computed(() => store.state.dateOptions)
const chosenDate = ref('all')

function formatPrice(value) {
    let val = (value / 1).toFixed(2).replace('.', ',')
    return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
}

function updateDashboard() {
    loading.value = {
        customersCount: true,
        productsCount: true,
        paidOrders: true,
        totalIncome: true,
        ordersByCountry: true,
        latestCustomers: true,
        latestOrders: true,
    }

    const d = chosenDate.value

    axiosClient.get('dashboard/customers-count', {params: {d}}).then(({data}) => {
        customersCount.value = data
        loading.value.customersCount = false
    })
    axiosClient.get('dashboard/products-count', {params: {d}}).then(({data}) => {
        productsCount.value = data
        loading.value.productsCount = false
    })
    axiosClient.get('dashboard/orders-count', {params: {d}}).then(({data}) => {
        paidOrders.value = data
        loading.value.paidOrders = false
    })
    axiosClient.get('dashboard/income-amount', {params: {d}}).then(({data}) => {
        totalIncome.value = data
        loading.value.totalIncome = false
    })
    axiosClient.get('dashboard/orders-by-country', {params: {d}}).then(({data}) => {
        options.value.series = []
        options.value.labels = []

        data.forEach(c => {
            options.value.series.push(c.count)
            options.value.labels.push(c.name)
        })

        loading.value.ordersByCountry = false
    })
    axiosClient.get('dashboard/latest-customers', {params: {d}}).then(({data}) => {
        latestCustomers.value = data
        loading.value.latestCustomers = false
    })
    axiosClient.get('dashboard/latest-orders', {params: {d}}).then(({data}) => {
        latestOrders.value = data.data
        loading.value.latestOrders = false
    })
}

function onDatePickerChange(val) {
    updateDashboard()
}

onMounted(() => updateDashboard())
</script>
