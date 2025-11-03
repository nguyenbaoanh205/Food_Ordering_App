<template>
    <section class="food_section layout_padding-bottom">
        <div class="container">
            <div class="heading_container heading_center">
                <h2>Our Menu</h2>
            </div>

            <!-- 🔹 Danh mục lọc món ăn -->
            <ul class="filters_menu">
                <li :class="{ active: activeFilter === 'all' }" @click="setFilter('all')">All</li>
                <li v-for="cat in categories" :key="cat.id" :class="{ active: activeFilter === cat.name.toLowerCase() }"
                    @click="setFilter(cat.name.toLowerCase())">
                    {{ cat.name }}
                </li>
            </ul>

            <!-- 🔹 Nội dung danh sách món ăn -->
            <div class="filters-content mt-3">
                <div v-if="loading" class="text-center text-secondary">Loading...</div>

                <div v-else>
                    <div v-if="filteredFoods.length" class="row grid">
                        <MotionGroup tag="div" class="d-flex flex-wrap" :initial="{ opacity: 0, y: 30 }"
                            :enter="{ opacity: 1, y: 0 }" :leave="{ opacity: 0, y: -30 }" transition="ease-in-out">
                            <FoodCard v-for="food in filteredFoods" :key="food.id" :food="food" @add-to-cart="addToCart"
                                class="col-sm-6 col-lg-4" />
                        </MotionGroup>
                    </div>

                    <div v-else class="text-center text-muted mt-4">
                        Không tìm thấy món ăn nào.
                    </div>
                </div>
            </div>

            <!-- 🔹 Phân trang -->
            <div class="pagination-container d-flex justify-content-center align-items-center mt-4"
                v-if="pagination.last_page > 1">
                <!-- Nút Previous -->
                <button class="pagination-btn mx-1" :disabled="pagination.current_page === 1"
                    @click="changePage(pagination.current_page - 1)">
                    ‹‹
                </button>

                <!-- Nút số trang -->
                <button v-for="page in pagination.last_page" :key="page" @click="changePage(page)"
                    class="pagination-btn mx-1" :class="{ active: pagination.current_page === page }">
                    {{ page }}
                </button>

                <!-- Nút Next -->
                <button class="pagination-btn mx-1" :disabled="pagination.current_page === pagination.last_page"
                    @click="changePage(pagination.current_page + 1)">
                    ››
                </button>
            </div>

        </div>
    </section>
</template>

<script setup>
import { ref, computed, onMounted, watch } from 'vue'
import { useRoute } from 'vue-router'
import api from '@/services/api'
import FoodCard from '@/components/client/FoodCard.vue'
import { useToast } from 'vue-toastification'

const toast = useToast()

// ⚙️ Dữ liệu chính
const foods = ref([])
const categories = ref([])
const activeFilter = ref('all')
const loading = ref(false)
const pagination = ref({
    current_page: 1,
    last_page: 1,
    per_page: 15,
})

const route = useRoute()

// 🧮 **Lọc danh sách món ăn theo danh mục**
const filteredFoods = computed(() => {
    if (activeFilter.value === 'all') return foods.value
    return foods.value.filter(
        (f) => f.category?.name?.toLowerCase() === activeFilter.value
    )
})

// 🔹 **Hàm đổi bộ lọc**
const setFilter = (filter) => {
    activeFilter.value = filter
    pagination.value.current_page = 1
    fetchFoods(1) // gọi lại API với category mới
}

const fetchCategories = async () => {
    try {
        const res = await api.get('/categories-client')
        categories.value = res.data
    } catch (err) {
        console.error(err)
        toast.error('Không thể tải danh mục!')
    }
}


// 🔍 Gọi API lấy danh sách món ăn (có hỗ trợ danh mục + tìm kiếm + phân trang)
const fetchFoods = async (page = 1) => {
    loading.value = true
    try {
        const { q } = route.query
        const params = {
            q,
            page,
            per_page: 15,
        }

        // nếu đang lọc theo danh mục cụ thể thì gửi lên API
        if (activeFilter.value !== 'all') {
            params.category = activeFilter.value
        }

        const res = await api.get('/foods-client', { params })

        foods.value = res.data.data

        pagination.value = {
            current_page: res.data.current_page,
            last_page: res.data.last_page,
            per_page: res.data.per_page,
        }

    } catch (err) {
        console.error(err)
        toast.error('Không thể tải menu!')
    } finally {
        loading.value = false
    }
}

// 🔁 **Chuyển trang**
const changePage = (page) => {
    if (page >= 1 && page <= pagination.value.last_page) {
        fetchFoods(page)
    }
}

// 🛒 **Thêm món vào giỏ hàng**
const addToCart = (food) => {
    toast.success(`Đã thêm ${food.name} vào giỏ hàng!`)
}

// 🚀 **Tự động gọi API khi trang load hoặc khi query thay đổi**
onMounted(() => {
    fetchCategories() // lấy toàn bộ danh mục
    fetchFoods()      // lấy danh sách món ăn
})
watch(() => route.query.q, () => fetchFoods(1))
</script>

<style scoped>
.pagination-btn {
    background-color: #979797;
    /* nền xám đậm */
    color: #f5f5f5;
    border: 1px solid #8d8d8d;
    border-radius: 6px;
    padding: 6px 12px;
    cursor: pointer;
    font-weight: 500;
    transition: all 0.3s ease;
}

.pagination-btn:hover:not(:disabled) {
    background-color: #3d3d3d;
    /* hover: sáng hơn chút */
    border-color: #4b4b4b;
}

.pagination-btn.active {
    background-color: #007bff;
    /* active: xanh lam */
    border-color: #006ae6;
    color: #fff;
    font-weight: 700;
}

.pagination-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}
</style>
