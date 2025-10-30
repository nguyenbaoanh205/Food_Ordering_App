<template>
    <div class="container py-5">
        <!-- 🌀 Loading & Error -->
        <div v-if="loading" class="text-center text-muted py-5">Loading...</div>
        <div v-else-if="error" class="alert alert-danger">{{ error }}</div>

        <!-- ✅ Nội dung chính -->
        <div v-else>
            <div class="row g-5 align-items-start">
                <!-- ẢNH MÓN ĂN -->
                <div class="col-md-5 text-center">
                    <img :src="food.image" :alt="food.name" class="img-fluid rounded shadow-sm food-image" />
                </div>

                <!-- THÔNG TIN CHI TIẾT -->
                <div class="col-md-7">
                    <h2 class="fw-bold mb-2">{{ food.name }}</h2>
                    <p class="text-muted">{{ food.category?.name }}</p>
                    <p class="lead">{{ food.description }}</p>

                    <!-- GIÁ GỐC -->
                    <h4 class="text-primary fw-bold mb-3">{{ formatCurrency(food.price) }}</h4>

                    <!-- SIZE OPTIONS -->
                    <div v-if="sizeOptions.length" class="mb-3">
                        <h6 class="fw-bold">Select Size</h6>
                        <div class="d-flex flex-wrap gap-2">
                            <button v-for="size in sizeOptions" :key="size.id" @click="selectedSize = size" class="btn"
                                :class="selectedSize?.id === size.id ? 'btn-primary' : 'btn-outline-primary'">
                                {{ size.name }}
                                <span v-if="size.extra_price">(+{{ size.extra_price }}$)</span>
                            </button>
                        </div>
                    </div>

                    <!-- TOPPING OPTIONS -->
                    <div v-if="toppingOptions.length" class="mb-3">
                        <h6 class="fw-bold">Extra Toppings</h6>
                        <div class="d-flex flex-wrap gap-3">
                            <div v-for="topping in toppingOptions" :key="topping.id" class="form-check">
                                <input type="checkbox" class="form-check-input" :id="`topping-${topping.id}`"
                                    :value="topping" v-model="selectedToppings" />
                                <label :for="`topping-${topping.id}`" class="form-check-label">
                                    {{ topping.name }}
                                    <small v-if="topping.extra_price">(+{{ topping.extra_price }}$)</small>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- SỐ LƯỢNG -->
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <label class="fw-bold">Quantity</label>
                        <div class="input-group quantity-box">
                            <button class="btn btn-outline-secondary" @click="decreaseQty">-</button>
                            <input type="number" class="form-control text-center" v-model.number="quantity" min="1" />
                            <button class="btn btn-outline-secondary" @click="increaseQty">+</button>
                        </div>
                    </div>

                    <!-- TỔNG TIỀN -->
                    <h5 class="fw-bold mb-4">
                        Total:
                        <span class="text-success">{{ formatCurrency(totalPrice) }}</span>
                    </h5>

                    <!-- BUTTON -->
                    <div class="d-flex flex-wrap gap-3">
                        <button class="btn btn-success px-4 py-2" @click="addToCart">
                            <i class="bi bi-cart-plus"></i> Add to Cart
                        </button>
                        <RouterLink to="/" class="btn btn-outline-secondary px-4 py-2">
                            Back
                        </RouterLink>
                    </div>
                </div>
            </div>

            <!-- 💬 FEEDBACK -->
            <div class="feedback-section mt-5">
                <h4 class="fw-bold mb-3">Customer Feedback</h4>
                <div v-if="feedbacks.length">
                    <div v-for="fb in feedbacks" :key="fb.id" class="border-bottom pb-3 mb-3">
                        <div class="d-flex justify-content-between">
                            <strong>{{ fb.user.name }}</strong>
                            <small class="text-muted">{{ new Date(fb.created_at).toLocaleDateString() }}</small>
                        </div>
                        <p class="mb-1">{{ fb.comment }}</p>
                        <small class="text-warning">
                            <i class="bi bi-star-fill" v-for="n in fb.rating" :key="n"></i>
                        </small>
                    </div>
                </div>
                <div v-else class="text-muted">No feedback yet.</div>
            </div>

            <!-- 🧁 SẢN PHẨM LIÊN QUAN -->
            <div class="related-section mt-5">
                <h4 class="fw-bold mb-3">You may also like</h4>
                <div class="row g-3">
                    <div v-for="related in relatedFoods" :key="related.id" class="col-6 col-md-3">
                        <RouterLink :to="{ name: 'foodDetail', params: { id: related.id } }"
                            class="text-decoration-none text-dark">
                            <div class="card shadow-sm border-0 h-100">
                                <img :src="related.image" class="card-img-top" :alt="related.name" />
                                <div class="card-body text-center">
                                    <h6 class="fw-bold">{{ related.name }}</h6>
                                    <p class="text-primary mb-0">{{ formatCurrency(related.price) }}</p>
                                </div>
                            </div>
                        </RouterLink>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import api from '@/services/api'
