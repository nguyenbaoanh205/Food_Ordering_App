// src/router/index.js
import Admin from '@/layouts/Admin.vue'
import Client from '@/layouts/Client.vue'
import { createRouter, createWebHistory } from 'vue-router'
import { useUserStore } from '@/stores/user'
import { useToast } from 'vue-toastification'

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
        component: () => import('@/views/auth/Login.vue')
      },
      {
        path: '/register',
        name: 'Register',
        component: () => import('@/views/auth/Register.vue')
      },
      {
        path: '',
        name: 'Home',
        component: () => import('@/views/client/Home.vue')
      },
      {
        path: 'menu',
        name: 'Menu',
        component: () => import('@/views/client/Menu.vue')
      },
      {
        path: 'conact',
        name: 'Contact',
        component: () => import('@/views/client/Contact.vue')
      },
      {
        path: 'about',
        name: 'About',
        component: () => import('@/views/client/About.vue')
      },
      {
        path: 'cart',
        name: 'Cart',
        component: () => import('@/views/client/Cart.vue')
      },
      {
        path: 'checkout',
        name: 'Checkout',
        component: () => import('@/views/client/CheckOut.vue')
      },
      {
        path: 'profile',
        name: 'Profile',
        component: () => import('@/views/client/Profile.vue')
      },
      {
        path: 'order-histories',
        name: 'OrderHistoryClient',
        component: () => import('@/views/client/OrderHistory.vue'),
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
        component: () => import('@/views/admin/Dashboard.vue')
      },
      {
        path: 'food',
        name: 'Food',
        component: () => import('@/views/admin/foods/foodList.vue'),
      },
      {
        path: 'food/create',
        name: 'foodCreate',
        component: () => import('@/views/admin/foods/foodCreate.vue')
      },
      {
        path: 'food/edit/:id',
        name: 'foodEdit',
        component: () => import('@/views/admin/foods/foodEdit.vue'),
        props: true
      },
      {
        path: 'food/:id',
        name: 'foodShow',
        component: () => import('@/views/admin/foods/foodShow.vue'),
        props: true
      },
      {
        path: 'food-options',
        name: 'FoodOption',
        component: () => import('@/views/admin/food-options/foodOptionList.vue'),
      },
      {
        path: 'food-options/create',
        name: 'foodOptionCreate',
        component: () => import('@/views/admin/food-options/foodOptionCreate.vue'),
      },
      {
        path: 'food-options/edit/:id',
        name: 'foodOptionEdit',
        component: () => import('@/views/admin/food-options/foodOptionEdit.vue'),
        props: true
      },
      {
        path: 'category',
        name: 'Category',
        component: () => import('@/views/admin/categories/categoryList.vue'),
      },
      {
        path: 'category/create',
        name: 'categoryCreate',
        component: () => import('@/views/admin/categories/categoryCreate.vue')
      },
      {
        path: 'category/edit/:id',
        name: 'categoryEdit',
        component: () => import('@/views/admin/categories/categoryEdit.vue'),
        props: true
      },
      {
        path: 'order',
        name: 'Order',
        component: () => import('@/views/admin/orders/orderList.vue'),
      },
      {
        path: 'order/:id',
        name: 'OrderShow',
        component: () => import('@/views/admin/orders/orderShow.vue'),
        props: true
      },
      {
        path: 'order-history',
        name: 'OrderHistory',
        component: () => import('@/views/admin/order_history/orderList.vue'),
      },
      {
        path: 'order-history/:id',
        name: 'OrderHistoryShow',
        component: () => import('@/views/admin/order_history/orderShow.vue'),
        props: true
      },
      {
        path: 'user',
        name: 'User',
        component: () => import('@/views/admin/users/userList.vue'),
      },
      {
        path: 'user/create',
        name: 'userCreate',
        component: () => import('@/views/admin/users/userCreate.vue')
      },
      {
        path: 'user/edit/:id',
        name: 'userEdit',
        component: () => import('@/views/admin/users/userEdit.vue'),
        props: true
      },
      {
        path: 'review',
        name: 'Review',
        component: () => import('@/views/admin/reviews/reviewList.vue'),
      },
      {
        path: 'banners',
        name: 'Banner',
        component: () => import('@/views/admin/banners/bannerList.vue')
      },
      {
        path: 'banners/create',
        name: 'bannerCreate',
        component: () => import('@/views/admin/banners/bannerCreate.vue')
      },
      {
        path: 'banners/edit/:id',
        name: 'bannerEdit',
        component: () => import('@/views/admin/banners/bannerEdit.vue'),
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

  if (to.meta.requiresAdmin && (!user || user.role !== 1)) {
    toast.error('Bạn không có quyền truy cập trang quản trị!')
    return next('/')
  }

  next()
})

export default router
