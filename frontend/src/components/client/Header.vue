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

          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class=""> </span>
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
                <button class="btn btn-outline-secondary d-flex align-items-center" type="button" id="userDropdown"
                  data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="fas fa-user me-2"></i>
                  <span>{{ userStore.user?.name || 'Tài khoản' }}</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                  <template v-if="userStore.user">
                    <li>
                      <RouterLink class="dropdown-item" :to="{ name: 'Profile' }">
                        Hồ sơ của tôi
                      </RouterLink>
                    </li>
                    <li>
                      <hr class="dropdown-divider" />
                    </li>
                    <li>
                      <button class="dropdown-item text-danger" @click="logout">
                        Đăng xuất
                      </button>
                    </li>
                  </template>
                  <template v-else>
                    <li>
                      <RouterLink class="dropdown-item" :to="{ name: 'Login' }">
                        Đăng nhập
                      </RouterLink>
                    </li>
                    <li>
                      <RouterLink class="dropdown-item" :to="{ name: 'Register' }">
                        Đăng ký
                      </RouterLink>
                    </li>
                  </template>
                </ul>
              </div>

              <!-- 🛒 Cart -->
              <RouterLink :to="{ name: 'Cart' }" class="cart_link" style="text-decoration: none;">
                <i class="fas fa-shopping-cart"></i>
              </RouterLink>

              <!-- 🔍 Search -->
              <form class="form-inline">
                <button class="btn my-2 my-sm-0 nav_search-btn" type="submit">
                  <i class="fas fa-search"></i>
                </button>
              </form>
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
};

const positions = {
  Menu: 'top center',
  About: 'top center',
  Book: 'top center',
  Login: 'top center',
  Register: 'top center',
};

const logout = async () => {
  await userStore.logout();
  toast.success("Đăng xuất thành công!");
  router.push("/login"); // chuyển trang mà toast vẫn hiển thị
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
</style>