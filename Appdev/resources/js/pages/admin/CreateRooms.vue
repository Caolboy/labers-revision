<template>
  <div>
    <h2 class="text-2xl font-bold text-orange-600 mb-6 text-center">Create New Room</h2>
    <form @submit.prevent="submitForm" class="space-y-5">
      
      <div>
        <label for="room_number" class="block text-sm font-semibold mb-1">
          Room Number <span class="text-red-500">*</span>
        </label>
        <input
          id="room_number"
          v-model="form.room_number"
          type="text"
          required
          class="w-full border border-orange-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-orange-400"
          placeholder="Enter room number"
        />
      </div>
 
      <div>
        <label for="lab_id" class="block text-sm font-semibold mb-1">
          Lab <span class="text-red-500">*</span>
        </label>
        <select
          id="lab_id"
          v-model="form.lab_id"
          required 
          class="w-full border border-orange-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-orange-400"
          :disabled="loadingLabs"
        >
          <option value="" disabled>
            {{ loadingLabs ? 'Loading labs...' : 'Select lab' }}
          </option>
          <option 
            v-for="lab in labs" 
            :key="lab.id" 
            :value="lab.id"
          >
            {{ lab.name }}
          </option>
        </select>
      </div>

      <div>
        <label class="block text-sm font-semibold mb-3">
          Time Slots <span class="text-red-500">*</span>
        </label>
        <div class="space-y-2 max-h-48 overflow-y-auto border border-orange-200 rounded-md p-3">
          <div 
            v-for="slot in availableTimeSlots" 
            :key="slot"
            class="flex items-center"
          >
            <input
              :id="`slot-${slot}`"
              type="checkbox"
              :value="slot"
              @change="handleTimeSlotChange"
              :checked="form.time_slots.includes(slot)"
              class="h-4 w-4 text-orange-600 focus:ring-orange-500 border-orange-300 rounded"
            />
            <label 
              :for="`slot-${slot}`"
              class="ml-2 text-sm text-gray-700 cursor-pointer"
            >
              {{ slot }}
            </label>
          </div>
        </div>
        <p v-if="form.time_slots.length === 0" class="text-red-500 text-xs mt-1">
          Please select at least one time slot
        </p>
        <p class="text-gray-500 text-xs mt-1">
          Selected: {{ form.time_slots.length }} slot(s)
        </p>
      </div>

      <div>
        <label for="status" class="block text-sm font-semibold mb-1">
          Status <span class="text-red-500">*</span>
        </label>
        <select
          id="status"
          v-model="form.status"
          required
          class="w-full border border-orange-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-orange-400"
        >
          <option value="" disabled>Select status</option>
          <option value="available">Available</option>
          <option value="unavailable">Unavailable</option>
        </select>
      </div>

      <button
        type="submit"
        :disabled="loading || form.time_slots.length === 0"
        class="w-full bg-orange-500 hover:bg-orange-700 disabled:bg-orange-300 disabled:cursor-not-allowed text-white font-bold py-2 rounded-md transition"
      >
        {{ loading ? 'Creating...' : 'Create Room' }}
      </button>
    </form>

    <p v-if="error" class="mt-4 text-center text-red-600 font-semibold">{{ error }}</p>
    <p v-if="success" class="mt-4 text-center text-green-600 font-semibold">Room created successfully!</p>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const form = ref({
  room_number: '',
  lab_id: '',
  status: '',
  time_slots: [],
})

const labs = ref([])
const loading = ref(false)
const loadingLabs = ref(false)
const error = ref(null)
const success = ref(false)

const availableTimeSlots = ref([
  '07:00-08:00',
  '08:00-09:00', 
  '09:00-10:00',
  '10:00-11:00',
  '11:00-12:00',
  '12:00-13:00',
  '13:00-14:00',
  '14:00-15:00',
  '15:00-16:00',
  '16:00-17:00',
  '17:00-18:00',
  '18:00-19:00',
  '19:00-20:00',
  '20:00-21:00'
])

async function fetchLabs() {
  loadingLabs.value = true
  try {
    const response = await axios.get('/admin/labs')
    labs.value = response.data
  } catch (err) {
    console.error('Error fetching labs:', err)
    error.value = 'Failed to load labs'
  } finally {
    loadingLabs.value = false
  }
}

function handleTimeSlotChange(event) {
  const slot = event.target.value
  const isChecked = event.target.checked
  
  console.log('Checkbox changed:', slot, isChecked)
  
  if (isChecked) {
    if (!form.value.time_slots.includes(slot)) {
      form.value.time_slots.push(slot)
    }
  } else {
    const index = form.value.time_slots.indexOf(slot)
    if (index > -1) {
      form.value.time_slots.splice(index, 1)
    }
  }
  
  console.log('Updated time_slots:', form.value.time_slots)
}

async function submitForm() {
  error.value = null
  success.value = false
  loading.value = true

  if (!form.value.time_slots || form.value.time_slots.length === 0) {
    error.value = 'Please select at least one time slot'
    loading.value = false
    return
  }

  try {
    const payload = {
      room_number: form.value.room_number,
      lab_id: parseInt(form.value.lab_id),
      status: form.value.status,
      time_slots: form.value.time_slots,
    }
    
    console.log('Sending payload:', payload)
    
    await axios.post('/admin/rooms', payload)

    form.value = { 
      room_number: '', 
      lab_id: '', 
      status: '',
      time_slots: []
    }
    success.value = true
  } catch (err) {
    console.error('Error:', err)
    error.value =
      err.response?.data?.message || 'An error occurred while creating room.'
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  fetchLabs()
})
</script>