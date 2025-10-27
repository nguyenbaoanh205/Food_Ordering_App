<template>
  <div class="container py-5" style="max-width: 400px;">
    <h2 class="text-center mb-4 fw-bold">Đăng ký tài khoản</h2>

    <form @submit.prevent="handleRegister">
      <div class="mb-3">
        <label class="form-label">Họ tên</label>
        <input v-model="form.name" type="text" class="form-control" required />
      </div>

      <div class="mb-3">
        <label class="form-label">Email</label>
        <input v-model="form.email" type="email" class="form-control" required />
      </div>

      <div class="mb-3">
        <label class="form-label">Mật khẩu</label>
        <input v-model="form.password" type="password" class="form-control" required />
      </div>

      <button type="submit" class="btn btn-primary w-100">Đăng ký</button>
    </form>

    <p class="text-center mt-3">
      Đã có tài khoản?
      <router-link to="/login">Đăng nhập</router-link>
    </p>

    <div v-if="error" class="alert alert-danger mt-3">{{ error }}</div>
  </div>
</template>

<script setup>
import { ref } from "vue";
import api from "../api/axios";

const form = ref({
  name: "",
  email: "",
  password: "",
});

const error = ref("");

const handleRegister = async () => {
  error.value = "";
  try {
    const res = await api.post("/register", form.value);
    localStorage.setItem("token", res.data.token);
    localStorage.setItem("user", JSON.stringify(res.data.user));
    alert("Đăng ký thành công!");
    window.location.href = "/"; // hoặc /home, tuỳ bạn
  } catch (err) {
    error.value = err.response?.data?.message || "Đăng ký thất bại!";
  }
};
</script>
