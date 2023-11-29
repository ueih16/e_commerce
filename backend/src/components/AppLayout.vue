<template>
    <div class="flex min-h-full bg-gray-200">
        <!-- Sidebar -->
        <Sidebar :class="{ '-ml-[200px]' : !sidebarOpened }" />
        <!-- /Sidebar -->

        <div class="flex-1">
            <Navbar @toggle-sidebar="toggleSidebar" />
            <!-- Content -->
            <main class="p-6">
                <router-view></router-view>
            </main>
            <!-- /Content -->
        </div>
    </div>
</template>

<script setup>

    import Sidebar from './Sidebar.vue'
    import Navbar from './Navbar.vue'
    import { ref, onMounted, onUnmounted } from 'vue'

    const sidebarOpened = ref(true)

    function toggleSidebar() {
        sidebarOpened.value = !sidebarOpened.value
    }

    onMounted(() => {
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
