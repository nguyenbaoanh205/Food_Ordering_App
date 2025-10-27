<template>
    <div class="container-fluid mt-4">
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-3 gap-2">
            <h2 class="fw-bold mb-0">User Management</h2>
            <div class="d-flex align-items-center gap-2">
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                    <input v-model="keyword" type="search" class="form-control"
                        placeholder="Search by name or email..." @keydown.enter.prevent="applySearch" />
                </div>
                <RouterLink :to="{ name: 'userCreate' }" class="btn btn-success w-50">Add User</RouterLink>
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
                                <th class="text-nowrap col-id">#</th>
                                <th class="col-name">Name</th>
                                <th>Email</th>
                                <th class="text-center">Role</th>
                                <th class="text-nowrap text-center col-actions">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-if="users.length === 0">
                                <td colspan="5" class="text-center text-muted py-4">No matching results</td>
                            </tr>
                            <tr v-for="(user, index) in users" :key="user.id">
                                <td class="col-id">{{ (pagination.current_page - 1) * (pagination.per_page || 10) + index + 1 }}</td>
                                <td class="fw-500 col-name">{{ user.name }}</td>
                                <td>{{ user.email }}</td>
                                <td class="text-center">
                                    <span v-if="user.role === 1" class="badge bg-primary">Admin</span>
                                    <span v-else class="badge bg-secondary">User</span>
                                </td>
                                <td class="text-center col-actions">
                                    <RouterLink class="btn btn-sm btn-primary me-2"
                                        :to="{ name: 'userEdit', params: { id: user.id } }">Edit</RouterLink>
                                    <button @click="deleteUser(user.id)" class="btn btn-sm btn-danger">Delete</button>
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

const users = ref([])
const loading = ref(true)
const error = ref(null)
const pagination = ref({
    current_page: 1,
    last_page: 1,
    per_page: 10
})
const currentPage = ref(1)
const keyword = ref('')

const fetchUsers = async (page = 1) => {
    try {
        const q = keyword.value ? `&q=${encodeURIComponent(keyword.value)}` : ''
        const res = await api.get(`/users?page=${page}${q}`)
        users.value = res.data.data
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
    fetchUsers()
})

const changePage = (page) => {
    if (page >= 1 && page <= pagination.value.last_page) {
        currentPage.value = page
        fetchUsers(page)
    }
}

const applySearch = () => {
    loading.value = true
    currentPage.value = 1
    fetchUsers(1)
}

const deleteUser = async (id) => {
    if (!confirm('Are you sure you want to delete this user?')) return
    try {
        await api.delete(`/users/${id}`)
        fetchUsers(currentPage.value)
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
.col-name { width: 25%; }

table { table-layout: fixed; }
</style>
