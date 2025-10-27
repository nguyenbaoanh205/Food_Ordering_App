<template>
  <section class="cart_section layout_padding">
    <div class="container">
      <div class="heading_container heading_center mb-4">
        <h2>Giỏ hàng của bạn</h2>
      </div>

      <div v-if="cartItems.length > 0" class="table-responsive">
        <table class="table table-bordered align-middle">
          <thead class="table-light">
            <tr>
              <th>Ảnh</th>
              <th>Sản phẩm</th>
              <th>Giá</th>
              <th>Số lượng</th>
              <th>Tổng</th>
              <th>Hành động</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="item in cartItems" :key="item.id">
              <td style="width:100px">
                <img :src="item.image" alt="" class="img-fluid rounded">
              </td>
              <td>{{ item.name }}</td>
              <td>{{ formatCurrency(item.price) }}</td>
              <td>
                <div class="d-flex align-items-center justify-content-center gap-2">
                  <button class="btn btn-outline-secondary btn-sm" @click="updateQuantity(item, -1)">-</button>
                  <span>{{ item.quantity }}</span>
                  <button class="btn btn-outline-secondary btn-sm" @click="updateQuantity(item, 1)">+</button>
                </div>
              </td>
              <td>{{ formatCurrency(item.price * item.quantity) }}</td>
              <td>
                <button class="btn btn-danger btn-sm" @click="removeItem(item.id)">
                  <i class="fa fa-trash"></i>
                </button>
              </td>
            </tr>
          </tbody>
        </table>

        <div class="text-end mt-4">
          <h4>Tổng cộng: <span class="text-primary">{{ formatCurrency(totalPrice) }}</span></h4>
          <RouterLink :to="{ name: 'Checkout' }" class="btn btn-warning mt-3">Thanh toán</RouterLink>
        </div>
      </div>

      <div v-else class="text-center py-5">
        <h5>Giỏ hàng của bạn đang trống.</h5>
        <RouterLink :to="{ name: 'Menu' }" class="btn btn-primary mt-3">Xem Menu</RouterLink>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import axios from 'axios'
import { RouterLink } from 'vue-router'

// 🧑 Giả sử userId bạn lưu trong localStorage khi đăng nhập
const userId = localStorage.getItem('userId') || 1

const cartItems = ref([])
const loading = ref(true)

const formatCurrency = (value) =>
  value.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' })

// ✅ Lấy giỏ hàng từ backend
const fetchCart = async () => {
  try {
    const res = await axios.get(`http://localhost:8000/api/users/${userId}/cart`)
    // Laravel trả về { items: [ {id, quantity, food: {...}} ] }
    cartItems.value = res.data.items.map(i => ({
      id: i.id,
      name: i.food.name,
      image: i.food.image,
      price: i.food.price,
      quantity: i.quantity
    }))
  } catch (err) {
    console.error('Lỗi khi tải giỏ hàng:', err)
  } finally {
    loading.value = false
  }
}

// ✅ Cập nhật số lượng
const updateQuantity = async (item, change) => {
  const newQty = item.quantity + change
  if (newQty <= 0) return

  item.quantity = newQty
  try {
    await axios.put(`http://localhost:8000/api/cart-items/${item.id}`, {
      quantity: newQty
    })
  } catch (err) {
    console.error('Lỗi cập nhật số lượng:', err)
  }
}

// ✅ Xóa sản phẩm
const removeItem = async (id) => {
  try {
    await axios.delete(`http://localhost:8000/api/cart-items/${id}`)
    cartItems.value = cartItems.value.filter(i => i.id !== id)
  } catch (err) {
    console.error('Lỗi xóa sản phẩm:', err)
  }
}

const totalPrice = computed(() =>
  cartItems.value.reduce((sum, item) => sum + item.price * item.quantity, 0)
)

onMounted(fetchCart)
</script>


<style scoped>
.cart_section {
  padding: 80px 0;
}
</style>
