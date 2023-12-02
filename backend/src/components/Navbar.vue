<template>
    <header class="flex items-center justify-between bg-white shadow h-14">
        <button @click="emit('toggle-sidebar')" class="p-2 mx-2 rounded-full hover:bg-gray-200 active:bg-gray-300">
            <Bars3Icon class="w-5"/>
        </button>
        <div class="flex items-center px-4">
            <Menu as="div" class="relative inline-block text-left">
                <div class="font-medium text-gray-700">
                    <MenuButton
                        class="inline-flex items-center justify-center w-full px-4 py-2 text-base font-medium text-gray-700 rounded-md focus:outline-none focus-visible:ring-2 focus-visible:ring-white/75"
                    >
                        <img
                            class="w-6 mx-2 rounded-full"
                            src="https://cdn5.vectorstock.com/i/1000x1000/92/89/hipster-avatar-image-vector-19639289.jpg"
                            alt="Avatar"
                        >
                        <small>{{ currentUser.name }}</small>
                        <ChevronDownIcon
                            class="w-5 h-5 ml-2 -mr-1 text-violet-200 hover:text-violet-100"
                            aria-hidden="true"
                        />
                    </MenuButton>
                </div>

                <transition
                    enter-active-class="transition duration-100 ease-out"
                    enter-from-class="transform scale-95 opacity-0"
                    enter-to-class="transform scale-100 opacity-100"
                    leave-active-class="transition duration-75 ease-in"
                    leave-from-class="transform scale-100 opacity-100"
                    leave-to-class="transform scale-95 opacity-0"
                >
                    <MenuItems
                        class="absolute right-0 w-40 mt-2 origin-top-right bg-white divide-y divide-gray-100 rounded-md shadow-lg ring-1 ring-black/5 focus:outline-none"
                    >
                        <div class="px-1 py-1">
                            <MenuItem v-slot="{ active }">
                                <button
                                    :class="[
                                    active ? 'bg-indigo-700 text-white' : 'text-gray-900',
                                    'group flex w-full items-center rounded-md px-2 py-2 text-sm',
                                    ]"
                                >
                                    <UserCircleIcon class="w-6 mx-2 text-indigo-400 group-hover:text-white"/>
                                    Profile
                                </button>
                            </MenuItem>
                            <MenuItem v-slot="{ active }">
                                <button
                                    @click="logout"
                                    :class="[
                                    active ? 'bg-indigo-700 text-white' : 'text-gray-900',
                                    'group flex w-full items-center rounded-md px-2 py-2 text-sm',
                                    ]"
                                >
                                    <ArrowLeftOnRectangleIcon class="w-6 mx-2 text-indigo-400 group-hover:text-white"/>
                                    Logout
                                </button>
                            </MenuItem>
                        </div>
                    </MenuItems>
                </transition>
            </Menu>
        </div>
    </header>
</template>

<script setup>
import {Bars3Icon, ChevronDownIcon, UserCircleIcon, ArrowLeftOnRectangleIcon} from "@heroicons/vue/24/outline"
import {Menu, MenuButton, MenuItems, MenuItem} from '@headlessui/vue'
import store from '../store'
import {useRouter} from 'vue-router'

const router = useRouter()

import {computed} from 'vue'

const currentUser = computed(() => store.state.user.data);
const emit = defineEmits(['toggle-sidebar'])

function logout() {
    store
        .dispatch('logout')
        .then(() => {
            router.push({name: 'Login'})
        })
}
</script>
