<script setup>
import { ref } from "vue";
import { useRouter, useRoute } from "vue-router";
import { useUserStore } from "@/stores/user";
import { useToast } from "vue-toastification";

const toast = useToast();
const router = useRouter();
const route = useRoute();
const userStore = useUserStore();

const form = ref({
  email: "",
  password: "",
});
const error = ref("");

const handleLogin = async () => {
  error.value = "";
  try {
    const redirectRole = await userStore.login(form.value);
    toast.success("Login successfully!");

    const redirectPath = route.query.redirect;
    if (redirectPath) {
      router.push(redirectPath);
    } else if (redirectRole === "admin") {
      router.push("/admin");
    } else {
      router.push("/");
    }
  } catch (errMsg) {
    toast.error(errMsg);
  }
};
</script>

<template>
  <section class="login-section d-flex align-items-center justify-content-center">
    <div class="login-card shadow-lg p-4 rounded-4 bg-white">
      <div class="text-center mb-4">
        <h2 class="fw-bold text-primary">Login</h2>
        <p class="text-muted small">Welcome back to <b>Order Food!</b> 🍔</p>
      </div>

      <form @submit.prevent="handleLogin">
        <div class="mb-3">
          <label class="form-label fw-semibold">Email</label>
          <input v-model="form.email" type="email" class="form-control form-control-lg" placeholder="Enter your email"
            required />
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Password</label>
          <input v-model="form.password" type="password" class="form-control form-control-lg" placeholder="••••••••"
            required />
        </div>

        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
          🍕 Login Now
        </button>
      </form>

      <p class="text-center mt-4">
        <span class="text-muted">Don't have an account?</span>
        <router-link to="/register" class="fw-bold text-decoration-none ms-1">
          Sign up now
        </router-link>
      </p>

      <div v-if="error" class="alert alert-danger mt-3 text-center">{{ error }}</div>
    </div>
  </section>
</template>


<style scoped>
.login-section {
  min-height: 75vh;
  background: linear-gradient(to right, rgba(255, 165, 0, 0.1), rgba(255, 255, 255, 0.8)),
    center/cover no-repeat;
  padding: 20px;
}

.login-card {
  width: 100%;
  max-width: 420px;
  background: #fffdf9;
  border: 2px solid #ffe5b4;
  transition: 0.3s ease;
}

.login-card:hover {
  transform: translateY(-3px);
  box-shadow: 0 8px 20px rgba(255, 165, 0, 0.25);
}

.form-control:focus {
  border-color: #ff9800;
  box-shadow: 0 0 5px rgba(255, 152, 0, 0.3);
}

.btn-primary {
  background-color: #ff9800;
  border: none;
  transition: all 0.3s ease;
}

.btn-primary:hover {
  background-color: #ff7f00;
}

.text-primary {
  color: #ff7f00 !important;
}
</style>
