<template>
    <div class="flex items-center justify-between mb-3">
        <h1 class="text-3xl font-semibold">Customers</h1>
<!--        <button-->
<!--            @click="showCustomerModal"-->
<!--            type="submit"-->
<!--            class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"-->
<!--        >-->
<!--            Add new customer-->
<!--        </button>-->
    </div>
    <CustomersTable @clickEdit="editCustomer"/>

</template>

<script setup>
import CustomersTable from "./CustomersTable.vue";
import {ref} from "vue";
import store from "../../store/index.js";

const DEFAULT_EMPTY_OBJECT = {
    id: '',
    first_name: '',
    last_name: '',
    email: '',
    phone: '',
    status: '',
    shippingAddress: {},
    billingAddress: {},
}

const customerModel = ref({...DEFAULT_EMPTY_OBJECT})


function onModalClose() {
    customerModel.value = {...DEFAULT_EMPTY_OBJECT}
}

function editCustomer(customer) {
    store.dispatch('getCustomer', customer.id)
        .then((response) => {
            customerModel.value = response.data
        })
}

</script>
