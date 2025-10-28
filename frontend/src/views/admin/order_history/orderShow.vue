<template>
    <div class="container-fluid mt-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h2 class="fw-bold mb-0">Order #{{ order?.id }}</h2>
            <RouterLink to="/admin/order" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Back to Orders
            </RouterLink>
        </div>

        <div v-if="loading" class="text-center text-muted py-4">Loading order details...</div>
        <div v-else-if="error" class="alert alert-danger">{{ error }}</div>
        <div v-else>
            <!-- Thông tin người dùng -->
            <div class="row" style="padding: 12px;">
                <div class="col-6 card shadow-sm mb-4 p-0">
                    <div class="card-header bg-light fw-bold">Customer Information</div>
                    <div class="card-body">
                        <p><strong>Name:</strong> {{ order.user.name }}</p>
                        <p><strong>Email:</strong> {{ order.user.email }}</p>
                        <p><strong>Phone:</strong> {{ order.user.phone ?? 'N/A' }}</p>
                    </div>
                </div>

                <!-- Thông tin đơn hàng -->
                <div class="col-6 card shadow-sm mb-4 p-0">
                    <div class="card-header bg-light fw-bold">Order Summary</div>
                    <div class="card-body">
                        <p><strong>Status:</strong> {{ order.status }}</p>
                        <p><strong>Payment Method:</strong> {{ order.payment_method }}</p>
                        <p><strong>Payment Status:</strong> {{ order.payment_status }}</p>
                        <p><strong>Created At:</strong> {{ formatDate(order.created_at) }}</p>
                        <p><strong>Total:</strong> {{ formatCurrency(order.total) }}</p>
                    </div>
                </div>
                <!-- Chi tiết món ăn -->
                <div class="card shadow-sm p-0">
                    <div class="card-header bg-light fw-bold">Order Items</div>
                    <div class="card-body p-0">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th class="col-3">Food</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-end">Price</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-if="!order.details || order.details.length === 0">
                                    <td colspan="5" class="text-center text-muted py-4">No order details found</td>
                                </tr>
                                <tr v-for="(detail, index) in order.details" :key="detail.id">
                                    <td>{{ index + 1 }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img v-if="detail.food?.image" :src="detail.food.image" class="thumb me-2"
                                                alt="food" />
                                            <span>{{ detail.food?.name ?? 'Unknown' }}</span>
                                        </div>
                                    </td>
                                    <td class="text-center">{{ detail.quantity }}</td>
                                    <td class="text-end">{{ formatCurrency(detail.price) }}</td>
                                    <td class="text-end">{{ formatCurrency(detail.price * detail.quantity) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer text-end fw-bold">
                        Grand Total: {{ formatCurrency(order.total) }}
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRoute, RouterLink } from 'vue-router'
import api from '@/services/api'

// const route = useRoute()
const order = ref(null)
const loading = ref(true)
const error = ref(null)

const props = defineProps({
    id: String,
    require: true
})

const fetchOrderDetail = async () => {
    try {
        const res = await api.get(`/orders/${props.id}`)
        order.value = res.data.data
    } catch (err) {
        error.value = err.message || 'Failed to fetch order details'
    } finally {
        loading.value = false
    }
}

onMounted(fetchOrderDetail)

const formatDate = (dateString) => {
    return new Date(dateString).toLocaleString('en-US', { timeZone: 'Asia/Ho_Chi_Minh' })
}

const formatCurrency = (value) => {
    if (value == null) return ''
    return new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(Number(value))
}
</script>

<style scoped>
.thumb {
    width: 48px;
    height: 48px;
    object-fit: cover;
    border-radius: 8px;
}
</style>
