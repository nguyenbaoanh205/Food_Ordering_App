<template>
    <div class="container-fluid mt-4">
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-3 gap-2">
            <h2 class="fw-bold mb-0">Add Category</h2>
            <router-link to="/admin/category" class="btn btn-outline-secondary">Back to list</router-link>
        </div>

        <div class="card shadow-sm w-100">
            <div class="card-body">
                <form @submit.prevent="createCategory">
                    <div class="row g-4">
                        <div class="col-12 col-md-6">
                            <label class="form-label">Name</label>
                            <input v-model="form.name" type="text" class="form-control" placeholder="Enter category name" />
                        </div>
                    </div>

                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-success">Create</button>
                        <router-link to="/admin/category" class="btn btn-secondary">Cancel</router-link>
                    </div>
                </form>
            </div>
        </div>
    </div>

</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import api from '@/services/api'

const router = useRouter()

const form = ref({
    name: '',
})

const createCategory = async () => {
    try {
        await api.post('/categories', form.value)
        alert('Created successfully!')
        router.push('/admin/category')
    } catch (err) {
        alert('Failed to create category')
    }
}
</script>
