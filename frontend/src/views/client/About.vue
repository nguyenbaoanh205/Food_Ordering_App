<template>
  <div class="bg-white">

    <!-- HERO -->
    <section class="py-5 py-md-7 position-relative overflow-hidden" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
      <div class="container">
        <div class="row align-items-center gy-5">
          <div class="col-lg-6">
            <h1 class="display-4 fw-bold mb-4">
              Welcome to <span class="text-main">Foodie</span>
            </h1>
            <p class="lead text-secondary mb-5">
              Fast – convenient food ordering platform – nationwide coverage.<br>
              Millions of delicious meals are waiting for you!
            </p>

            <!-- Stats -->
            <div class="row g-5 text-center text-md-start">
              <div class="col-4">
                <i class="bi bi-lightning-charge-fill display-4 text-main"></i>
                <h3 class="fw-bold mt-3 mb-0">30 mins</h3>
                <p class="text-muted small">Average delivery</p>
              </div>
              <div class="col-4">
                <i class="bi bi-shop display-4 text-main"></i>
                <h3 class="fw-bold mt-3 mb-0">50K+</h3>
                <p class="text-muted small">Partner restaurants</p>
              </div>
              <div class="col-4">
                <i class="bi bi-geo-alt-fill display-4 text-main"></i>
                <h3 class="fw-bold mt-3 mb-0">63</h3>
                <p class="text-muted small">Provinces covered</p>
              </div>
            </div>
          </div>

          <div class="col-lg-6 text-center">
            <img :src="Img"
                 alt="Food delivery"
                 class="img-fluid rounded-4 shadow-lg"
                 style="max-height: 520px; width: 100%; object-fit: cover;">
          </div>
        </div>
      </div>
    </section>

    <!-- MISSION - VISION - VALUES -->
    <section class="py-5 py-md-7">
      <div class="container">
        <div class="text-center mb-5">
          <h2 class="display-6 fw-bold">Who We Are</h2>
          <p class="lead text-muted">Foodie – Bringing delicious meals to every home in just minutes</p>
        </div>

        <div class="row g-5 text-center">
          <div class="col-md-4">
            <div class="p-4">
              <div class="feature-icon mb-4">
                <i class="bi bi-rocket-takeoff-fill"></i>
              </div>
              <h4 class="fw-bold text-main">Mission</h4>
              <p class="text-muted">Connecting people with the tastiest, fastest, and most convenient meals.</p>
            </div>
          </div>

          <div class="col-md-4">
            <div class="p-4">
              <div class="feature-icon mb-4">
                <i class="bi bi-eye-fill"></i>
              </div>
              <h4 class="fw-bold text-main">Vision</h4>
              <p class="text-muted">To become Vietnam's number one food delivery platform by 2030.</p>
            </div>
          </div>

          <div class="col-md-4">
            <div class="p-4">
              <div class="feature-icon mb-4">
                <i class="bi bi-heart-fill"></i>
              </div>
              <h4 class="fw-bold text-main">Core Values</h4>
              <p class="text-muted">Fast – Accurate – Friendly – Customer-Centric</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- WHY CHOOSE FOODIE -->
    <section class="py-5 py-md-7 bg-light">
      <div class="container">
        <div class="text-center mb-5">
          <h2 class="display-6 fw-bold">
            Why millions trust <span class="text-main">Foodie</span>?
          </h2>
        </div>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
          <div class="col">
            <div class="text-center p-4 bg-white rounded-4 shadow-sm h-100 card-hover">
              <div class="why-number mb-3">01</div>
              <h5 class="fw-bold">Super Fast Delivery</h5>
              <p class="text-muted small">Meals always arrive hot</p>
            </div>
          </div>
          <div class="col">
            <div class="text-center p-4 bg-white rounded-4 shadow-sm h-100 card-hover">
              <div class="why-number mb-3">02</div>
              <h5 class="fw-bold">Attractive Offers</h5>
              <p class="text-muted small">Free shipping, daily discounts</p>
            </div>
          </div>
          <div class="col">
            <div class="text-center p-4 bg-white rounded-4 shadow-sm h-100 card-hover">
              <div class="why-number mb-3">03</div>
              <h5 class="fw-bold">Variety of Meals</h5>
              <p class="text-muted small">From budget-friendly to premium dishes</p>
            </div>
          </div>
          <div class="col">
            <div class="text-center p-4 bg-white rounded-4 shadow-sm h-100 card-hover">
              <div class="why-number mb-3">04</div>
              <h5 class="fw-bold">24/7 Support</h5>
              <p class="text-muted small">Always ready to assist</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- JOURNEY -->
    <section class="py-5 py-md-7">
      <div class="container">
        <div class="text-center mb-5">
          <h2 class="display-6 fw-bold">Our Growth Journey</h2>
        </div>

        <div class="row row-cols-2 row-cols-md-4 g-4 text-center">
          <div class="col">
            <div class="milestone p-4 rounded-3">
              <h3 class="fw-bold text-main">2018</h3>
              <p class="mb-0 small text-muted">Founded</p>
            </div>
          </div>
          <div class="col">
            <div class="milestone p-4 rounded-3">
              <h3 class="fw-bold text-main">2020</h3>
              <p class="mb-0 small text-muted">10 million orders</p>
            </div>
          </div>
          <div class="col">
            <div class="milestone p-4 rounded-3">
              <h3 class="fw-bold text-main">2023</h3>
              <p class="mb-0 small text-muted">Operating in 63 provinces</p>
            </div>
          </div>
          <div class="col">
            <div class="milestone p-4 rounded-3">
              <h3 class="fw-bold text-main">2025</h3>
              <p class="mb-0 small text-muted">Top 1 in Vietnam</p>
            </div>
          </div>
        </div>
      </div>
    </section>

  </div>
</template>

<script setup>
import Img from '@/assets/images/about_img.jpg';
</script>

<style scoped>
/* Primary color */
.text-main {
  color: #222831 !important;
}

/* Feature icon circle */
.feature-icon {
  width: 90px;
  height: 90px;
  background: #222831;
  color: white;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 2.5rem;
  margin: 0 auto;
}

/* Number circle */
.why-number {
  width: 64px;
  height: 64px;
  background: #222831;
  color: white;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto;
  font-size: 1.6rem;
  font-weight: bold;
}

/* Card hover effect */
.card-hover {
  transition: all 0.35s ease;
}
.card-hover:hover {
  transform: translateY(-12px);
  box-shadow: 0 20px 40px rgba(34, 40, 49, 0.15) !important;
}

/* Milestone */
.milestone {
  background: #f1f3f5;
  transition: all 0.3s ease;
  border: 2px solid transparent;
}
.milestone:hover {
  background: #222831;
  color: white !important;
  border-color: #222831;
}
.milestone:hover h3,
.milestone:hover p {
  color: white !important;
}
</style>
