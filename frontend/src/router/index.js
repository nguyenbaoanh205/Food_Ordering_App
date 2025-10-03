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
      {
        path: 'book',
        name: 'Book',
        component: () => import('@/views/client/Book.vue')
      }
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
        path: 'order',
        name: 'Order',
        component: () => import('@/views/admin/Order.vue'),
      },
      {
        path: 'food',
        name: 'Food',
        component: () => import('@/views/admin/food/foodList.vue'),
      },
      {
        path: 'food/create',
        name: 'foodCreate',
        component: () => import('@/views/admin/food/foodCreate.vue')
      },
      {
        path: 'food/edit/:id',
        name: 'foodEdit',
        component: () => import('@/views/admin/food/foodEdit.vue'),
        props: true
      },
      {
        path: 'food/:id',
        name: 'foodShow',
        component: () => import('@/views/admin/food/foodShow.vue'),
        props: true
      },
  // {
  //   path: 'users',
  //   name: 'Users',
  //   component: () => import('@/views/admin/Users.vue')
  // },
  // {
  //   path: 'settings',
  //   name: 'Settings',
  //   component: () => import('@/views/admin/Settings.vue')
  // }
]
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router
