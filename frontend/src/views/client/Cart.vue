<template>
  <section class="cart_section py-5">
    <div class="container">
      <!-- Tiêu đề -->
      <div class="heading_container text-center mb-4">
        <h2 class="fw-bold text-dark">
          <i class="fa fa-shopping-basket me-2 text-warning"></i> Giỏ hàng
        </h2>
      </div>

      <!-- Nếu có sản phẩm -->
      <div v-if="cartItems.length > 0">
        <!-- Desktop layout -->
        <div class="table-responsive cart-desktop d-none d-md-block bg-white p-3 rounded-4 shadow-sm border">
          <table class="table align-middle text-center mb-0">
            <thead class="table-light">
              <tr>
                <th>Ảnh</th>
                <th class="text-start">Sản phẩm</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Tổng</th>
                <th>Hành động</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="item in cartItems" :key="item.id" class="align-middle border-bottom">
                <td style="width: 100px;">
                  <img :src="item.image" alt="Sản phẩm" class="img-fluid rounded-3"
                    style="width: 80px; height: 80px; object-fit: cover;" />
                </td>
                <td class="text-start">
                  <strong>{{ item.name }}</strong>
                  <ul v-if="item.options?.length" class="list-unstyled small text-muted mb-0 mt-1">
                    <li v-for="opt in item.options" :key="opt.id">
                      <template v-if="opt.option">
                        <span class="text-capitalize">{{ opt.option.type }}:</span>
                        {{ opt.option.name }}
                        (+{{ formatCurrency(opt.option.extra_price) }})
                      </template>
                    </li>
                  </ul>
                </td>
                <td class="fw-semibold">{{ formatCurrency(item.price) }}</td>
                <td>
                  <div class="d-flex justify-content-center align-items-center gap-2">
                    <button class="btn btn-outline-secondary btn-sm rounded-circle" @click="updateQuantity(item, -1)">
                      <i class="fa fa-minus"></i>
                    </button>
                    <span class="fw-semibold">{{ item.quantity }}</span>
                    <button class="btn btn-outline-secondary btn-sm rounded-circle" @click="updateQuantity(item, 1)">
                      <i class="fa fa-plus"></i>
                    </button>
                  </div>
                </td>
                <td class="fw-bold text-dark">{{ formatCurrency(getItemTotal(item)) }}</td>
                <td>
                  <button class="btn btn-outline-danger btn-sm rounded-circle" @click="removeItem(item.id)">
                    <i class="fa fa-trash"></i>
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Mobile layout -->
        <div class="cart-mobile d-block d-md-none">
          <div v-for="item in cartItems" :key="item.id" class="cart-item card mb-3 border-0 shadow-sm bg-white">
            <div class="d-flex align-items-center p-2">
              <img :src="item.image" alt="Sản phẩm" class="rounded"
                style="width: 80px; height: 80px; object-fit: cover;" />
              <div class="ms-3 flex-grow-1">
                <h6 class="fw-bold text-dark mb-1">{{ item.name }}</h6>
                <p class="text-muted small mb-1">{{ formatCurrency(item.price) }}</p>
                <ul v-if="item.options?.length" class="list-unstyled text-muted small mb-1">
                  <li v-for="opt in item.options" :key="opt.id">
                    <span v-if="opt.option">
                      <span class="text-capitalize">{{ opt.option.type }}: </span>{{ opt.option.name }}
                      (+{{ formatCurrency(opt.option.extra_price) }})
                    </span>
                  </li>
                </ul>

                <div class="d-flex align-items-center justify-content-between mt-2">
                  <div class="quantity-controls d-flex align-items-center">
                    <button class="btn btn-outline-secondary btn-sm rounded-circle" @click="updateQuantity(item, -1)">
                      <i class="fa fa-minus"></i>
                    </button>
                    <span class="mx-2">{{ item.quantity }}</span>
                    <button class="btn btn-outline-secondary btn-sm rounded-circle" @click="updateQuantity(item, 1)">
                      <i class="fa fa-plus"></i>
                    </button>
                  </div>
                  <button class="btn btn-sm btn-outline-danger rounded-circle" @click="removeItem(item.id)">
                    <i class="fa fa-trash"></i>
                  </button>
                </div>
              </div>
            </div>
            <div class="border-top px-3 py-2 text-end">
              <span class="fw-bold text-dark">
                Tổng: {{ formatCurrency(getItemTotal(item)) }}
              </span>
            </div>
          </div>
        </div>

        <!-- Tổng cộng -->
        <div class="text-end mt-4 cart-summary">
          <h4 class="fw-bold text-dark" style="text-align: right">
            Tổng cộng:
            <span class="text-danger">{{ formatCurrency(totalPrice) }}</span>
          </h4>
          <RouterLink :to="{ name: 'Checkout' }"
            class="btn btn-warning btn-lg rounded-pill shadow px-5 mt-3 text-dark fw-semibold">
            <i class="fa fa-credit-card me-2"></i> Thanh toán
          </RouterLink>
        </div>
      </div>

      <!-- Khi giỏ hàng trống -->
      <div v-else class="text-center py-5">
        <img src="https://cdn-icons-png.flaticon.com/512/2038/2038854.png" alt="Empty Cart" class="img-fluid mb-3"
          style="width: 120px;" />
        <h5 class="fw-bold text-dark mb-3">Giỏ hàng của bạn đang trống</h5>
        <RouterLink :to="{ name: 'Menu' }" class="btn btn-outline-dark rounded-pill px-4">
          <i class="fa fa-utensils me-2"></i> Xem Menu
        </RouterLink>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useUserStore } from '@/stores/user'
