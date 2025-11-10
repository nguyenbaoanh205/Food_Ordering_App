import { defineStore } from "pinia";
import api from "@/services/api";

export const useUserStore = defineStore("user", {
  state: () => ({
    user: JSON.parse(localStorage.getItem("user")) || null,
    token: localStorage.getItem("token") || null,
    tokenTime: parseInt(localStorage.getItem("tokenTime")) || null,
  }),

  getters: {
    isLoggedIn: (state) => !!state.token,
  },

  actions: {
    async login(form) {
      try {
        const res = await api.post("/login", form);
        const { token, user, redirect } = res.data;

        this.user = user;
        this.token = token;
        this.tokenTime = Date.now(); // 🕒 thời điểm đăng nhập

        localStorage.setItem("user", JSON.stringify(user));
        localStorage.setItem("token", token);
        localStorage.setItem("tokenTime", this.tokenTime);

        return redirect;
      } catch (err) {
        throw (
          err.response?.data?.message ||
          err.response?.data?.errors?.email?.[0] ||
          "Đăng nhập thất bại!"
        );
      }
    },

    async register(form) {
      try {
        const res = await api.post("/register", form);
        return res.data.message;
      } catch (err) {
        throw (
          err.response?.data?.message ||
          "Đăng ký thất bại!"
        );
      }
    },



    async logout() {
      try {
        if (this.token) {
          await api.post(
            "/logout",
            {},
            { headers: { Authorization: `Bearer ${this.token}` } }
          );
        }
      } catch (error) {
        console.error("Lỗi khi gọi API logout:", error);
      } finally {
        this.user = null;
        this.token = null;
        this.tokenTime = null;

        localStorage.removeItem("user");
        localStorage.removeItem("token");
        localStorage.removeItem("tokenTime");
      }
    },

    // ✅ Kiểm tra token còn hợp lệ không
    checkAuth() {
      const MAX_AGE = 2 * 60 * 60 * 1000; // 2 tiếng
      const tokenTime = parseInt(localStorage.getItem("tokenTime")) || 0;

      if (!this.token || !this.user) return false;

      const now = Date.now();
      if (now - tokenTime > MAX_AGE) {
        this.logout();
        return false;
      } else {
        // reset thời gian hoạt động (sliding session)
        localStorage.setItem("tokenTime", now);
        return true;
      }
    }

  },
});
