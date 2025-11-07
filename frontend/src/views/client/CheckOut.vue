<template>
    <section class="checkout_section py-5">
        <div class="container">
            <div class="heading_container heading_center mb-4">
                <h2 class="fw-bold text-dark">Thanh toán đơn hàng</h2>
                <p class="text-muted">Kiểm tra thông tin trước khi xác nhận nhé!</p>
            </div>

            <div v-if="cartItems.length > 0" class="row g-4">
                <!-- 🧾 Danh sách món -->
                <div class="col-lg-7">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="card-header bg-warning text-dark fw-semibold py-3">
                            <i class="fa fa-utensils me-2"></i> Danh sách món
                        </div>

                        <ul class="list-group list-group-flush">
                            <li v-for="item in displayCartItems" :key="item.id"
                                class="list-group-item d-flex justify-content-between align-items-center py-3">
                                <div class="d-flex align-items-start">
                                    <img :src="item.food.image || '/images/default-food.jpg'"
                                        class="rounded-3 me-3 food-img" alt="Food" />
                                    <div>
                                        <h6 class="fw-semibold mb-1">{{ item.food.name }}</h6>
                                        <ul class="small text-muted mb-1 ps-3" v-if="item.options?.length">
                                            <li v-for="opt in item.options" :key="opt.id">
                                                {{ opt.option.type.charAt(0).toUpperCase() + opt.option.type.slice(1)}}:
                                                {{ opt.option.name }}
                                                <!-- (+{{ formatPrice(opt.option.extra_price) }}) -->
                                            </li>
                                        </ul>
                                        <small class="text-muted">Quantity: x{{ item.quantity }}</small>
                                    </div>
                                </div>

                                <div class="text-end">
                                    <!-- <div class="text-secondary small">{{ formatPrice(item.displayPrice) }}/món</div> -->
                                    <div class="fw-bold text-danger">{{ formatPrice(item.totalPrice) }}</div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- 💳 Thông tin thanh toán -->
                <div class="col-lg-5">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="card-header bg-success text-white fw-semibold py-3">
                            <i class="fa fa-receipt me-2"></i> Thông tin thanh toán
                        </div>

                        <div class="card-body">
                            <!-- Họ tên -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Họ và tên</label>
                                <input v-model="checkoutInfo.name" type="text" class="form-control"
                                    placeholder="Nhập họ tên người nhận" />
                            </div>

                            <!-- SĐT -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Số điện thoại</label>
                                <input v-model="checkoutInfo.phone" type="tel" class="form-control"
                                    placeholder="VD: 0987 654 321" />
                            </div>

                            <!-- Địa chỉ -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Địa chỉ nhận hàng</label>
                                <textarea v-model="checkoutInfo.address" rows="2" class="form-control"
                                    placeholder="Nhập địa chỉ giao hàng cụ thể"></textarea>
                            </div>

                            <!-- Ghi chú -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Ghi chú (tùy chọn)</label>
                                <textarea v-model="checkoutInfo.note" rows="2" class="form-control"
                                    placeholder="VD: Không hành, ít cay, giao giờ hành chính..."></textarea>
                            </div>

                            <!-- Phương thức thanh toán -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Phương thức thanh toán</label>
                                <select v-model="paymentMethod" class="form-select">
                                    <option value="cash">💵 Tiền mặt khi nhận hàng</option>
                                    <option value="momo">📱 Momo</option>
                                    <option value="credit_card">💳 Thẻ tín dụng</option>
                                    <option value="paypal">🅿️ Paypal</option>
                                    <option value="stripe">💠 Stripe</option>
                                </select>
                            </div>

                            <!-- Tổng cộng -->
                            <div class="d-flex justify-content-between align-items-center border-top pt-3 mb-3">
                                <h5 class="m-0 fw-bold text-dark">Tổng cộng:</h5>
                                <h5 class="m-0 text-danger fw-bold">{{ formatPrice(totalAmount) }}</h5>
                            </div>

                            <!-- Nút đặt hàng -->
                            <button class="btn btn-success w-100 py-3 fw-semibold rounded-pill shadow-sm"
                                @click="handleCheckout" :disabled="loading">
                                <span v-if="loading"><i class="fa fa-spinner fa-spin me-2"></i>Đang xử lý...</span>
                                <span v-else><i class="fa fa-check-circle me-2"></i>Đặt hàng ngay</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 🚫 Giỏ hàng trống -->
            <div v-else class="text-center mt-5">
                <img src="https://cdn-icons-png.flaticon.com/512/2038/2038854.png" alt="Empty" width="180"
                    class="mb-3" />
                <h5>Giỏ hàng của bạn đang trống.</h5>
                <router-link to="/menu" class="btn btn-warning rounded-pill mt-3 px-4">
                    <i class="fa fa-utensils me-2"></i> Quay lại menu
                </router-link>
            </div>
        </div>
    </section>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import api from '@/services/api'
