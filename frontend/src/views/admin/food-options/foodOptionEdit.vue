<template>
  <div class="container-fluid mt-4">
    <div class="d-flex flex-wrap align-items-center justify-content-between mb-3 gap-2">
      <h2 class="fw-bold mb-0">Edit Food Option</h2>
      <router-link to="/admin/food-options" class="btn btn-outline-secondary">
        Back to list
      </router-link>
    </div>

    <div class="card shadow-sm w-100">
      <div class="card-body">
        <form @submit.prevent="updateOption">
          <div class="row g-4">
            <!-- 🔹 Món ăn -->
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
                placeholder="Enter option name"
              />
            </div>

            <!-- 🔹 Giá cộng thêm -->
            <div class="col-12 col-md-6">
              <label class="form-label">Extra Price ($)</label>
              <input
                v-model="form.extra_price"
                type="number"
                step="0.01"
                min="0"
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
            <button type="submit" class="btn btn-primary">Update</button>
            <router-link to="/admin/food-options" class="btn btn-secondary">Cancel</router-link>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import api from '@/services/api'

const router = useRouter()
const route = useRoute()
const id = route.params.id

const form = ref({
  food_id: '',
  name: '',
  extra_price: '',
  type: ''
})

const foods = ref([])

// 📥 Lấy danh sách món ăn
const fetchFoods = async () => {
  try {
    const res = await api.get('/foods/select')
    foods.value = res.data.data || res.data
  } catch (err) {
    console.error(err)
    alert('Failed to load food list')
  }
}

// 📥 Lấy dữ liệu option cần sửa
const fetchOption = async () => {
  try {
    const res = await api.get(`/food-options/${id}`)
    const option = res.data.data

    form.value = {
      food_id: option.food_id,
      name: option.name,
      extra_price: option.extra_price,
      type: option.type
    }
  } catch (err) {
    console.error(err)
    alert('Failed to load food option')
  }
}

// 📤 Cập nhật option
const updateOption = async () => {
  try {
    await api.put(`/food-options/${id}`, form.value)
    alert('Food option updated successfully!')
    router.push('/admin/food-options')
  } catch (err) {
    console.error(err)
    alert('Failed to update food option')
  }
}

onMounted(() => {
  fetchFoods()
  fetchOption()
})
</script>

<style scoped>
.fw-500 {
  font-weight: 500;
}
</style>
