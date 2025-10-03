<template>
    <div class="container mt-4">
        <h2 class="fw-bold mb-3">Chỉnh sửa món ăn</h2>

        <div class="card shadow-sm">
            <div class="card-body">
                <form @submit.prevent="updateFood">
                    <div class="mb-3">
                        <label class="form-label">Tên món</label>
                        <input v-model="form.name" type="text" class="form-control" />
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Giá</label>
                        <input v-model="form.price" type="text" class="form-control" />
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Mô tả</label>
                        <textarea v-model="form.description" class="form-control"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Hình ảnh (URL)</label>
                        <input v-model="form.image" type="text" class="form-control" />
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Danh mục</label>
                        <select v-model="form.category_id" class="form-select">
                            <option v-for="c in categories" :key="c.id" :value="c.id">
                                {{ c.name }}
                            </option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                    <router-link to="/admin/food" class="btn btn-secondary ms-2">Hủy</router-link>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import api from '@/services/api'

// ✅ nhận props từ router
const props = defineProps({
    id: {
        type: String,
        required: true
    }
})

const router = useRouter()

const form = ref({
    name: '',
    price: '',
    description: '',
    image: '',
    category_id: ''
})

const categories = ref([])

onMounted(async () => {
    try {
        // Lấy danh mục
        const catRes = await api.get('/categories')
        categories.value = catRes.data

        // Lấy chi tiết món ăn
        const res = await api.get(`/foods/${props.id}`)
        // 👇 Nếu Laravel trả về { data: { ... } }
        const food = res.data.data || res.data

        form.value = {
            name: food.name,
            price: food.price,
            description: food.description,
            image: food.image,
            category_id: food.category_id
        }
    } catch (err) {
        alert('Lỗi tải dữ liệu')
    }
})

const updateFood = async () => {
    try {
        await api.put(`/foods/${props.id}`, form.value)
        alert('Cập nhật thành công!')
        router.push('/admin/food')
    } catch (err) {
        alert('Lỗi cập nhật món ăn')
    }
}
</script>
