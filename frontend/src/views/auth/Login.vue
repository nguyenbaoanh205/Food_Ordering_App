<script setup>
import { ref } from "vue";
import { useRouter, useRoute } from "vue-router";
import { useUserStore } from "@/stores/user"; // ✅ import Pinia store
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
    const redirectRole = await userStore.login(form.value); // ✅ Gọi Pinia login
    toast.success("Đăng nhập thành công!");

    // 🟢 Nếu có query redirect => quay lại đó
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
  <div class="container py-5" style="max-width: 400px;">
    <h2 class="text-center mb-4 fw-bold">Đăng nhập</h2>

    <form @submit.prevent="handleLogin">
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input v-model="form.email" type="email" class="form-control" required />
      </div>

      <div class="mb-3">
        <label class="form-label">Mật khẩu</label>
        <input v-model="form.password" type="password" class="form-control" required />
      </div>

      <button type="submit" class="btn btn-primary w-100">Đăng nhập</button>
    </form>

    <p class="text-center mt-3">
      Chưa có tài khoản?
      <router-link to="/register">Đăng ký ngay</router-link>
    </p>

    <div v-if="error" class="alert alert-danger mt-3">{{ error }}</div>
  </div>
</template>
