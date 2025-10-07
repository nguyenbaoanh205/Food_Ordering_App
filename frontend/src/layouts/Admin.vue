<template>
  <div class="d-flex">
    <!-- Sidebar -->
    <Sidebar :is-collapsed="isSidebarCollapsed" />

    <!-- Main content -->
    <div class="flex-grow-1" :class="{ 'main-content-collapsed': isSidebarCollapsed }">
      <Navbar @toggle-sidebar="toggleSidebar" />
      <div class="container-fluid p-4 content">
        <RouterView />
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import Sidebar from '@/components/admin/Sidebar.vue'
import Navbar from '@/components/admin/Navbar.vue'

const isSidebarCollapsed = ref(false)

const toggleSidebar = () => {
  isSidebarCollapsed.value = !isSidebarCollapsed.value
}
</script>

<style scoped>
.main-content-collapsed {
  margin-left: 70px;
}

.content {
  margin-left: 240px;
  transition: margin-left 0.3s ease;
}

@media (max-width: 991px) {
  .content {
    margin-left: 70px;
  }

  .main-content-collapsed {
    margin-left: 0;
  }
}
</style>