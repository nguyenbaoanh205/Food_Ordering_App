// src/services/api.js
import axios from 'axios'

const api = axios.create({
  baseURL: 'http://localhost:8000/api', // Laravel API
  headers: {
    'Content-Type': 'application/json'
  }
})

api.interceptors.request.use((config) => {
  const token = localStorage.getItem('token') // token bạn lưu khi đăng nhập
  if (token) {
    config.headers.Authorization = `Bearer ${token}`
  }
  return config
})
export default api
