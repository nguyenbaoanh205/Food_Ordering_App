<template>
    <div class="container mt-4">
        <h2 class="fw-bold mb-3">Thêm món ăn</h2>

        <div class="card shadow-sm">
            <div class="card-body">
                <form @submit.prevent="createFood">
                    <div class="mb-3">
                        <label class="form-label">Tên món</label>
                        <input v-model="form.name" type="text" class="form-control" />
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Giá</label>
                        <input v-model="form.price" type="number" class="form-control" />
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

                    <button type="submit" class="btn btn-success">Thêm</button>
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
    const res = await api.get('/categories') // API lấy danh mục
    categories.value = res.data
})

const createFood = async () => {
    try {
        //   console.log(form.value)
        await api.post('/foods', form.value)
        alert('Thêm thành công!')
        router.push('/admin/food')
    } catch (err) {
        alert('Lỗi thêm món ăn')
    }
}
</script>
