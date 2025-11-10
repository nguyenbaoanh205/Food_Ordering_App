<script setup>
import { ref } from "vue";
import { useUserStore } from "@/stores/user";
import { useRouter } from "vue-router";
import { useToast } from "vue-toastification";

const userStore = useUserStore();
const router = useRouter();
const toast = useToast();

const form = ref({
  name: "",
  email: "",
  password: "",
});

const error = ref("");

const handleRegister = async () => {
  error.value = "";
  try {
    const redirect = await userStore.register(form.value);
    toast.success("Register successfully!");
    redirect === "admin" ? router.push("/admin") : router.push("/login");
  } catch (errMsg) {
    toast.error(errMsg);
  }
};
</script>

<template>
  <section class="register-section d-flex align-items-center justify-content-center">
    <div class="register-card shadow-lg p-4 rounded-4 bg-white">
      <div class="text-center mb-4">
        <h2 class="fw-bold text-primary">Create an Account</h2>
        <p class="text-muted small">
          Join <b>Order Food</b> and enjoy the most delicious dishes! 🍱
        </p>
      </div>

      <form @submit.prevent="handleRegister">
        <div class="mb-3">
          <label class="form-label fw-semibold">Full Name</label>
          <input v-model="form.name" type="text" class="form-control form-control-lg" placeholder="Enter your full name"
            required />
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Email</label>
          <input v-model="form.email" type="email" class="form-control form-control-lg"
            placeholder="Enter your email address" required />
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Password</label>
          <input v-model="form.password" type="password" class="form-control form-control-lg"
            placeholder="Create a password" required />
        </div>

        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
          🍜 Sign Up Now
        </button>
      </form>

      <p class="text-center mt-4">
        <span class="text-muted">Already have an account?</span>
        <router-link to="/login" class="fw-bold text-decoration-none ms-1">Login</router-link>
      </p>

      <div v-if="error" class="alert alert-danger mt-3 text-center">{{ error }}</div>
    </div>
  </section>
</template>


<style scoped>
.register-section {
  min-height: 75vh;
  background: linear-gradient(to right, rgba(255, 165, 0, 0.1), rgba(255, 255, 255, 0.8)),
    center/cover no-repeat;
  padding: 20px;
}

.register-card {
  width: 100%;
  max-width: 420px;
  background: #fffdf9;
  border: 2px solid #ffe5b4;
  transition: 0.3s ease;
}

.register-card:hover {
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
