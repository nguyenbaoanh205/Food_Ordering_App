<template>
    <div class="container mt-4">
        <h1 class="mb-3">Chi tiết món ăn</h1>

        <!-- Loading -->
        <div v-if="loading" class="alert alert-info">Đang tải dữ liệu...</div>

        <!-- Error -->
        <div v-if="error" class="alert alert-danger">{{ error }}</div>

        <!-- Hiển thị chi tiết -->
        <div v-if="food" class="card">
            <div class="card-body">
                <h4 class="card-title">{{ food.name }}</h4>
                <p class="card-text">{{ food.description }}</p>
                <p><strong>Giá:</strong> {{ food.price }} VNĐ</p>
                <p><strong>Loại:</strong> {{ food.category?.name || 'No category' }}</p>

                <div v-if="food.image">
                    <img :src="food.image" alt="Hình ảnh" class="img-fluid rounded" style="max-width: 400px;" />
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
        const res = await api.get(`/foods/${props.id}`) // call API theo id
        food.value = res.data.data
    } catch (err) {
        error.value = 'Không thể tải dữ liệu món ăn.'
    } finally {
        loading.value = false
    }
})
</script>
<style></style>