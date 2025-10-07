<template>
    <div class="container-fluid mt-4">
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-3 gap-2">
            <h2 class="fw-bold mb-0">Order Management</h2>
            <div class="d-flex align-items-center gap-2">
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                    <input v-model="keyword" type="search" class="form-control"
                        placeholder="Search by name, category..." @keydown.enter.prevent="applySearch" />
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
                                <th class="col-name">User</th>
                                <th class="text-center col-price">Total</th>
                                <th class="col-desc">Status</th>
                                <th class="col-image">Payment Method</th>
                                <th class="col-category">Payment Status</th>
                                <th>Created At</th>
                                <th class="text-nowrap text-center col-actions">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-if="orders.length === 0">
                                <td colspan="7" class="text-center text-muted py-4">No matching results</td>
                            </tr>
                            <tr v-for="(order, index) in orders" :key="order.id">
                                <td class="col-id">#{{ (pagination.current_page - 1) * 10 + index + 1 }}</td>
                                <td class="fw-500 col-name">{{ order.user.name }}</td>
                                <td class="text-center col-price">{{ formatCurrency(order.total) }}</td>
                                <td class="text-truncate col-desc">{{ order.status }}</td>
                                <td class="col-image">{{ order.payment_method }}</td>
                                <td class="col-category">{{ order.payment_status }}</td>
                                <td>{{ formatDate(order.created_at) }}</td>
                                <td class="text-center col-actions">
                                    <RouterLink class="btn btn-sm btn-outline-secondary me-2"
                                        :to="{ name: 'OrderShow', params: { id: order.id } }">Details</RouterLink>
                                </td>
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

                <li v-for="page in pagination.last_page" :key="page" class="page-item"
                    :class="{ active: page === pagination.current_page }">
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
import api from '../../../services/api'
import { RouterLink } from 'vue-router'

const orders = ref([])
const loading = ref(true)
const error = ref(null)
const pagination = ref({
    current_page: 1,
    last_page: 1
})
const currentPage = ref(1)
const keyword = ref('')

// Hàm lấy danh sách món ăn
const fetchOrders = async (page = 1) => {
    try {
        const q = keyword.value ? `&q=${encodeURIComponent(keyword.value)}` : ''
        const res = await api.get(`/orders?page=${page}${q}`)
        orders.value = res.data.data        
        
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
    fetchOrders()
})

// Phân trang
const changePage = (page) => {
    if (page >= 1 && page <= pagination.value.last_page) {
        currentPage.value = page
        fetchOrders(page)
    }
}

// Áp dụng tìm kiếm khi nhấn Enter
const applySearch = () => {
    loading.value = true
    currentPage.value = 1
    fetchOrders(1)
}

const formatDate = (dateString) => {
  return new Date(dateString).toLocaleString('en-US', { timeZone: 'Asia/Ho_Chi_Minh' });
};

// Định dạng tiền tệ
const formatCurrency = (value) => {
    if (value == null) return ''
    try {
        return new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(Number(value))
    } catch (e) {
        return value
    }
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

.col-image {
    width: 10%;
}

.col-actions {
    width: 200px;
}

.col-price {
    width: 19%;
}

.col-category {
    width: 16%;
}

.col-name {
    width: 6%;
}

.col-desc {
    width: 16%;
    max-width: 0;
}

/* Ảnh thumbnail của món ăn */
.food-thumb {
    width: 72px;
    height: 72px;
    object-fit: cover;
}

/* Giúp bảng tôn trọng width đã set và xử lý truncate mượt hơn */
table {
    table-layout: fixed;
}

.col-desc {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
</style>
