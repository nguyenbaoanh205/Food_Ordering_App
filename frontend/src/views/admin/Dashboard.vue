<template>
  <div class="container-fluid py-4">
    <h2 class="fw-bold mb-0">Dashboard</h2>

    <!-- Statistic Cards -->
    <div class="row g-4 mb-4">
      <div class="col-md-3" v-for="item in stats" :key="item.title">
        <div class="card shadow-sm border-0 text-center p-3">
          <h6 class="text-secondary">{{ item.title }}</h6>
          <h3 class="fw-bold text-dark">{{ item.value }}</h3>
        </div>
      </div>
    </div>

    <!-- Charts -->
    <div class="row g-4">
      <!-- Bar Chart: Revenue by Month -->
      <div class="col-lg-6">
        <div class="card shadow-sm border-0 p-3">
          <h5 class="mb-3 text-secondary">📈 Revenue in the Last 6 Months</h5>
          <BarChart :series="barSeries" :categories="barCategories" />
        </div>
      </div>

      <!-- Bar Chart: Top Selling Foods -->
      <div class="col-lg-6">
        <div class="card shadow-sm border-0 p-3">
          <h5 class="mb-3 text-secondary">🍔 Best-Selling Foods</h5>
          <TopFoodsChart :series="topFoodsSeries" :categories="topFoodsCategories" />
        </div>
      </div>

      <!-- Line Chart: Orders by Month -->
      <!-- <div class="col-lg-6">
        <div class="card shadow-sm border-0 p-3">
          <h5 class="mb-3 text-secondary">📉 Estimated Monthly Orders</h5>
          <LineChart :series="lineSeries" :categories="barCategories" />
        </div>
      </div> -->

      <!-- Pie Chart: Order Status Ratio -->
      <div class="col-lg-6">
        <div class="card shadow-sm border-0 p-3">
          <h5 class="mb-3 text-secondary">🥧 Order Status Distribution</h5>
          <PieChart :series="pieSeries" :labels="pieLabels" :colors="pieColors"/>
        </div>
      </div>
    </div>
  </div>
</template>


<script setup>
import { ref, onMounted } from 'vue'
import api from '@/services/api'
import BarChart from '@/components/admin/charts/BarChart.vue'
import PieChart from '@/components/admin/charts/PieChart.vue'
import LineChart from '@/components/admin/charts/LineChart.vue'
import TopFoodsChart from '@/components/admin/charts/TopFoodsChart.vue'
import { useToast } from 'vue-toastification'
import echo from '@/plugins/echo'

const toast = useToast()
// 🧾 Cards thống kê
const stats = ref([
  { title: 'Total Orders', value: '...' },
  { title: 'Revenue ($)', value: '...' },
  { title: 'Users', value: '...' },
  { title: 'Cancelled Orders', value: '...' },
])

// 📊 Bar Chart: Monthly Revenue
const barSeries = ref([{ name: 'Revenue', data: [] }])
const barCategories = ref([])

// 📈 Line Chart: Estimated Orders
const lineSeries = ref([{ name: 'Estimated Orders', data: [] }])

// 🥧 Pie Chart: Order Status Ratio
const pieSeries = ref([])
const pieLabels = ref([
  'Pending',
  'Confirmed',
  'Preparing',
  'Shipping',
  'Delivered',
  'Completed',
  'Cancelled'
])

const pieColors = ref([
  '#4E79A7', // Màu xanh dương
  '#F28E2B', // Cam
  '#E15759', // Đỏ nhạt
  '#76B7B2', // Xanh ngọc
  '#59A14F', // Xanh lá
  '#2ecc71', // Vàng
  '#B07AA1'  // Tím pastel
])

// 🍔 Bar Chart: Top Selling Foods
const topFoodsSeries = ref([{ name: 'Total Sold', data: [] }])
const topFoodsCategories = ref([])

async function loadStatistics() {
  try {
    const res = await api.get('/admin/dashboard/statistics')
    const data = res.data

    stats.value = [
      { title: 'Total Orders', value: data.orders },
      { title: 'Revenue ($)', value: data.revenue.toLocaleString('en-US') },
      { title: 'Users', value: data.users },
      { title: 'Cancelled Orders', value: data.ordersByStatus.cancelled },
    ]

    barCategories.value = data.revenueByMonth.map(i => `Month ${i.month}`)
    barSeries.value = [{ name: 'Revenue', data: data.revenueByMonth.map(i => i.total) }]

    pieSeries.value = [
      data.ordersByStatus.pending,
      data.ordersByStatus.confirmed,
      data.ordersByStatus.preparing,
      data.ordersByStatus.shipping,
      data.ordersByStatus.delivered,
      data.ordersByStatus.completed,
      data.ordersByStatus.cancelled
    ]

    if (data.topFoods && data.topFoods.length > 0) {
      topFoodsCategories.value = data.topFoods.map(f => f.name)
      topFoodsSeries.value = [{
        name: 'Total Sold',
        data: data.topFoods.map(f => f.total_sold)
      }]
    }
  } catch (err) {
    console.error('❌ Error loading statistics:', err)
  }
}


// 🧠 Gọi ban đầu
onMounted(async () => {
  // console.log('🚀 Dashboard mounted, loading statistics...')

  // Load statistics ban đầu
  await loadStatistics()

  // ✅ Kiểm tra và setup Pusher connection
  // console.log('📡 Setting up Pusher listener...')
  // console.log('Echo instance:', echo)

  try {
    // Subscribe vào channel 'orders'
    const channel = echo.channel('orders')
    // console.log('✅ Subscribed to channel: orders')

    // Lắng nghe event 'order.created' (Laravel tự động thêm prefix với broadcastAs)
    channel.listen('.order.created', (data) => {
      // console.log('📦 Đơn hàng mới nhận được:', data)
      // toast.success(`🎉 Đơn hàng mới #${data.id} - ${data.receiver_name}`)
      loadStatistics()
    })

    // // Debug: Lắng nghe callback khi subscribe thành công
    // channel.subscribed(() => {
    //   console.log('✅ Successfully subscribed to orders channel')
    // })

    // // Error handling - chỉ bind nếu pusher đã sẵn sàng
    // if (echo.connector && echo.connector.pusher && echo.connector.pusher.connection) {
    //   echo.connector.pusher.connection.bind('error', (err) => {
    //     console.error('❌ Pusher connection error:', err)
    //   })

    //   echo.connector.pusher.connection.bind('connected', () => {
    //     console.log('✅ Pusher connected successfully')
    //   })

    //   echo.connector.pusher.connection.bind('disconnected', () => {
    //     console.warn('⚠️ Pusher disconnected')
    //   })
    // }

  } catch (error) {
    console.error('❌ Error setting up Pusher listener:', error)
    toast.error('Không thể kết nối Pusher realtime: ' + error.message)
  }
})
</script>

<style scoped>
.card {
  border-radius: 1rem;
}
</style>
