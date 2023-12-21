<template>
    <div class="mb-2 flex items-center justify-between">
        <h1 class="text-3xl font-semibold">Dashboard</h1>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-4">
        <!--    Active Customers-->
        <div class="animate-fade-in-down bg-white py-6 px-5 rounded-lg shadow flex flex-col items-center justify-center">
            <label class="text-lg font-semibold block mb-2">Active Customers</label>
            <template v-if="!loading.customersCount">
                <span class="text-3xl font-semibold">{{ customersCount }}</span>
            </template>
            <Spinner v-else text="" class=""/>
        </div>
        <!--/    Active Customers-->
        <!--    Active Products -->
        <div
            class="animate-fade-in-down bg-white py-6 px-5 rounded-lg shadow flex flex-col items-center justify-center"
            style="animation-delay: 0.1s"
        >
            <label class="text-lg font-semibold block mb-2">Active Products</label>
            <template v-if="!loading.productsCount">
                <span class="text-3xl font-semibold">{{ productsCount }}</span>
            </template>
            <Spinner v-else text="" class=""/>
        </div>
        <!--/    Active Products -->
        <!--    Paid Orders -->
        <div
            class="animate-fade-in-down bg-white py-6 px-5 rounded-lg shadow flex flex-col items-center justify-center"
            style="animation-delay: 0.2s"
        >
            <label class="text-lg font-semibold block mb-2">Paid Orders</label>
            <template v-if="!loading.paidOrders">
                <span class="text-3xl font-semibold">{{ paidOrders }}</span>
            </template>
            <Spinner v-else text="" class=""/>
        </div>
        <!--/    Paid Orders -->
        <!--    Total Income -->
        <div
            class="animate-fade-in-down bg-white py-6 px-5 rounded-lg shadow flex flex-col items-center"
            style="animation-delay: 0.3s"
        >
            <label class="text-lg font-semibold block mb-2">Total Income</label>
            <template v-if="!loading.totalIncome">
                <span class="text-3xl font-semibold">${{ formatPrice(totalIncome) }}</span>
            </template>
            <Spinner v-else text="" class=""/>
        </div>
        <!--/    Total Income -->
    </div>

    <div class="grid grid-rows-2 grid-flow-col grid-cols-1 md:grid-cols-3 gap-3">
        <div class="col-span-2 row-span-2 bg-white py-6 px-5 rounded-lg shadow flex items-center justify-center">
            Products
        </div>
        <div class="bg-white py-2 px-1 rounded-lg shadow flex items-center justify-center">
            <apexchart type="donut" :options="options" :series="options.series"></apexchart>
        </div>
        <div class="bg-white py-6 px-5 rounded-lg shadow flex items-center justify-center">
            Customers
        </div>
    </div>
</template>

<script setup>
import {ref} from 'vue'
import axiosClient from '../axios.js'
import Spinner from '../components/core/Spinner.vue'

const options = ref({
    type: 'donut',
    series: [44, 55, 41, 17, 15],
    labels: ['Apple', 'Mango', 'Orange', 'Watermelon'],
    dataLabels: {
        style: {
            color: undefined
        },
    },
})

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
const ordersByCountry = ref([])
const latestCustomers = ref([])
const latestOrders = ref([])

function formatPrice(value) {
    let val = (value/1).toFixed(2).replace('.', ',')
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

</script>
