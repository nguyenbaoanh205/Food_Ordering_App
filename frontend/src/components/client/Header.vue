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

            <div class="user_option">
              <!-- 👤 Profile -->
              <RouterLink :to="{ name: 'Profile' }" class="user_link">
                <i class="fas fa-user"></i>
              </RouterLink>

              <!-- 🛒 Cart -->
              <RouterLink :to="{ name: 'Cart' }" class="cart_link">
                <i class="fas fa-shopping-cart"></i>
              </RouterLink>

              <!-- 🔍 Search -->
              <form class="form-inline">
                <button class="btn my-2 my-sm-0 nav_search-btn" type="submit">
                  <i class="fas fa-search"></i>
                </button>
              </form>

              <!-- 🧾 Order Online -->
              <RouterLink :to="{ name: 'Order' }" class="order_online">
                Order Online
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
import { RouterLink, useRoute } from 'vue-router';
import Banner from './Banner.vue';
const route = useRoute()
const heights = {
  Home: '1000px',
  Menu: '85px',
  About: '85px',
  Book: '85px',
}

const positions = {
  Menu: 'top center',
  About: 'top center',
  Book: 'top center',
}
</script>
<style>
.hero_area {
  position: relative;
  overflow: hidden;
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