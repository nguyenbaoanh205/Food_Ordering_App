import { defineStore } from "pinia";
import api from "@/services/api"; // ← bạn đã có sẵn file này

export const useUserStore = defineStore("user", {
  state: () => ({
    user: JSON.parse(localStorage.getItem("user")) || null,
    token: localStorage.getItem("token") || null,
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

        localStorage.setItem("user", JSON.stringify(user));
        localStorage.setItem("token", token);

        alert("Đăng nhập thành công!");
        return redirect;
      } catch (err) {
        throw (
          err.response?.data?.message ||
          err.response?.data?.errors?.email?.[0] ||
          "Đăng nhập thất bại!"
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
        localStorage.removeItem("user");
        localStorage.removeItem("token");
      }
    },
  },
});
