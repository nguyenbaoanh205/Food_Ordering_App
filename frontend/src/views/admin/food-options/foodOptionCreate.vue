<template>
  <div class="container-fluid mt-4">
    <div class="d-flex flex-wrap align-items-center justify-content-between mb-3 gap-2">
      <h2 class="fw-bold mb-0">Add Food Option</h2>
      <router-link to="/admin/food-options" class="btn btn-outline-secondary">Back to list</router-link>
    </div>

    <div class="card shadow-sm w-100">
      <div class="card-body">
        <form @submit.prevent="createOption">
          <div class="row g-4">

            <!-- 🔹 Chọn món ăn -->
            <div class="col-12 col-md-6">
              <label class="form-label">Food</label>
              <select v-model="form.food_id" class="form-select">
                <option disabled value="">-- Select Food --</option>
                <option v-for="food in foods" :key="food.id" :value="food.id">
                  {{ food.name }}
                </option>
              </select>
            </div>

            <!-- 🔹 Tên tùy chọn -->
            <div class="col-12 col-md-6">
              <label class="form-label">Option Name</label>
              <input
                v-model="form.name"
                type="text"
                class="form-control"
                placeholder="Enter option name (e.g. Extra Cheese, Size L)"
              />
            </div>

            <!-- 🔹 Giá cộng thêm -->
            <div class="col-12 col-md-6">
              <label class="form-label">Extra Price ($)</label>
              <input
                v-model="form.extra_price"
                type="number"
                min="0"
                step="0.01"
                class="form-control"
                placeholder="Enter extra price"
              />
            </div>

            <!-- 🔹 Loại tùy chọn -->
            <div class="col-12 col-md-6">
              <label class="form-label">Type</label>
              <select v-model="form.type" class="form-select">
                <option disabled value="">-- Select Type --</option>
                <option value="size">Size</option>
                <option value="topping">Topping</option>
              </select>
            </div>
          </div>

          <div class="mt-4 d-flex gap-2">
            <button type="submit" class="btn btn-success">Create</button>
            <router-link to="/admin/food-options" class="btn btn-secondary">Cancel</router-link>
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

// 🧾 Danh sách món ăn để chọn
const foods = ref([])

const form = ref({
  food_id: '',
  name: '',
  extra_price: '',
  type: '',
})

// 📥 Lấy danh sách món ăn
const fetchFoods = async () => {
  try {
    const res = await api.get('/foods')
    foods.value = res.data.data || res.data // Tùy API trả về
  } catch (err) {
    alert('Failed to load food list')
  }
}

// 🧩 Gửi request tạo option
const createOption = async () => {
  try {
    await api.post('/food-options', form.value)
    alert('Food option created successfully!')
    router.push('/admin/food-options')
  } catch (err) {
    console.error(err)
    alert('Failed to create food option')
  }
}

onMounted(fetchFoods)
</script>

<style scoped>
.fw-500 {
  font-weight: 500;
}
</style>
