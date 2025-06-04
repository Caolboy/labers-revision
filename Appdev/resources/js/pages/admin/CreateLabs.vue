<template>
  <div>
    <h2 class="text-2xl font-bold text-orange-600 mb-6 text-center">Create New Lab</h2>
    <form @submit.prevent="submitForm" enctype="multipart/form-data" class="space-y-5">
      <div>
        <label for="name" class="block text-sm font-semibold mb-1">Name <span class="text-red-500">*</span></label>
        <input
          id="name"
          v-model="form.name"
          type="text"
          required
          class="w-full border border-orange-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-orange-400"
          placeholder="Enter lab name"
        />
      </div>

      <div>
        <label for="description" class="block text-sm font-semibold mb-1">Description</label>
        <textarea
          id="description"
          v-model="form.description"
          rows="4"
          class="w-full border border-orange-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-orange-400 resize-none"
          placeholder="Enter description (optional)"
        ></textarea>
      </div>

      <div>
        <label for="status" class="block text-sm font-semibold mb-1">Status <span class="text-red-500">*</span></label>
        <select
          id="status"
          v-model="form.status"
          required
          class="w-full border border-orange-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-orange-400"
        >
          <option value="" disabled>Select status</option>
          <option value="active">Active</option>
          <option value="inactive">Inactive</option>
        </select>
      </div>

      <div>
        <label class="block text-sm font-semibold mb-1">Image</label>
        <div
          @drop.prevent="handleDrop"
          @dragover.prevent="handleDragOver"
          @dragleave.prevent="handleDragLeave"
          :class="['border-2 border-dashed rounded-md p-6 text-center cursor-pointer transition-colors', dragActive ? 'border-orange-500 bg-orange-50' : 'border-orange-300 bg-white']"
          @click="triggerFileSelect"
          ref="dropArea"
        >
          <input
            ref="fileInput"
            type="file"
            accept="image/*"
            class="hidden"
            @change="onFileChange"
          />
          <p class="text-orange-400 text-sm mb-1">Choose or Drop File</p>
          <p class="text-gray-500 text-xs italic">
            {{ form.image ? form.image.name : 'No file chosen' }}
          </p>
        </div>

        <div v-if="imagePreview" class="mt-3">
          <img
            :src="imagePreview"
            alt="Preview"
            class="mx-auto rounded-md border border-orange-300 max-h-48 object-contain"
          />
        </div>
      </div>

      <button
        type="submit"
        :disabled="loading"
        class="w-full bg-orange-500 hover:bg-orange-700 disabled:bg-orange-300 disabled:cursor-not-allowed text-white font-bold py-2 rounded-md transition"
      >
        {{ loading ? 'Creating...' : 'Create Lab' }}
      </button>
    </form>

    <p v-if="error" class="mt-4 text-center text-red-600 font-semibold">{{ error }}</p>
    <p v-if="success" class="mt-4 text-center text-green-600 font-semibold">Lab created successfully!</p>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import axios from 'axios'

const form = ref({
  name: '',
  description: '',
  status: '',
  image: null,
})

const loading = ref(false)
const error = ref(null)
const success = ref(false)
const imagePreview = ref(null)
const dragActive = ref(false)

const fileInput = ref(null)

function onFileChange(e) {
  const file = e.target.files[0] || null
  setFile(file)
}

function handleDrop(e) {
  dragActive.value = false
  const file = e.dataTransfer.files[0] || null
  if (file && file.type.startsWith('image/')) {
    setFile(file)
  } else {
    error.value = 'Please upload a valid image file.'
  }
}

function handleDragOver() {
  dragActive.value = true
}

function handleDragLeave() {
  dragActive.value = false
}

function setFile(file) {
  error.value = null
  form.value.image = file
  if (file) {
    const reader = new FileReader()
    reader.onload = (event) => {
      imagePreview.value = event.target.result
    }
    reader.readAsDataURL(file)
  } else {
    imagePreview.value = null
  }
}

function triggerFileSelect() {
  fileInput.value.click()
}

async function submitForm() {
  error.value = null
  success.value = false
  loading.value = true

  try {
    const formData = new FormData()
    formData.append('name', form.value.name)
    formData.append('description', form.value.description)
    formData.append('status', form.value.status)
    if (form.value.image) {
      formData.append('image', form.value.image)
    }

    await axios.post('/admin/labs', formData, {
      headers: {
        'Content-Type': 'multipart/form-data',
      },
    })

    form.value = {
      name: '',
      description: '',
      status: '',
      image: null,
    }
    imagePreview.value = null
    success.value = true
  } catch (err) {
    if (err.response?.data?.message) {
      error.value = err.response.data.message
    } else {
      error.value = 'An error occurred while creating the lab.'
    }
  } finally {
    loading.value = false
  }
}
</script>
