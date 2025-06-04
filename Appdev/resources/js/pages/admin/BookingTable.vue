<template>
  <div>
     <transition name="fade-scale">
      <div
        v-if="showModal"
        class="fixed inset-0 bg-black/40 backdrop-blur-sm z-50 flex items-center justify-center"
        @click.self="showModal = false"
      >
        <div class="bg-white rounded-xl shadow-lg p-6 w-full max-w-sm text-center">
          <h3 class="text-lg font-semibold mb-4 text-orange-600">Confirm Action</h3>
          <p class="mb-6">
            Are you sure you want to cancel this booking?
          </p>
          <div class="flex justify-center gap-4">
            <button
              @click="confirmAction"
              class="bg-orange-600 text-white px-4 py-2 rounded hover:bg-orange-700"
            >
              Yes
            </button>
            <button
              @click="showModal = false"
              class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400"
            >
              Cancel
            </button>
          </div>
        </div>
      </div>
    </transition>

    <div class="overflow-x-auto border border-orange-200 rounded-2xl">
      <table class="min-w-full text-sm text-left border-collapse">
        <thead class="bg-orange-100 text-orange-700">
          <tr>
            <th class="p-3">User</th>
            <th class="p-3">Item</th>
            <th class="p-3 text-center">Date</th>
            <th v-if="type === 'lab'" class="p-3 text-center">Time</th>
            <th class="p-3 text-center">Status</th>
            <th class="p-3 text-center">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="booking in bookings.data"
            :key="booking.id"
            class="border-t border-orange-100 hover:bg-blue-50 transition"
          >
            <td class="p-3">{{ booking.user.name }}</td>
            <td class="p-3">
              <span v-if="type === 'lab'">{{ booking.room.lab.name }} - Room {{ booking.room.room_number }}</span>
              <span v-else>{{ booking.equipment.name }}</span>
            </td>
            <td class="p-3 text-center">{{ booking.booking_date }}</td>
            <td v-if="type === 'lab'" class="p-3 text-center">{{ booking.time_slot?.slot || '—' }}</td>
            <td class="p-3 text-center">
              <span
                :class="[ 'capitalize px-3 py-1 rounded-full text-white text-xs font-semibold',
                  booking.status === 'approved' ? 'bg-green-500' :
                  booking.status === 'cancelled' ? 'bg-red-500' :
                  booking.status === 'returned' ? 'bg-blue-500' : 'bg-yellow-400'
                ]"
              >
                {{ booking.status }}
              </span>
            </td>
            <td class="p-3 text-center">
              <div v-if="!isPastBooking(booking)" class="flex justify-center gap-2 flex-wrap">
                <button
                  v-if="canApprove(booking.status)"
                  @click="directAction(booking.id, 'approved')"
                  class="bg-green-500 text-white px-3 py-1 text-xs rounded hover:bg-green-600"
                >Approve</button>
                <button
                  v-if="canCancel(booking.status)"
                  @click="openModal(booking.id, 'cancelled')"
                  class="bg-red-500 text-white px-3 py-1 text-xs rounded hover:bg-red-600"
                >Cancel</button>
                <button
                  v-if="type === 'equipment' && canReturn(booking.status, booking.booking_date)"
                  @click="directAction(booking.id, 'returned')"
                  class="bg-blue-500 text-white px-3 py-1 text-xs rounded hover:bg-blue-600"
                >Returned</button>
              </div>
            </td>
          </tr>
          <tr v-if="bookings.data.length === 0">
            <td colspan="6" class="text-center p-4 text-gray-400">No bookings available.</td>
          </tr>
        </tbody>
      </table>
    </div>

    <div v-if="bookings.total > bookings.per_page" class="flex justify-center mt-6 gap-2">
      <button
        :disabled="bookings.current_page === 1"
        @click="$emit('page-change', bookings.current_page - 1)"
        class="px-3 py-1 bg-orange-100 text-orange-600 rounded hover:bg-orange-200 disabled:opacity-50"
      >Previous</button>
      <span class="px-3 py-1 text-sm text-gray-600">Page {{ bookings.current_page }} of {{ bookings.last_page }}</span>
      <button
        :disabled="bookings.current_page === bookings.last_page"
        @click="$emit('page-change', bookings.current_page + 1)"
        class="px-3 py-1 bg-orange-100 text-orange-600 rounded hover:bg-orange-200 disabled:opacity-50"
      >Next</button>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const props = defineProps({
  bookings: Object,
  type: String,
})

const emit = defineEmits(['update', 'page-change'])

const showModal = ref(false)
const selectedBookingId = ref(null)
const selectedAction = ref('')

const openModal = (id, action) => {
  selectedBookingId.value = id
  selectedAction.value = action
  showModal.value = true
}

const confirmAction = () => {
  emit('update', selectedBookingId.value, props.type, selectedAction.value)
  showModal.value = false
}

const directAction = (id, action) => {
  emit('update', id, props.type, action)
}

const canApprove = (status) => !['approved', 'cancelled', 'returned'].includes(status)
const canCancel = (status) => !['cancelled', 'returned'].includes(status)
const canReturn = (status, bookingDate) => {
  const today = new Date().toISOString().split('T')[0]
  return status === 'approved' && bookingDate <= today
}

const isPastBooking = (booking) => {
  const now = new Date()
  const bookingDate = new Date(booking.booking_date)
  const nowDateOnly = new Date(now.getFullYear(), now.getMonth(), now.getDate())
  const bookingDateOnly = new Date(bookingDate.getFullYear(), bookingDate.getMonth(), bookingDate.getDate())

  return bookingDateOnly < nowDateOnly
}


</script>

<style scoped>
.fade-scale-enter-active,
.fade-scale-leave-active {
  transition: opacity 0.3s ease, transform 0.3s ease;
}
.fade-scale-enter-from,
.fade-scale-leave-to {
  opacity: 0;
  transform: scale(0.95);
}
</style>