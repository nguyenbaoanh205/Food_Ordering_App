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
            <div class="" style="padding: 12px;">
                <div class="row g-3 mb-4">
                    <!-- Customer Information -->
                    <div class="col-md-4 d-flex">
                        <div class="card shadow-sm flex-fill">
                            <div class="card-header bg-light fw-bold">Customer Information</div>
                            <div class="card-body">
                                <p><strong>Name:</strong> {{ order.receiver_name || 'N/A' }}</p>
                                <p><strong>Phone:</strong> {{ order.receiver_phone || 'N/A' }}</p>
                                <p><strong>Address:</strong> {{ order.receiver_address || 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="col-md-4 d-flex">
                        <div class="card shadow-sm flex-fill">
                            <div class="card-header bg-light fw-bold">Order Summary</div>
                            <div class="card-body">
                                <p><strong>Status:</strong> <span class="badge" :class="{
                                    'bg-secondary': order.status === 'pending',
                                    'bg-primary': order.status === 'confirmed',
                                    'bg-info': order.status === 'preparing',
                                    'bg-warning text-dark': order.status === 'shipping',
                                    'bg-dark': order.status === 'delivered',
                                    'bg-success': order.status === 'completed',
                                    'bg-danger': order.status === 'cancelled'
                                }">
                                        {{ order.status }}
                                    </span></p>
                                <p><strong>Payment Method:</strong> {{ order.payment_method }}</p>
                                <p><strong>Payment Status:</strong> {{ order.payment_status }}</p>
                                <p><strong>Created At:</strong> {{ formatDate(order.created_at) }}</p>
                                <p><strong>Total:</strong> {{ formatCurrency(order.total) }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Update Status -->
                    <div class="col-md-4 d-flex">
                        <div class="card shadow-sm flex-fill">
                            <div class="card-header bg-light fw-bold">Update Order Status</div>
                            <div class="card-body">
                                <div class="d-flex align-items-center gap-2">
                                    <select v-model="status" class="form-select w-auto">
                                        <option value="pending">Pending</option>
                                        <option value="confirmed">Confirmed</option>
                                        <option value="preparing">Preparing</option>
                                        <option value="shipping">Shipping</option>
                                        <option value="delivered">Delivered</option>
                                        <option value="completed">Completed</option>
                                        <option value="cancelled">Cancelled</option>
                                    </select>
                                    <button class="btn btn-primary" @click="updateStatus" :disabled="updating">
                                        <span v-if="updating" class="spinner-border spinner-border-sm me-1"></span>
                                        Update
                                    </button>
                                </div>
                            </div>
                        </div>
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
                                    <th class="col-3">Options</th>
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
                                            <!-- Ảnh món ăn -->
                                            <img v-if="detail.food?.image" :src="detail.food.image"
                                                class="img-thumbnail me-2" style="width: 20%;" alt="food" />

                                            <!-- Tên và giá món -->
                                            <div>
                                                <div class="fw-bold">{{ detail.food?.name ?? 'Unknown' }}</div>
                                                <div class="text-muted small">
                                                    Giá gốc: {{ formatCurrency(detail.food?.price ?? 0) }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <div v-if="detail.options?.length">
                                            <!-- Size -->
                                            <div v-if="detail.options.filter(o => o.option.type === 'size').length">
                                                <strong>Size: </strong>
                                                <span
                                                    v-for="opt in detail.options.filter(o => o.option.type === 'size')"
                                                    :key="opt.id">
                                                    {{ opt.option.name }} (+{{ formatCurrency(opt.option.extra_price ||
                                                        0) }})
                                                </span>
                                            </div>
                                            <!-- Topping -->
                                            <div v-if="detail.options.filter(o => o.option.type === 'topping').length">
                                                <strong>Topping: </strong>
                                                <span
                                                    v-for="opt in detail.options.filter(o => o.option.type === 'topping')"
                                                    :key="opt.id">
                                                    {{ opt.option.name }} (+{{ formatCurrency(opt.option.extra_price ||
                                                        0) }})
                                                </span>
                                            </div>
                                        </div>
                                        <div v-else class="text-muted">No options</div>
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
import { ref, onMounted, watch } from 'vue'
import { useRoute, RouterLink } from 'vue-router'
import api from '@/services/api'
import { useToast } from 'vue-toastification'

const toast = useToast()
const order = ref(null)
const loading = ref(true)
const error = ref(null)

const status = ref('')      // trạng thái đơn hàng
const updating = ref(false) // trạng thái loading khi cập nhật

// Props
const props = defineProps({
    id: String,
    require: true
})

// Lấy chi tiết order
const fetchOrderDetail = async () => {
    loading.value = true
    try {
        const res = await api.get(`/orders/${props.id}`)
        order.value = res.data.data

        // Khi order load xong, set status hiện tại
        status.value = order.value.status
    } catch (err) {
        error.value = err.message || 'Failed to fetch order details'
    } finally {
        loading.value = false
    }
}

onMounted(fetchOrderDetail)

// Hàm format ngày
const formatDate = (dateString) => new Date(dateString).toLocaleString('en-US')

// Hàm format tiền
const formatCurrency = (value) => {
    if (value == null) return ''
    return new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(Number(value))
}

// ✅ Cập nhật trạng thái order
const updateStatus = async () => {
    if (!status.value || status.value === order.value.status) return

    // ✅ Kiểm tra transition hợp lệ
    const validTransitions = {
        pending: ['confirmed', 'cancelled'],
        confirmed: ['preparing', 'cancelled'],
        preparing: ['shipping', 'cancelled'],
        shipping: ['delivered', 'cancelled'],
        delivered: ['completed'],
        completed: [],
        cancelled: []
    }

    if (!validTransitions[order.value.status]?.includes(status.value)) {
        toast.error(`Invalid status transition: ${order.value.status} → ${status.value}`)
        return
    }

    updating.value = true
    try {
        // Gọi API update
        const res = await api.put(`/orders/${props.id}`, { status: status.value })

        // Cập nhật order mới từ response
        order.value = res.data.data

        toast.success(`Cập nhật trạng thái thành công: ${status.value}`)

    } catch (err) {
        console.error(err)
        toast.error(err.response?.data?.message || 'Cập nhật thất bại!')
    } finally {
        updating.value = false
    }
}

</script>


<style scoped>
.thumb {
    width: 48px;
    height: 48px;
    object-fit: cover;
    border-radius: 8px;
}

td {
    vertical-align: middle;
    /* căn giữa theo chiều dọc */
}
</style>
