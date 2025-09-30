<!-- src/views/Foods.vue -->
<script setup>
import { ref, onMounted } from 'vue'
import api from '../services/api'

const foods = ref([])
const loading = ref(true)
const error = ref(null)

onMounted(async () => {
  try {
    const res = await api.get('/foods')
    foods.value = res.data
  } catch (err) {
    error.value = err.message || 'Lỗi kết nối API'
  } finally {
    loading.value = false
  }
})
</script>

<template>
  <div>
    <h1>Danh sách món ăn</h1>

    <p v-if="loading">Đang tải...</p>
    <p v-if="error" style="color:red">{{ error }}</p>

    <ul v-if="!loading && !error">
      <li v-for="f in foods" :key="f.id">
        {{ f.name }} - {{ f.price }} VNĐ
      </li>
    </ul>
  </div>
</template>