import { useToast } from 'vue-toastification'
import { useUserStore } from '@/stores/user'

const toast = useToast()
const route = useRoute()
const router = useRouter()
const userStore = useUserStore()
const food = ref({})
const relatedFoods = ref([])
const feedbacks = ref([])
const loading = ref(true)
const error = ref(null)

const sizeOptions = ref([])
const toppingOptions = ref([])

const selectedSize = ref(null)
const selectedToppings = ref([])
const quantity = ref(1)

// ✅ Lấy dữ liệu món ăn
const fetchFoodDetail = async () => {
    try {
        const res = await api.get(`/foods/${route.params.id}`)
        food.value = res.data.data
        const options = food.value.options || []
        sizeOptions.value = options.filter(o => o.type === 'size')
        toppingOptions.value = options.filter(o => o.type === 'topping')
        fetchRelatedFoods()
        fetchFeedbacks()
    } catch (err) {
        error.value = 'Failed to load food details'
    } finally {
        loading.value = false
    }
}

// ✅ Lấy sản phẩm liên quan (theo category)
const fetchRelatedFoods = async () => {
    if (!food.value.category_id) return
    const res = await api.get(`/foods?category_id=${food.value.category_id}`)
    relatedFoods.value = res.data.data.filter(f => f.id !== food.value.id).slice(0, 4)
}

// ✅ Lấy feedback từ khách hàng
const fetchFeedbacks = async () => {
    const res = await api.get(`/reviews?food_id=${food.value.id}`)
    feedbacks.value = res.data.data || []
}

// ✅ Tính tổng tiền
const totalPrice = computed(() => {
    let total = Number(food.value.price) || 0
    if (selectedSize.value) total += Number(selectedSize.value.extra_price || 0)
    selectedToppings.value.forEach(t => (total += Number(t.extra_price || 0)))
    return total * quantity.value
})

// ✅ Thêm vào giỏ hàng
const addToCart = async () => {
    try {
        const userId = userStore.user.id
        const basePrice = Number(food.value.price) || 0
        const sizeExtra = selectedSize.value ? Number(selectedSize.value.extra_price) : 0
        const toppingsExtra = selectedToppings.value.reduce((sum, t) => sum + Number(t.extra_price || 0), 0)

        const totalItemPrice = basePrice + sizeExtra + toppingsExtra

        const payload = {
            user_id: userId,
            food_id: food.value.id,
            quantity: quantity.value,
            price: totalItemPrice, // ✅ Gửi đúng field backend cần
            size_option_id: selectedSize.value ? selectedSize.value.id : null, // 🟢 thêm dòng này
            topping_option_ids: selectedToppings.value.map(t => t.id),
        }

        await api.post('/cart/add', payload)
        console.log(payload);

        toast.success('Added to cart successfully!')
        router.push('/cart')

    } catch (err) {
        console.error(err)
        toast.error('Failed to add to cart')
    }
}


const increaseQty = () => quantity.value++
const decreaseQty = () => (quantity.value > 1 ? quantity.value-- : 1)
const formatCurrency = val =>
    new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(val)

onMounted(fetchFoodDetail)
</script>

<style scoped>
.food-image {
    max-height: 400px;
    object-fit: cover;
    width: 100%;
}

.quantity-box {
    width: 120px;
}

.related-section img {
    height: 150px;
    object-fit: cover;
}

.feedback-section i {
    font-size: 0.9rem;
}

@media (max-width: 768px) {
    .food-image {
        max-height: 280px;
    }

    .quantity-box {
        width: 100px;
    }
}
</style>
