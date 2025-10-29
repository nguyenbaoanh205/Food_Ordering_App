<template>
    <section class="food_section layout_padding-bottom">
        <div class="container">
            <div class="heading_container heading_center">
                <h2>Our Menu</h2>
            </div>

            <ul class="filters_menu">
                <li :class="{ active: activeFilter === 'all' }" @click="setFilter('all')">All</li>
                <li v-for="cat in categories" :key="cat.id" :class="{ active: activeFilter === cat.name.toLowerCase() }"
                    @click="setFilter(cat.name.toLowerCase())">
                    {{ cat.name }}
                </li>
            </ul>

            <div class="filters-content">
                <div class="row grid">
                    <MotionGroup tag="div" class="d-flex flex-wrap" :initial="{ opacity: 0, y: 30 }"
                        :enter="{ opacity: 1, y: 0 }" :leave="{ opacity: 0, y: -30 }" transition="ease-in-out">
                        <FoodCard v-for="foodChildren in filteredFoods" :key="foodChildren.id" :food="foodChildren"
                            @add-to-cart="addToCart" class="col-sm-6 col-lg-4" />
                    </MotionGroup>
                </div>
            </div>


            <!-- <div class="btn-box">
                <a href="#">View More</a>
            </div> -->
        </div>
    </section>
</template>
<script setup>
import { ref, computed, onMounted } from 'vue'
import api from '@/services/api'
import FoodCard from '@/components/client/FoodCard.vue'
import { useToast } from 'vue-toastification'

const toast = useToast()
const foods = ref([])
const categories = ref([])
const activeFilter = ref('all')

const filteredFoods = computed(() => {
    if (activeFilter.value === 'all') return foods.value
    return foods.value.filter(f => f.category?.name?.toLowerCase() === activeFilter.value)
})

const setFilter = (filter) => {
    activeFilter.value = filter
}

const fetchFoods = async () => {
    try {
        const res = await api.get('/foods')
        foods.value = res.data.data
        categories.value = res.data.data
            .map(f => f.category)                       // lấy category của từng food
            .filter((cat, index, self) =>               // loại trùng theo id
                cat && index === self.findIndex(c => c.id === cat.id)
            )
    } catch (err) {
        toast.error('Không thể tải menu!')
    }
}

const addToCart = (food) => {
    toast.success(`Đã thêm ${food.name} vào giỏ hàng!`)
}

onMounted(fetchFoods)
</script>
<style scoped></style>