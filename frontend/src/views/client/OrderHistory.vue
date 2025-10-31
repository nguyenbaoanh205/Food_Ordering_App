<template>
    <section class="order_history_section layout_padding">
        <div class="container">
            <div class="heading_container heading_center mb-4">
                <h2>Lịch sử đơn hàng</h2>
            </div>

            <div v-if="loading" class="text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-3">Đang tải đơn hàng...</p>
            </div>

            <div v-else-if="orders.length === 0" class="text-center py-5">
                <p>Bạn chưa có đơn hàng nào.</p>
                <router-link to="/menu" class="btn btn-primary">Đặt món ngay</router-link>
            </div>

            <div v-else class="accordion" id="orderAccordion">
                <div class="accordion-item mb-3" v-for="(order, index) in orders" :key="order.id">
                    <h2 class="accordion-header" :id="'heading' + order.id">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            :data-bs-target="'#collapse' + order.id" aria-expanded="false"
                            :aria-controls="'collapse' + order.id">
                            <div class="d-flex justify-content-between w-100">
                                <span>Đơn #{{ order.id }}</span>
                                <span>{{ formatDate(order.created_at) }}</span>
                                <span class="text-success fw-bold">{{ formatPrice(order.total) }}</span>

                                <!-- Badge màu động -->
                                <span class="badge" :class="{
                                    'bg-secondary': order.status === 'pending',
                                    'bg-primary': order.status === 'confirmed',
                                    'bg-success': order.status === 'completed',
                                    'bg-danger': order.status === 'cancelled'
                                }">
                                    {{ order.status }}
                                </span>
                            </div>
                        </button>
                    </h2>


                    <div :id="'collapse' + order.id" class="accordion-collapse collapse"
                        :aria-labelledby="'heading' + order.id" data-bs-parent="#orderAccordion">
                        <div class="accordion-body">
                            <!-- Thông tin người dùng -->
                            <div class="mb-3 p-3 border rounded bg-light">
                                <h5>Thông tin người dùng</h5>
                                <p><strong>Tên:</strong> {{ order.receiver_name }}</p>
                                <p><strong>Điện thoại:</strong> {{ order.receiver_phone }}</p>
                                <p v-if="order.receiver_address"><strong>Địa chỉ:</strong> {{ order.receiver_address }}
                                </p>
                                <!-- Ghi chú -->
                                <p><strong>Ghi chú:</strong> {{ order.note || 'Không có' }}</p>
                            </div>

                            <!-- Thông tin người đặt -->
                            <!-- <div class="mb-3 p-3 border rounded bg-light">
                                <h5>Thông tin người dùng</h5>
                                <p><strong>Tên:</strong> {{ order.receiver_name }}</p>
                                <p><strong>Email:</strong> {{ order.receiver_phone }}</p>
                                <p v-if="order.receiver_address"><strong>Điện thoại:</strong> {{ order.receiver_address }}</p>
                            </div> -->


                            <!-- Danh sách món -->
                            <ul class="list-group">
                                <li v-for="item in order.details" :key="item.id"
                                    class="list-group-item d-flex align-items-center">
                                    <!-- Cột 1: Thông tin món -->
                                    <div class="col-md-6 d-flex align-items-center gap-3">
                                        <img :src="item.food.image || '/default-food.png'" alt="food image"
                                            class="food-img"
                                            style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;" />
                                        <div>
                                            <strong>{{ item.food.name }}</strong>
                                            <div v-if="item.options.length" class="mt-1 small text-muted">
                                                <div v-if="item.options.filter(o => o.option.type === 'size').length">
                                                    <strong>Size:</strong>
                                                    <span
                                                        v-for="opt in item.options.filter(o => o.option.type === 'size')"
                                                        :key="opt.id">
                                                        {{ opt.option.name }} (+{{ formatPrice(opt.option.extra_price ||
                                                        0) }})
                                                    </span>
                                                </div>
                                                <div
                                                    v-if="item.options.filter(o => o.option.type === 'topping').length">
                                                    <strong>Topping:</strong>
                                                    <span
                                                        v-for="opt in item.options.filter(o => o.option.type === 'topping')"
                                                        :key="opt.id">
                                                        {{ opt.option.name }} (+{{ formatPrice(opt.option.extra_price ||
                                                        0) }})
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Cột 2: Số lượng -->
                                    <div class="col-md-3 text-center">
                                        <span class="fw-semibold">Quantity: x{{ item.quantity }}</span>
                                    </div>

                                    <!-- Cột 3: Thành tiền -->
                                    <div class="col-md-3 text-end">
                                        <span class="fw-bold text-danger">
                                            Total: {{ formatPrice(item.price * item.quantity) }}
                                        </span>
                                    </div>
                                </li>
                            </ul>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api from '@/services/api'
import { useUserStore } from '@/stores/user'
import { useRouter } from 'vue-router'

const userStore = useUserStore()
const router = useRouter()
const orders = ref([])
const loading = ref(true)

const formatPrice = (val) =>
    new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(parseFloat(val))
const formatDate = (dateStr) => new Date(dateStr).toLocaleString()

const fetchOrders = async () => {
    if (!userStore.isLoggedIn) return router.push('/login')
    loading.value = true
    try {
        const res = await api.get(`/order-histories`, {
            headers: { Authorization: `Bearer ${userStore.token}` }
        })
        orders.value = res.data.data || []
    } catch (err) {
        console.error(err)
        orders.value = []
    } finally {
        loading.value = false
    }
}

onMounted(fetchOrders)
</script>

<style scoped>
.order_history_section {
    padding: 60px 0;
}

.accordion-button {
    display: flex;
    flex-direction: column;
}

.accordion-button span {
    margin-bottom: 2px;
}

.food-img {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 8px;
}

.list-group-item {
    gap: 12px;
}
</style>
