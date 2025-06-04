<script setup>
import { ref, computed, onMounted, watch } from 'vue'
import axios from 'axios'
import BookingTable from './BookingTable.vue'

const allLabBookings = ref([])
const allEquipmentBookings = ref([])
const loading = ref(true)

const labPage = ref(1)
const equipmentPage = ref(1)

const labSearch = ref('')
const equipmentSearch = ref('')

const labSort = ref('booking_date_desc')
const equipmentSort = ref('booking_date_desc')

const perPage = 10

const fetchBookings = async () => {
  loading.value = true
  try {
    const res = await axios.get('/admin/bookings')
    allLabBookings.value = res.data.lab_bookings
    allEquipmentBookings.value = res.data.equipment_bookings
  } catch (e) {
    console.error(e)
  } finally {
    loading.value = false
  }
}

const filteredLabBookings = computed(() => {
  let filtered = allLabBookings.value

  if (labSearch.value.trim()) {
    const searchLower = labSearch.value.trim().toLowerCase()
    filtered = filtered.filter(b =>
      b.user.name.toLowerCase().includes(searchLower) ||
      b.room.lab.name.toLowerCase().includes(searchLower) ||
      String(b.room.room_number).toLowerCase().includes(searchLower)
    )
  }

  switch (labSort.value) {
    case 'user_name':
      filtered.sort((a, b) => a.user.name.localeCompare(b.user.name))
      break
    case 'lab_type':
      filtered.sort((a, b) => a.room.lab.name.localeCompare(b.room.lab.name))
      break
    case 'room_number':
      filtered.sort((a, b) => a.room.room_number - b.room.room_number)
      break
    case 'booking_date_desc':
      filtered.sort((a, b) => new Date(b.booking_date) - new Date(a.booking_date))
      break
    case 'status':
      filtered.sort((a, b) => a.status.localeCompare(b.status))
      break
  }

  return filtered
})

const filteredEquipmentBookings = computed(() => {
  let filtered = allEquipmentBookings.value

  if (equipmentSearch.value.trim()) {
    const searchLower = equipmentSearch.value.trim().toLowerCase()
    filtered = filtered.filter(b =>
      b.user.name.toLowerCase().includes(searchLower) ||
      b.equipment.name.toLowerCase().includes(searchLower)
    )
  }

  switch (equipmentSort.value) {
    case 'equipment_name':
      filtered.sort((a, b) => a.equipment.name.localeCompare(b.equipment.name))
      break
    case 'booking_date_desc':
      filtered.sort((a, b) => new Date(b.booking_date) - new Date(a.booking_date))
      break
    case 'status':
      filtered.sort((a, b) => a.status.localeCompare(b.status))
      break
    case 'user_name':
      filtered.sort((a, b) => a.user.name.localeCompare(b.user.name))
      break
  }

  return filtered
})

const pagedLabBookings = computed(() => {
  const start = (labPage.value - 1) * perPage
  return filteredLabBookings.value.slice(start, start + perPage)
})

const pagedEquipmentBookings = computed(() => {
  const start = (equipmentPage.value - 1) * perPage
  return filteredEquipmentBookings.value.slice(start, start + perPage)
})

const labTotalPages = computed(() => Math.ceil(filteredLabBookings.value.length / perPage))
const equipmentTotalPages = computed(() => Math.ceil(filteredEquipmentBookings.value.length / perPage))

const updateStatus = async (id, type, status) => {
  try {
    await axios.put(`/admin/bookings/${id}/status`, { type, status })
    await fetchBookings() 
  } catch (e) {
    console.error(e)
  }
}

const handleLabPageChange = (page) => {
  if (page >= 1 && page <= labTotalPages.value) labPage.value = page
}

const handleEquipmentPageChange = (page) => {
  if (page >= 1 && page <= equipmentTotalPages.value) equipmentPage.value = page
}

watch([labSearch, labSort], () => { labPage.value = 1 })
watch([equipmentSearch, equipmentSort], () => { equipmentPage.value = 1 })

onMounted(fetchBookings)
</script>

<template>
  <div class="p-6 bg-white rounded-2xl shadow-md">

    <div v-if="loading" class="text-center text-gray-500">Loading bookings…</div>

    <div v-else>
      <div class="mb-10">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-4">
          <h3 class="text-xl font-semibold text-orange-500">Lab Bookings</h3>
          <div class="flex gap-2">
            <input v-model="labSearch" placeholder="Search..." class="px-3 py-2 border border-orange-300 rounded-md text-sm w-full md:w-96 focus:outline-none focus:ring-2 focus:ring-orange-400" />
            <select v-model="labSort" class="px-3 py-2 border border-orange-300 rounded-md text-sm text-gray-500 focus:outline-none focus:ring-2 focus:ring-orange-400">
              <option value="booking_date_desc">Date (Newest)</option>
              <option value="user_name">User Name</option>
              <option value="lab_type">Lab Type</option>
              <option value="room_number">Room Number</option>
              <option value="status">Status</option>
            </select>
          </div>
        </div>
        <BookingTable
          :bookings="{ data: pagedLabBookings, current_page: labPage, last_page: labTotalPages, per_page: perPage, total: filteredLabBookings.length }"
          type="lab"
          @update="updateStatus"
          @page-change="handleLabPageChange"
        />
      </div>
    </div>
  </div>

<br>

  <div class="p-6 bg-white rounded-2xl shadow-md">

    <div v-if="loading" class="text-center text-gray-500">Loading bookings…</div>

    <div v-else>
      <div class="mb-10">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-4">
          <h3 class="text-xl font-semibold text-orange-500">Equipment Bookings</h3>
          <div class="flex gap-2">
            <input v-model="equipmentSearch" placeholder="Search..." class="px-3 py-2 border border-orange-300 rounded-md text-sm w-full md:w-96 focus:outline-none focus:ring-2 focus:ring-orange-400" />
            <select v-model="equipmentSort" class="px-3 py-2 border border-orange-300 rounded-md text-sm text-gray-500 focus:outline-none focus:ring-2 focus:ring-orange-400">
              <option value="booking_date_desc">Date (Newest)</option>
              <option value="user_name">User Name</option>
              <option value="equipment_name">Equipment Name</option>
              <option value="status">Status</option>
            </select>
          </div>
        </div>
        <BookingTable
          :bookings="{ data: pagedEquipmentBookings, current_page: equipmentPage, last_page: equipmentTotalPages, per_page: perPage, total: filteredEquipmentBookings.length }"
          type="equipment"
          @update="updateStatus"
          @page-change="handleEquipmentPageChange"
        />
      </div>
    </div>
  </div>
</template>