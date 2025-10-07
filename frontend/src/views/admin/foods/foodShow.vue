<template>
    <div class="container-fluid mt-4">
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-3 gap-2">
            <h2 class="fw-bold mb-0">Food Detail</h2>
            <router-link to="/admin/food" class="btn btn-outline-secondary">Back to list</router-link>
        </div>

        <div v-if="loading" class="p-4 text-center text-muted">Loading...</div>
        <div v-else-if="error" class="alert alert-danger">{{ error }}</div>
        <div v-else-if="food" class="card shadow-sm w-100">
            <div class="card-body">
                <div class="row g-4 align-items-start">
                    <div class="col-12 col-md-4" v-if="food.image">
                        <img :src="food.image" alt="Image" class="img-fluid rounded shadow-sm w-100" style="max-width: 500px; object-fit: cover;" />
                    </div>
                    <div class="col-12 col-md-8">
                        <h4 class="card-title mb-2">{{ food.name }}</h4>
                        <div class="text-muted mb-3">{{ food.description }}</div>
                        <div class="mb-2"><strong>Price:</strong> {{ formatCurrency(food.price) }}</div>
                        <div class="mb-2"><strong>Category:</strong> {{ food.category?.name || 'No category' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import { ref, onMounted } from 'vue';
import api from '@/services/api';

const props = defineProps({
    id: {
        type: String,
        required: true
    }
})
const food = ref(null);
const loading = ref(true)
const error = ref(null)

onMounted(async () => {
    try {
        const res = await api.get(`/foods/${props.id}`)
        food.value = res.data.data
    } catch (err) {
        error.value = 'Unable to load food data.'
    } finally {
        loading.value = false
    }
})

const formatCurrency = (value) => {
    if (value == null) return ''
    try {
        return new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(Number(value))
    } catch (e) {
        return value
    }
}
</script>
<style></style>