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
                                    'bg-secondary': order.status === 'pending',    // chờ xử lý
                                    'bg-primary': order.status === 'confirmed',    // đã xác nhận
                                    'bg-info': order.status === 'preparing',       // đang chuẩn bị
                                    'bg-warning': order.status === 'shipping',     // đang giao
                                    'bg-dark': order.status === 'delivered',       // đã giao
                                    'bg-success': order.status === 'completed',    // hoàn tất
                                    'bg-danger': order.status === 'cancelled'      // hủy
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

                                        <div v-if="['delivered', 'completed'].includes(order.status) && !reviews.includes(item.food.id)"
                                            class="mt-2">
                                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                                data-bs-target="#reviewModal"
                                                @click="prepareReview(order.id, item.food.id, item.food.name)">
                                                Đánh giá
                                            </button>
                                        </div>

                                    </div>
                                </li>
                            </ul>
                            <!-- Nút đánh giá -->
                            <!-- <div class="mt-3 text-end" v-if="order.status === 'completed' && !order.has_review">
                                <button class="btn btn-outline-success btn-sm" @click="openReviewModal(order)">
                                    ⭐ Đánh giá đơn hàng
                                </button>
                            </div>
                            <div class="mt-3 text-end" v-else-if="order.status === 'completed' && order.has_review">
                                <span class="badge bg-success">✅ Đã đánh giá</span>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Modal đánh giá -->
    <div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reviewModalLabel">Đánh giá món: {{ selectedFoodName }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label class="form-label">Chọn số sao:</label>
                    <select v-model="review.rating" class="form-select">
                        <option v-for="i in 5" :key="i" :value="i">{{ i }} ⭐</option>
                    </select>

                    <label class="form-label mt-3">Nhận xét:</label>
                    <textarea v-model="review.comment" class="form-control" rows="3"
                        placeholder="Viết cảm nhận của bạn..."></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="button" class="btn btn-primary" @click="submitReview">Gửi đánh giá</button>
                </div>
            </div>
        </div>
    </div>

</template>

<script setup>
import { ref, onMounted, onBeforeUnmount, watch } from 'vue'
import api from '@/services/api'
import { useUserStore } from '@/stores/user'
import { useRouter, useRoute } from 'vue-router'
import { useToast } from 'vue-toastification'
import { useCartStore } from '@/stores/cart'
import echo from '@/plugins/echo'
// import { Modal } from 'bootstrap'

const userStore = useUserStore()
const router = useRouter()
const route = useRoute()
const cartStore = useCartStore()
const toast = useToast()

const orders = ref([])
const loading = ref(true)
let channel = null
let reviewModal = null

const selectedOrderId = ref(null)
const selectedFoodId = ref(null)
const selectedFoodName = ref('')
const review = ref({ rating: 5, comment: '' })
const reviews = ref([])

const formatPrice = (val) =>
    new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(parseFloat(val))
const formatDate = (dateStr) => new Date(dateStr).toLocaleString('en-US')

const fetchOrders = async () => {
    if (!userStore.isLoggedIn) return router.push('/login')
    loading.value = true
    try {
        const res = await api.get(`/order-histories`, {
            headers: { Authorization: `Bearer ${userStore.token}` }
        })
        orders.value = res.data.data || []

        reviews.value = []
        orders.value.forEach(order => {
            order.details.forEach(item => {
                if (item.reviewed) reviews.value.push(item.food.id)
            })
        })
    } catch (err) {
        console.error(err)
        orders.value = []
    } finally {
        loading.value = false
    }
}

function prepareReview(orderId, foodId, foodName) {
    selectedOrderId.value = orderId
    selectedFoodId.value = foodId
    selectedFoodName.value = foodName
    review.value = { rating: 5, comment: '' }
}

async function submitReview() {
    try {
        await api.post('/reviews', {
            user_id: userStore.user.id,
            order_id: selectedOrderId.value,
            food_id: selectedFoodId.value,
            rating: review.value.rating,
            comment: review.value.comment,
        }, {
            headers: { Authorization: `Bearer ${userStore.token}` }
        })

        reviews.value.push(selectedFoodId.value)
        toast.success('🎉 Cảm ơn bạn đã đánh giá!')
        // Đóng modal bằng JS bootstrap
        const modalEl = document.getElementById('reviewModal')
        const modal = bootstrap.Modal.getInstance(modalEl)
        modal.hide()
    } catch (err) {
        console.error(err)
        toast.error(err.response?.data?.message || 'Gửi đánh giá thất bại!')
    }
}

function listenRealtime(userId) {
    channel = echo.channel(`user.${userId}`)
    channel.listen('.order.status.updated', (data) => {
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

// 🔄 Mounted: fetch, modal, realtime
onMounted(async () => {
    await fetchOrders()

    if (userStore.user?.id) listenRealtime(userStore.user.id)

    // Nếu vừa thanh toán xong
    if (route.query.success === 'true') {
        try {
            await api.delete('/cart/clear', {
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

// 🔄 Watch user login/logout để lắng nghe realtime
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
