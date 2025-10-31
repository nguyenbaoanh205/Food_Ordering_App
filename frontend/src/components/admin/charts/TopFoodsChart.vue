<template>
  <apexchart type="bar" height="320" :options="chartOptions" :series="series" />
</template>

<script setup>
import { computed } from 'vue'
import ApexChart from 'vue3-apexcharts'

const props = defineProps({
  series: Array,
  categories: Array
})

// ✅ Dùng computed để chart tự cập nhật khi categories thay đổi
const chartOptions = computed(() => ({
  chart: { toolbar: { show: false } },
  xaxis: {
    categories: props.categories
  },
  colors: ['#f39c12'],
  plotOptions: {
    bar: { borderRadius: 6, horizontal: true }
  },
  dataLabels: { enabled: true },
}))
</script>
