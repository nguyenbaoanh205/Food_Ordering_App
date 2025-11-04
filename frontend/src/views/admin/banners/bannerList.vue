<template>
    <div class="container-fluid mt-4">
        <!-- Header -->
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-3 gap-2">
            <h2 class="fw-bold mb-0">Banner Management</h2>

            <div class="d-flex align-items-center gap-2">
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                    <input v-model="keyword" type="search" class="form-control" placeholder="Search by title..."
                        @keydown.enter.prevent="applySearch" />
                </div>
                <RouterLink :to="{ name: 'bannerCreate' }" class="btn btn-success w-50">
                    Add Banner
                </RouterLink>
            </div>
        </div>

        <!-- Table -->
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div v-if="loading" class="p-4 text-center text-muted">Loading data...</div>
                <div v-else-if="error" class="alert alert-danger m-3">{{ error }}</div>
                <div v-else>
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-nowrap col-id">#</th>
                                <th class="col-title">Title</th>
                                <th class="col-desc">Description</th>
                                <th class="col-link">Link Url</th>
                                <th class="text-center col-status">Status</th>
                                <th class="text-nowrap text-center col-actions">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-if="banners.length === 0">
                                <td colspan="5" class="text-center text-muted py-4">No matching results</td>
                            </tr>
                            <tr v-for="(banner, index) in banners" :key="banner.id">
                                <td>{{ (pagination.current_page - 1) * pagination.per_page + index + 1 }}</td>
                                <td class="fw-500">{{ banner.title }}</td>
                                <td class="text-truncate" style="max-width: 250px">{{ banner.description }}</td>
                                <td class="text-truncate" style="max-width: 100px">{{ banner.link }}</td>
                                <td class="text-center">
                                    <span class="badge" :class="banner.status ? 'bg-success' : 'bg-secondary'">
                                        {{ banner.status ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <RouterLink class="btn btn-sm btn-primary me-2"
                                        :to="{ name: 'bannerEdit', params: { id: banner.id } }">Edit</RouterLink>
                                    <button @click="deleteBanner(banner.id)" class="btn btn-sm btn-danger">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Pagination -->
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
import { RouterLink } from 'vue-router'
import api from '@/services/api'
import { useToast } from 'vue-toastification'

const toast = useToast()
const banners = ref([])
const loading = ref(true)
const error = ref(null)
const keyword = ref('')
const currentPage = ref(1)
const pagination = ref({
    current_page: 1,
    last_page: 1,
    per_page: 10,
})

const fetchBanners = async (page = 1) => {
    try {
        const q = keyword.value ? `&q=${encodeURIComponent(keyword.value)}` : ''
        const res = await api.get(`/banners?page=${page}${q}`)
        banners.value = res.data.data
        pagination.value = {
            current_page: res.data.current_page,
            last_page: res.data.last_page,
            per_page: res.data.per_page || 10,
        }
    } catch (err) {
        error.value = err.message || 'Failed to connect to API'
    } finally {
        loading.value = false
    }
}

onMounted(() => {
    fetchBanners()
})

const changePage = (page) => {
    if (page >= 1 && page <= pagination.value.last_page) {
        currentPage.value = page
        fetchBanners(page)
    }
}

const applySearch = () => {
    loading.value = true
    currentPage.value = 1
    fetchBanners(1)
}

const deleteBanner = async (id) => {
    if (!confirm('Are you sure you want to delete this banner?')) return
    try {
        await api.delete(`/banners/${id}`)
        fetchBanners(currentPage.value)
        toast.success('Banner deleted successfully!')
    } catch (err) {
        toast.error('Failed to delete banner!')
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

.col-id {
    width: 60px;
}

.col-title {
    width: 20%;
}

.col-desc {
    width: 25%;
}

.col-link {
    width: 20%;
}

.col-status {
    width: 120px;
}

.col-actions {
    width: 180px;
}

table {
    table-layout: fixed;
}
</style>
