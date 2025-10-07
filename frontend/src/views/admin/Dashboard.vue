<template>
  <div>
    <h2 class="fw-bold mb-4">Dashboard</h2>
    <div class="row g-3">
      <div class="col-md-4">
        <div class="card text-center shadow-sm">
          <div class="card-body">
            <h5 class="card-title text-muted">Tổng đơn hàng</h5>
            <p class="fs-3 fw-bold">{{ stats.total_orders }}</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card text-center shadow-sm">
          <div class="card-body">
            <h5 class="card-title text-muted">Doanh thu</h5>
            <p class="fs-3 fw-bold">${{ Number(stats.total_revenue).toLocaleString() }}</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card text-center shadow-sm">
          <div class="card-body">
            <h5 class="card-title text-muted">Khách hàng</h5>
            <p class="fs-3 fw-bold">{{ stats.customers }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { reactive, onMounted } from 'vue'
import api from '@/services/api'

const stats = reactive({ total_orders: 0, total_revenue: 0, customers: 0 })

const fetchStats = async () => {
  try {
    const res = await api.get('/orders-stats')
    stats.total_orders = res.data.total_orders
    stats.total_revenue = res.data.total_revenue
    stats.customers = res.data.customers
  } catch (e) {
    // swallow error for now
  }
}

onMounted(fetchStats)
</script>
