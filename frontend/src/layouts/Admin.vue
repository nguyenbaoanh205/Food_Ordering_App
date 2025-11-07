<template>
  <div class="d-flex">
    <!-- Sidebar -->
    <Sidebar :is-collapsed="isSidebarCollapsed" />

    <!-- Main content -->
    <div class="flex-grow-1" :class="{ 'main-content-collapsed': isSidebarCollapsed }">
      <Navbar @toggle-sidebar="toggleSidebar" />
      <div class="container-fluid p-4 mt-5 content">
        <RouterView />
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import Sidebar from '@/components/admin/Sidebar.vue'
import Navbar from '@/components/admin/Navbar.vue'
import { onMounted } from 'vue'
import { useToast } from 'vue-toastification'
import echo from '@/plugins/echo'

const toast = useToast()
const isSidebarCollapsed = ref(false)

const toggleSidebar = () => {
  isSidebarCollapsed.value = !isSidebarCollapsed.value
}
onMounted(() => {
  // console.log('📡 Listening for order.created event...')

  echo.channel('orders')
    .listen('.order.created', (e) => {
      // console.log('📦 Nhận được đơn hàng mới:', e)
      toast.info(`Đơn hàng mới #${e.id} - ${e.receiver_name}`)
    })
});

</script>

<style scoped lang="css">
.content {
  margin-left: 240px;
  width: 88%;
  transition: margin-left 0.3s ease;
}

.main-content-collapsed .content {
  margin-left: 70px;
}

@media (max-width: 991px) {
  .content {
    margin-left: 70px;
  }

  .main-content-collapsed .content {
    margin-left: 0;
  }
}
</style>