<template>
  <section class="profile_section layout_padding">
    <div class="container">
      <div class="heading_container heading_center mb-4">
        <h2>Thông tin tài khoản</h2>
      </div>

      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card shadow-sm p-4">
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
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref } from 'vue'

const user = ref({
  name: 'Nguyễn Văn A',
  email: 'nguyenvana@example.com'
})

const password = ref('')

const updateProfile = () => {
  console.log('Đã cập nhật:', user.value, password.value)
  alert('Cập nhật thông tin thành công!')
}

const logout = () => {
  localStorage.removeItem('user')
  window.location.href = '/login'
}
</script>

<style scoped>
.profile_section {
  padding: 80px 0;
}
</style>
