<template>
    <div class="p-4 bg-white rounded-lg shadow animate-fade-in-down">
        <div class="flex justify-between pb-3 border-b-2">
            <div class="flex items-center">
                <span class="mr-3 whitespace-nowrap">Per page</span>
                <select
                    @change="getCustomers(null)"
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
            <div>
                <input
                    v-model="search"
                    @change="getCustomers(null)"
                    placeholder="Type to search customers"
                    class="relative block w-48 px-3 py-2 text-gray-900 placeholder-gray-500 border border-gray-300 rounded-md appearance-none focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                >
            </div>
        </div>
        <table class="w-full table-auto">
            <thead>
            <tr>
                <TableHeaderCell @click="sortCustomer" :sort-field="sortField" :sort-direction="sortDirection"
                                 field="user_id" class="p-2 text-left border-b-2">#
                </TableHeaderCell>
                <TableHeaderCell @click="sortCustomer" :sort-field="sortField" :sort-direction="sortDirection"
                                 field="full_name" class="p-2 text-left border-b-2">Name
                </TableHeaderCell>
                <TableHeaderCell @click="sortCustomer" :sort-field="sortField" :sort-direction="sortDirection"
                                 field="email" class="p-2 text-left border-b-2">Email
                </TableHeaderCell>
                <TableHeaderCell @click="sortCustomer" :sort-field="sortField" :sort-direction="sortDirection"
                                 field="phone" class="p-2 text-left border-b-2">Phone
                </TableHeaderCell>
                <TableHeaderCell @click="sortCustomer" :sort-field="sortField" :sort-direction="sortDirection"
                                 field="status" class="p-2 text-left border-b-2">Status
                </TableHeaderCell>
                <TableHeaderCell @click="sortCustomer" :sort-field="sortField" :sort-direction="sortDirection"
                                 field="created_at" class="p-2 text-left border-b-2">Register date
                </TableHeaderCell>
                <TableHeaderCell field="action" class="p-2 text-left border-b-2">
                    Actions
                </TableHeaderCell>
            </tr>
            </thead>

            <tbody v-if="customers.loading || !customers.data.length">
            <tr>
                <td colspan="6">
                    <Spinner v-if="customers.loading"/>
                    <p v-else class="py-8 text-center text-gray-700">
                        There are no customers
                    </p>
                </td>
            </tr>
            </tbody>

            <tbody v-else>
            <tr v-for="(customer, index) of customers.data" class="animate-fade-in-down" :style="{'animation-delay': `${0.06*index}s`}">
                <td class="p-2 border-b-2">
                    {{ customer.id }}
                </td>
                <td class="p-2 border-b-2">
                    {{ customer.full_name }}
                </td>
                <td class="p-2 border-b-2">{{ customer.email }}</td>
                <td class="p-2 border-b-2">{{ customer.phone }}</td>
                <td class="p-2 border-b-2">{{ customer.status }}</td>
                <td class="p-2 border-b-2 max-w-[200px] whitespace-nowrap overflow-hidden text-ellipsis">{{ customer.created_at }}</td>
                <td class="p-2 border-b-2">
                    <div class="flex items-center justify-start">
                        <button
                            @click="editCustomer(customer)"
                            type="button"
                            class="flex items-center justify-between px-4 py-2 mb-2 text-sm font-medium text-white bg-blue-700 rounded-md hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 me-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
                        >
                            <pencil-icon class="w-4 mr-1"/>
                            Edit
                        </button>
                        <button
                            @click="deleteCustomer(customer)"
                            type="button"
                            class="flex items-center justify-between px-4 py-2 mb-2 text-sm font-medium text-white bg-red-700 rounded-md focus:outline-none hover:bg-red-800 focus:ring-4 focus:ring-red-300 me-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900"
                        >
                            <trash-icon class="w-4 mr-1"/>
                            Delete
                        </button>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="flex items-center justify-between mt-1">
            <span class="items-center justify-between mt-5">
                Showing from {{ customers.from }} to {{ customers.to }}
            </span>
            <nav
                v-if="customers.total > customers.limit"
                class="relative z-0 inline-flex items-center justify-center -space-x-px rounded-md shadow-sm"
                aria-label="Pagination"
            >
                <!-- Current: "z-10 bg-indigo-50 border-indigo-500 text-indigo-600", Default: "bg-white border-gray-300 text-gray-500 hover:bg-gray-50" -->
                <a
                    v-for="(link, i) of customers.links"
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
                    i === customers.links.length - 1 ? 'rounded-r-md' : '',
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
import {Menu, MenuButton, MenuItem, MenuItems} from "@headlessui/vue";
import {EllipsisVerticalIcon, PencilIcon, TrashIcon} from '@heroicons/vue/24/outline'
import store from '../../store'

const perPage = ref(PRODUCTS_PER_PAGE)
const search = ref('')
const customers = computed(() => store.state.customers)
const sortField = ref('user_id')
const sortDirection = ref('desc')
const emit = defineEmits(['clickEdit'])

onMounted(() => {
    getCustomers()
})

function getCustomers(url = null) {
    store
        .dispatch('getCustomers', {
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
    getCustomers(link.url)
}

function sortCustomer(field) {
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
    getCustomers()
}

function editCustomer(customer) {
    emit('clickEdit' ,customer)
}

function deleteCustomer(customer) {
    if(confirm('Are you sure to delete this customer?')) {
        store
            .dispatch('deleteCustomer', customer.id)
            .then(() => {
                getCustomers()
            })
    }
}

</script>
