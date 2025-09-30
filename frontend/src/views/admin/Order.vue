<template>
  <div>
    <h2 class="fw-bold mb-4">Quản lý đơn hàng</h2>
    <div class="card shadow-sm">
      <div class="card-body p-0">
        <table class="table table-hover mb-0">
          <thead class="table-dark">
            <tr>
              <th>ID</th>
              <th>Khách hàng</th>
              <th>Tổng tiền</th>
              <th>Trạng thái</th>
              <th>Thao tác</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="order in orders" :key="order.id">
              <td>{{ order.id }}</td>
              <td>{{ order.customer }}</td>
              <td>{{ order.total }}</td>
              <td>
                <span :class="order.status === 'pending' ? 'badge bg-warning' : 'badge bg-success'">
                  {{ order.status }}
                </span>
              </td>
              <td>
                <button class="btn btn-sm btn-primary me-2">Chi tiết</button>
                <button class="btn btn-sm btn-danger">Xóa</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const orders = ref([
  { id: 1, customer: 'Nguyễn Văn A', total: '$20', status: 'pending' },
  { id: 2, customer: 'Trần Thị B', total: '$35', status: 'completed' },
])
</script>
