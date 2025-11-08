// src/router/index.js
import Admin from '@/layouts/Admin.vue'
import Client from '@/layouts/Client.vue'
import { createRouter, createWebHistory } from 'vue-router'
import { useUserStore } from '@/stores/user'
import { useToast } from 'vue-toastification'
import api from '@/services/api'
const toast = useToast()
const routes = [
  {
    path: '/',
    name: 'Client',
    component: Client,
    children: [
      {
        path: '/login',
        name: 'Login',
        component: () => import('@/views/auth/Login.vue'),
        meta: { title: 'Login' }
      },
      {
        path: '/register',
        name: 'Register',
        component: () => import('@/views/auth/Register.vue'),
        meta: { title: 'Register' }
      },
      {
        path: '',
        name: 'Home',
        component: () => import('@/views/client/Home.vue'),
        meta: { title: 'Home' }
      },
      {
        path: 'menu',
        name: 'Menu',
        component: () => import('@/views/client/Menu.vue'),
        meta: { title: 'Menu' }
      },
      {
        path: 'conact',
        name: 'Contact',
        component: () => import('@/views/client/Contact.vue'),
        meta: { title: 'Contact' }
      },
      {
        path: 'about',
        name: 'About',
        component: () => import('@/views/client/About.vue'),
        meta: { title: 'About' }
      },
      {
        path: 'cart',
        name: 'Cart',
        component: () => import('@/views/client/Cart.vue'),
        meta: { title: 'Cart' }
      },
      {
        path: 'checkout',
        name: 'Checkout',
        component: () => import('@/views/client/CheckOut.vue'),
        meta: { title: 'Checkout' }
      },
      {
        path: 'profile',
        name: 'Profile',
        component: () => import('@/views/client/Profile.vue'),
        meta: { title: 'Profile' }
      },
      {
        path: 'order-histories',
        name: 'OrderHistoryClient',
        component: () => import('@/views/client/OrderHistory.vue'),
        meta: { title: 'Order history' }
      },
      {
        path: '/food/:id',
        name: 'foodDetail',
        component: () => import('@/views/client/FoodDetail.vue'),
        props: true
      }
    ]
  },
  {
    path: '/admin',
    name: 'Admin',
    component: Admin,
    meta: { requiresAdmin: true },
    children: [
      {
        path: '',
        name: 'Dashboard',
        component: () => import('@/views/admin/Dashboard.vue'),
        meta: { title: 'Dashboard' }
      },
      {
        path: 'food',
        name: 'Food',
        component: () => import('@/views/admin/foods/foodList.vue'),
        meta: { title: 'Food' }
      },
      {
        path: 'food/create',
        name: 'foodCreate',
        component: () => import('@/views/admin/foods/foodCreate.vue'),
        meta: { title: 'Create food' }
      },
      {
        path: 'food/edit/:id',
        name: 'foodEdit',
        component: () => import('@/views/admin/foods/foodEdit.vue'),
        meta: { title: 'Edit food' },
        props: true
      },
      {
        path: 'food/:id',
        name: 'foodShow',
        component: () => import('@/views/admin/foods/foodShow.vue'),
        meta: { title: 'Show food' },
        props: true
      },
      {
        path: 'food-options',
        name: 'FoodOption',
        component: () => import('@/views/admin/food-options/foodOptionList.vue'),
        meta: { title: 'Food options' }
      },
      {
        path: 'food-options/create',
        name: 'foodOptionCreate',
        component: () => import('@/views/admin/food-options/foodOptionCreate.vue'),
        meta: { title: 'Create food option' }
      },
      {
        path: 'food-options/edit/:id',
        name: 'foodOptionEdit',
        component: () => import('@/views/admin/food-options/foodOptionEdit.vue'),
        meta: { title: 'Edit food option' },
        props: true
      },
      {
        path: 'category',
        name: 'Category',
        component: () => import('@/views/admin/categories/categoryList.vue'),
        meta: { title: 'Category' }
      },
      {
        path: 'category/create',
        name: 'categoryCreate',
        component: () => import('@/views/admin/categories/categoryCreate.vue'),
        meta: { title: 'Create category' }
      },
      {
        path: 'category/edit/:id',
        name: 'categoryEdit',
        component: () => import('@/views/admin/categories/categoryEdit.vue'),
        meta: { title: 'Edit category' },
        props: true
      },
      {
        path: 'order',
        name: 'Order',
        component: () => import('@/views/admin/orders/orderList.vue'),
        meta: { title: 'Order' }
      },
      {
        path: 'order/:id',
        name: 'OrderShow',
        component: () => import('@/views/admin/orders/orderShow.vue'),
        meta: { title: 'Show order' },
        props: true
      },
      {
        path: 'order-history',
        name: 'OrderHistory',
        component: () => import('@/views/admin/order_history/orderList.vue'),
        meta: { title: 'Order history' }
      },
      {
        path: 'order-history/:id',
        name: 'OrderHistoryShow',
        component: () => import('@/views/admin/order_history/orderShow.vue'),
        meta: { title: 'Show order history' },
        props: true
      },
      {
        path: 'user',
        name: 'User',
        component: () => import('@/views/admin/users/userList.vue'),
        meta: { title: 'User' }
      },
      {
        path: 'user/create',
        name: 'userCreate',
        component: () => import('@/views/admin/users/userCreate.vue'),
        meta: { title: 'Create user' }
      },
      {
        path: 'user/edit/:id',
        name: 'userEdit',
        component: () => import('@/views/admin/users/userEdit.vue'),
        meta: { title: 'Edit user' },
        props: true
      },
      {
        path: 'review',
        name: 'Review',
        component: () => import('@/views/admin/reviews/reviewList.vue'),
        meta: { title: 'Review' }
      },
      {
        path: 'banners',
        name: 'Banner',
        component: () => import('@/views/admin/banners/bannerList.vue'),
        meta: { title: 'Banner' }
      },
      {
        path: 'banners/create',
        name: 'bannerCreate',
        component: () => import('@/views/admin/banners/bannerCreate.vue'),
        meta: { title: 'Create banner' }
      },
      {
        path: 'banners/edit/:id',
        name: 'bannerEdit',
        component: () => import('@/views/admin/banners/bannerEdit.vue'),
        meta: { title: 'Edit banner' },
        props: true
      }


    ]
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

router.beforeEach((to, from, next) => {
  const userStore = useUserStore()
  const user = userStore.user

  // Nếu route yêu cầu admin mà user không phải admin → chặn
  if (to.meta.requiresAdmin && (!user || user.role !== 1)) {
    toast.error('Bạn không có quyền truy cập trang quản trị!')
    return next('/')
  }

  // Nếu là admin mà cố vào trang client (không có meta.requiresAdmin) → chặn luôn
  if (user && user.role === 1 && !to.meta.requiresAdmin) {
    toast.warning('Admin không thể truy cập khu vực khách hàng!')
    return next('/admin')
  }

  // 🧠 Cập nhật tiêu đề tab
  const defaultTitle = 'Food Ordering App'
  document.title = to.meta.title || defaultTitle

  next()
})

router.afterEach(async (to) => {
  const defaultTitle = 'Food Ordering App'

  if (to.name === 'foodDetail') {
    try {
      const res = await api.get(`/foods/${to.params.id}`)
      const food = res.data.data
      document.title = `${food.name}`
    } catch (err) {
      document.title = defaultTitle
    }
  } else {
    document.title = to.meta.title || defaultTitle
  }
})


export default router
