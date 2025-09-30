import { createApp } from 'vue'
import App from './App.vue'
import router from './router'

// CSS của thư viện trước (bootstrap, fontawesome)
import '@/assets/css/bootstrap.css'
import '@/assets/css/font-awesome.min.css'

// Global CSS/SCSS của bạn sau (ghi đè thư viện nếu cần)
import '@/assets/css/style.scss'
import '@/assets/css/style.css'
import '@/assets/css/responsive.css'


const app = createApp(App)

app.use(router)
app.mount('#app')

