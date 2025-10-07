<template>
    <div>
        <h2 class="fw-bold mb-4">Quản lý category</h2>

        <RouterLink :to="{ name: 'categoryCreate' }" class="btn btn-primary mb-3">Add Category</RouterLink>

        <div class="card shadow-sm">
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>id</th>
                            <th>name</th>
                            <th>action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="category in categories" :key="category.id">
                            <td>{{ category.id }}</td>
                            <td>{{ category.name }}</td>
                            <td>
                                <RouterLink class="btn btn-sm btn-primary me-2"
                                    :to="{ name: 'categoryEdit', params: { id: category.id } }">Edit</RouterLink>
                                <button @click="deletecategory(category.id)" class="btn btn-sm btn-danger">Xóa</button>
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

const categories = ref([])
const loading = ref(true)
const error = ref(null)
const pagination = ref({
    current_page: 1,
    last_page: 1
})
const currentPage = ref(1)

const fetchcategories = async (page = 1) => {
    try {
        const res = await api.get(`/categories?page=${page}`)
        categories.value = res.data.data
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
    fetchcategories()
})

const changePage = (page) => {
    if (page >= 1 && page <= pagination.value.last_page) {
        currentPage.value = page
        fetchcategories(page)
    }
}

const deletecategory = async (id) => {
    if (!confirm('Bạn có chắc muốn xoá món ăn này?')) return
    try {
        await api.delete(`/categories/${id}`)
        // Sau khi xoá xong, gọi lại API để refresh danh sách
        fetchcategories(currentPage.value)
        alert('Xoá thành công!')
    } catch (err) {
        alert('Có lỗi khi xoá!')
    }
}
</script>
