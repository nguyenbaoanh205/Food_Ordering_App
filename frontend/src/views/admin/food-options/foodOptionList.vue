<template>
  <div class="container-fluid mt-4">
    <div class="d-flex flex-wrap align-items-center justify-content-between mb-3 gap-2">
      <h2 class="fw-bold mb-0">Food Option Management</h2>

      <div class="d-flex align-items-center gap-2">
        <div class="input-group">
          <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
          <input
            v-model="keyword"
            type="search"
            class="form-control"
            placeholder="Search by option name or food name..."
            @keydown.enter.prevent="applySearch"
          />
        </div>
        <RouterLink
          :to="{ name: 'foodOptionCreate' }"
          class="btn btn-success w-50"
        >
          Add Option
        </RouterLink>
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
                <th class="text-nowrap col-id">#</th>
                <th class="col-name">Option Name</th>
                <th>Type</th>
                <th>Extra Price</th>
                <th>Food</th>
                <th class="text-center col-actions">Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-if="foodOptions.length === 0">
                <td colspan="6" class="text-center text-muted py-4">No matching results</td>
              </tr>

              <tr
                v-for="(option, index) in foodOptions"
                :key="option.id"
              >
                <td>{{ (pagination.current_page - 1) * (pagination.per_page || 10) + index + 1 }}</td>
                <td class="fw-500">{{ option.name }}</td>
                <td>
                  <span
                    class="badge"
                    :class="{
                      'bg-info': option.type === 'size',
                      'bg-warning text-dark': option.type === 'topping'
                    }"
                  >
                    {{ option.type }}
                  </span>
                </td>
                <td>{{ formatCurrency(option.extra_price) }}</td>
                <td>{{ option.food?.name || '—' }}</td>
                <td class="text-center col-actions">
                  <RouterLink
                    class="btn btn-sm btn-primary me-2"
                    :to="{ name: 'foodOptionEdit', params: { id: option.id } }"
                  >
                    Edit
                  </RouterLink>
                  <button
                    @click="deleteOption(option.id)"
                    class="btn btn-sm btn-danger"
                  >
                    Delete
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <nav v-if="pagination.last_page > 1" class="mt-3">
      <ul class="pagination mb-0">
        <li class="page-item" :class="{ disabled: pagination.current_page === 1 }">
          <button class="page-link" @click="changePage(pagination.current_page - 1)">«</button>
        </li>

        <li
          v-for="page in pagination.last_page"
          :key="page"
          class="page-item"
          :class="{ active: page === pagination.current_page }"
        >
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

const foodOptions = ref([])
const loading = ref(true)
const error = ref(null)
const pagination = ref({
  current_page: 1,
  last_page: 1,
  per_page: 10
})
const currentPage = ref(1)
const keyword = ref('')

const fetchOptions = async (page = 1) => {
  try {
    const q = keyword.value ? `&q=${encodeURIComponent(keyword.value)}` : ''
    const res = await api.get(`/food-options?page=${page}${q}`)
    foodOptions.value = res.data.data
    pagination.value = {
      current_page: res.data.current_page || 1,
      last_page: res.data.last_page || 1,
      per_page: res.data.per_page || 10
    }
  } catch (err) {
    error.value = err.response?.data?.message || 'Failed to load options'
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  fetchOptions()
})

const changePage = (page) => {
  if (page >= 1 && page <= pagination.value.last_page) {
    currentPage.value = page
    fetchOptions(page)
  }
}

const applySearch = () => {
  loading.value = true
  currentPage.value = 1
  fetchOptions(1)
}

// Định dạng tiền tệ
const formatCurrency = (value) => {
    if (value == null) return ''
    try {
        return new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(Number(value))
    } catch (e) {
        return value
    }
}

const deleteOption = async (id) => {
  if (!confirm('Are you sure you want to delete this option?')) return
  try {
    await api.delete(`/admin/food-options/${id}`)
    fetchOptions(currentPage.value)
    alert('Deleted successfully!')
  } catch (err) {
    alert('Failed to delete option!')
  }
}
</script>

<style scoped>
.fw-500 { font-weight: 500; }

.table td,
.table th {
  vertical-align: middle;
}

.col-id { width: 72px; }
.col-actions { width: 200px; }
.col-name { width: 20%; }

table { table-layout: fixed; }
</style>
