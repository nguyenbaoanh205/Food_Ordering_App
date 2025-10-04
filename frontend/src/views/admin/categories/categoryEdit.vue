<template>
    <div class="container mt-4">
        <h2 class="fw-bold mb-3">Chỉnh sửa danh mục</h2>

        <div class="card shadow-sm">
            <div class="card-body">
                <form @submit.prevent="updateCategory">
                    <div class="mb-3">
                        <label class="form-label">Tên danh mục</label>
                        <input v-model="form.name" type="text" class="form-control" />
                    </div>

                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                    <router-link to="/admin/category" class="btn btn-secondary ms-2">Hủy</router-link>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import api from '@/services/api'

const props = defineProps({
    id: {
        type: String,
        required: true
    }
})

const router = useRouter()

const form = ref({
    name: '',
})

onMounted(async () => {
    try {
        const res = await api.get(`/categories/${props.id}`)        
        const categories = res.data.data

        form.value = {
            name: categories.name,
        }
    } catch (err) {
        alert('Lỗi tải dữ liệu')
    }
})

const updateCategory = async () => {
    try {
        await api.put(`/categories/${props.id}`, form.value)
        alert('Cập nhật thành công!')
        router.push('/admin/category')
    } catch (err) {
        alert('Lỗi cập nhật món ăn')
    }
}
</script>
