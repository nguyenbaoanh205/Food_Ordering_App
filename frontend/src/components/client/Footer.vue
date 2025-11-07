<template>
  <footer class="footer_section">
    <div class="container">
      <div class="row g-5">
        <!-- Column 1: Contact -->
        <div class="col-lg-4 col-md-6 footer-col">
          <div class="footer_contact p-2">
            <h4 class="footer-title">
              <i class="fas fa-headset me-2"></i> Contact Us
            </h4>
            <div class="contact_link_box">
              <a href="#" class="contact-item">
                <i class="fas fa-map-marker-alt"></i>
                <span>123 Food Street, District 1, Ho Chi Minh City</span>
              </a>
              <a href="tel:+841234567890" class="contact-item">
                <i class="fas fa-phone-alt"></i>
                <span>+84 123 456 7890</span>
              </a>
              <a href="mailto:order@feane.com" class="contact-item">
                <i class="fas fa-envelope"></i>
                <span>order@feane.com</span>
              </a>
            </div>
          </div>
        </div>

        <!-- Column 2: Brand & Description -->
        <div class="col-lg-4 col-md-6 footer-col text-center text-md-start">
          <div class="footer_detail p-2">
            <a href="#" class="footer-logo">
              <span class="brand-name">Order Food</span>
              <i class="fas fa-utensils ms-2"></i>
            </a>
            <p class="footer-desc">
              Delivering hot and fresh meals within 30 minutes.
              Fresh every day – from the kitchen to your hands!
            </p>
            <div class="footer_social">
              <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
              <a href="#" aria-label="Messenger"><i class="fab fa-facebook-messenger"></i></a>
              <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
              <a href="#" aria-label="Tiktok"><i class="fab fa-tiktok"></i></a>
            </div>
          </div>
        </div>

        <!-- Column 3: Opening Hours -->
        <div class="col-lg-4  col-md-12 footer-col">
          <div class="footer_order p-2">
            <h4 class="footer-title">
              <i class="fas fa-clock me-2"></i> Opening Hours
            </h4>
            <div class="opening-hours">
              <p><strong>Every day:</strong> 10:00 AM - 10:00 PM</p>
              <p class="text-success"><i class="fas fa-check-circle"></i> Now Open</p>
              <p class="mt-3">
                <a href="#" class="btn-order-now">
                  <i class="fas fa-shopping-cart me-1"></i> Order Now
                </a>
              </p>
            </div>
          </div>

        </div>
      </div>

      <!-- Footer Bottom -->
      <div class="footer-info text-center mt-5">
        <p class="mb-0">
          &copy; <span id="displayYear"></span>
          <strong> Order Food</strong> – All rights reserved.<br>
          <small>
            Developed by
            <a href="#" target="_blank" class="text-decoration-underline">
              Nguyen Bao Anh
            </a>
          </small>
        </p>
      </div>
    </div>
  </footer>
</template>

<script setup>
import { onMounted } from 'vue'
import Logo from '@/assets/images/logo_food_order.png';

// Auto-update year
onMounted(() => {
  document.getElementById('displayYear').textContent = new Date().getFullYear()
})
</script>

<style scoped>
.footer_section {
  background: linear-gradient(135deg, #1a1a1a 0%, #2d1b1b 100%);
  color: #f8f9fa;
  padding: 60px 0 30px;
  font-family: 'Poppins', sans-serif;
}

.footer-title {
  font-size: 1.35rem;
  font-weight: 600;
  color: #ff6b35;
  margin-bottom: 1.5rem;
  display: flex;
  align-items: center;
}

.contact_link_box .contact-item {
  display: flex;
  align-items: center;
  color: #ddd;
  text-decoration: none;
  margin-bottom: 1rem;
  transition: all 0.3s ease;
  font-size: 0.95rem;
}

.contact_link_box .contact-item:hover {
  color: #ff6b35;
  transform: translateX(5px);
}

.contact_link_box .contact-item i {
  width: 20px;
  color: #ff6b35;
  margin-right: 12px;
  font-size: 1.1rem;
}

.footer-logo {
  display: inline-flex;
  align-items: center;
  font-size: 2rem;
  font-weight: 700;
  color: #ff6b35;
  text-decoration: none;
  margin-bottom: 1rem;
}

.brand-name {
  font-family: 'Dancing Script', cursive;
  font-size: 2.2rem;
}

.footer-desc {
  font-size: 0.95rem;
  line-height: 1.7;
  color: #ccc;
  margin-bottom: 1.5rem;
}

.footer_social a {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 40px;
  height: 40px;
  background: rgba(255, 107, 53, 0.2);
  color: #ff6b35;
  border-radius: 50%;
  margin: 0 8px;
  transition: all 0.3s ease;
  font-size: 1rem;
}

.footer_social a:hover {
  background: #ff6b35;
  color: white;
  transform: translateY(-3px);
}

.opening-hours p {
  margin-bottom: 0.75rem;
  color: #ddd;
  font-size: 0.95rem;
}

.btn-order-now {
  display: inline-flex;
  align-items: center;
  background: #ff6b35;
  color: white;
  padding: 10px 20px;
  border-radius: 50px;
  font-size: 0.9rem;
  font-weight: 500;
  text-decoration: none;
  transition: all 0.3s ease;
  box-shadow: 0 4px 10px rgba(255, 107, 53, 0.3);
}

.btn-order-now:hover {
  background: #e55a2b;
  transform: translateY(-2px);
  box-shadow: 0 6px 15px rgba(255, 107, 53, 0.4);
}

.footer-info {
  border-top: 1px solid rgba(255, 255, 255, 0.1);
  padding-top: 20px;
  margin-top: 40px;
  font-size: 0.9rem;
  color: #aaa;
}

.footer-info a {
  color: #ff6b35;
}

.footer-info a:hover {
  text-decoration: underline;
}

/* Responsive */
@media (max-width: 768px) {
  .footer-title {
    font-size: 1.2rem;
  }

  .footer-logo {
    font-size: 1.8rem;
    justify-content: center;
  }

  .footer_social {
    justify-content: center;
  }

  .btn-order-now {
    width: 100%;
    justify-content: center;
  }
}
</style>
