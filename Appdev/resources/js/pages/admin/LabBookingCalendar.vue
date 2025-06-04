<template>
  <div class="p-6 max-w-full mx-auto">

    <div class="w-full bg-white rounded-2xl shadow p-4">
      <FullCalendar :options="calendarOptions" />
    </div>

    <transition name="fade-scale">
      <div
        v-if="selectedEvent"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/30 backdrop-blur-sm px-4 rounded-2x1"
        @click.self="closeModal"
      >
        <div class="bg-white p-6 rounded shadow-xl w-full max-w-md mx-auto" @click.stop>
          <h3 class="text-lg font-semibold mb-4 text-center text-orange-600">Booking Details</h3>
          <div class="space-y-2 text-sm">
            <p><strong>User:</strong> {{ selectedEvent.user }}</p>
            <p><strong>Room:</strong> {{ selectedEvent.room }}</p>
            <p><strong>Time Slot:</strong> {{ selectedEvent.slot }}</p>
            <p><strong>Date:</strong> {{ selectedEvent.date }}</p>
          </div>
          <div class="flex justify-end mt-6">
            <button
              @click="closeModal"
              class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded transition"
            >
              Close
            </button>
          </div>
        </div>
      </div>
    </transition>
  </div>
</template>

<script>
import FullCalendar from '@fullcalendar/vue3'
import dayGridPlugin from '@fullcalendar/daygrid'
import axios from 'axios'

export default {
  components: { FullCalendar },
  data() {
    return {
      selectedEvent: null,
      calendarOptions: {
        plugins: [dayGridPlugin],
        initialView: 'dayGridMonth',
        textColor: 'orange',
        headerToolbar: {
          left: 'prev,next today',
          center: 'title',
          right: '',
        },
        validRange: {
          start: new Date().toISOString().split('T')[0],
        },
        weekends: true,
        events: this.fetchEvents,
        eventClick: this.handleEventClick,
        eventColor: '#f97316', 
        eventClassNames: () => [
          'cursor-pointer',
          'bg-orange-100',
          'hover:bg-orange-200',
          'rounded-2x1',
          'text-sm',
          'px-2',
          'py-1',
          'transition-colors',
        ],
      },
    }
  },
  methods: {
    fetchEvents(info, successCallback, failureCallback) {
      axios.get('/admin/lab-bookings', {
        params: {
          start: info.startStr,
          end: info.endStr,
        },
      })
      .then(response => {
        const data = response.data.map(e => ({
          ...e,
          title: `${e.room} - ${e.slot}`,
        }))
        successCallback(data)
      })
      .catch(() => failureCallback())
    },
    handleEventClick(info) {
      const props = info.event.extendedProps
      this.selectedEvent = {
        user: props.user,
        room: props.room,
        slot: props.slot,
        date: info.event.startStr,
      }
    },
    closeModal() {
      this.selectedEvent = null
    },
  },
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
