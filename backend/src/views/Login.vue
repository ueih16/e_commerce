<template>
    <GuestLayout title="Login to your account">
        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">

            <form class="space-y-6" method="POST" @submit.prevent="login">
                <div>
                    <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email address</label>
                    <div class="mt-2">
                        <input
                            v-model="user.email"
                            id="email"
                            name="email"
                            type="email"
                            autocomplete="off"
                            required
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                        />
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
                        <div class="text-sm">
                            <router-link :to="{ name: 'RequestPassword' }"
                                         class="font-semibold text-indigo-600 hover:text-indigo-500">Forgot password?
                            </router-link>
                        </div>
                    </div>
                    <div class="mt-2">
                        <input
                            v-model="user.password"
                            id="password"
                            name="password"
                            type="password"
                            autocomplete="off"
                            required
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                        />
                    </div>
                </div>

                <div class="flex items-center justify-start">
                    <div>
                        <label
                            class="block text-gray-500 font-bold"
                            for="remember"
                        >
                            <input
                                v-model="user.remember"
                                class="ml-2 leading-tight"
                                type="checkbox"
                                id="remember"
                                name="remember"
                            >
                            <span class="text-sm font-medium leading-6 text-gray-900">
                                Remember me
                            </span>
                        </label>
                    </div>
                </div>

                <div>
                    <button
                        type="submit"
                        class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                    >
                        Sign in
                    </button>
                </div>
            </form>

            <p class="mt-10 text-sm text-center text-gray-500">
                Not a member? {{ ' ' }}
                <a href="#" class="font-semibold leading-6 text-indigo-600 hover:text-indigo-500">
                    Register
                </a>
            </p>

        </div>
    </GuestLayout>
</template>

<script setup>
import GuestLayout from "../components/GuestLayout.vue";
import {ref} from 'vue'
import store from '../store'
import router from '../router'

const errorMsg = ref('')
const loading = ref(false)

const user = {
    email: '',
    password: '',
    remember: false,
}

function login() {
    loading.value = true;
    store.dispatch('login', user)
        .then(() => {
            loading.value = false;
            router.push({name: 'app.dashboard'})
        })
        .catch(({response}) => {
            loading.value = false;
            errorMsg.value = response.data.message;
        })
}
</script>
