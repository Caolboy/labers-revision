<template>
  <div class="min-w-full bg-gray-50 p-4">

    <div class="mb-6">
      <div class="flex items-center mb-3">
        <div class="bg-orange-500 text-white rounded-full w-8 h-8 flex items-center justify-center text-sm font-semibold mr-3">
          4
        </div>
        <h2 class="text-xl font-semibold text-orange-600">Confirm Booking</h2>
      </div>
      <p class="text-sm text-gray-600 ml-11">Please review your booking details before confirming.</p>
    </div>

    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-sm">

      <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
        <h3 class="text-sm font-medium text-gray-700 mb-3">Booking Summary</h3>
        <div class="space-y-3">
          <div class="flex justify-between items-start">
            <span class="text-sm text-gray-600">Category:</span>
            <span class="text-sm font-medium text-gray-900">{{ category.name }}</span>
          </div>
          
          <div class="flex justify-between items-start">
            <span class="text-sm text-gray-600">Item:</span>
            <div class="text-right">
              <span class="text-sm font-medium text-gray-900">{{ item.name }}</span>
              <span class="text-xs text-gray-500 block capitalize">({{ item.type }})</span>
            </div>
          </div>
          
          <div class="flex justify-between items-start">
            <span class="text-sm text-gray-600">Date:</span>
            <span class="text-sm font-medium text-gray-900">{{ formatDate(date) }}</span>
          </div>
          
          <div v-if="item.type === 'room'" class="flex justify-between items-start">
            <span class="text-sm text-gray-600">Time:</span>
            <span class="text-sm font-medium text-gray-900">{{ time }}</span>
          </div>
        </div>
      </div>
    </div>

    <div class="ml-11 mb-6">
      <div v-if="success" class="bg-green-50 border border-green-200 rounded-lg p-4">
        <div class="flex items-center">
          <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
          </svg>
          <div>
            <h4 class="text-sm font-medium text-green-800">Booking Successful!</h4>
            <p class="text-sm text-green-700 mt-1">Your booking has been confirmed and saved.</p>
          </div>
        </div>
      </div>

      <div v-if="error" class="bg-red-50 border border-red-200 rounded-lg p-4">
        <div class="flex items-start">
          <svg class="w-5 h-5 text-red-500 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
          </svg>
          <div>
            <h4 class="text-sm font-medium text-red-800">Booking Failed</h4>
            <p class="text-sm text-red-700 mt-1">{{ error }}</p>
          </div>
        </div>
      </div>
    </div>

    <div class="flex justify-between">
      <button
        @click="$emit('back')"
        class="px-6 py-2 rounded-lg font-medium transition-all duration-200 bg-gray-200 text-gray-700 hover:bg-gray-300"
        :disabled="loading"
      >
        ← Back
      </button>
      <button
        @click="submitBooking"
        :class="[
          'px-6 py-2 rounded-lg font-medium transition-all duration-200 flex items-center',
          loading || success
            ? 'bg-gray-400 text-white cursor-not-allowed'
            : 'bg-orange-500 text-white hover:bg-orange-600'
        ]"
        :disabled="loading || success"
      >
        <svg v-if="loading" class="animate-spin -ml-1 mr-3 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        <svg v-else-if="success" class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
        </svg>
        {{ loading ? 'Processing...' : success ? 'Confirmed' : 'Confirm Booking' }}
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import axios from 'axios'

const props = defineProps({
  category:     Object,
  item:         Object,
  date:         String,
  time:         String,
  time_slot_id: Number,   
})

const emit    = defineEmits(['back', 'complete'])
const loading = ref(false)
const success = ref(false)
const error   = ref(null)

function formatDate(dateString) {
  if (!dateString) return ''
  const date = new Date(dateString)
  return date.toLocaleDateString('en-US', {
    weekday: 'long',
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  })
}

async function submitBooking() {
  loading.value = true
  error.value   = null
  success.value = false

  try {
    await axios.post('/bookings', {
      category_id:   props.category.id,
      item_id:       props.item.id,
      item_type:     props.item.type,
      date:          props.date,
      time:          props.time,
      time_slot_id:  props.time_slot_id,
    })
    success.value = true
    emit('complete')
  } catch (e) {
    error.value = e.response?.data?.message || e.message
  } finally {
    loading.value = false
  }
}
</script>