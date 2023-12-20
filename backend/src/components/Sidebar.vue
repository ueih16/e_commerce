<template>
    <div class="w-[200px] bg-indigo-700 px-2 py-4 text-white transition-all">
        <!-- Dashboard -->
        <router-link
            :to="{ name: 'app.dashboard' }"
            class="flex items-center px-2 py-1 my-1 space-x-2 transition-colors rounded-md hover:bg-black/30"
        >
            <span>
                <HomeIcon class="w-5 mx-1"/>
            </span>
            <span class="text-base">
                Dashboard
            </span>
        </router-link>
        <!-- /Dashboard -->

        <!-- Products -->
        <router-link
            :to="{ name: 'app.products' }"
            class="flex items-center px-2 py-1 my-1 space-x-2 transition-colors rounded-md hover:bg-black/30"
        >
            <span>
                <BuildingStorefrontIcon class="w-5 mx-1"/>
            </span>
            <span class="text-base">
                Products
            </span>
        </router-link>
        <!-- /Products -->

        <!-- Orders -->
        <router-link
            :to="{ name: 'app.orders' }"
            class="flex items-center px-2 py-1 my-1 space-x-2 transition-colors rounded-md hover:bg-black/30"
        >
            <span>
                <Bars3Icon class="w-5 mx-1"/>
            </span>
            <span class="text-base">
                Orders
            </span>
        </router-link>
        <!-- /Orders -->

        <!-- Users -->
        <router-link
            :to="{ name: 'app.users' }"
            class="flex items-center px-2 py-1 my-1 space-x-2 transition-colors rounded-md hover:bg-black/30"
        >
            <span>
                <UserIcon class="w-5 mx-1"/>
            </span>
            <span class="text-base">
                Users
            </span>
        </router-link>
        <!-- /Users -->

        <!-- Customers -->
        <router-link
            :to="{ name: 'app.customers' }"
            class="flex items-center px-2 py-1 my-1 space-x-2 transition-colors rounded-md hover:bg-black/30"
        >
            <span>
                <UsersIcon class="w-5 mx-1"/>
            </span>
            <span class="text-base">
                Customers
            </span>
        </router-link>
        <!-- /Customers -->

        <!-- Reports -->
        <router-link
            :to="{ name: 'app.reports' }"
            class="flex items-center px-2 py-1 my-1 space-x-2 transition-colors rounded-md hover:bg-black/30"
        >
            <span>
                <FlagIcon class="w-5 mx-1"/>
            </span>
            <span class="text-base">
                Reports
            </span>
        </router-link>
        <!-- /Reports -->
    </div>
</template>

<script setup>
import {HomeIcon, FlagIcon, UserIcon, BuildingStorefrontIcon, Bars3Icon, UsersIcon} from "@heroicons/vue/24/outline";
</script>
