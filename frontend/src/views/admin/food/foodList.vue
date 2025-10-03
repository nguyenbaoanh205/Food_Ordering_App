<template>
    <div>
        <h2 class="fw-bold mb-4">Quản lý food</h2>

        <RouterLink :to="{ name: 'foodCreate' }" class="btn btn-primary mb-3">Add Food</RouterLink>

        <div class="card shadow-sm">
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>id</th>
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
                            <td>{{ food.price }}</td>
                            <td>{{ food.description }}</td>
                            <td>
                                <img :src="food.image" alt="" style="width: 100px; height: 100px; object-fit: cover;">
                            </td>
                            <td>{{ food.category?.name }}</td>
                            <td>
                                <RouterLink class="btn btn-sm btn-primary me-2"
                                    :to="{ name: 'foodShow', params: { id: food.id } }">Chi tiết</RouterLink>
                                <RouterLink class="btn btn-sm btn-primary me-2"
                                    :to="{ name: 'foodEdit', params: { id: food.id } }">Edit</RouterLink>
                                <button @click="deleteFood(food.id)" class="btn btn-sm btn-danger">Xóa</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- PHÂN TRANG -->
        <nav v-if="pagination.last_page > 1" class="mt-3">
            <ul class="pagination">
                <li class="page-item" :class="{ disabled: pagination.current_page === 1 }">
                    <button class="page-link" @click="changePage(pagination.current_page - 1)">«</button>
                </li>

                <li v-for="page in pagination.last_page" :key="page" class="page-item"
                    :class="{ active: page === pagination.current_page }">
                    <button class="page-link" @click="changePage(page)">{{ page }}</button>
                </li>

                <li class="page-item" :class="{ disabled: pagination.current_page === pagination.last_page }">
                    <button class="page-link" @click="changePage(pagination.current_page + 1)">»</button>
                </li>
            </ul>
        </nav>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api from '../../../services/api'
import { RouterLink } from 'vue-router'

const foods = ref([])
const loading = ref(true)
const error = ref(null)
const pagination = ref({
    current_page: 1,
    last_page: 1
})
const currentPage = ref(1)

const fetchFoods = async (page = 1) => {
    loading.value = true
    try {
        const res = await api.get(`/foods?page=${page}`)
        foods.value = res.data.data
        pagination.value = {
            current_page: res.data.current_page,
            last_page: res.data.last_page
        }
    } catch (err) {
        error.value = err.message || 'Lỗi kết nối API'
    } finally {
        loading.value = false
    }
}


onMounted(() => {
    fetchFoods()
})

const changePage = (page) => {
    if (page >= 1 && page <= pagination.value.last_page) {
        currentPage.value = page
        fetchFoods(page)
    }
}

const deleteFood = async (id) => {
    if (!confirm('Bạn có chắc muốn xoá món ăn này?')) return
    try {
        await api.delete(`/foods/${id}`)
        // Sau khi xoá xong, gọi lại API để refresh danh sách
        fetchFoods(currentPage.value)
        alert('Xoá thành công!')
    } catch (err) {
        alert('Có lỗi khi xoá!')
    }
}
</script>
