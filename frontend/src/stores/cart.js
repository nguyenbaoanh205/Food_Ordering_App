import { defineStore } from "pinia";
import api from "@/services/api";

export const useCartStore = defineStore("cart", {
    state: () => ({
        items: [],
    }),

    getters: {
        cartCount: (state) => state.items.length,
    },

    actions: {
        async fetchCart(userId) {
            if (!userId) {
                this.items = [];
                return;
            }

            try {
                const res = await api.get(`/users/${userId}/cart`);
                this.items = res.data.items || [];
            } catch (error) {
                console.error("Lỗi khi lấy giỏ hàng:", error);
                this.items = [];
            }
        },

        // 🛒 Thêm vào giỏ hàng (có topping, size)
        async addToCart(userId, foodId, quantity = 1, price = 0, sizeOptionId = null, toppingOptionIds = []) {
            try {
                await api.post(`/cart/add`, {
                    user_id: userId,
                    food_id: foodId,
                    quantity,
                    price,
                    size_option_id: sizeOptionId,
                    topping_option_ids: toppingOptionIds,
                });
                await this.fetchCart(userId); // cập nhật giỏ hàng ngay
            } catch (error) {
                console.error("Lỗi khi thêm giỏ hàng:", error);
            }
        },

        async clearCart() {
            this.items = [];
        },
    },
});
