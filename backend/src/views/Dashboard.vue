<template>
    <div class="mb-2 flex items-center justify-between">
        <h1 class="text-3xl font-semibold">Dashboard</h1>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-4">
        <!--    Active Customers-->
        <div class="animate-fade-in-down bg-white py-6 px-5 rounded-lg shadow flex flex-col items-center justify-center">
            <label class="text-lg font-semibold block mb-2">Active Customers</label>
            <span class="text-3xl font-semibold">20</span>
        </div>
        <!--/    Active Customers-->

        <!--    Active Products -->
        <div class="animate-fade-in-down bg-white py-6 px-5 rounded-lg shadow flex flex-col items-center justify-center"
             style="animation-delay: 0.1s">
            <label class="text-lg font-semibold block mb-2">Active Products</label>
            <span class="text-3xl font-semibold">100</span>
        </div>
        <!--/    Active Products -->

        <!--    Paid Orders -->
        <div class="animate-fade-in-down bg-white py-6 px-5 rounded-lg shadow flex flex-col items-center justify-center"
             style="animation-delay: 0.2s">
            <label class="text-lg font-semibold block mb-2">Paid Orders</label>
            <span class="text-3xl font-semibold">200</span>
        </div>
        <!--/    Paid Orders -->

        <!--    Total Income -->
        <div class="animate-fade-in-down bg-white py-6 px-5 rounded-lg shadow flex flex-col items-center"
             style="animation-delay: 0.3s">
            <label class="text-lg font-semibold block mb-2">Total Income</label>
            <span class="text-3xl font-semibold">$10000</span>
        </div>
        <!--/    Total Income -->

        <div>
            <apexchart type="donut" width="500" :options="options" :series="options.series"></apexchart>
        </div>
    </div>
</template>

<script setup>
import {ref} from 'vue'

const options = ref({
    series: [44, 55, 13, 43, 22],
    labels: ['Team A', 'Team B', 'Team C', 'Team D', 'Team E'],
})
</script>
