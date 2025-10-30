<template>
  <div class="hero_area" :style="heights[route.name] ? { height: heights[route.name] } : {}">
    <div class="bg-box">
      <img :src="Image1" alt="" :style="{
        objectFit: 'cover',
        objectPosition: positions[route.name] || 'center center'
      }">
    </div>
    <!-- header section strats -->
    <header class="header_section">
      <div class="container">
        <nav class="navbar navbar-expand-lg custom_nav-container ">
          <RouterLink class="navbar-brand" :to="{ name: 'Home' }">
            <span>
              Feane
            </span>
          </RouterLink>

          <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>


          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mx-auto">
              <li class="nav-item">
                <RouterLink class="nav-link" :to="{ name: 'Home' }" active-class="active" exact-active-class="active">
                  Home
                </RouterLink>
              </li>
              <li class="nav-item">
                <RouterLink class="nav-link" :to="{ name: 'Menu' }" active-class="active">
                  Menu
                </RouterLink>
              </li>
              <li class="nav-item">
                <RouterLink class="nav-link" :to="{ name: 'About' }" active-class="active">
                  About
                </RouterLink>
              </li>
              <!-- <li class="nav-item">
                <RouterLink class="nav-link" :to="{ name: 'Book' }" active-class="active">
                  Book Table
                </RouterLink>
              </li> -->
            </ul>

            <div class="user_option d-flex align-items-center gap-3">

              <!-- 👤 Profile dropdown -->
              <div class="dropdown">
                <button
                  class="btn btn-transparent text-light d-flex align-items-center px-2 py-1 rounded-3 hover-bright"
                  type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="fas fa-user me-2"></i>
                  <span>{{ userStore.user?.name || 'Tài khoản' }}</span>
                  <i class="fas fa-chevron-down ms-2 small opacity-75"></i>
                </button>

                <ul class="dropdown-menu dropdown-menu-end shadow-lg rounded-3 border-0 mt-2">
                  <template v-if="userStore.user">
                    <li>
                      <RouterLink class="dropdown-item py-2" :to="{ name: 'Profile' }">
                        <i class="fas fa-id-card me-2 text-secondary"></i> Hồ sơ của tôi
                      </RouterLink>
                    </li>
                    <li>
                      <hr class="dropdown-divider" />
                    </li>
                    <li>
                      <RouterLink class="dropdown-item py-2" :to="{ name: 'OrderHistoryClient' }">
                        <i class="fas fa-history me-2 text-secondary"></i> Lịch sử đơn hàng
                      </RouterLink>
                    </li>
                    <li>
                      <hr class="dropdown-divider" />
                    </li>
                    <li>
                      <button class="dropdown-item text-danger py-2" @click="logout">
                        <i class="fas fa-sign-out-alt me-2"></i> Đăng xuất
                      </button>
                    </li>
                  </template>


                  <template v-else>
                    <li>
                      <RouterLink class="dropdown-item py-2" :to="{ name: 'Login' }">
                        <i class="fas fa-sign-in-alt me-2 text-success"></i> Đăng nhập
                      </RouterLink>
                    </li>
                    <li>
                      <RouterLink class="dropdown-item py-2" :to="{ name: 'Register' }">
                        <i class="fas fa-user-plus me-2 text-primary"></i> Đăng ký
                      </RouterLink>
                    </li>
                  </template>
                </ul>
              </div>

              <!-- 🛒 Cart -->
              <RouterLink :to="{ name: 'Cart' }"
                class="icon-btn text-light d-flex align-items-center justify-content-center hover-bright text-decoration-none">
                <i class="fas fa-shopping-cart"></i>
              </RouterLink>

              <!-- 🔍 Search -->
              <button class="icon-btn text-light d-flex align-items-center justify-content-center hover-bright"
                type="button">
                <i class="fas fa-search"></i>
              </button>

            </div>


          </div>
        </nav>
      </div>
    </header>
    <!-- end header section -->
    <Banner v-if="route.name === 'Home'" />
  </div>
</template>
<script setup>
import Image1 from '@/assets/images/hero-bg.jpg';
import { RouterLink, useRoute, useRouter } from 'vue-router';
import Banner from './Banner.vue';
import { useUserStore } from '@/stores/user';
import { useToast } from "vue-toastification";

const toast = useToast();
const route = useRoute();
const router = useRouter();
const userStore = useUserStore();

const heights = {
  Home: '1000px',
  Menu: '95px',
  About: '95px',
  Book: '95px',
  Login: '95px',
  Register: '95px',
  Profile: '95px',
  Cart: '95px',
};

const positions = {
  Menu: 'top center',
  About: 'top center',
  Book: 'top center',
  Login: 'top center',
  Register: 'top center',
  Profile: 'top center',
  Cart: 'top center',
};

const logout = async () => {
  await userStore.logout();
  toast.success("Đăng xuất thành công!");
  router.push("/"); // chuyển trang mà toast vẫn hiển thị
};
</script>

<style>
.hero_area {
  position: relative;
  overflow: visible !important;
  /* Cho phép phần tử con tràn ra */
  width: 100%;
  min-height: unset !important;
  /* xóa min-height mặc định */
}

.bg-box {
  width: 100%;
  height: 100%;
}

.bg-box img {
  width: 100%;
  height: 100%;
  display: block;
  object-fit: cover;
}

.nav-link.active {
  color: #ffbe33 !important;
}

.btn-transparent {
  background: transparent;
  border: none;
  transition: color 0.2s ease, transform 0.2s ease;
}

.btn-transparent:hover {
  /* color: #0d6efd; */
  transform: translateY(-1px);
}

.icon-btn {
  background: transparent;
  border: none;
  font-size: 1rem;
  width: 40px;
  height: 40px;
  transition: color 0.2s ease, transform 0.2s ease;
}

.icon-btn:hover {
  color: #0d6efd;
  transform: scale(1.1);
}

.hover-bright:hover {
  /* color: #0d6efd !important; */
}

.dropdown-menu {
  background: rgba(255, 255, 255, 0.95);
  backdrop-filter: blur(10px);
}
</style>