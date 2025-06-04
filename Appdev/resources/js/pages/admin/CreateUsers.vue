<template>
  <div>
    <h2 class="text-2xl font-bold text-orange-600 mb-6 text-center">Create New User</h2>
    <form @submit.prevent="submitForm" class="space-y-5">

      <div>
        <label for="name" class="block text-sm font-semibold mb-1">
          Name <span class="text-red-500">*</span>
        </label>
        <input
          id="name"
          v-model="form.name"
          type="text"
          required
          @input="onNameInput"
          class="w-full border border-orange-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-orange-400"
          placeholder="Enter full name"
        />
      </div>

      <div>
        <label for="email" class="block text-sm font-semibold mb-1">
          Email <span class="text-red-500">*</span>
        </label>
        <input
          id="email"
          v-model="form.email"
          type="email"
          required
          class="w-full border border-orange-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-orange-400"
          placeholder="Enter email address"
        />
      </div>

      <div>
        <label for="password" class="block text-sm font-semibold mb-1">
          Password <span class="text-red-500">*</span>
        </label>
        <input
          id="password"
          v-model="form.password"
          type="password"
          required
          class="w-full border border-orange-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-orange-400"
          placeholder="Enter password"
        />
      </div>

      <div>
        <label for="is_admin" class="block text-sm font-semibold mb-1">
          Role <span class="text-red-500">*</span>
        </label>
        <select
          id="is_admin"
          v-model="form.is_admin"
          class="w-full border border-orange-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-orange-400"
          required
        >
          <option :value="0">User</option>
          <option :value="1">Admin</option>
        </select>
      </div>

      <button
        type="submit"
        :disabled="loading"
        class="w-full bg-orange-500 hover:bg-orange-700 disabled:bg-orange-300 disabled:cursor-not-allowed text-white font-bold py-2 rounded-md transition"
      >
        {{ loading ? 'Creating...' : 'Create User' }}
      </button>
    </form>

    <p v-if="error" class="mt-4 text-center text-red-600 font-semibold">{{ error }}</p>
    <p v-if="success" class="mt-4 text-center text-green-600 font-semibold">User created successfully!</p>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import axios from 'axios'

const form = ref({
  name: '',
  email: '',
  password: '',
  is_admin: 0, 
})

const loading = ref(false)
const error = ref(null)
const success = ref(false)

function onNameInput(e) {
  const filtered = e.target.value.replace(/[^A-Za-z\s]/g, '')
  form.value.name = filtered
}

function validateName(name) {
  return /^[A-Za-z\s]+$/.test(name)
}

function validateEmail(email) {
  return /\S+@\S+\.\S+/.test(email)
}

function validatePassword(password) {
  return /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/.test(password)
}

async function submitForm() {
  error.value = null
  success.value = false

  if (!validateName(form.value.name)) {
    error.value = 'Name must contain only letters and spaces.'
    return
  }

  if (!validateEmail(form.value.email)) {
    error.value = 'Please enter a valid email address.'
    return
  }

  if (!validatePassword(form.value.password)) {
    error.value = 'Password must be at least 8 characters and contain both letters and numbers.'
    return
  }

  loading.value = true

  try {
    await axios.post('/admin/users', {
      name: form.value.name,
      email: form.value.email,
      password: form.value.password,
      is_admin: form.value.is_admin,
    })

    form.value = { name: '', email: '', password: '', is_admin: 0 }
    success.value = true
  } catch (err) {
    error.value = err.response?.data?.message || 'An error occurred while creating user.'
  } finally {
    loading.value = false
  }
}
</script>
