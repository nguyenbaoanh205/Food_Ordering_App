<template>
  <div class="bg-dark text-white vh-100 p-3" style="width: 240px;">
    <h4 class="mb-4">🍔 Food Admin</h4>
    <ul class="nav flex-column">
      <!-- <li class="nav-item">
        <RouterLink to="/admin/dashboard" class="nav-link text-white">Dashboard</RouterLink>
      </li> -->
      <li class="nav-item">
        <RouterLink to="/admin/order" class="nav-link text-white">Orders</RouterLink>
      </li>
      <li class="nav-item">
        <RouterLink to="/admin/food" class="nav-link text-white">Foods</RouterLink>
      </li>
      <li class="nav-item">
        <RouterLink to="/admin/category" class="nav-link text-white">Categories</RouterLink>
      </li>
    </ul>
  </div>
</template>
