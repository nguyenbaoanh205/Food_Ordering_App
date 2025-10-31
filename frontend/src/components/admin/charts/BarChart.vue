<template>
  <apexchart
    type="bar"
    height="320"
    :options="chartOptions"
    :series="series"
  />
</template>

<script setup>
import { computed, watch, ref } from 'vue'
import ApexChart from 'vue3-apexcharts'

const props = defineProps({
  series: {
    type: Array,
    default: () => []
  },
  categories: {
    type: Array,
    default: () => []
  }
})

// 🧠 Dùng computed để render lại khi props thay đổi
const chartOptions = computed(() => ({
  chart: {
    toolbar: { show: false },
    foreColor: '#333'
  },
  xaxis: {
    categories: props.categories,
    labels: {
      style: { fontSize: '13px' }
    }
  },
  yaxis: {
    labels: {
      formatter: val => val.toLocaleString('vi-VN')
    }
  },
  dataLabels: { enabled: false },
  plotOptions: {
    bar: {
      borderRadius: 6,
      horizontal: false,
      columnWidth: '45%',
      distributed: false
    }
  },
  fill: {
    colors: ['#4f46e5']
  },
  grid: { borderColor: '#e5e7eb' },
  tooltip: {
    y: { formatter: val => val.toLocaleString('vi-VN') + ' ₫' }
  }
}))
</script>
