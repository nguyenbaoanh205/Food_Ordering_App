<template>
    <section class="checkout_section layout_padding">
        <div class="container">
            <div class="heading_container heading_center mb-4">
                <h2>Thanh toán đơn hàng</h2>
            </div>

            <div v-if="cartItems.length > 0" class="row">
                <!-- 🧾 Thông tin đơn hàng -->
                <div class="col-md-7">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Danh sách món</h5>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li v-for="item in displayCartItems" :key="item.id" class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ item.food.name }}</strong>
                                        <ul class="mb-1 small text-muted ps-3">
                                            <li v-for="opt in item.options" :key="opt.id">
                                                {{ opt.option.name }}
                                                (+{{ formatPrice(opt.option.extra_price) }})
                                            </li>
                                        </ul>
                                        <small>Số lượng: {{ item.quantity }}</small>
                                    </div>
                                    <div class="text-end">
                                        <div>{{ formatPrice(item.displayPrice) }}/món</div>
                                        <div class="fw-bold text-danger">{{ formatPrice(item.totalPrice) }}</div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- 💳 Thông tin thanh toán -->
                <div class="col-md-5">
                    <div class="card shadow-sm">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">Thông tin thanh toán</h5>
                        </div>

                        <div class="card-body">
                            <!-- 🧍‍♂️ Thông tin người nhận -->
                            <div class="mb-3">
                                <label class="form-label">Họ và tên</label>
                                <input v-model="checkoutInfo.name" type="text" class="form-control"
                                    placeholder="Nhập họ và tên người nhận" />
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Số điện thoại</label>
                                <input v-model="checkoutInfo.phone" type="tel" class="form-control"
                                    placeholder="VD: 0987654321" />
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Địa chỉ nhận hàng</label>
                                <textarea v-model="checkoutInfo.address" class="form-control" rows="2"
                                    placeholder="Nhập địa chỉ giao hàng"></textarea>
                            </div>

                            <!-- 💰 Phương thức thanh toán -->
                            <div class="mb-3">
                                <label class="form-label">Phương thức thanh toán</label>
                                <select v-model="paymentMethod" class="form-select">
                                    <option value="cash">💵 Tiền mặt</option>
                                    <option value="credit_card">💳 Thẻ tín dụng</option>
                                    <option value="paypal">🅿️ Paypal</option>
                                    <option value="momo">📱 Momo</option>
                                    <option value="stripe">💠 Stripe</option>
                                </select>
                            </div>

                            <!-- Tổng tiền -->
                            <div class="border-top pt-3 mb-3">
                                <h5 class="text-end mb-0">
                                    Tổng cộng:
                                    <span class="text-danger fw-bold">
                                        {{ formatPrice(totalAmount) }}
                                    </span>
                                </h5>
                            </div>

                            <!-- Nút đặt hàng -->
                            <button class="btn btn-success w-100" @click="handleCheckout" :disabled="loading">
                                <span v-if="loading">Đang xử lý...</span>
                                <span v-else>Đặt hàng ngay</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 🚫 Giỏ hàng trống -->
            <div v-else class="text-center mt-5">
                <p>Giỏ hàng của bạn đang trống.</p>
                <router-link to="/menu" class="btn btn-primary">Quay lại menu</router-link>
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
    address: ''
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
        console.log('🧾 Cart items:', res.data.items)
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
        router.push('/')
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
    padding: 40px 0;
}

.card {
    border-radius: 12px;
    overflow: hidden;
}

.card-header {
    font-weight: 600;
}

.form-label {
    font-weight: 500;
}

textarea.form-control {
    resize: none;
}
</style>
