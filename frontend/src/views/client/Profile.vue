<template>
  <section class="profile_section layout_padding">
    <div class="container">
      <div class="heading_container heading_center mb-4">
        <h2>Thông tin tài khoản</h2>
      </div>

      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card shadow-sm p-4" v-if="user">
            <div class="text-center mb-4">
              <i class="fa fa-user-circle fa-4x text-primary"></i>
              <h4 class="mt-2">{{ user.name }}</h4>
              <p class="text-muted">{{ user.email }}</p>
            </div>

            <div class="mb-3">
              <label class="form-label">Tên</label>
              <input type="text" class="form-control" v-model="user.name">
            </div>

            <div class="mb-3">
              <label class="form-label">Email</label>
              <input type="email" class="form-control" v-model="user.email" disabled>
            </div>

            <div class="mb-3">
              <label class="form-label">Mật khẩu mới</label>
              <input type="password" class="form-control" v-model="password">
            </div>

            <div class="text-center">
              <button class="btn btn-primary" @click="updateProfile">Cập nhật thông tin</button>
              <button class="btn btn-outline-danger ms-2" @click="logout">Đăng xuất</button>
            </div>
          </div>

          <div v-else class="text-center py-5">
            <div class="spinner-border text-primary" role="status">
              <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-3">Đang tải thông tin...</p>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api from '@/services/api'
import { useRouter } from 'vue-router'

const router = useRouter()
const user = ref(null)
const password = ref('')

// ✅ Lấy thông tin user từ API
const fetchProfile = async () => {
  try {
    const token = localStorage.getItem('token')
    if (!token) {
      router.push('/login')
      return
    }

    const res = await api.get('/profile', {
      headers: { Authorization: `Bearer ${token}` }
    })
    user.value = res.data.user
  } catch (error) {
    console.error(error)
    router.push('/login')
  }
}

// ✅ Cập nhật thông tin
const updateProfile = async () => {
  try {
    const token = localStorage.getItem('token')
    const res = await api.post(
      '/update-profile',
      { name: user.value.name, password: password.value },
      { headers: { Authorization: `Bearer ${token}` } }
    )

    alert(res.data.message)
    password.value = ''
  } catch (error) {
    alert('Cập nhật thất bại!')
  }
}

// ✅ Đăng xuất
const logout = async () => {
  try {
    // Gửi yêu cầu logout đến Laravel
    await api.post("/logout", {}, {
      headers: { Authorization: `Bearer ${localStorage.getItem("token")}` }
    });

    alert("Đăng xuất thành công!");
  } catch (error) {
    console.error("Lỗi khi gọi API logout:", error);
  } finally {
    // Xóa dữ liệu cục bộ
    localStorage.removeItem("token");
    localStorage.removeItem("user");
    window.location.href = "/login";
  }
};

onMounted(fetchProfile)
</script>

<style scoped>
.profile_section {
  padding: 80px 0;
}
</style>
