# 🍔 Order Food App  
> **Fullstack Food Ordering System** built with **Laravel (Backend API)** + **Vue.js 3 (Frontend SPA)**  

---

## 📖 Giới thiệu  

**Order Food App** là hệ thống đặt món ăn trực tuyến cho phép người dùng duyệt menu, thêm món vào giỏ hàng, đặt hàng, đánh giá sản phẩm và theo dõi trạng thái đơn hàng **theo thời gian thực**.  
Ứng dụng được xây dựng bằng **Laravel** cho backend và **Vue.js 3** cho frontend, mang lại hiệu suất cao và trải nghiệm mượt mà.

---

## 🎯 Mục tiêu dự án  
- Xây dựng hệ thống **E-commerce mini** cho lĩnh vực F&B.  
- Tích hợp **Laravel API + Vue.js SPA**.  
- Cung cấp tính năng **realtime notification** khi có đơn hàng mới.  
- Hỗ trợ **authentication**, **authorization**, **bình luận**, **đánh giá**, **thống kê doanh thu**.

---

## ⚙️ Công nghệ sử dụng  
### 🧩 Frontend (Client)
- [Vue.js 3](https://vuejs.org/)  
- [Vue Router](https://router.vuejs.org/)  
- [Pinia](https://pinia.vuejs.org/)  
- [Axios](https://axios-http.com/)  
- [Bootstrap](https://getbootstrap.com/) hoặc [TailwindCSS](https://tailwindcss.com/)  
- [Vue Toastification](https://vue-toastification.maronato.dev/)  
- [Laravel Echo + Pusher](https://pusher.com/)  

### 🧰 Backend (Server)
- [Laravel 10+](https://laravel.com/)  
- [MySQL](https://www.mysql.com/)  
- [Laravel Sanctum](https://laravel.com/docs/sanctum)  
- [Laravel Broadcasting](https://laravel.com/docs/broadcasting)  
- [Mail/Queue](https://laravel.com/docs/queues)  

---

## 📁 Cấu trúc thư mục  

food-ordering-app/
│
├── backend/ # Laravel API
│ ├── app/
│ ├── database/
│ ├── routes/
│ ├── config/
│ └── ...
│
├── frontend/ # Vue.js App
│ ├── src/
│ │ ├── components/
│ │ ├── views/
│ │ ├── router/
│ │ ├── store/
│ │ └── plugins/
│ └── ...
│
└── README.md

---

## 🚀 Cài đặt & Chạy dự án  

### 1️⃣ Backend (Laravel)
- cd backend
- composer install
- cp .env.example .env
- php artisan key:generate
- php artisan migrate --seed
- php artisan serve

### 2️⃣ Frontend (Vue.js)
- cd frontend
- npm install
- npm run dev

---

🔑 Chức năng chính

👤 Người dùng
- Đăng ký / Đăng nhập (Laravel Sanctum)
- Xem danh sách món ăn
- Tìm kiếm và lọc món ăn theo danh mục
- Thêm món vào giỏ hàng
- Thanh toán và đặt hàng
- Đánh giá, bình luận món ăn
- Xem lịch sử & trạng thái đơn hàng realtime

🛠️ Quản trị viên (Admin)
- Quản lý danh mục & sản phẩm
- Quản lý người dùng
- Quản lý đơn hàng (duyệt, giao hàng, hủy)
- Nhận thông báo realtime khi có đơn hàng mới
- Thống kê doanh thu, đơn hàng, sản phẩm bán chạy

---

📡 API Chính
- Method	Endpoint	Mô tả
- POST	/api/register	Đăng ký tài khoản
- POST	/api/login	Đăng nhập
- GET	/api/foods	Lấy danh sách món ăn
- POST	/api/orders	Tạo đơn hàng
- GET	/api/orders/{id}	Xem chi tiết đơn hàng
- PUT	/api/orders/{id}	Cập nhật trạng thái đơn hàng (Admin)

---

🔔 Tính năng Realtime
- Khi admin cập nhật trạng thái đơn hàng, người dùng nhận được thông báo ngay lập tức.
- Khi có đơn hàng mới, admin cũng được thông báo realtime qua Pusher + Laravel Echo.

---

🧪 Môi trường phát triển
- Công cụ	Phiên bản khuyến nghị
- PHP	8.2+
- Laravel	12x
- Node.js	22+
- MySQL	8.0+
- Composer	2.8+
- NPM	10+