import { useUserStore } from '@/stores/user'
import { useToast } from 'vue-toastification'
import Swal from 'sweetalert2'
import { useRouter, useRoute } from 'vue-router'
const toast = useToast()
const userStore = useUserStore()
const router = useRouter()
const cartItems = ref([])
const paymentMethod = ref('cash')
const loading = ref(false)

const checkoutInfo = ref({
    name: '',
    phone: '',
    address: '',
    note: ''
})

// 🧮 Tính tổng giá có size + topping
const displayCartItems = computed(() => {
    return cartItems.value.map(item => {
        const optionTotal = item.options?.reduce((sum, o) => {
            const extra = parseFloat(o.option?.extra_price || 0)
            return sum + extra
        }, 0) || 0

        const foodPrice = parseFloat(item.food.price || 0)
        const finalPrice = foodPrice + optionTotal
        const total = finalPrice * item.quantity

        return {
            ...item,
            displayPrice: finalPrice,
            totalPrice: total
        }
    })
})

const totalAmount = computed(() =>
    displayCartItems.value.reduce((sum, i) => sum + i.totalPrice, 0)
)

// 💵 Định dạng tiền tệ USD
const formatPrice = val =>
    new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(parseFloat(val))

// 🛒 Lấy giỏ hàng từ DB
const fetchCart = async () => {
    try {
        const res = await api.get(`/users/${userStore.user.id}/cart`)
        // console.log('🧾 Cart items:', res.data.items)
        cartItems.value = res.data.items || []
    } catch (err) {
        console.error(err)
        toast.error('Không thể tải giỏ hàng!')
    }
}

// 💰 Xử lý đặt hàng
const handleCheckout = async () => {
    if (!userStore.user) {
        toast.error('Vui lòng đăng nhập trước khi thanh toán!')
        return
    }

    if (!checkoutInfo.value.name || !checkoutInfo.value.phone || !checkoutInfo.value.address) {
        toast.warning('Vui lòng nhập đầy đủ thông tin người nhận!')
        return
    }

    if (cartItems.value.length === 0) {
        toast.warning('Giỏ hàng trống!')
        return
    }

    loading.value = true
    try {
        const payload = {
            user_id: userStore.user.id,
            payment_method: paymentMethod.value,
            receiver_name: checkoutInfo.value.name,
            receiver_phone: checkoutInfo.value.phone,
            receiver_address: checkoutInfo.value.address,
            note: checkoutInfo.value.note,
            items: displayCartItems.value.map(item => ({
                food_id: item.food.id,
                quantity: item.quantity,
                price: item.displayPrice,
                options: item.options?.map(o => ({
                    option_id: o.option.id,
                    extra_price: o.option.extra_price
                })) || []
            }))
        }

        await api.post('/orders', payload)

        // 🩵 Hiện popup cảm ơn
        await Swal.fire({
            icon: 'success',
            title: 'Cảm ơn bạn!',
            text: 'Thanh toán thành công. Đơn hàng của bạn đang được xử lý!',
            confirmButtonText: 'OK',
            confirmButtonColor: '#3085d6'
        })

        // 🧹 Dọn giỏ hàng và chuyển hướng
        cartItems.value = []
        router.push('/order-histories')
    } catch (err) {
        console.error(err)
        toast.error('Lỗi khi đặt hàng!')
    } finally {
        loading.value = false
    }
}

onMounted(() => {
    if (userStore.user) {
        fetchCart()
    }
})
</script>



<style scoped>
.checkout_section {
    background: #fff;
    color: #222;
}

.food-img {
    width: 70px;
    height: 70px;
    object-fit: cover;
}

.card {
    border-radius: 15px !important;
}

.form-control,
.form-select,
textarea {
    border-radius: 12px;
    padding: 10px 14px;
}

.btn {
    transition: all 0.2s ease;
}

.btn:hover {
    transform: translateY(-2px);
}

@media (max-width: 768px) {
    .food-img {
        width: 60px;
        height: 60px;
    }

    h2 {
        font-size: 1.4rem;
    }

    .card-header {
        font-size: 1rem;
    }

    .checkout_section {
        padding: 1rem;
    }
}
</style>