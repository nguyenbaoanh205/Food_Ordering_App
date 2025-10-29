<template>
    <div class="container-fluid mt-4">
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-3 gap-2">
            <h2 class="fw-bold mb-0">Edit Food</h2>
            <router-link to="/admin/food" class="btn btn-outline-secondary">Back to list</router-link>
        </div>

        <div class="card shadow-sm w-100">
            <div class="card-body">
                <form @submit.prevent="updateFood">
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
                        <button type="submit" class="btn btn-primary">Update</button>
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
import { useToast } from "vue-toastification";
const toast = useToast();
// receive id from route
const props = defineProps({
    id: {
        type: String,
        required: true
    }
})

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
    try {
        // Fetch categories
        const catRes = await api.get('/categories')
        categories.value = catRes.data.data
        
        // Fetch food detail
        const res = await api.get(`/foods/${props.id}`)
        // Handle both { data: { ... } } and direct object
        const food = res.data.data || res.data

        form.value = {
            name: food.name,
            price: food.price,
            description: food.description,
            image: food.image,
            category_id: food.category_id
        }
    } catch (err) {
        toast.error('Failed to load data')
    }
})

const updateFood = async () => {
    try {
        await api.put(`/foods/${props.id}`, form.value)
        toast.success('Updated successfully!')
        router.push('/admin/food')
    } catch (err) {
        toast.error('Failed to update food')
    }
}
</script>
