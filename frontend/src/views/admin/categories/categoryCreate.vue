<template>
    <div class="container mt-4">
        <h2 class="fw-bold mb-3">Thêm danh muc</h2>

        <div class="card shadow-sm">
            <div class="card-body">
                <form @submit.prevent="createCategory">
                    <div class="mb-3">
                        <label class="form-label">Tên danh mục</label>
                        <input v-model="form.name" type="text" class="form-control" />
                    </div>

                    <button type="submit" class="btn btn-success">Thêm</button>
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

const router = useRouter()

const form = ref({
    name: '',
})

const createCategory = async () => {
    try {
        await api.post('/categories', form.value)
        alert('Thêm thành công!')
        router.push('/admin/category')
    } catch (err) {
        alert('Lỗi thêm món ăn')
    }
}
</script>
