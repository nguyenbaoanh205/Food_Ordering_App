<template>
  <apexchart type="donut" height="300" :options="{ labels }" :series="series" />
</template>

<script setup>
import ApexChart from 'vue3-apexcharts'
const props = defineProps({
  series: Array,
  labels: Array
})
</script>
