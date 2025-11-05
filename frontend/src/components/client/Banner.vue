<template>
  <!-- slider section -->
  <section class="slider_section">
    <Splide :options="options" class="container">
      <SplideSlide v-for="(slide, index) in slides" :key="index">
        <div class="container">
          <div class="row">
            <div class="col-md-6 col-lg-6">
              <div class="detail-box">
                <h1>{{ slide.title }}</h1>
                <p>{{ slide.description }}</p>
                <div class="btn-box">
                  <a :href="slide.link" class="btn1">Order Now</a>
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
import { ref, onMounted } from 'vue'
import api from '@/services/api'

const slides = ref([])

const options = {
  type: 'loop',
  perPage: 1,
  autoplay: true,
  interval: 3000,
  pauseOnHover: true,
  arrows: false,
  pagination: false,
  speed: 700,
}

onMounted(async () => {
  try {
    const res = await api.get('/banners-client')
    slides.value = res.data
  } catch (error) {
    console.error(error)
  }
})
</script>

<style>
.custom-splide {
  margin-top: 30px;
}

.custom-splide .splide__slide {
  display: block !important;
}

.custom-splide .container {
  max-width: 1320px;
  /* hoặc theo Bootstrap container bạn muốn */
  margin: 0 auto;
}
.btn1{
  text-decoration: none;
}
</style>