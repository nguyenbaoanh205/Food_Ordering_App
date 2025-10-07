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
/* Default desktop spacing when sidebar is expanded */
.content {
  margin-left: 240px;
  width: 88%;
  transition: margin-left 0.3s ease;
}

/* When sidebar is collapsed, reduce left margin for main content */
.main-content-collapsed .content {
  margin-left: 70px;
}

@media (max-width: 991px) {
  /* On tablet/mobile, default to compact sidebar width */
  .content {
    margin-left: 70px;
  }

  /* If sidebar is toggled (collapsed on mobile), use full width */
  .main-content-collapsed .content {
    margin-left: 0;
  }
}
</style>