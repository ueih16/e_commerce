<template>
<!--    <div>-->
<!--        <label class="sr-only">{{ label }}</label>-->
<!--    </div>-->
    <div class="flex mt-1 rounded-md shadow-sm">
        <span
            v-if="prepend"
            class="inline-flex items-center px-3 text-sm text-gray-500 border border-gray-300 rounded-l-md border--r-0 bg-gray-50"
        >
            {{ prepend }}
        </span>
        <template v-if="type === 'textarea'">
            <textarea
                :id="id"
                :name="name"
                :required="required"
                :value="props.modelValue"
                @input="emit('update:modelValue', $event.target.value)"
                :class="inputClasses"
                :placeholder="label"
            >
            </textarea>
        </template>
        <template v-else-if="type === 'checkbox'">
            <input
                :id="id"
                :type="type"
                :name="name"
                :required="required"
                :checked="props.modelValue"
                @change="emit('update:modelValue', $event.target.checked)"
                class="ml-2 leading-tight"
            >
            <label :for="id" class="text-sm font-medium leading-6 text-gray-900">
                {{label}}
            </label>
        </template>
        <template v-else-if="type === 'file'">
            <input
                :id="id"
                :type="type"
                :name="name"
                :required="required"
                :value="props.modelValue"
                @input="emit('change', $event.target.files[0])"
                :class="inputClasses"
                :placeholder="label"
            >
        </template>
        <template v-else-if="type === 'select'">
            <select
                :id="id"
                :name="name"
                :required="required"
                :value="props.modelValue"
                :class="inputClasses"
                @change="onChange($event.target.value)"
            >
                <option
                    v-for="option of selectOptions"
                    :value="option.key"
                >
                    {{ option.text }}
                </option>
            </select>
        </template>
        <template v-else>
            <input
                :id="id"
                :type="type"
                :name="name"
                :required="required"
                :value="props.modelValue"
                @input="emit('update:modelValue', $event.target.value)"
                :class="inputClasses"
                :placeholder="label"
                step="0.01"
            >
        </template>
        <span
            v-if="append"
            class="inline-flex items-center px-3 text-sm text-gray-500 border border-l-0 border-gray-300 rounded-r-md bg-gray-50"
        >
            {{ append }}
        </span>
    </div>
</template>

<script setup>
import {computed} from 'vue'

const props = defineProps({
    modelValue: [String, Number, File],
    label: String,
    id: String,
    type: {
        type: String,
        default: 'text'
    },
    name: String,
    required: Boolean,
    prepend: {
        type: String,
        default: ''
    },
    append: {
        type: String,
        default: ''
    },
    selectOptions: Array,
})

const inputClasses = computed(() => {
    const cls = [
        `block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm`,
    ];

    if (props.append && !props.prepend) {
        cls.push(`rounded-l-md`)
    } else if (props.prepend && !props.append) {
        cls.push(`rounded-r-md`)
    } else if (!props.prepend && !props.append) {
        cls.push('rounded-md')
    }
    return cls.join(' ')
})

const emit = defineEmits(['update:modelValue'])

function onChange(value) {
    emit('update:modelValue', value)
}
</script>
