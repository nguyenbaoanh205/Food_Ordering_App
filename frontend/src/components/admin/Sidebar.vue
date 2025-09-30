<template>
  <div class="bg-dark text-white vh-100 p-3" style="width: 240px;">
    <h4 class="mb-4">🍔 Food Admin</h4>
    <ul class="nav flex-column">
      <li class="nav-item">
        <RouterLink to="/admin/dashboard" class="nav-link text-white">Dashboard</RouterLink>
      </li>
      <li class="nav-item">
        <RouterLink to="/admin/orders" class="nav-link text-white">Orders</RouterLink>
      </li>
      <li class="nav-item">
        <RouterLink to="/admin/products" class="nav-link text-white">Products</RouterLink>
      </li>
      <li class="nav-item">
        <RouterLink to="/admin/users" class="nav-link text-white">Users</RouterLink>
      </li>
      <li class="nav-item">
        <RouterLink to="/admin/settings" class="nav-link text-white">Settings</RouterLink>
      </li>
    </ul>
  </div>
</template>
