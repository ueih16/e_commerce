<template>
    <div class="grid gap-3 grid-cols-2">
        <router-link
            class="px-3 py-2 text-gray-700 rounded-md bg-white transition-all duration-300 ease-in-out"
            active-class="text-white bg-indigo-500 shadow"
            :to="{name: 'reports.orders'}"
        >
            Orders report
        </router-link>
        <router-link
            class="px-3 py-2 text-gray-700 rounded-md bg-white transition-all duration-300 ease-in-out"
            active-class="text-white bg-indigo-500 shadow"
            :to="{name: 'reports.customers'}"
        >
            Customers report
        </router-link>
    </div>
    <div class="bg-white p-3 rounded-md shadow mt-3">
        <router-view></router-view>
    </div>
</template>

<script setup>
</script>
