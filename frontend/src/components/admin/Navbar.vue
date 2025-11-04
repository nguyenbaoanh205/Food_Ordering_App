<template>
  <nav
    class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top"
    :class="{ 'navbar-collapsed': isSidebarCollapsed }"
  >
    <div class="container-fluid px-4">
      <!-- Sidebar toggle button (mobile + responsive) -->
      <button
        class="btn btn-outline-primary d-lg-none me-3"
        type="button"
        @click="toggleSidebar"
        aria-controls="sidebar"
        aria-expanded="false"
        aria-label="Toggle sidebar"
      >
        <i class="bi bi-list"></i>
      </button>

      <!-- Brand -->
      <span class="navbar-brand fw-bold text-primary d-flex align-items-center gap-2">
        <!-- <i class="bi bi-basket2-fill fs-4"></i> -->
        <span>Food Admin</span>
      </span>

      <!-- Right side -->
      <div class="d-flex align-items-center ms-auto gap-3">
        <!-- Notification bell -->
        <!-- <button class="btn btn-light position-relative">
          <i class="bi bi-bell fs-5"></i>
          <span
            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
            style="font-size: 0.6rem;"
          >
            3
          </span>
        </button> -->

        <!-- User dropdown -->
        <div class="dropdown">
          <button
            class="btn btn-outline-secondary d-flex align-items-center gap-2"
            id="userDropdown"
            data-bs-toggle="dropdown"
            aria-expanded="false"
          >
            <i class="bi bi-person-circle fs-5"></i>
            <span>Xin chào, {{ userStore.user?.name }}</span>
            <i class="bi bi-caret-down-fill small"></i>
          </button>

          <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="userDropdown">
            <!-- <li><a class="dropdown-item" href="#">Trang cá nhân</a></li> -->
            <!-- <li><a class="dropdown-item" href="#">Cài đặt</a></li> -->
            <li><hr class="dropdown-divider" /></li>
            <li>
              <button class="dropdown-item text-danger d-flex align-items-center gap-2" @click="handleLogout">
                <i class="bi bi-box-arrow-right"></i> Đăng xuất
              </button>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </nav>
</template>

<script setup>
import { useRouter } from "vue-router";
import { useUserStore } from "@/stores/user";
import { useToast } from "vue-toastification";

const router = useRouter();
const userStore = useUserStore();
const toast = useToast();


const handleLogout = async () => {
    await userStore.logout(); // xóa token + user
    toast.success("Đăng xuất thành công!");
    router.push("/login"); // chuyển trang mà không reload
};
</script>


<style scoped>
.navbar {
  height: 64px;
  border-bottom: 1px solid #e9ecef;
  z-index: 1030;
  transition: all 0.3s ease;
}

.navbar-collapsed {
  width: calc(100% - 80px);
  margin-left: 80px;
}

.navbar:not(.navbar-collapsed) {
  width: calc(100% - 240px);
  margin-left: 240px;
}

.btn-outline-secondary {
  border-radius: 50px;
  padding: 0.4rem 0.9rem;
}

.dropdown-menu {
  border: none;
  border-radius: 0.75rem;
  min-width: 180px;
}

.dropdown-item:hover {
  background-color: #f8f9fa;
}
</style>
