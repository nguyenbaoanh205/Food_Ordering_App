<template>
    <div class="container-fluid mt-4">
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-3 gap-2">
            <h2 class="fw-bold mb-0">Add Food</h2>
            <router-link to="/admin/food" class="btn btn-outline-secondary">Back to list</router-link>
        </div>

        <div class="card shadow-sm w-100">
            <div class="card-body">
                <form @submit.prevent="createFood">
                    <div class="row g-4">
                        <div class="col-12 col-md-6">
                            <label class="form-label">Name</label>
                            <input v-model="form.name" type="text" class="form-control" placeholder="Enter food name" />
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label">Price</label>
                            <input v-model="form.price" type="number" step="0.01" class="form-control" placeholder="Enter price" />
                        </div>

                        <div class="col-12">
                            <label class="form-label">Description</label>
                            <textarea v-model="form.description" class="form-control" rows="3" placeholder="Enter description"></textarea>
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label">Image (URL)</label>
                            <input v-model="form.image" type="text" class="form-control" placeholder="https://..." />
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label">Category</label>
                            <select v-model="form.category_id" class="form-select">
                                <option disabled value="">-- Select category --</option>
                                <option v-for="c in categories" :key="c.id" :value="c.id">{{ c.name }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-success">Create</button>
                        <router-link to="/admin/food" class="btn btn-secondary">Cancel</router-link>
                    </div>
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
    const res = await api.get('/categories')
    categories.value = res.data.data
})

const createFood = async () => {
    try {
        await api.post('/foods', form.value)
        alert('Created successfully!')
        router.push('/admin/food')
    } catch (err) {
        alert('Failed to create food')
    }
}
</script>
