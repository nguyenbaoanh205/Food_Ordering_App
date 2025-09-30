<template>
  <div class="d-flex">
    <!-- Sidebar -->
    <Sidebar />

    <!-- Main content -->
    <div class="flex-grow-1">
      <Navbar />
      <div class="container-fluid p-4">
        <RouterView />
      </div>
    </div>
  </div>
</template>

<script setup>
import Sidebar from '@/components/admin/Sidebar.vue'
import Navbar from '@/components/admin/Navbar.vue'
</script>
