<template>
    <Header />
    <router-view />
    <Footer />
</template>
<script setup>
import Header from '@/components/client/Header.vue';
import Footer from '@/components/client/Footer.vue';

// CSS của thư viện trước (bootstrap, fontawesome)
import '@/assets/css/bootstrap.css'
import '@/assets/css/font-awesome.min.css'

// Global CSS/SCSS của bạn sau (ghi đè thư viện nếu cần)
import '@/assets/css/style.scss'
import '@/assets/css/style.css'
import '@/assets/css/responsive.css'
</script>
<style></style>