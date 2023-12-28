<template>
    <div class="flex items-center justify-end mb-2">
        <div class="flex justify-center items-center">
            <div class="mr-2">Date Period</div>
            <CustomInput type="select" v-model="chosenDate" @change="onDatePickerChange" :select-options="dateOptions"/>
        </div>
    </div>
    <div>
        <apexchart :type="options.type" height="600" :options="options" :series="options.series" class="w-full"></apexchart>
    </div>
</template>

<script setup>
import {computed, onMounted, ref} from "vue";
import CustomInput from "../../components/core/CustomInput.vue";
import store from "../../store/index.js";
import axiosClient from "../../axios.js";

const dateOptions = computed(() => store.state.dateOptions)
const chosenDate = ref('all')

const options = ref({
    type: 'bar',
    series: [{
        data: [],
        name: 'Order(s)',
    }],
    labels: [],
    yaxis: {
        title: {
            text: 'Number of customers'
        }
    },
    grid: {
        show: true,
        xaxis: {
            lines: {
                show: true
            }
        },
        yaxis: {
            lines: {
                show: true
            }
        },
    }
})

function getData() {
    const d = chosenDate.value

    axiosClient.get('report/orders', {params: {d}})
        .then(({data}) => {
            options.value.labels = []
            options.value.series[0].data = []

            options.value.labels = data.labels
            options.value.series[0].data = data.data
        })
}


function onDatePickerChange() {
    getData()
}

onMounted(() => {
    getData()
})
</script>
