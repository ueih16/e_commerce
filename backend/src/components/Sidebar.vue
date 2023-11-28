<template>
    <div class="w-[200px] bg-indigo-700 px-2 py-4 font-medium text-white transition-all">
        <router-link
            :to="{ name: 'app.dashboard' }"
            class="flex items-center px-2 py-1 space-x-2 font-medium transition-colors rounded-md hover:bg-black/30"
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
            class="flex items-center px-2 py-1 space-x-2 font-medium transition-colors rounded-md hover:bg-black/30"
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
            class="flex items-center px-2 py-1 space-x-2 font-medium transition-colors rounded-md hover:bg-black/30"
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
            class="flex items-center px-2 py-1 space-x-2 font-medium transition-colors rounded-md hover:bg-black/30"
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
