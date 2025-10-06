// src/router/index.js
import Admin from '@/layouts/Admin.vue'
import Client from '@/layouts/Client.vue'
import { createRouter, createWebHistory } from 'vue-router'

const routes = [
  {
    path: '/',
    name: 'Client',
    component: Client,
    children: [
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
        path: 'about',
        name: 'About',
        component: () => import('@/views/client/About.vue')
      },
      // {
      //   path: 'book',
      //   name: 'Book',
      //   component: () => import('@/views/client/Book.vue')
      // }
    ]
  },
  {
    path: '/admin',
    name: 'Admin',
    component: Admin,
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
        component: () => import('@/views/admin/Order.vue'),
      },


    ]
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router
