<template>
    <div class="container mx-auto lg:w-2/3 xl:w-2/3">
        <h1 class="mb-6 text-3xl font-bold">Order #{{ order.id }}</h1>
        <div class="p-3 bg-white rounded-md shadow-md">
            <div>
                <h2 class="text-2xl font-bold mb-4 py-2 border-b border-gray-300">
                    Order details
                    <OrderStatus :order="order" />
                </h2>
                <table class="table-sm">
                    <tbody>
                    <tr>
                        <td class="font-bold px-4">Order #:</td>
                        <td>{{ order.id }}</td>
                    </tr>
                    <tr>
                        <td class="font-bold px-4">Order Date:</td>
                        <td>{{ order.created_at }}</td>
                    </tr>
                    <tr>
                        <td class="font-bold px-4">Order Status: </td>
                        <td>
                            <select v-model="order.status" @change="onStatusChange">
                                <option v-for="status of orderStatuses" :value="status">{{status}}</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="font-bold px-4">SubTotal:</td>
                        <td>${{ order.total_price }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <hr class="my-5"/>

            <!-- Customer detail -->
            <div>
                <h2 class="text-2xl font-bold mb-4 py-2 border-b border-gray-300">Customer details</h2>
                <table class="table-sm">
                    <tbody>
                    <tr>
                        <td class="font-bold px-4">Fullname:</td>
                        <td>{{ order.customer.first_name }} {{ order.customer.last_name }}</td>
                    </tr>
                    <tr>
                        <td class="font-bold px-4">Email:</td>
                        <td>{{ order.customer.email }}</td>
                    </tr>
                    <tr>
                        <td class="font-bold px-4">Phone:</td>
                        <td>{{ order.customer.phone }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <!--/ Customer detail -->

            <!--  Addresses Details-->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <div>
                    <h2 class="text-xl font-semibold mt-6 pb-2 border-b border-gray-300">Billing Address</h2>
                    <!--  Billing Address Details-->
                    <div>
                        {{ order.customer.billingAddress.address1 }}, {{ order.customer.billingAddress.address2 }}
                        <br/>
                        {{ order.customer.billingAddress.city }}, {{ order.customer.billingAddress.zipcode }}
                        <br/>
                        {{ order.customer.billingAddress.state }}, {{ order.customer.billingAddress.country }}
                        <br/>
                    </div>
                    <!--/  Billing Address Details-->
                </div>
                <div>
                    <h2 class="text-xl font-semibold mt-6 pb-2 border-b border-gray-300">Shipping Address</h2>
                    <!--  Shipping Address Details-->
                    <div>
                        {{ order.customer.shippingAddress.address1 }}, {{ order.customer.shippingAddress.address2 }}
                        <br/>
                        {{ order.customer.shippingAddress.city }}, {{ order.customer.shippingAddress.zipcode }}
                        <br/>
                        {{ order.customer.shippingAddress.state }}, {{ order.customer.shippingAddress.country }}
                        <br/>
                    </div>
                    <!--/  Shipping Address Details-->
                </div>
            </div>
            <!--/  Addresses Details-->

            <hr class="my-5"/>

            <!-- Order Items -->
            <h2 class="text-2xl font-bold mb-4 py-2 border-b border-gray-300">Order items</h2>
            <div>
                <!-- Product Item -->
                <div
                    v-for="(item, index) of order.items"
                    :key="index"
                    class="flex gap-6"
                >
                    <div class="flex items-center w-16 h-16 border border-gray-300">
                        <img :src="item.product.image" alt=""/>
                    </div>
                    <div class="flex flex-col justify-between flex-1">
                        <h3 class="mb-4 text-ellipsis">
                            {{ item.product.title }}
                        </h3>
                        <h3 class="flex justify-between mb-4 text-ellipsis">
                            Quantity: {{ item.quantity }}
                            <div class="mb-4 text-lg font-bold">${{ item.unit_price }}</div>
                        </h3>
                    </div>
                </div>
                <!--/ Product Item -->
                <hr class="my-2"/>
            </div>
            <!--/ Order Items -->
            <router-link
                :to="{ name: 'app.orders'}"
                type="button"
                class="flex items-center justify-center w-full py-3 text-lg text-white bg-gray-600 rounded hover:bg-gray-700"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="w-6 h-6 mx-4"
                >
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
                </svg>
                Back to view all orders
            </router-link>
        </div>
    </div>
</template>

<script setup>
import store from "../../store/index.js";
import {useRoute} from "vue-router";
import {onMounted, ref} from "vue";
import OrderStatus from "./OrderStatus.vue";
import axiosClient from "../../axios.js";

const route = useRoute()
const order = ref({
    customer: {
        shippingAddress: {},
        billingAddress: {},
    },
});
const orderStatuses = ref([]);

onMounted(() => {
    store.dispatch('getOrder', route.params.id)
        .then((response) => {
            order.value = response.data
        })

    store.dispatch('getOrderStatuses')
        .then((response) => {
            orderStatuses.value = response.data
        })
})

function onStatusChange() {
    axiosClient.post(`/orders/change-status/${order.value.id}/${order.value.status}`)
        .then(() => {
            store.commit('showToast', `Order status was successfully changed into "${order.value.status}"`)
        })
}
</script> {

