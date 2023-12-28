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
    <ProductModal v-model="showModal" :product="productModel" @close="onModalClose"/>
    <ProductsTable @clickEdit="editProduct"/>

</template>

<script setup>
import ProductsTable from "./ProductsTable.vue";
import ProductModal from "./ProductModal.vue";
import {ref} from "vue";
import  store from '../../store'

const DEFAULT_EMPTY_OBJECT = {
    id: '',
    image: '',
    title: '',
    description: '',
    price: '',
    published: false,
}

const showModal = ref(false)
const productModel = ref({...DEFAULT_EMPTY_OBJECT})

function showProductModal() {
    showModal.value = true
}

function onModalClose() {
    productModel.value = {...DEFAULT_EMPTY_OBJECT}
}

function editProduct(product) {
    store.dispatch('getProduct', product.id)
        .then(({data}) => {
            productModel.value = data
            showProductModal()
        })
}

</script>
