<template>
  <!-- slider section -->
  <section class="slider_section">
    <Carousel :pagination-enabled="true" :items-to-show="1" :wrap-around="true" :autoplay="false"
      autoplay-timeout="50000" :pauseAutoplayOnHover="true" class="custom-carousel">
      <Slide v-for="(slide, index) in slides" :key="index">
        <div class="container">
          <div class="row">
            <div class="col-md-7 col-lg-6">
              <div class="detail-box">
                <h1>{{ slide.title }}</h1>
                <p>{{ slide.description }}</p>
                <div class="btn-box">
                  <a href="" class="btn1">Order Now</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </Slide>
    </Carousel>
  </section>
  <!-- end slider section -->
</template>

<script setup>
import { Carousel, Slide } from 'vue3-carousel';
import 'vue3-carousel/dist/carousel.css';

const slides = [
  {
    title: 'Fast Food Restaurant',
    description: 'Doloremque, itaque aperiam facilis rerum, commodi, temporibus sapiente ad mollitia laborum quam quisquam esse error unde. Tempora ex doloremque, labore, sunt repellat dolore, iste magni quos nihil ducimus libero ipsam.'
  },
  {
    title: 'Fast Food Restaurant',
    description: 'Doloremque, itaque aperiam facilis rerum, commodi, temporibus sapiente ad mollitia laborum quam quisquam esse error unde. Tempora ex doloremque, labore, sunt repellat dolore, iste magni quos nihil ducimus libero ipsam.'
  },
  {
    title: 'Fast Food Restaurant',
    description: 'Doloremque, itaque aperiam facilis rerum, commodi, temporibus sapiente ad mollitia laborum quam quisquam esse error unde. Tempora ex doloremque, labore, sunt repellat dolore, iste magni quos nihil ducimus libero ipsam.'
  }
]
</script>

<style>
/* Optional: Customize your carousel if needed */
.custom-carousel {
  margin-top: 30px;
}

.btn1 {
  display: inline-block;
  padding: 10px 20px;
  background: #ff5722;
  color: white;
  text-decoration: none;
  border-radius: 4px;
}

.btn1:hover {
  background: #e64a19;
}
</style>
