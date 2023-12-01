<template>
    <div class="flex items-center justify-between mb-3">
        <h1 class="text-3xl font-semibold">Products</h1>
        <button
            @click="showProductModal"
            type="submit"
            class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
        >
            Add new product
        </button>
    </div>
    <ProductModal v-model="showModal" :product="productModel"/>
    <ProductsTable/>

    <v-btn color="primary">Hello, world!</v-btn>
</template>

<script setup>
import ProductsTable from "./ProductsTable.vue";
import ProductModal from "./ProductModal.vue";
import {ref} from "vue";

const showModal = ref(false)
const productModel = ref({
    id: '',
    image: '',
    title: '',
    description: '',
    price: '',
})

function showProductModal() {
    showModal.value = true
}

</script>
