<template>
    <div>
        <h2 class="fw-bold mb-4">Quản lý food</h2>
        <RouterLink :to="{ name: 'foodCreate' }" class="btn btn-primary mb-3">Add Food</RouterLink>
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>name</th>
                            <th>price</th>
                            <th>description</th>
                            <th>image</th>
                            <th>category</th>
                            <th>action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="food in foods" :key="food.id">
                            <td>{{ food.id }}</td>
                            <td>{{ food.name }}</td>
                            <td>{{ food.description }}</td>
                            <td>
                                <img :src="food.image" alt="" style="width: 100px; height: 100px; object-fit: cover;">
                            </td>
                            <td>
                                <!-- <span> -->
                                {{ food.category.name }}
                                <!-- </span> -->
                            </td>
                            <td>
                                <RouterLink class="btn btn-sm btn-primary me-2" :to="{ name: 'foodShow', params: { id: food.id } }">Chi tiết</RouterLink>
                                <button class="btn btn-sm btn-danger">Xóa</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
<script setup>
import { ref, onMounted } from 'vue'
import api from '../../../services/api'
import { RouterLink } from 'vue-router'

const foods = ref([])
const loading = ref(true)
const error = ref(null)

onMounted(async () => {
    try {
        const res = await api.get('/foods')
        foods.value = res.data.data
    } catch (err) {
        error.value = err.message || 'Lỗi kết nối API'
    } finally {
        loading.value = false
    }
})
</script>