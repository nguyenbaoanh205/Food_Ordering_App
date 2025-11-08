<template>
    <section class="order_history_section layout_padding">
        <div class="container">
            <div class="heading_container heading_center mb-4">
                <h2>Order History</h2>
            </div>

            <div v-if="loading" class="text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-3">Loading orders...</p>
            </div>

            <div v-else-if="orders.length === 0" class="text-center py-5">
                <p>You have no orders yet.</p>
                <router-link to="/menu" class="btn btn-primary">Order now</router-link>
            </div>

            <div v-else class="accordion" id="orderAccordion">
                <div class="accordion-item mb-3" v-for="(order, index) in orders" :key="order.id">
                    <h2 class="accordion-header" :id="'heading' + order.id">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            :data-bs-target="'#collapse' + order.id" aria-expanded="false"
                            :aria-controls="'collapse' + order.id">
                            <div class="d-flex justify-content-between w-100">
                                <span><strong>Order #{{ order.id }}</strong></span>
                                <span>{{ formatDate(order.created_at) }}</span>
                                <span class="fw-bold">{{ formatPrice(order.total) }}</span>

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
                                <h5>Information User</h5>
                                <p><strong>Full Name:</strong> {{ order.receiver_name }}</p>
                                <p><strong>Phone:</strong> {{ order.receiver_phone }}</p>
                                <p v-if="order.receiver_address"><strong>Address:</strong> {{ order.receiver_address }}
                                </p>
                                <p><strong>Note:</strong> {{ order.note || 'Không có' }}</p>
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
                                                    <strong>Size: </strong>
                                                    <span
                                                        v-for="opt in item.options.filter(o => o.option.type === 'size')"
                                                        :key="opt.id">
                                                        {{ opt.option.name }} (+{{ formatPrice(opt.option.extra_price ||
                                                            0) }})
                                                    </span>
                                                </div>
                                                <div
                                                    v-if="item.options.filter(o => o.option.type === 'topping').length">
                                                    <strong>Topping: </strong>
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
import { ref, onMounted, onBeforeUnmount, watch } from 'vue'
import api from '@/services/api'
import { useUserStore } from '@/stores/user'
import { useRouter, useRoute } from 'vue-router'
import { useToast } from 'vue-toastification'
import { useCartStore } from '@/stores/cart'
import echo from '@/plugins/echo'

const userStore = useUserStore()
const router = useRouter()
const route = useRoute()
const cartStore = useCartStore()
const toast = useToast()

const orders = ref([])
const loading = ref(true)
let channel = null

const formatPrice = (val) =>
    new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(parseFloat(val))
const formatDate = (dateStr) => new Date(dateStr).toLocaleString()

// 🟢 Fetch danh sách order ban đầu
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

// 🟢 Lắng nghe realtime trạng thái order
function listenRealtime(userId) {
    channel = echo.channel(`user.${userId}`)
    channel.listen('.order.status.updated', (data) => {
        // toast.info(`📦 Đơn hàng #${data.id} đã chuyển trạng thái: ${data.status}`)

        // Update trực tiếp badge trạng thái và thời gian cập nhật
        const idx = orders.value.findIndex(o => o.id === data.id)
        if (idx !== -1) {
            orders.value[idx].status = data.status
            orders.value[idx].updated_at = data.updated_at
        }
    })
}

function stopListening(userId) {
    if (channel) {
        echo.leave(`user.${userId}`)
        channel = null
    }
}

// 🔄 Mounted: fetch và đăng ký realtime
onMounted(async () => {
    await fetchOrders()
    if (userStore.user?.id) listenRealtime(userStore.user.id)

    if (route.query.success === 'true') {
        try {
            await api.post('/cart/clear', {}, {
                headers: { Authorization: `Bearer ${userStore.token}` }
            })

            cartStore.clearCart()
        } catch (err) {
            console.error(err)
        }
    }
})

// 🔄 Trước khi unmount: hủy lắng nghe
onBeforeUnmount(() => {
    if (userStore.user?.id) stopListening(userStore.user.id)
})

// 🔄 Watch userStore.user để tự động hủy/lắng nghe khi login/logout
watch(() => userStore.user, (newUser, oldUser) => {
    if (oldUser?.id) stopListening(oldUser.id)
    if (newUser?.id) listenRealtime(newUser.id)
})
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
    gap: 8px;
}

.badge {
    border-radius: 45px;
}

/* Mobile chỉnh lại layout */
@media (max-width: 768px) {
    .list-group-item {
        flex-direction: column;
        align-items: flex-start;
        text-align: left;
        padding: 0.7rem;
    }

    .list-group-item .col-md-6,
    .list-group-item .col-md-3 {
        width: 100%;
    }

    /* Ảnh và thông tin món xếp hàng ngang, nhưng nhỏ hơn */
    .list-group-item .col-md-6 {
        display: flex;
        align-items: flex-start;
        gap: 0.8rem;
    }

    .list-group-item img.food-img {
        width: 50px !important;
        height: 50px !important;
        border-radius: 6px;
    }

    /* Thông tin size + topping nhỏ gọn */
    .list-group-item .small.text-muted {
        font-size: 0.85rem;
        line-height: 1.3;
    }

    /* Quantity hiển thị rõ hơn, đặt gần giá */
    .list-group-item .col-md-3.text-center {
        text-align: left !important;
        margin-top: 0.5rem;
    }

    /* Giá tổng làm nổi bật */
    .list-group-item .col-md-3.text-end {
        width: 100%;
        text-align: right;
        margin-top: 0.25rem;
    }

    /* Accordion title gọn lại */
    .accordion-button {
        flex-wrap: wrap;
        gap: 0.3rem;
    }

    .accordion-button>.d-flex span {
        font-size: 0.9rem;
    }

    /* Badge thu nhỏ */
    .accordion-button .badge {
        font-size: 0.75rem;
        padding: 0.2em 0.7em;
    }
}
</style>
