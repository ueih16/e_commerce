<template>
    <div class="flex items-center justify-between mb-3">
        <h1 class="text-3xl font-semibold">Orders</h1>
    </div>
    <OrdersTable @clickEdit="clickShow"/>
</template>

<script setup>
import {ref, computed} from "vue";
import  store from '../../store'
import OrdersTable from "./OrdersTable.vue";


const orders = computed(() => store.state.orders)
function clickShow(order) {

}

</script>
