<script setup>
import { onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useUserStore } from '@/stores/user'
import { useCartStore } from '@/stores/cart'
import { useToast } from 'vue-toastification'
import api from '@/services/api'

const route = useRoute()
const router = useRouter()
const userStore = useUserStore()
const cartStore = useCartStore()
const toast = useToast()

onMounted(async () => {
  const token = route.query.token
  if (!token) {
    toast.error('Không tìm thấy thông tin thanh toán PayPal!')
    router.push('/checkout')
    return
  }

  // Lấy lại items + checkout info từ localStorage
  const items = JSON.parse(localStorage.getItem('paypal_checkout_items') || '[]')
  const checkoutInfo = JSON.parse(localStorage.getItem('paypal_checkout_info') || '{}')

  try {
    const res = await api.post('/paypal/capture-payment', {
      token,
      user_id: userStore.user.id,
      total: items.reduce((sum, i) => sum + i.totalPrice, 0),
      receiver_name: checkoutInfo.name,
      receiver_phone: checkoutInfo.phone,
      receiver_address: checkoutInfo.address,
      note: checkoutInfo.note || '',
      items: items.map(item => ({
        food_id: item.food.id,
        quantity: item.quantity,
        price: item.displayPrice,
        options: item.options?.map(o => ({
          option_id: o.option.id,
          extra_price: o.option.extra_price
        })) || []
      }))
    })
    // console.log('PayPal capture response:', res.data)

    if (res.data.status && res.data.status.toLowerCase() === 'completed') {
      toast.success('Thanh toán PayPal thành công!')
      await api.delete('/cart/clear'); // xóa giỏ hàng trên server
      cartStore.clearCart() // xóa giỏ hàng trên client (pinia)
      localStorage.removeItem('paypal_checkout_items')
      localStorage.removeItem('paypal_checkout_info')
      router.push('/order-histories')
    } else {
      toast.error('Thanh toán PayPal không hoàn tất!')
      router.push('/checkout')
    }

  } catch (error) {
    console.error('PayPal capture error:', error)
    toast.error('Thanh toán PayPal thất bại!')
    router.push('/checkout')
  }
})
</script>

<template>
  <div class="paypal-success">
    <div class="loader"></div>
    <h2>Đang xử lý thanh toán PayPal...</h2>
    <p>Vui lòng đợi trong giây lát...</p>
  </div>
</template>

<style scoped>
.paypal-success {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  background-color: #f9fafb;
  text-align: center;
  gap: 20px;
}

.loader {
  border: 8px solid #f3f3f3;
  border-top: 8px solid #0070ba;
  border-radius: 50%;
  width: 60px;
  height: 60px;
  animation: spin 1s linear infinite;
}

@keyframes spin {
  0% {
    transform: rotate(0deg);
  }

  100% {
    transform: rotate(360deg);
  }
}

h2 {
  font-size: 1.8rem;
  color: #111827;
  margin: 0;
}

p {
  color: #6b7280;
  margin: 0;
}
</style>
