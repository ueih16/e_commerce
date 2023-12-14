<template>
    <div
        v-if="currentUser.data.id"
        class="flex min-h-full bg-gray-200"
    >
        <!-- Sidebar -->
        <Sidebar :class="{ '-ml-[200px]' : !sidebarOpened }"/>
        <!-- /Sidebar -->

        <div class="flex-1">
            <Navbar @toggle-sidebar="toggleSidebar"/>
            <!-- Content -->
            <main class="p-6">
                <router-view></router-view>
            </main>
            <!-- /Content -->
        </div>
    </div>

    <!-- Spinner -->
    <div v-else class="flex items-center justify-center min-h-full bg-gray-200">
        <Spinner />
    </div>
    <!-- /Spinner -->
    <Toast />
</template>

<script setup>

import Sidebar from './Sidebar.vue'
import Navbar from './Navbar.vue'
import {ref, onMounted, onUnmounted, computed} from 'vue'
import store from '../store'
import Spinner from "./core/Spinner.vue";
import Toast from "./core/Toast.vue";

const sidebarOpened = ref(true)
const currentUser = computed(() => store.state.user)

function toggleSidebar() {
    sidebarOpened.value = !sidebarOpened.value
}

onMounted(() => {
    store.dispatch('getUser')
    handleSidebarOpened()
    window.addEventListener('resize', handleSidebarOpened)
})

onUnmounted(() => {
    window.removeEventListener('resize', handleSidebarOpened)
})

function handleSidebarOpened() {
    sidebarOpened.value = window.outerWidth > 768
}
</script>
