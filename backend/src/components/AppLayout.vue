<template>
    <div class="flex min-h-full">
        <!-- Sidebar -->
            <Sidebar />
        <!-- /Sidebar -->

        <div class="flex-1">
            <header class="h-8 bg-white shadow">
                Header
            </header>

            <!-- Content -->
            <main>
                <router-view></router-view>
            </main>
            <!-- /Content -->
        </div>
    </div>
</template>

<script setup>

    import Sidebar from "./Sidebar.vue";

    const {title} = defineProps({
        title: String,
    })
</script>
