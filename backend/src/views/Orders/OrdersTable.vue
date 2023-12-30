<template>
    <div class="p-4 bg-white rounded-lg shadow animate-fade-in-down">
        <div class="flex justify-between pb-3 border-b-2">
            <div class="flex items-center">
                <span class="mr-3 whitespace-nowrap">Per page</span>
                <select
                    @change="getOrders(null)"
                    v-model="perPage"
                    class="relative block w-24 px-3 py-2 text-gray-900 placeholder-gray-500 border border-gray-300 rounded-md appearance-none focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                >
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
        </div>
        <table class="w-full table-auto">
            <thead>
            <tr>
                <TableHeaderCell @click="sortOrder" :sort-field="sortField" :sort-direction="sortDirection"
                                 field="id" class="p-2 text-left border-b-2">#
                </TableHeaderCell>
                <TableHeaderCell @click="sortOrder" :sort-field="sortField" :sort-direction="sortDirection"
                                 field="status" class="p-2 text-left border-b-2">Status
                </TableHeaderCell>
                <TableHeaderCell @click="sortOrder" :sort-field="sortField" :sort-direction="sortDirection"
                                 field="" class="p-2 text-left border-b-2">Customer
                </TableHeaderCell>
                <TableHeaderCell @click="sortOrder" :sort-field="sortField" :sort-direction="sortDirection"
                                 field="created_at" class="p-2 text-left border-b-2">Date
                </TableHeaderCell>
                <TableHeaderCell @click="sortOrder" :sort-field="sortField" :sort-direction="sortDirection"
                                 field="total_price" class="p-2 text-left border-b-2">Total price
                </TableHeaderCell>
                <TableHeaderCell @click="sortOrder" :sort-field="sortField" :sort-direction="sortDirection"
                                 field="order_item_count" class="p-2 text-left border-b-2">Items
                </TableHeaderCell>
                <TableHeaderCell field="action" class="p-2 text-left border-b-2">
                    Actions
                </TableHeaderCell>
            </tr>
            </thead>

            <tbody v-if="orders.loading || !orders.data.length">
            <tr>
                <td colspan="6">
                    <Spinner v-if="orders.loading"/>
                    <p v-else class="py-8 text-center text-gray-700">
                        There are no orders
                    </p>
                </td>
            </tr>
            </tbody>

            <tbody v-else>
            <tr v-for="(order, index) of orders.data" class="animate-fade-in-down" :style="{'animation-delay': `${0.06*index}s`}">
                <td class="p-2 border-b-2">{{ order.id }}</td>
                <td class="p-2 border-b-2">
                    <OrderStatus :order="order" />
                </td>
                <td class="p-2 border-b-2">
                    <span>{{ order.customer.first_name }} {{ order.customer.last_name ?? ''}}</span>
                </td>
                <td class="p-2 border-b-2 max-w-[200px] whitespace-nowrap overflow-hidden text-ellipsis">
                    {{ order.created_at }}
                </td>
                <td class="p-2 border-b-2">{{ order.total_price }}</td>
                <td class="p-2 border-b-2">{{ order.number_of_items }}</td>
                <td class="p-2 border-b-2">
                    <router-link :to="{name: 'app.orders.view', params: {id: order.id}}"
                        class="flex items-center justify-center w-8 h-8 text-indigo-700 border border-indigo-700 rounded-full hover:text-white hover:bg-indigo-700">
                        <EyeIcon class="w-4 h-4"/>
                    </router-link>
                </td>
            </tr>
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="flex items-center justify-between mt-1">
            <span class="items-center justify-between mt-5">
                Showing from {{ orders.from }} to {{ orders.to }}
            </span>
            <nav
                v-if="orders.total > orders.limit"
                class="relative z-0 inline-flex items-center justify-center -space-x-px rounded-md shadow-sm"
                aria-label="Pagination"
            >
                <!-- Current: "z-10 bg-indigo-50 border-indigo-500 text-indigo-600", Default: "bg-white border-gray-300 text-gray-500 hover:bg-gray-50" -->
                <a
                    v-for="(link, i) of orders.links"
                    :key="i"
                    :disabled="!link.url"
                    href="#"
                    @click.prevent="getForPage($event, link)"
                    aria-current="page"
                    class="relative inline-flex items-center px-4 py-2 text-sm font-medium border whitespace-nowrap"
                    :class="[
                    link.active
                        ? 'z-10 bg-indigo-50 border-indigo-500 text-indigo-600'
                        : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50',
                    i === 0 ? 'rounded-l-md' : '',
                    i === orders.links.length - 1 ? 'rounded-r-md' : '',
                    !link.url ? ' bg-gray-100 text-gray-700': ''
                ]"
                    v-html="link.label"
                >
                </a>
            </nav>
        </div>
        <!-- /Pagination -->
    </div>
</template>

<script setup>
import Spinner from '../../components/core/Spinner.vue'
import {ref, computed, onMounted} from 'vue'
import {PRODUCTS_PER_PAGE} from '../../constants.js'
import TableHeaderCell from "../../components/core/Table/TableHeaderCell.vue";
import store from '../../store'
import {EyeIcon} from '@heroicons/vue/24/outline'
import OrderStatus from "./OrderStatus.vue";

const perPage = ref(PRODUCTS_PER_PAGE)
const search = ref('')
const orders = computed(() => store.state.orders)
const sortField = ref('updated_at')
const sortDirection = ref('desc')

onMounted(() => {
    getOrders()
})

function getOrders(url = null) {
    store
        .dispatch('getOrders', {
            url,
            search: search.value,
            perPage: perPage.value,
            sort_field: sortField.value,
            sort_direction: sortDirection.value,
        })
}

function getForPage(ev, link) {
    if (!link.url || link.active) {
        return
    }
    getOrders(link.url)
}

function sortOrder(field) {
    if (sortField.value === field) {
        if (sortDirection.value === 'asc') {
            sortDirection.value = 'desc'
        } else {
            sortDirection.value = 'asc'
        }
    } else {
        sortField.value = field
        sortDirection.value = 'asc'
    }
    getOrders()
}

</script>
