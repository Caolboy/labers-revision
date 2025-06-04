<template>
  <div class="min-w-full bg-gray-50 p-4">

    <div class="mb-6">
      <div class="flex items-center mb-3">
        <div class="bg-orange-500 text-white rounded-full w-8 h-8 flex items-center justify-center text-sm font-semibold mr-3">
          3
        </div>
        <h2 class="text-xl font-semibold text-orange-600">Select Date & Time</h2>
      </div>
      <p class="text-sm text-gray-600 ml-11">Choose your preferred date and time slot for the booking.</p>
    </div>

    <div class="ml-11">
      <div class="mb-6">
        <label class="block text-sm font-medium text-gray-700 mb-2">Date:</label>
        <input
          type="date"
          v-model="selectedDate"
          :min="today"
          class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200"
        />
      </div>

      <div v-if="isRoom" class="mb-6">
        <label class="block text-sm font-medium text-gray-700 mb-3">Time Slot:</label>
        
        <div v-if="loadingSlots" class="flex items-center justify-center py-8">
          <div class="flex items-center text-gray-500">
            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-orange-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Loading available slots...
          </div>
        </div>

        <div v-else-if="slots.length === 0" class="text-center py-8">
          <div class="text-gray-500">
            <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <p class="text-sm">No time slots available for the selected date.</p>
          </div>
        </div>

        <div v-else class="grid grid-cols-2 gap-3">
          <button
            v-for="slot in slots"
            :key="slot.id"
            :disabled="!slot.available"
            @click="selectSlot(slot)"
            :class="[
              'border rounded-lg px-4 py-3 text-sm font-medium transition-all duration-200',
              selectedSlotId === slot.id
                ? 'border-orange-500 bg-orange-50 text-orange-700'
                : slot.available
                  ? 'border-gray-300 text-gray-700 hover:border-orange-300 hover:bg-orange-50'
                  : 'border-gray-200 text-gray-400 bg-gray-50 cursor-not-allowed'
            ]"
          >
            <div class="flex items-center">
              <div :class="[
                'w-4 h-4 rounded-full border-2 flex items-center justify-center mr-3',
                selectedSlotId === slot.id
                  ? 'border-orange-500 bg-orange-500'
                  : slot.available
                    ? 'border-gray-300'
                    : 'border-gray-200'
              ]">
                <div v-if="selectedSlotId === slot.id" class="w-1.5 h-1.5 bg-white rounded-full"></div>
              </div>
              <span>{{ slot.slot }}</span>
            </div>
          </button>
        </div>
      </div>
    </div>

    <div class="flex justify-between">
      <button
        class="px-6 py-2 rounded-lg font-medium transition-all duration-200 bg-gray-200 text-gray-700 hover:bg-gray-300"
        @click="$emit('back')"
      >
        ← Back
      </button>
      <button
        :class="[
          'px-6 py-2 rounded-lg font-medium transition-all duration-200',
          canContinue 
            ? 'bg-orange-500 text-white hover:bg-orange-600' 
            : 'bg-gray-200 text-gray-400 cursor-not-allowed'
        ]"
        :disabled="!canContinue"
        @click="onNext"
      >
        Next →
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref, watch, computed } from 'vue'
import axios from 'axios'

const props = defineProps({
  selectedItem:     Object,
  selectedDateTime: Object,  
})
const emit = defineEmits(['update:selectedDateTime', 'next', 'back'])

const selectedDate        = ref(props.selectedDateTime.date || '')
const selectedSlotId      = ref(props.selectedDateTime.time_slot_id || null)
const selectedSlotLabel   = ref(props.selectedDateTime.time || '')
const slots               = ref([])
const loadingSlots        = ref(false)
const isRoom              = computed(() => props.selectedItem?.type === 'room')

const today = computed(() => {
  const d = new Date()
  const month = String(d.getMonth() + 1).padStart(2, '0')
  const day = String(d.getDate()).padStart(2, '0')
  const year = d.getFullYear()
  return `${year}-${month}-${day}`
})

async function fetchSlots() {
  if (!isRoom.value || !selectedDate.value) {
    slots.value = []
    return
  }
  loadingSlots.value = true
  try {
    const { data } = await axios.get('/available-slots', {
      params: { item_id: props.selectedItem.id, date: selectedDate.value }
    })
    slots.value = data
  } catch {
    slots.value = []
  } finally {
    loadingSlots.value = false
  }
}

watch([() => props.selectedItem, selectedDate], fetchSlots, { immediate: true })

watch([selectedDate, selectedSlotId, selectedSlotLabel], () => {
  emit('update:selectedDateTime', {
    date          : selectedDate.value,
    time_slot_id  : isRoom.value ? selectedSlotId.value : null,
    time          : isRoom.value ? selectedSlotLabel.value : null
  })
})

const canContinue = computed(() => {
  if (!selectedDate.value) return false
  return isRoom.value ? !!selectedSlotId.value : true
})

function selectSlot(slot) {
  selectedSlotId.value    = slot.id
  selectedSlotLabel.value = slot.slot
}

function onNext() {
  if (canContinue.value) emit('next')
}
</script>