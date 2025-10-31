<template>
  <div class="container-fluid mt-4">
    <div class="d-flex flex-wrap align-items-center justify-content-between mb-3 gap-2">
      <h2 class="fw-bold mb-0">Order History</h2>
      <div class="d-flex align-items-center gap-2">
        <div class="input-group">
          <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
          <input
            v-model="keyword"
            type="search"
            class="form-control"
            placeholder="Search by note or status..."
            @keydown.enter.prevent="applySearch"
          />
        </div>
      </div>
    </div>

    <div class="card shadow-sm">
      <div class="card-body p-0">
        <div v-if="loading" class="p-4 text-center text-muted">Loading data...</div>
        <div v-else-if="error" class="alert alert-danger m-3">{{ error }}</div>
        <div v-else>
          <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
              <tr>
                <th class="text-nowrap col-id">ID</th>
                <th class="col-name">Order ID</th>
                <th class="col-status">Status</th>
                <th class="col-note">Note</th>
                <th>Created At</th>
                <!-- <th class="text-nowrap text-center col-actions">Actions</th> -->
              </tr>
            </thead>
            <tbody>
              <tr v-if="histories.length === 0">
                <td colspan="6" class="text-center text-muted py-4">No matching results</td>
              </tr>
              <tr v-for="(history, index) in histories" :key="history.id">
                <td class="col-id">#{{ (pagination.current_page - 1) * 10 + index + 1 }}</td>
                <td class="fw-500 col-name">{{ history.order_id }}</td>
                <td class="col-status">{{ history.status }}</td>
                <td class="col-note text-truncate">{{ history.note }}</td>
                <td>{{ formatDate(history.created_at) }}</td>
                <!-- <td class="text-center col-actions">
                  <RouterLink
                    class="btn btn-sm btn-outline-secondary me-2"
                    :to="{ name: 'OrderHistoryShow', params: { id: history.id } }"
                  >Details</RouterLink>
                </td> -->
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- PHÂN TRANG -->
    <nav v-if="pagination.last_page > 1" class="mt-3">
      <ul class="pagination mb-0">
        <li class="page-item" :class="{ disabled: pagination.current_page === 1 }">
          <button class="page-link" @click="changePage(pagination.current_page - 1)">«</button>
        </li>

        <li v-for="page in pagination.last_page" :key="page" class="page-item" :class="{ active: page === pagination.current_page }">
          <button class="page-link" @click="changePage(page)">{{ page }}</button>
        </li>

        <li class="page-item" :class="{ disabled: pagination.current_page === pagination.last_page }">
          <button class="page-link" @click="changePage(pagination.current_page + 1)">»</button>
        </li>
      </ul>
    </nav>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api from '@/services/api'
import { RouterLink } from 'vue-router'

const histories = ref([])
const loading = ref(true)
const error = ref(null)
const pagination = ref({
  current_page: 1,
  last_page: 1
})
const currentPage = ref(1)
const keyword = ref('')

// Lấy danh sách order histories
const fetchHistories = async (page = 1) => {
  try {
    const q = keyword.value ? `&q=${encodeURIComponent(keyword.value)}` : ''
    const res = await api.get(`/order-history?page=${page}${q}`)   
    histories.value = res.data.data
    pagination.value = {
      current_page: res.data.current_page,
      last_page: res.data.last_page,
      per_page: res.data.per_page
    }
  } catch (err) {
    error.value = err.message || 'Lỗi kết nối API'
  } finally {
    loading.value = false
  }
}

// Khi component mount
onMounted(() => {
  fetchHistories()
})

// Phân trang
const changePage = (page) => {
  if (page >= 1 && page <= pagination.value.last_page) {
    currentPage.value = page
    fetchHistories(page)
  }
}

// Áp dụng tìm kiếm khi nhấn Enter
const applySearch = () => {
  loading.value = true
  currentPage.value = 1
  fetchHistories(1)
}

const formatDate = (dateString) => {
  return new Date(dateString).toLocaleString('en-US', { timeZone: 'Asia/Ho_Chi_Minh' })
}
</script>

<style scoped>
.fw-500 {
  font-weight: 500;
}

.table td,
.table th {
  vertical-align: middle;
}

/* Cân đối độ rộng các cột */
.col-id {
  width: 72px;
}

.col-status {
  width: 15%;
}

.col-note {
  width: 40%;
}

.col-actions {
  width: 200px;
}

.col-name {
  width: 10%;
}

table {
  table-layout: fixed;
}

.col-note {
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
</style>
