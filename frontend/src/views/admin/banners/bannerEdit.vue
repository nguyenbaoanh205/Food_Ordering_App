<template>
  <div class="container-fluid mt-4">
    <div class="d-flex flex-wrap align-items-center justify-content-between mb-3 gap-2">
      <h2 class="fw-bold mb-0">Edit Banner</h2>
      <router-link to="/admin/banners" class="btn btn-outline-secondary">Back to list</router-link>
    </div>

    <div class="card shadow-sm w-100">
      <div class="card-body">
        <form @submit.prevent="updateBanner">
          <div class="row g-4">
            <div class="col-12 col-md-6">
              <label class="form-label">Title</label>
              <input v-model="form.title" type="text" class="form-control" />
            </div>

            <div class="col-12 col-md-6">
              <label class="form-label">Link URL</label>
              <input v-model="form.link" type="text" class="form-control" />
            </div>

            <div class="col-12">
              <label class="form-label">Description</label>
              <textarea v-model="form.description" class="form-control"></textarea>
            </div>

            <div class="col-12 col-md-6">
              <label class="form-label">Status</label>
              <select v-model="form.status" class="form-select">
                <option :value="1">Active</option>
                <option :value="0">Inactive</option>
              </select>
            </div>
          </div>

          <div class="mt-4 d-flex gap-2">
            <button type="submit" class="btn btn-primary">Update</button>
            <router-link to="/admin/banners" class="btn btn-secondary">Cancel</router-link>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useRouter, useRoute } from "vue-router";
import api from "@/services/api";
import { useToast } from "vue-toastification";

const toast = useToast();
const router = useRouter();
const route = useRoute();

const form = ref({
  title: "",
  link: "",
  description: "",
  status: 1,
});

const fetchBanner = async () => {
  try {
    const res = await api.get(`/banners/${route.params.id}`);
    form.value = res.data;
  } catch (err) {
    toast.error("Failed to load banner data");
  }
};

const updateBanner = async () => {
  try {
    await api.put(`/banners/${route.params.id}`, form.value);
    toast.success("Banner updated successfully!");
    router.push("/admin/banners");
  } catch (err) {
    toast.error("Failed to update banner");
  }
};

onMounted(fetchBanner);
</script>
