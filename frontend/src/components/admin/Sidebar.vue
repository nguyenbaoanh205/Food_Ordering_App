<template>
  <div class="sidebar bg-dark text-white p-3" :class="{ 'sidebar-collapsed': isCollapsed }" style="width: 240px;">
    <div class="d-flex align-items-center mb-4">
      <h4 class="mb-0 text-primary">🍔 Food Admin</h4>
    </div>
    <ul class="nav flex-column">
      <li class="nav-item">
        <RouterLink to="/admin/dashboard" class="nav-link text-white" active-class="active">
          <i class="bi bi-house-door me-2"></i> Dashboard
        </RouterLink>
      </li>
      <li class="nav-item">
        <RouterLink to="/admin/order" class="nav-link text-white" active-class="active">
          <i class="bi bi-cart me-2"></i> Orders
        </RouterLink>
      </li>
      <li class="nav-item">
        <RouterLink to="/admin/food" class="nav-link text-white" active-class="active">
          <i class="bi bi-egg-fried me-2"></i> Foods
        </RouterLink>
      </li>
      <li class="nav-item">
        <RouterLink to="/admin/category" class="nav-link text-white" active-class="active">
          <i class="bi bi-tags me-2"></i> Categories
        </RouterLink>
      </li>
    </ul>
  </div>
</template>

<script setup>
defineProps({
  isCollapsed: Boolean
})
</script>

<style scoped>
.sidebar {
  height: 100vh;
  position: fixed;
  top: 0;
  left: 0;
  transition: width 0.3s ease;
  z-index: 1000;
  overflow-y: auto;
}

.sidebar-collapsed {
  width: 70px !important;
}

.sidebar-collapsed .nav-link span,
.sidebar-collapsed h4 {
  display: none;
}

.nav-link {
  border-radius: 8px;
  padding: 10px 15px;
  transition: background-color 0.2s ease;
}

.nav-link:hover {
  background-color: rgba(255, 255, 255, 0.1);
}

.nav-link.active {
  background-color: #007bff;
  color: white !important;
  font-weight: 500;
}

@media (max-width: 991px) {
  .sidebar {
    width: 70px;
  }

  .sidebar-collapsed {
    width: 0;
    overflow: hidden;
  }

  .nav-link span,
  h4 {
    display: none;
  }

  .sidebar:not(.sidebar-collapsed) .nav-link span,
  .sidebar:not(.sidebar-collapsed) h4 {
    display: block;
  }
}
</style>