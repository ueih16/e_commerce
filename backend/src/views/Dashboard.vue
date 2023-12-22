<template>
    <div class="flex items-center justify-between mb-2">
        <h1 class="text-3xl font-semibold">Dashboard</h1>
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

    <div class="grid grid-flow-col grid-cols-1 grid-rows-2 gap-3 md:grid-cols-3">
        <div class="flex items-center justify-center col-span-2 row-span-2 px-5 py-6 bg-white rounded-lg shadow">
            Products
        </div>
        <div class="flex flex-col items-center justify-center px-1 py-2 bg-white rounded-lg shadow">
            <label class="block mb-2 text-lg font-semibold">Order by country</label>
            <template v-if="!loading.totalIncome">
                <apexchart type="donut" :options="options" :series="options.series" class="w-full"></apexchart>
            </template>
            <Spinner v-else text="" class=""/>
        </div>
        <div class="px-5 py-6 bg-white rounded-lg shadow">
            <label class="block mb-2 text-lg font-semibold">Latest Customers</label>
            <template v-if="!loading.latestCustomers">
                <div v-for="c of latestCustomers" :key="c.id" class="flex items-center mb-3 flex-start">
                    <div class="flex items-center justify-center w-12 h-12 mr-2 bg-gray-200 rounded-full">
                        <UserIcon class="w-5"/>
                    </div>
                    <div>
                        <h3>{{ c.full_name }}</h3>
                        <p>{{ c.email }}</p>
                    </div>
                </div>
            </template>
            <Spinner v-else text="" class=""/>
        </div>
    </div>
</template>

<script setup>
import {ref} from 'vue'
import axiosClient from '../axios.js'
import Spinner from '../components/core/Spinner.vue'
import {UserIcon} from "@heroicons/vue/24/outline";

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
const ordersByCountry = ref({
    data: [],
    labels: [],
})
const latestCustomers = ref([])
const latestOrders = ref([])

const options = ref({
    type: 'donut',
    series: ordersByCountry.value.data,
    labels: ordersByCountry.value.labels,
    animations: {
        enabled: true,
        easing: 'easeinout',
    }
})

function formatPrice(value) {
    let val = (value / 1).toFixed(2).replace('.', ',')
    return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
}

axiosClient.get('/dashboard/customers-count').then(({data}) => {
    customersCount.value = data
    loading.value.customersCount = false
})
axiosClient.get('/dashboard/products-count').then(({data}) => {
    productsCount.value = data
    loading.value.productsCount = false
})
axiosClient.get('/dashboard/orders-count').then(({data}) => {
    paidOrders.value = data
    loading.value.paidOrders = false
})
axiosClient.get('/dashboard/income-amount').then(({data}) => {
    totalIncome.value = data
    loading.value.totalIncome = false
})
axiosClient.get('/dashboard/orders-by-country').then(({data}) => {
    data.forEach(c => {
        ordersByCountry.value.data.push(c.count)
        ordersByCountry.value.labels.push(c.name)
    })
    console.log(ordersByCountry.value)
    loading.value.ordersByCountry = false
})
axiosClient.get('/dashboard/latest-customers').then(({data}) => {
    latestCustomers.value = data
    loading.value.latestCustomers = false
})
</script>