import api from '@/services/api'

const userStore = useUserStore()
const userId = userStore.user?.id

const cartItems = ref([])
const loading = ref(true)

const formatCurrency = val =>
  new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(val)

// 🧾 Lấy giỏ hàng
const fetchCart = async () => {
  try {
    const res = await api.get(`/users/${userId}/cart`)
    cartItems.value = res.data.items.map(i => ({
      id: i.id,
      name: i.food.name,
      image: i.food.image,
      price: i.price, // giá item, có thể đã bao gồm base + size
      quantity: i.quantity,
      options: i.options || []
    }))
  } catch (err) {
    console.error('Lỗi khi tải giỏ hàng:', err)
  } finally {
    loading.value = false
  }
}

// ✅ Tính tổng cho từng item (bao gồm topping)
const getItemTotal = (item) => {
  const optionsTotal = item.options?.reduce((sum, o) => sum + o.price, 0) || 0
  return (item.price + optionsTotal) * item.quantity
}
const updateQuantity = async (item, change) => {
  const newQty = item.quantity + change
  if (newQty <= 0) return
  item.quantity = newQty
  try {
    await api.put(`/cart-items/${item.id}`, { quantity: newQty })
  } catch (err) {
    console.error('Lỗi cập nhật số lượng:', err)
  }
}

const removeItem = async (id) => {
  try {
    await api.delete(`/cart-items/${id}`)
    cartItems.value = cartItems.value.filter(i => i.id !== id)
  } catch (err) {
    console.error('Lỗi xóa sản phẩm:', err)
  }
}

const totalPrice = computed(() =>
  cartItems.value.reduce((sum, item) => sum + getItemTotal(item), 0)
)

onMounted(fetchCart)
</script>

<style scoped>
.cart_section {
  background-color: #fff;
  color: #000;
  min-height: 80vh;
}

.table {
  border-collapse: separate !important;
  border-spacing: 0 10px !important;
}

.table tbody tr {
  background: #fff;
  border-radius: 10px;
  transition: all 0.3s ease;
}

.table tbody tr:hover {
  background: #f9f9f9;
}

.cart-item {
  border-radius: 12px;
  overflow: hidden;
  transition: box-shadow 0.3s ease;
}

.cart-item:hover {
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
}

.cart-item h6 {
  font-size: 15px;
  line-height: 1.3;
}

.quantity-controls button {
  width: 30px;
  height: 30px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.btn-warning {
  background-color: #ffb700 !important;
  border: none;
}

.btn-warning:hover {
  background-color: #ffa000 !important;
}

@media (max-width: 768px) {
  .cart-summary {
    text-align: right;
  }

  .cart-summary .btn {
    display: inline-block;
    margin-top: 10px;
  }

  .btn-lg {
    width: 60%;
  }
}
</style>
