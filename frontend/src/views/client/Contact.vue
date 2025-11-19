<template>
    <div class="bg-white min-vh-75">

        <!-- HERO -->
        <section class="py-4 text-center" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
            <div class="container">
                <h1 class="display-4 fw-bold mb-3">
                    Contact <span class="text-main">Order Food</span>
                </h1>
                <p class="lead text-secondary">
                    We are always ready to assist you 24/7
                </p>
            </div>
        </section>

        <!-- MAIN CONTENT -->
        <section class="py-5">
            <div class="container">
                <div class="row g-5 justify-content-center">

                    <!-- CONTACT FORM -->
                    <div class="col-lg-7">
                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="p-5">
                                <h4 class="fw-bold mb-4 text-main">
                                    Send Us a Message
                                </h4>

                                <form @submit.prevent="submitForm" class="row g-4">
                                    <div class="col-md-6">
                                        <label class="form-label text-secondary small fw-medium">Full Name</label>
                                        <input v-model="form.name" required
                                            class="form-control form-control-lg rounded-3" placeholder="John Doe">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label text-secondary small fw-medium">Email</label>
                                        <input v-model="form.email" type="email" required
                                            class="form-control form-control-lg rounded-3"
                                            placeholder="you@example.com">
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label text-secondary small fw-medium">Message</label>
                                        <textarea v-model="form.message" rows="6" required
                                            class="form-control rounded-3 resize-none"
                                            placeholder="Let us know how we can help you..."></textarea>
                                    </div>

                                    <div class="col-12">
                                        <button type="submit"
                                            class="btn btn-main text-white btn-lg px-5 py-3 rounded-3 fw-bold shadow-sm w-100 w-md-auto">
                                            Send Message
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- CONTACT INFO -->
                    <div class="col-lg-4">
                        <div class="card border-0 shadow-sm rounded-4 h-100">
                            <div class="p-5">
                                <h5 class="fw-bold mb-4 text-main">
                                    Contact Information
                                </h5>

                                <div class="d-flex align-items-start mb-4">
                                    <div class="icon-circle flex-shrink-0 me-3">
                                        <i class="bi bi-telephone-fill text-white fs-5"></i>
                                    </div>
                                    <div>
                                        <p class="mb-1 fw-bold">1900 9999</p>
                                        <small class="text-muted">24/7 Hotline Support</small>
                                    </div>
                                </div>

                                <div class="d-flex align-items-start mb-4">
                                    <div class="icon-circle flex-shrink-0 me-3">
                                        <i class="bi bi-envelope-fill text-white fs-5"></i>
                                    </div>
                                    <div>
                                        <p class="mb-1 fw-bold">support@orderfood.vn</p>
                                        <small class="text-muted">Response within 1 hour</small>
                                    </div>
                                </div>

                                <div class="d-flex align-items-start mb-4">
                                    <div class="icon-circle flex-shrink-0 me-3">
                                        <i class="bi bi-geo-alt-fill text-white fs-5"></i>
                                    </div>
                                    <div>
                                        <p class="mb-1 fw-bold">123 Nguyen Trai, Hanoi</p>
                                        <small class="text-muted">Head Office</small>
                                    </div>
                                </div>

                                <hr class="my-4">

                                <h6 class="fw-bold text-main mb-3">Working Hours</h6>
                                <p class="text-muted mb-1">Mon – Fri: 08:00 - 22:00</p>
                                <p class="text-muted mb-0">Sat – Sun: 09:00 - 23:00</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </div>
</template>


<script setup>
import { reactive } from "vue";
import api from "@/services/api";

const form = reactive({
    name: "",
    email: "",
    message: ""
});

const submitForm = async () => {
    try {
        await api.post("/contact", form);
        alert("Gửi thành công! Chúng tôi sẽ liên hệ bạn sớm nhất ❤️");
        Object.assign(form, { name: "", email: "", message: "" });
    } catch (error) {
        alert("Có lỗi xảy ra. Vui lòng thử lại sau!");
    }
};
</script>

<style scoped>
/* Màu chủ đạo #222831 */
.text-main {
    color: #222831 !important;
}

/* Nút màu chủ đạo */
.btn-main {
    background: #222831;
    transition: all 0.3s ease;
}

.btn-main:hover {
    background: #1a1f25;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(34, 40, 49, 0.3);
}

/* Icon tròn màu chủ đạo */
.icon-circle {
    width: 48px;
    height: 48px;
    background: #222831;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Focus input đẹp */
input:focus,
textarea:focus {
    border-color: #222831 !important;
    box-shadow: 0 0 0 4px rgba(34, 40, 49, 0.15) !important;
}
</style>