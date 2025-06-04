<template>
  <div class="min-w-full p-6">
    <div class="bg-gradient-to-r from-orange-400 to-orange-500 text-white p-6 rounded-2xl mb-6">
      <h1 class="text-2xl font-bold mb-2">Laboratory Availability</h1>
      <p class="text-orange-100">In case you missed something</p>
    </div>

    <div class="flex flex-col items-center w-full">
      <div class="w-full bg-white rounded-lg p-6 shadow-lg overflow-hidden">
        <FullCalendar :options="calendarOptions" />
      </div>
    </div>

    <transition name="fade-scale">
      <div
        v-if="modalData"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm px-4"
        @click.self="closeModal"
      >
        <div
          class="bg-white p-6 rounded-xl shadow-2xl w-full max-w-5xl mx-auto overflow-y-auto max-h-[90vh]"
          @click.stop
        >
          <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">{{ selectedDate }}</h2>
            <button
              @click="closeModal"
              class="bg-orange-500 text-white px-4 py-2 rounded-lg hover:bg-orange-600 transition-colors font-medium"
            >
              Close
            </button>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <div 
              v-for="lab in modalData" 
              :key="lab.lab_name" 
              class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow"
            >
              <div class="p-4 border-b border-gray-100">
                <div class="flex items-center space-x-2">
                  <div class="w-1 h-8 bg-orange-500 rounded"></div>
                  <h3 class="text-lg font-semibold text-gray-800">{{ lab.lab_name }}</h3>
                </div>
              </div>

              <div class="p-4 space-y-4">
                <div>
                  <h4 class="text-sm font-semibold text-green-700 mb-2">Available Slots</h4>
                  <div class="space-y-1">
                    <div 
                      v-for="slot in lab.available" 
                      :key="slot.room_number + slot.slot"
                      class="text-sm text-gray-700"
                    >
                      Room {{ slot.room_number }} | {{ slot.slot }}
                    </div>
                    <div v-if="lab.available.length === 0" class="text-sm text-gray-400 italic">
                      No available slots
                    </div>
                  </div>
                </div>

                <div>
                  <h4 class="text-sm font-semibold text-red-700 mb-2">Booked Slots</h4>
                  <div class="space-y-1">
                    <div 
                      v-for="slot in lab.booked" 
                      :key="slot.room_number + slot.slot"
                      class="text-sm text-gray-700"
                    >
                      Room {{ slot.room_number }} | {{ slot.slot }}
                    </div>
                    <div v-if="lab.booked.length === 0" class="text-sm text-gray-400 italic">
                      No bookings yet
                    </div>
                  </div>
                </div>
              </div>
            </div>
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
      selectedDate: null,
      modalData: null,
      calendarOptions: {
        plugins: [dayGridPlugin],
        initialView: 'dayGridMonth',
        headerToolbar: {
          left: 'prev next today',
          center: 'title',
          right: '',
        },
        validRange: {
          start: new Date().toISOString().split('T')[0]
        },
        weekends: true,
        eventClick: this.handleEventClick,
        events: this.generateAvailabilityEvents,
        eventColor: '#944c10',
        eventBackgroundColor: '#944c10',
        eventBorderColor: '#ea580c',
        eventTextColor: '#ffffff',
        height: 'auto',
        aspectRatio: 1.8,
        dayMaxEvents: false,
        eventDisplay: 'block',
        eventClassNames: () => [
          'cursor-pointer',
          'rounded-md',
          'text-xs',
          'font-medium',
          'px-2',
          'py-1',
          'transition-all',
          'duration-200',
          'hover:bg-orange-600',
          'hover:shadow-sm',
          'text-center',
          'border-0'
        ],
        dayCellClassNames: () => [
          'hover:bg-gray-50',
          'transition-colors',
          'duration-150'
        ],
        dayHeaderClassNames: () => [
          'text-gray-600',
          'font-semibold',
          'text-sm',
          'py-3',
          'bg-gray-50'
        ]
      }
    }
  },
  methods: {
    generateAvailabilityEvents(info, successCallback) {
      const start = new Date(info.start)
      const end = new Date(info.end)
      const events = []

      for (let date = new Date(start); date <= end; date.setDate(date.getDate() + 1)) {
        const day = date.toISOString().split('T')[0]
        events.push({
          title: 'Check Availability',
          start: day,
          allDay: true,
          extendedProps: {
            checkDate: day
          }
        })
      }

      successCallback(events)
    },

    handleEventClick(info) {
      const date = info.event.extendedProps.checkDate
      if (!date) return

      axios.get('/calendar-availability', {
        params: { date }
      })
        .then(response => {
          this.modalData = response.data
          this.selectedDate = date
        })
        .catch(() => {
          alert('Failed to fetch availability')
        })
    },

    closeModal() {
      this.modalData = null
      this.selectedDate = null
    }
  }
}
</script>

<style>
.fade-scale-enter-active,
.fade-scale-leave-active {
  transition: opacity 0.3s ease, transform 0.3s ease;
}
.fade-scale-enter-from,
.fade-scale-leave-to {
  opacity: 0;
  transform: scale(0.95);
}

.fc {
  font-family: inherit;
}

.fc-theme-standard .fc-scrollgrid {
  border: none;
}

.fc-theme-standard td, 
.fc-theme-standard th {
  border: 1px solid #e5e7eb;
}

.fc-daygrid-day-number {
  color: #374151;
  font-weight: 600;
  font-size: 0.875rem;
  padding: 8px;
}

.fc-day-today {
  background-color: #fef3c7 !important;
}

.fc-day-today .fc-daygrid-day-number {
  color: #d97706;
  font-weight: 700;
}

.fc-toolbar-title {
  font-size: 1.5rem !important;
  font-weight: 700 !important;
  color: #f97316;
}

.fc-button-primary {
  background-color: #f97316 !important;
  border-color: #f97316 !important;
  color: white !important;
  font-weight: 600 !important;
  border-radius: 6px !important;
  padding: 6px 12px !important;
}

.fc-button-primary:hover {
  background-color: #ea580c !important;
  border-color: #ea580c !important;
}

.fc-button-primary:disabled {
  background-color: #d1d5db !important;
  border-color: #d1d5db !important;
}

.fc-event {
  border: none !important;
  font-size: 0.75rem !important;
  font-weight: 600 !important;
}

.fc-daygrid-event {
  margin: 1px 2px !important;
  border-radius: 4px !important;
}
</style>