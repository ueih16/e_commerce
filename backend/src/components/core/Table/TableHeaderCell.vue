<template>
    <th
        @click="emit('click', field)"
        class="p-2 text-left bg-gray-100 border-b-2 cursor-pointer"
        :class="field === sortField ? 'bg-blue-50' : ''"
    >
        <div class="flex items-center justify-start">
            <slot></slot>
            <div
                v-if="field === sortField"
                class="flex items-center ml-2"
            >
                <BarsArrowUpIcon
                    v-if="sortDirection === 'asc'"
                    class="w-4"
                />
                <BarsArrowDownIcon
                    v-else
                    class="w-4"
                />
            </div>
        </div>
    </th>
</template>

<script setup>
import {BarsArrowUpIcon, BarsArrowDownIcon} from "@heroicons/vue/24/outline"

const emit = defineEmits(['click'])
const {field, sortField, sortDirection} = defineProps({
    field: String,
    sortField: String,
    sortDirection: String,
})

</script>
