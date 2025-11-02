<template>
  <div class="container-fluid py-4">
    <h2 class="fw-bold text-primary mb-4">📊 Thống kê tổng quan</h2>

    <!-- Cards thống kê -->
    <div class="row g-4 mb-4">
      <div class="col-md-3" v-for="item in stats" :key="item.title">
        <div class="card shadow-sm border-0 text-center p-3">
          <h6 class="text-secondary">{{ item.title }}</h6>
          <h3 class="fw-bold text-dark">{{ item.value }}</h3>
        </div>
      </div>
    </div>

    <!-- Biểu đồ -->
    <div class="row g-4">
      <!-- Biểu đồ cột: Doanh thu theo tháng -->
      <div class="col-lg-6">
        <div class="card shadow-sm p-3">
          <h5 class="mb-3 text-secondary">📈 Doanh thu 6 tháng gần nhất</h5>
          <BarChart :series="barSeries" :categories="barCategories" />
        </div>
      </div>

      <!-- Biểu đồ cột: Món ăn bán chạy -->
      <div class="col-lg-6">
        <div class="card shadow-sm p-3">
          <h5 class="mb-3 text-secondary">🍔 Món ăn bán chạy nhất</h5>
          <TopFoodsChart :series="topFoodsSeries" :categories="topFoodsCategories" />
        </div>
      </div>

      <!-- Biểu đồ đường: Số đơn hàng theo tháng -->
      <!-- <div class="col-lg-6">
        <div class="card shadow-sm p-3">
          <h5 class="mb-3 text-secondary">📉 Số đơn hàng (ước tính theo tháng)</h5>
          <LineChart :series="lineSeries" :categories="barCategories" />
        </div>
      </div> -->

      <!-- Biểu đồ tròn: Tỷ lệ đơn hàng -->
      <div class="col-lg-6">
        <div class="card shadow-sm p-3">
          <h5 class="mb-3 text-secondary">🥧 Tỷ lệ đơn hàng theo trạng thái</h5>
          <PieChart :series="pieSeries" :labels="pieLabels" />
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
  { title: 'Tổng đơn hàng', value: '...' },
  { title: 'Doanh thu (₫)', value: '...' },
  { title: 'Người dùng', value: '...' },
  { title: 'Đơn huỷ', value: '...' },
])

// 📊 Biểu đồ doanh thu theo tháng
const barSeries = ref([{ name: 'Doanh thu', data: [] }])
const barCategories = ref([])

// 📈 Biểu đồ đường: số đơn hàng
const lineSeries = ref([{ name: 'Đơn hàng (ước tính)', data: [] }])

// 🥧 Biểu đồ tròn: tỷ lệ đơn hàng theo trạng thái
const pieSeries = ref([])
const pieLabels = ref(['Đang xử lý', 'Đã xác nhận', 'Hoàn thành', 'Đã hủy'])

// 🍔 Biểu đồ cột: Top món ăn bán chạy nhất
const topFoodsSeries = ref([{ name: 'Số lượng bán', data: [] }])
const topFoodsCategories = ref([])

async function loadStatistics() {
  try {
    const res = await api.get('/admin/dashboard/statistics')
    const data = res.data

    stats.value = [
      { title: 'Tổng đơn hàng', value: data.orders },
      { title: 'Doanh thu (₫)', value: data.revenue.toLocaleString('vi-VN') },
      { title: 'Người dùng', value: data.users },
      { title: 'Đơn huỷ', value: data.ordersByStatus.cancelled },
    ]

    barCategories.value = data.revenueByMonth.map(i => `Tháng ${i.month}`)
    barSeries.value = [{ name: 'Doanh thu', data: data.revenueByMonth.map(i => i.total) }]

    pieSeries.value = [
      data.ordersByStatus.pending,
      data.ordersByStatus.confirmed,
      data.ordersByStatus.completed,
      data.ordersByStatus.cancelled
    ]

    if (data.topFoods && data.topFoods.length > 0) {
      topFoodsCategories.value = data.topFoods.map(f => f.name)
      topFoodsSeries.value = [{
        name: 'Số lượng bán',
        data: data.topFoods.map(f => f.total_sold)
      }]
    }
  } catch (err) {
    console.error('❌ Lỗi khi tải thống kê:', err)
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
      toast.success(`🎉 Đơn hàng mới #${data.id} - ${data.receiver_name}`)
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
