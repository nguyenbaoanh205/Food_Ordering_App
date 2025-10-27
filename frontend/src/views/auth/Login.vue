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

<script setup>
import { ref } from "vue";
import api from "../api/axios";

const form = ref({
  email: "",
  password: "",
});

const error = ref("");

const handleLogin = async () => {
  error.value = "";
  try {
    const res = await api.post("/login", form.value);
    localStorage.setItem("token", res.data.token);
    localStorage.setItem("user", JSON.stringify(res.data.user));

    alert("Đăng nhập thành công!");
    window.location.href = "/"; // chuyển hướng sang trang chính
  } catch (err) {
    error.value = err.response?.data?.message || "Đăng nhập thất bại!";
  }
};
</script>
