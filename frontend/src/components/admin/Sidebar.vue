<template>
  <div class="sidebar bg-dark text-white p-3" :class="{ 'sidebar-collapsed': isCollapsed }" style="width: 240px;">
    <!-- Brand -->
    <RouterLink class="navbar-brand" :to="{ name: 'Dashboard' }">
      <!-- <div class="d-flex align-items-center mb-3 brand"> -->
      <img :src="Logo" style="width: 200px;" alt="">
      <!-- </div> -->
    </RouterLink>

    <!-- Navigation -->
    <ul class="nav flex-column">
      <!-- Dashboard -->
      <li class="nav-item">
        <RouterLink :to="{ name: 'Dashboard' }" class="nav-link text-white d-flex align-items-center"
          exact-active-class="active">
          <i class="bi bi-house-door me-2"></i>
          <span>Dashboard</span>
        </RouterLink>
      </li>

      <!-- Food Management -->
      <li class="nav-item mt-3 sidebar-section">Food Management</li>

      <li class="nav-item">
        <RouterLink :to="{ name: 'Category' }" class="nav-link text-white d-flex align-items-center"
          exact-active-class="active">
          <i class="bi bi-tags me-2"></i>
          <span>Categories</span>
        </RouterLink>
      </li>
      <li class="nav-item">
        <RouterLink :to="{ name: 'Food' }" class="nav-link text-white d-flex align-items-center"
          exact-active-class="active">
          <i class="bi bi-basket me-2"></i> <!-- Thay đổi icon ở đây -->
          <span>Foods</span>
        </RouterLink>
      </li>
      <li class="nav-item">
        <RouterLink :to="{ name: 'FoodOption' }" class="nav-link text-white d-flex align-items-center"
          exact-active-class="active">
          <i class="bi bi-list-check me-2"></i> <!-- Thay đổi icon ở đây -->
          <span>Food Options</span>
        </RouterLink>
      </li>

      <!-- Order Management -->
      <li class="nav-item mt-3 sidebar-section">Order Management</li>

      <li class="nav-item">
        <RouterLink :to="{ name: 'Order' }" class="nav-link text-white d-flex align-items-center"
          exact-active-class="active">
          <i class="bi bi-cart me-2"></i>
          <span>Orders</span>
        </RouterLink>
      </li>

      <li class="nav-item">
        <RouterLink :to="{ name: 'OrderHistory' }" class="nav-link text-white d-flex align-items-center"
          exact-active-class="active">
          <i class="bi bi-clock-history me-2"></i>
          <span>Order History</span>
        </RouterLink>
      </li>

      <!-- User & Review Management -->
      <li class="nav-item mt-3 sidebar-section">User & Review Management</li>

      <li class="nav-item">
        <RouterLink :to="{ name: 'User' }" class="nav-link text-white d-flex align-items-center"
          exact-active-class="active">
          <i class="bi bi-people me-2"></i>
          <span>Users</span>
        </RouterLink>
      </li>

      <li class="nav-item">
        <RouterLink :to="{ name: 'Review' }" class="nav-link text-white d-flex align-items-center"
          exact-active-class="active">
          <i class="bi bi-chat-dots me-2"></i>
          <span>Reviews</span>
        </RouterLink>
      </li>

      <li class="nav-item">
        <RouterLink :to="{ name: 'Banner' }" class="nav-link text-white d-flex align-items-center"
          exact-active-class="active">
          <i class="bi bi-image me-2"></i>
          <span>Banners</span>
        </RouterLink>
      </li>
    </ul>
  </div>
</template>


<script setup>
defineProps({
  isCollapsed: Boolean
})

import Logo from '@/assets/images/Order_Food.png';

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

.brand i {
  font-size: 1.25rem;
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

.sidebar-section {
  font-size: 0.75rem;
  text-transform: uppercase;
  letter-spacing: 0.04em;
  color: rgba(255, 255, 255, 0.6);
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