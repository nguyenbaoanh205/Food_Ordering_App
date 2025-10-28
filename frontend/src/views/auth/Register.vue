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
    const redirect = await userStore.register(form.value); // dùng store
    toast.success("Đăng ký thành công!");
    // Điều hướng sau khi register
    redirect === "admin" ? router.push("/admin") : router.push("/");
  } catch (errMsg) {
    toast.error(errMsg); // hiển thị lỗi bằng toast
  }
};
</script>
