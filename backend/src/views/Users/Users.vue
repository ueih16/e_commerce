<template>
    <div class="flex items-center justify-between mb-3">
        <h1 class="text-3xl font-semibold">Users</h1>
        <button
            @click="showUserModal"
            type="submit"
            class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
        >
            Add new user
        </button>
    </div>
    <UserModal v-model="showModal" :user="userModel" @close="onModalClose"/>
    <UsersTable @clickEdit="editUser"/>

</template>

<script setup>
import UsersTable from "./UsersTable.vue";
import UserModal from "./UserModal.vue";
import {ref} from "vue";

const DEFAULT_EMPTY_OBJECT = {
    id: '',
    name: '',
    email: '',
    password: '',
}

const showModal = ref(false)
const userModel = ref({...DEFAULT_EMPTY_OBJECT})

function showUserModal() {
    showModal.value = true
}

function onModalClose() {
    userModel.value = {...DEFAULT_EMPTY_OBJECT}
}

function editUser(user) {
    userModel.value = user
    showUserModal()
}

</script>
