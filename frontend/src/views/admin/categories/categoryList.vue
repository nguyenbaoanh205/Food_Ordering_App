<template>
    <div class="container-fluid mt-4">
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-3 gap-2">
            <h2 class="fw-bold mb-0">Category Management</h2>
            <div class="d-flex align-items-center gap-2">
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                    <input v-model="keyword" type="search" class="form-control"
                        placeholder="Search by name..." @keydown.enter.prevent="applySearch" />
                </div>
                <RouterLink :to="{ name: 'categoryCreate' }" class="btn btn-success w-50">Add Category</RouterLink>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div v-if="loading" class="p-4 text-center text-muted">Loading data...</div>
                <div v-else-if="error" class="alert alert-danger m-3">{{ error }}</div>
                <div v-else>
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-nowrap col-id">ID</th>
                                <th class="col-name">Name</th>
                                <th class="text-nowrap text-center col-actions">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-if="categories.length === 0">
                                <td colspan="3" class="text-center text-muted py-4">No matching results</td>
                            </tr>
                            <tr v-for="(category, index) in categories" :key="category.id">
                                <td class="col-id">{{ (pagination.current_page - 1) * (pagination.per_page || 10) + index + 1 }}</td>
                                <td class="fw-500 col-name">{{ category.name }}</td>
                                <td class="text-center col-actions">
                                    <RouterLink class="btn btn-sm btn-primary me-2"
                                        :to="{ name: 'categoryEdit', params: { id: category.id } }">Edit</RouterLink>
                                    <button @click="deleteCategory(category.id)" class="btn btn-sm btn-danger">Delete</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <nav v-if="pagination.last_page > 1" class="mt-3">
            <ul class="pagination mb-0">
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
    last_page: 1,
    per_page: 10
})
const currentPage = ref(1)
const keyword = ref('')

const fetchCategories = async (page = 1) => {
    try {
        const q = keyword.value ? `&q=${encodeURIComponent(keyword.value)}` : ''
        const res = await api.get(`/categories?page=${page}${q}`)
        categories.value = res.data.data
        pagination.value = {
            current_page: res.data.current_page,
            last_page: res.data.last_page,
            per_page: res.data.per_page || 10
        }
    } catch (err) {
        error.value = err.message || 'Failed to connect to API'
    } finally {
        loading.value = false
    }
}

onMounted(() => {
    fetchCategories()
})

const changePage = (page) => {
    if (page >= 1 && page <= pagination.value.last_page) {
        currentPage.value = page
        fetchCategories(page)
    }
}

const applySearch = () => {
    loading.value = true
    currentPage.value = 1
    fetchCategories(1)
}

const deleteCategory = async (id) => {
    if (!confirm('Are you sure you want to delete this item?')) return
    try {
        await api.delete(`/categories/${id}`)
        fetchCategories(currentPage.value)
        alert('Deleted successfully!')
    } catch (err) {
        alert('Failed to delete!')
    }
}
</script>

<style scoped>
.fw-500 {
    font-weight: 500;
}

.table td,
.table th {
    vertical-align: middle;
}

.col-id { width: 72px; }
.col-actions { width: 200px; }
.col-name { width: 40%; }

/* Respect fixed layout and truncation if needed */
table { table-layout: fixed; }
</style>

