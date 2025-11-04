<template>
  <!-- slider section -->
  <section class="slider_section">
    <Splide :options="options" class="custom-splide">
      <SplideSlide v-for="(slide, index) in slides" :key="index">
        <div class="container">
          <div class="row">
            <div class="col-md-7 col-lg-6">
              <div class="detail-box">
                <h1>{{ slide.title }}</h1>
                <p>{{ slide.description }}</p>
                <div class="btn-box">
                  <a href="#" class="btn1">Order Now</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </SplideSlide>
    </Splide>
  </section>
  <!-- end slider section -->
</template>

<script setup>
import { Splide, SplideSlide } from '@splidejs/vue-splide'
import '@splidejs/vue-splide/css'

// 🖼️ Dữ liệu slide
const slides = [
  {
    title: 'Fast Food Restaurant',
    description:
      'Doloremque, itaque aperiam facilis rerum, commodi, temporibus sapiente ad mollitia laborum quam quisquam esse error unde. Tempora ex doloremque, labore, sunt repellat dolore, iste magni quos nihil ducimus libero ipsam.',
  },
  {
    title: 'Delicious Burgers',
    description:
      'Try our special juicy burgers made with fresh ingredients. Quick service and amazing taste.',
  },
  {
    title: 'Hot and Fresh Pizza',
    description:
      'Enjoy our signature pizzas baked to perfection with melted cheese and fresh toppings.',
  },
]

// ⚙️ Tùy chọn Splide
const options = {
  type: 'loop',
  perPage: 1,
  autoplay: true,
  interval: 4000,
  pauseOnHover: true,
  arrows: false,
  pagination: false,
  speed: 800,
}
</script>

<style>
.custom-splide {
  margin-top: 30px;
}
</style>