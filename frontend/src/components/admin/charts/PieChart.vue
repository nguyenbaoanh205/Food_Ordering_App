<template>
  <apexchart type="donut" height="300" :options="{
    labels,
    colors
  }" :series="series" />
</template>

<script setup>
import ApexChart from 'vue3-apexcharts'

const props = defineProps({
  series: Array,
  labels: Array,
  colors: Array   // ⬅️ thêm dòng này
})
</script>
