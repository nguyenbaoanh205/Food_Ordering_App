<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm px-4" style="width: 88%; margin-left: 240px;">
    <div class="container-fluid">
      <!-- Sidebar toggle button for mobile -->
      <button
        class="navbar-toggler me-3"
        type="button"
        @click="toggleSidebar"
        aria-controls="sidebar"
        aria-expanded="false"
        aria-label="Toggle sidebar"
      >
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Brand -->
      <span class="navbar-brand fw-bold text-primary">🍔 Food Admin</span>

      <!-- User -->
      <div class="d-flex align-items-center ms-auto gap-3">
        <div class="dropdown">
          <button
            class="btn btn-outline-secondary d-flex align-items-center"
            type="button"
            id="userDropdown"
            data-bs-toggle="dropdown"
            aria-expanded="false"
          >
            <span class="me-2">Xin chào, Admin</span>
            <i class="bi bi-person-circle"></i>
          </button>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
            <li><a class="dropdown-item" href="#">Profile</a></li>
            <li><a class="dropdown-item" href="#">Settings</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><button class="dropdown-item text-danger" @click="logout">Đăng xuất</button></li>
          </ul>
        </div>
      </div>
    </div>
  </nav>
</template>

<script setup>
import { ref } from 'vue'

const emit = defineEmits(['toggle-sidebar'])

const toggleSidebar = () => {
  emit('toggle-sidebar')
}

const logout = () => {
  // Add logout logic here (e.g., clear token, redirect to login)
  console.log('Logged out')
}
</script>

<style scoped>
.navbar {
  border-bottom: 1px solid #e9ecef;
  transition: all 0.3s ease;
}

.navbar-brand {
  font-size: 1.5rem;
  color: #007bff !important;
}

.btn-outline-secondary {
  border-radius: 50px;
  padding: 0.5rem 1rem;
}

.dropdown-menu {
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  border: none;
}
</style>