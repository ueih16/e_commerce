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
                                    {{ customer.id ? `Update customer: "${props.customer.first_name} ${props.customer.last_name}"` : 'Create new customer' }}
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
                                        v-model="customer.first_name"
                                        label="Customer first name"
                                        class="mb-2"
                                    />
                                    <CustomInput
                                        v-model="customer.last_name"
                                        label="Customer last name"
                                        class="mb-2"
                                    />
                                    <CustomInput
                                        v-model="customer.email"
                                        label="Customer email"
                                        class="mb-2"
                                    />
                                    <CustomInput
                                        v-model="customer.phone"
                                        label="Customer phone"
                                        class="mb-2"
                                    />
                                    <CustomInput
                                        name="status"
                                        id="status"
                                        type="checkbox"
                                        v-model="customer.status"
                                        label="Active"
                                        class="mb-2"
                                    />
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                        <!-- Billing address -->
                                        <div>
                                            <h2 class="text-xl font-semibold mt-6 pb-2 border-b border-gray-300">Billing address</h2>
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                                <CustomInput
                                                    v-model="customer.billingAddress.address1"
                                                    label="Address 1"
                                                    class="mb-2"
                                                />
                                                <CustomInput
                                                    v-model="customer.billingAddress.address2"
                                                    label="Address 2"
                                                    class="mb-2"
                                                />
                                                <CustomInput
                                                    v-model="customer.billingAddress.city"
                                                    label="City"
                                                    class="mb-2"
                                                />
                                                <CustomInput

                                                    v-model="customer.billingAddress.zip_code"
                                                    label="Country code"
                                                    class="mb-2"
                                                />
                                                <CustomInput
                                                    type="select"
                                                    v-model="customer.billingAddress.country_code"
                                                    label="Zipcode"
                                                    class="mb-2"
                                                    :selectOptions="countries"
                                                />
                                                <CustomInput
                                                    v-if="!billingCountry.states"
                                                    v-model="customer.billingAddress.state"
                                                    label="State"
                                                    class="mb-2"
                                                />
                                                <CustomInput
                                                    v-else
                                                    type="select"
                                                    v-model="customer.billingAddress.state"
                                                    label="State"
                                                    class="mb-2"
                                                    :selectOptions="billingStateOptions"
                                                />
                                            </div>
                                        </div>

                                        <!-- Shipping address -->
                                        <div>
                                            <h2 class="text-xl font-semibold mt-6 pb-2 border-b border-gray-300">Shipping address</h2>
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                                <CustomInput
                                                    v-model="customer.shippingAddress.address1"
                                                    label="Address 1"
                                                    class="mb-2"
                                                />
                                                <CustomInput
                                                    v-model="customer.shippingAddress.address2"
                                                    label="Address 2"
                                                    class="mb-2"
                                                />
                                                <CustomInput
                                                    v-model="customer.shippingAddress.city"
                                                    label="City"
                                                    class="mb-2"
                                                />
                                                <CustomInput

                                                    v-model="customer.shippingAddress.zip_code"
                                                    label="Country code"
                                                    class="mb-2"
                                                />
                                                <CustomInput
                                                    type="select"
                                                    v-model="customer.shippingAddress.country_code"
                                                    label="Zipcode"
                                                    class="mb-2"
                                                    :selectOptions="countries"
                                                />
                                                <CustomInput
                                                    v-if="!shippingCountry.states"
                                                    v-model="customer.shippingAddress.state"
                                                    label="State"
                                                    class="mb-2"
                                                />
                                                <CustomInput
                                                    v-else
                                                    type="select"
                                                    v-model="customer.shippingAddress.state"
                                                    label="State"
                                                    class="mb-2"
                                                    :selectOptions="shippingStateOptions"
                                                />
                                            </div>
                                        </div>
                                    </div>
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
    customer: {
        required: true,
        type: Object,
    },
})

const countries = computed(() => store.state.countries.map(c => ({key: c.code, text: c.name})))

const billingCountry = computed(() => store.state.countries.find(c => c.code === customer.value.billingAddress.country_code))
const billingStateOptions = computed(() => {
    if(!billingCountry.value || !billingCountry.value.states) {
        return []
    }
    return Object.entries(billingCountry.value.states).map(c => ({key: c[0], text: c[1]}))
})

const shippingCountry = computed(() => store.state.countries.find(c => c.code === customer.value.shippingAddress.country_code))
const shippingStateOptions = computed(() => {
    if(!shippingCountry.value || !shippingCountry.value.states) {
        return []
    }
    return Object.entries(shippingCountry.value.states).map(c => ({key: c[0], text: c[1]}))
})

const emit = defineEmits(['update:modelValue', 'close'])

const customer = ref({
    id: props.customer.id,
    first_name: props.customer.first_name,
    last_name: props.customer.last_name,
    email: props.customer.email,
    phone: props.customer.phone,
    status: props.customer.status,
    billingAddress: props.customer.billingAddress,
    shippingAddress: props.customer.shippingAddress,
})

const show = computed({
    get: () => props.modelValue,
    set: (value) => emit('update:modelValue', value)
})

onUpdated(() => {
    customer.value = {
        id: props.customer.id,
        first_name: props.customer.first_name,
        last_name: props.customer.last_name,
        email: props.customer.email,
        phone: props.customer.phone,
        status: props.customer.status,
        billingAddress: props.customer.billingAddress,
        shippingAddress: props.customer.shippingAddress,
    }
})

function closeModal() {
    show.value = false
    emit('close')
}

function onSubmit() {
    loading.value = true
    if(props.customer.id) {
        customer.value.status = !!customer.value.status
        store.dispatch('updateCustomer', customer.value)
            .then(response => {
                loading.value = false
                if(response.status === 200) {
                    store.dispatch('getCustomers')
                    closeModal()
                }
            })
    }
    // else {
    //     store.dispatch('createCustomer', customer.value)
    //         .then(response => {
    //             loading.value = false
    //             if(response.status === 201) {
    //                 store.dispatch('getCustomers')
    //                 closeModal()
    //             }
    //         })
    //         .catch((err) => {
    //             loading.value = false
    //             store.commit('showToast', ['Invalid email or password !', 'error'])
    //         })
    // }

}
</script>

