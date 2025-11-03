<template>
    <Header />
    <router-view />
    <Footer />
</template>
<script setup>
import Header from '@/components/client/Header.vue';
import Footer from '@/components/client/Footer.vue';
import { onMounted, onBeforeUnmount, watch } from 'vue'
import echo from '@/plugins/echo'
import { useToast } from 'vue-toastification'
import { useUserStore } from '@/stores/user'
// CSS của thư viện trước (bootstrap, fontawesome)
import '@/assets/css/bootstrap.css'
import '@/assets/css/font-awesome.min.css'

// Global CSS/SCSS của bạn sau (ghi đè thư viện nếu cần)
import '@/assets/css/style.scss'
import '@/assets/css/style.css'
import '@/assets/css/responsive.css'

const toast = useToast()
const userStore = useUserStore()
let channel = null

// 🔔 Hàm đăng ký lắng nghe
function listenRealtime(userId) {
  channel = echo.channel(`user.${userId}`)
  channel.listen('.order.status.updated', (data) => {
    toast.info(`📦 Đơn hàng #${data.id} đã chuyển trạng thái: ${data.status}`, {
      position: 'top-right',
      timeout: 5000,
    })
  })
}

// 🧹 Hàm hủy lắng nghe
function stopListening(userId) {
  if (channel) {
    echo.leave(`user.${userId}`)
    channel = null
  }
}

// 📡 Lắng nghe khi layout mounted
onMounted(() => {
  if (userStore.user?.id) {
    listenRealtime(userStore.user.id)
  }

  // 🔄 Watch userStore.user để tự động đăng ký hoặc hủy khi login/logout
  watch(() => userStore.user, (newUser, oldUser) => {
    if (oldUser?.id) stopListening(oldUser.id)
    if (newUser?.id) listenRealtime(newUser.id)
  })
})

onBeforeUnmount(() => {
  if (userStore.user?.id) stopListening(userStore.user.id)
})
</script>
<style></style>