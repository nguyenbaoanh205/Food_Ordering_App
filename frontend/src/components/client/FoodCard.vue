<template>
    <div class="col-sm-6 col-lg-4 all" :class="food.category?.name?.toLowerCase()">
        <div class="box">
            <!-- <div> -->
            <RouterLink :to="{ name: 'foodDetail', params: { id: food.id } }">
                <div class="img-box">
                    <img :src="food.image" :alt="food.name" />
                </div>
            </RouterLink>
            <div class="detail-box">
                <h5>{{ food.name }}</h5>
                <p>{{ food.description.slice(0, 90) }}{{ food.description.length > 90 ? '...' : '' }}</p>
                <div class="options">
                    <h6>${{ food.price }}</h6>
                    <button @click="$emit('add-to-cart', food)" class="btn btn-sm btn-warning rounded-5">
                        <i class="fas fa-cart-plus" style="color: #fff;"></i>
                    </button>
                </div>
            </div>
            <!-- </div> -->
        </div>
    </div>
</template>

<script setup>
defineProps({
    food: {
        type: Object,
        required: true
    }
})
</script>

<style scoped>
/* .detail-box {
    height: 200px;
} */
</style>
