<template>
    <TransitionRoot appear :show="show" as="template">
        <Dialog as="div" @close="closeModal" class="relative z-10">
            <TransitionChild
                as="template"
                enter="duration-300 ease-out"
                enter-from="opacity-0"
                enter-to="opacity-100"
                leave="duration-200 ease-in"
                leave-from="opacity-100"
                leave-to="opacity-0"
            >
                <div class="fixed inset-0 bg-opacity-75 bg-black/25"/>
            </TransitionChild>

            <div class="fixed inset-0 overflow-y-auto">
                <div
                    class="flex items-center justify-center min-h-full p-4 text-center"
                >
                    <TransitionChild
                        as="template"
                        enter="duration-300 ease-out"
                        enter-from="opacity-0 scale-95"
                        enter-to="opacity-100 scale-100"
                        leave="duration-200 ease-in"
                        leave-from="opacity-100 scale-100"
                        leave-to="opacity-0 scale-95"
                    >
                        <DialogPanel
                            class="w-full max-w-md overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl"
                        >
                            <Spinner
                                v-if="loading"
                                class="absolute top-0 bottom-0 left-0 right-0 flex items-center justify-center bg-white"
                            />
                            <header class="flex items-center justify-between px-4 py-3">
                                <DialogTitle
                                    as="h3"
                                    class="text-lg font-medium leading-6 text-gray-900"
                                >
                                    {{ user.id ? `Update user: "${props.user.name}"` : 'Create new user' }}
                                </DialogTitle>
                                <button
                                    @click="closeModal"
                                    class="w-8 h-8 flex items-center justify-center rounded-full transition-colors cursor-pointer hover:bg-[rgba(0,0,0,0.2)]"
                                >
                                    <XMarkIcon class="w-6"/>
                                </button>
                            </header>
                            <form @submit.prevent="onSubmit">
                                <div class="px-4 pt-4 pb-5 bg-white">
                                    <CustomInput
                                        v-model="user.name"
                                        label="User full name"
                                        class="mb-2"
                                    />
                                    <CustomInput
                                        v-model="user.email"
                                        label="User email"
                                        class="mb-2"
                                    />
                                    <CustomInput
                                        type="password"
                                        v-model="user.password"
                                        label="User password"
                                        class="mb-2"
                                    />
                                </div>
                                <footer class="px-4 py-3 bg-gray-50 sm:px-6 sm:flex sm:flex-row-reverse">
                                    <button
                                        type="submit"
                                        class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-white bg-indigo-600 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm hover:bg-indigo-700 focus:ring-indigo-500"
                                    >
                                        Save
                                    </button>
                                    <button type="button"
                                            @click="closeModal"
                                            class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                                    >
                                        Close
                                    </button>
                                </footer>
                            </form>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<script setup>
import {ref, computed, onUpdated} from 'vue'
import {TransitionRoot, TransitionChild, Dialog, DialogPanel, DialogTitle,} from '@headlessui/vue'
import Spinner from '../../components/core/Spinner.vue';
import {XMarkIcon} from '@heroicons/vue/24/outline'
import store from '../../store'
import CustomInput from '../../components/core/CustomInput.vue'

const loading = ref(false)

const props = defineProps({
    modelValue: Boolean,
    user: {
        required: true,
        type: Object,
    }
})

const emit = defineEmits(['update:modelValue', 'close'])

const user = ref({
    id: props.user.id,
    name: props.user.name,
    email: props.user.email,
    password: props.user.password,
})

const show = computed({
    get: () => props.modelValue,
    set: (value) => emit('update:modelValue', value)
})

onUpdated(() => {
    user.value = {
        id: props.user.id,
        name: props.user.name,
        email: props.user.email,
        password: props.user.password,
    }
})

function closeModal() {
    show.value = false
    emit('close')
}

function onSubmit() {
    loading.value = true
    if(props.user.id) {
        store.dispatch('updateUser', user.value)
            .then(response => {
                loading.value = false
                if(response.status === 200) {
                    store.dispatch('getUsers')
                    closeModal()
                }
            })
    } else {
        store.dispatch('createUser', user.value)
            .then(response => {
                loading.value = false
                if(response.status === 201) {
                    store.dispatch('getUsers')
                    closeModal()
                }
            })
    }

}
</script>

