<template>
    <div class="w-[200px] bg-indigo-700 px-2 py-4 text-white transition-all">
        <router-link
            :to="{ name: 'app.dashboard' }"
            class="flex items-center px-2 py-1 my-1 space-x-2 transition-colors rounded-md hover:bg-black/30"
        >
            <span>
                <HomeIcon class="w-5 mx-1" />
            </span>
            <span class="text-base">
                Dashboard
            </span>
        </router-link>
        <router-link
            :to="{ name: 'app.products' }"
            class="flex items-center px-2 py-1 my-1 space-x-2 transition-colors rounded-md hover:bg-black/30"
        >
            <span>
                <BuildingStorefrontIcon class="w-5 mx-1" />
            </span>
            <span class="text-base">
                Products
            </span>
        </router-link>
        <router-link
            :to="{ name: 'app.user' }"
            class="flex items-center px-2 py-1 my-1 space-x-2 transition-colors rounded-md hover:bg-black/30"
        >
            <span>
                <UserIcon class="w-5 mx-1" />
            </span>
            <span class="text-base">
                User
            </span>
        </router-link>
        <router-link
            :to="{ name: 'app.orders' }"
            class="flex items-center px-2 py-1 my-1 space-x-2 transition-colors rounded-md hover:bg-black/30"
        >
            <span>
                <UserIcon class="w-5 mx-1" />
            </span>
            <span class="text-base">
                Orders
            </span>
        </router-link>
        <router-link
            :to="{ name: 'app.reports' }"
            class="flex items-center px-2 py-1 my-1 space-x-2 transition-colors rounded-md hover:bg-black/30"
        >
            <span>
                <FlagIcon class="w-5 mx-1" />
            </span>
            <span class="text-base">
                Reports
            </span>
        </router-link>
    </div>
</template>

<script setup>
    import { HomeIcon, FlagIcon, UserIcon, BuildingStorefrontIcon  } from "@heroicons/vue/24/outline";
</script>
