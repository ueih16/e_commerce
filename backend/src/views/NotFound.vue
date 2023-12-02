<template>
    <div class="flex items-center justify-center flex-grow min-h-screen bg-gray-50">
        <div class="p-8 text-center bg-white rounded-lg shadow-xl">
            <h1 class="mb-4 text-4xl font-bold">404</h1>
            <p class="text-gray-600">Oops! The page you are looking for could not be found.</p>
            <router-link :to="{ name: 'app.dashboard' }"
               class="inline-block px-4 py-2 mt-4 font-semibold text-white bg-blue-500 rounded hover:bg-blue-600">
                Go back to Home
            </router-link>
        </div>
    </div>
</template>

<script setup></script>
