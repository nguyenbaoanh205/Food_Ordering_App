<template>
    <div class="container-fluid mt-4">
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-3 gap-2">
            <h2 class="fw-bold mb-0">Edit User</h2>
            <router-link to="/admin/user" class="btn btn-outline-secondary">Back to list</router-link>
        </div>

        <div class="card shadow-sm w-100">
            <div class="card-body">
                <form @submit.prevent="updateUser">
                    <div class="row g-4">
                        <div class="col-12 col-md-6">
                            <label class="form-label">Name</label>
                            <input v-model="form.name" type="text" class="form-control" placeholder="Enter user name" />
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label">Email</label>
                            <input v-model="form.email" type="email" class="form-control" placeholder="Enter user email" readonly />
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label">Role</label>
                            <select v-model="form.role" class="form-select">
                                <option :value="0">User</option>
                                <option :value="1">Admin</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <router-link to="/admin/user" class="btn btn-secondary">Cancel</router-link>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import api from '@/services/api'

const props = defineProps({
    id: {
        type: String,
        required: true
    }
})

const router = useRouter()

const form = ref({
    name: '',
    email: '',
    role: 0
})

onMounted(async () => {
    try {
        const res = await api.get(`/users/${props.id}`)
        const user = res.data.data

        form.value = {
            name: user.name,
            email: user.email,
            role: user.role
        }
    } catch (err) {
        alert('Failed to load user data')
    }
})

const updateUser = async () => {
    try {
        await api.put(`/users/${props.id}`, form.value)
        alert('Updated successfully!')
        router.push('/admin/user')
    } catch (err) {
        alert('Failed to update user')
    }
}
</script>
