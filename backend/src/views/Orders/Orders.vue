<template>
    <div class="flex items-center justify-between mb-3">
        <h1 class="text-3xl font-semibold">Orders</h1>
    </div>
    <OrdersTable/>
</template>

<script setup>
import {computed} from "vue";
import  store from '../../store'
import OrdersTable from "./OrdersTable.vue";


const orders = computed(() => store.state.orders)

</script>
