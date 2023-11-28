<template>
    <div class="w-[200px] bg-indigo-700 text-gray-300 py-4 px-2">
        <router-link
            :to="{ name: 'app.dashboard' }"
            class="flex items-center px-2 py-1 space-x-2 transition-colors rounded-md hover:bg-black/30 font-medium"
        >
            <span>
                <HomeModernIcon class="w-5" />
            </span>
            <span class="text-sm">
                Dashboard
            </span>
        </router-link>
        <router-link
            :to="{ name: 'app.products' }"
            class="flex items-center px-2 py-1 space-x-2 transition-colors rounded-md hover:bg-black/30 font-medium"
        >
            <span>
                <ListBulletIcon class="w-5" />
            </span>
            <span class="text-sm">
                Products
            </span>
        </router-link>
        <router-link
            :to="{ name: 'app.user' }"
            class="flex items-center px-2 py-1 space-x-2 transition-colors rounded-md hover:bg-black/30 font-medium"
        >
            <span>
                <UserIcon class="w-5" />
            </span>
            <span class="text-sm">
                User
            </span>
        </router-link>
        <router-link
            :to="{ name: 'app.reports' }"
            class="flex items-center px-2 py-1 space-x-2 transition-colors rounded-md hover:bg-black/30 font-medium"
        >
            <span>
                <FlagIcon class="w-5" />
            </span>
            <span class="text-sm">
                Reports
            </span>
        </router-link>
    </div>
</template>

<script setup>
    import { HomeModernIcon, FlagIcon, UserIcon, ListBulletIcon  } from "@heroicons/vue/20/solid";
</script>
