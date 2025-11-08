<template>
  <div class="hero_area" :style="heights[route.name] ? { height: heights[route.name] } : {}">
    <div class="bg-box">
      <img :src="Image1" alt="" :style="{
        objectFit: 'cover',
        objectPosition: 'top center'
      }">
    </div>
    <!-- header section strats -->
    <header class="header_section" style="z-index: 9999 !important;">
      <div class="container">
        <nav class="navbar navbar-expand-lg custom_nav-container p-0">
          <RouterLink class="navbar-brand" :to="{ name: 'Home' }">
            <span>
              <img :src="Logo" style="width: 150px;" alt="">
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
                <RouterLink class="nav-link" :to="{ name: 'Contact' }" active-class="active">
                  Contact
                </RouterLink>
              </li>
              <li class="nav-item">
                <RouterLink class="nav-link" :to="{ name: 'About' }" active-class="active">
                  About
                </RouterLink>
              </li>
            </ul>

            <div class="user_option d-flex align-items-center gap-3">

              <!-- 🔍 Search -->
              <div class="d-flex align-items-center bg-dark rounded-pill px-2" style="border: 1px #ffffff4d solid;">
                <input v-model="searchQuery" @keyup.enter="searchFood" style="width: 125px;" type="text"
                  class="form-control place bg-transparent border-0 text-light" placeholder="Search dish..." />
                <button class="icon-btn text-light d-flex align-items-center justify-content-center hover-bright"
                  type="button" @click="searchFood">
                  <i class="fas fa-search"></i>
                </button>
              </div>

              <!-- 👤 Profile dropdown -->
              <div class="dropdown dropdown-center ">
                <button
                  class="btn btn-transparent text-light d-flex align-items-center px-2 py-1 rounded-3 hover-bright"
                  type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="fas fa-user me-2"></i>
                  <span>{{ userStore.user?.name }}</span>
                  <i class="fas fa-chevron-down ms-2 small opacity-75" style="margin-left: 0px !important;"></i>
                </button>

                <ul class="dropdown-menu shadow-lg rounded-3 border-0 mt-2">
                  <template v-if="userStore.user">
                    <li>
                      <RouterLink class="dropdown-item py-2" :to="{ name: 'Profile' }">
                        <i class="fas fa-id-card me-2 text-secondary"></i> My profile
                      </RouterLink>
                    </li>
                    <li>
                      <hr class="dropdown-divider" />
                    </li>
                    <li>
                      <RouterLink class="dropdown-item py-2" :to="{ name: 'OrderHistoryClient' }">
                        <i class="fas fa-history me-2 text-secondary"></i> Order history
                      </RouterLink>
                    </li>
                    <li>
                      <hr class="dropdown-divider" />
                    </li>
                    <li>
                      <button class="dropdown-item text-danger py-2" @click="logout">
                        <i class="fas fa-sign-out-alt me-2"></i> Sign out
                      </button>
                    </li>
                  </template>


                  <template v-else>
                    <li>
                      <RouterLink class="dropdown-item py-2" :to="{ name: 'Login' }">
                        <i class="fas fa-sign-in-alt me-2 text-success"></i> Login
                      </RouterLink>
                    </li>
                    <li>
                      <RouterLink class="dropdown-item py-2" :to="{ name: 'Register' }">
                        <i class="fas fa-user-plus me-2 text-primary"></i> Register
                      </RouterLink>
                    </li>
                  </template>
                </ul>
              </div>

              <!-- 🛒 Cart -->
              <RouterLink :to="{ name: 'Cart' }"
                class="icon-btn text-light d-flex align-items-center justify-content-center hover-bright text-decoration-none">
                <i class="fas fa-shopping-cart"></i>
                <span v-if="cartStore.cartCount > 0" class="position-absolute badge rounded-pill bg-danger"
                  style="font-size: 0.7rem;">
                  {{ cartStore.cartCount }}
                </span>
              </RouterLink>

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
import Logo from '@/assets/images/logo_food_order.png';
import { RouterLink, useRoute, useRouter } from 'vue-router';
import { onMounted, watch, ref } from "vue";
import Banner from './Banner.vue';
import { useUserStore } from '@/stores/user';
import { useCartStore } from '@/stores/cart';
import { useToast } from "vue-toastification";

const toast = useToast();
const route = useRoute();
const router = useRouter();
const userStore = useUserStore();
const cartStore = useCartStore();
const searchQuery = ref('');

const heights = {
  Home: '1000px',
  About: '114px',
  FoodDetail: '114px',
};

const searchFood = () => {
  if (searchQuery.value.trim() !== '') {
    router.push({ name: 'Menu', query: { q: searchQuery.value } });
  }
};

const logout = async () => {
  await userStore.logout();
  toast.success("Logout successfully!");
  router.push("/");
};

// 🔄 Khi component mount hoặc user thay đổi
onMounted(() => {
  if (userStore.user?.id) cartStore.fetchCart(userStore.user.id);
});

watch(
  () => userStore.user?.id,
  (id) => {
    if (id) cartStore.fetchCart(id);
    else cartStore.clearCart();
  }
);
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

/* .btn-transparent:hover {
  transform: translateY(-1px);
} */

.icon-btn {
  background: transparent;
  border: none;
  font-size: 1rem;
  width: 40px;
  height: 40px;
  transition: color 0.2s ease, transform 0.2s ease;
}

/* 
.icon-btn:hover {
  color: #0d6efd;
  transform: scale(1.1);
} */

.dropdown-menu {
  background: rgba(255, 255, 255, 0.95);
  backdrop-filter: blur(10px);
}

.form-control::placeholder {
  color: #ccc;
}

.icon-btn {
  background: none;
  border: none;
  cursor: pointer;
  transition: 0.3s;
}

.icon-btn:hover {
  color: #ffcc00;
}

.place::placeholder {
  color: white !important;
  opacity: 1;
  font-size: 0.9rem;
}

.dropdown-center .dropdown-menu {
  left: 50% !important;
  transform: translateX(-50%) !important;
  right: auto !important;
}

.badge {
  min-width: 20px;
  height: 20px;
  line-height: 18px;
  text-align: center;
  font-size: 0.75rem;
  padding: 0;
  border-radius: 50%;
  right: -5px;
  top: 20px;
}

@media (max-width: 768px) {
  .header_section {
    padding: 5px 0 !important;
  }

}
</style>