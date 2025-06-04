<template>
  <div class="p-6 bg-white rounded-2xl shadow-md mt-8 font-sans">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
      <h2 class="text-2xl font-semibold text-orange-600">All Rooms</h2>
      <input
        v-model="search"
        @input="handleSearch"
        type="text"
        placeholder="Search room number or lab"
        class="px-3 py-2 border border-orange-300 rounded-md text-sm w-full sm:w-72 focus:outline-none focus:ring-2 focus:ring-orange-400"
      />
    </div>

    <div class="overflow-x-auto border border-orange-200 rounded-2xl">
      <table class="min-w-full text-sm text-gray-700">
        <thead class="bg-orange-100 text-orange-700">
          <tr>
            <th class="py-3 px-4 font-semibold text-left">#</th>
            <th class="py-3 px-4 font-semibold text-left">Room Number</th>
            <th class="py-3 px-4 font-semibold text-left">Lab</th>
            <th class="py-3 px-4 font-semibold text-center">Status</th>
            <th class="py-3 px-4 font-semibold text-center">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="room in paginatedRooms"
            :key="room.id"
            class="border-t border-orange-100 hover:bg-blue-50 transition"
          >
            <td class="py-3 px-4">{{ room.id }}</td>
            <td class="py-3 px-4">{{ room.room_number }}</td>
            <td class="py-3 px-4">{{ room.lab.name }}</td>
            <td class="py-3 px-4 text-center">
              <span
                :class="room.status === 'available' ? 'bg-green-500' : 'bg-red-500'"
                class="inline-block px-3 py-1 rounded-full text-white text-xs font-semibold"
              >
                {{ room.status === 'available' ? 'Available' : 'Unavailable' }}
              </span>
            </td>
            <td class="py-3 px-4 text-center space-x-2">
              <button
                @click="openEditModal(room)"
                class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs"
              >
                Edit
              </button>
              <button
                @click="openDeleteModal(room)"
                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs"
              >
                Delete
              </button>
            </td>
          </tr>
          <tr v-if="rooms.length === 0">
            <td colspan="5" class="p-4 text-center text-gray-500">No rooms found.</td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="flex justify-center mt-6 gap-4">
      <button
        @click="prevPage"
        :disabled="currentPage === 1"
        class="bg-orange-300 hover:bg-orange-400 text-white px-4 py-1 rounded disabled:opacity-50"
      >
        Previous
      </button>
      <span class="text-sm text-gray-700 mt-1">Page {{ currentPage }} of {{ totalPages }}</span>
      <button
        @click="nextPage"
        :disabled="currentPage === totalPages"
        class="bg-orange-300 hover:bg-orange-400 text-white px-4 py-1 rounded disabled:opacity-50"
      >
        Next
      </button>
    </div>

    <transition name="fade-scale">
      <div
        v-if="editRoom"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/30 backdrop-blur-sm px-4"
        @click.self="cancelEditRoom"
      >
        <div class="bg-white p-6 rounded-xl w-full max-w-md shadow-lg" @click.stop>
          <h3 class="text-xl font-semibold text-orange-600 mb-4 text-center">Edit Room</h3>
          <form @submit.prevent="updateRoom" class="space-y-4">
            <div>
              <label class="block mb-1 font-semibold">Room Number</label>
              <input
                v-model="editRoom.room_number"
                type="number"
                required
                class="w-full border border-orange-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-orange-400"
              />
            </div>
            <div>
              <label class="block mb-1 font-semibold">Lab ID</label>
              <input
                v-model="editRoom.lab_id"
                type="number"
                required
                class="w-full border border-orange-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-orange-400"
              />
            </div>
            <div>
              <label class="block mb-1 font-semibold">Status</label>
              <select
                v-model="editRoom.status"
                class="w-full border border-orange-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-orange-400"
              >
                <option value="available">Available</option>
                <option value="unavailable">Unavailable</option>
              </select>
            </div>

            <div class="flex justify-end gap-3 pt-2">
              <button
                type="button"
                @click="cancelEditRoom"
                class="bg-gray-300 hover:bg-gray-400 px-4 py-2 rounded-md font-semibold"
              >
                Cancel
              </button>
              <button
                type="submit"
                class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-md font-semibold"
              >
                Save
              </button>
            </div>
          </form>
        </div>
      </div>
    </transition>

    <transition name="fade-scale">
      <div
        v-if="deleteRoom"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/30 backdrop-blur-sm px-4"
        @click.self="deleteRoom = null"
      >
        <div class="bg-white p-6 rounded-xl w-full max-w-sm shadow-lg text-center" @click.stop>
          <h3 class="text-xl font-semibold text-orange-600 mb-3">Delete Room</h3>
          <p class="text-gray-700 mb-5">
            Are you sure you want to delete <strong>Room {{ deleteRoom.room_number }}</strong>?
          </p>
          <div class="flex justify-center gap-4">
            <button
              @click="confirmDeleteRoom"
              class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md font-semibold"
            >
              Delete
            </button>
            <button
              @click="deleteRoom = null"
              class="bg-gray-300 hover:bg-gray-400 px-4 py-2 rounded-md font-semibold"
            >
              Cancel
            </button>
          </div>
        </div>
      </div>
    </transition>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import axios from 'axios'

const rooms = ref([])
const search = ref('')
const editRoom = ref(null)
const deleteRoom = ref(null)

const currentPage = ref(1)
const perPage = 5

const totalPages = computed(() =>
  Math.ceil(rooms.value.length / perPage)
)

const paginatedRooms = computed(() => {
  const start = (currentPage.value - 1) * perPage
  const end = start + perPage
  return rooms.value.slice(start, end)
})

const prevPage = () => {
  if (currentPage.value > 1) currentPage.value--
}

const nextPage = () => {
  if (currentPage.value < totalPages.value) currentPage.value++
}

const fetchRooms = async () => {
  try {
    const res = await axios.get('/admin/rooms', { params: { search: search.value } })
    rooms.value = res.data
    currentPage.value = 1
  } catch (err) {
    console.error('Failed to fetch rooms', err)
  }
}

const handleSearch = () => {
  currentPage.value = 1
  fetchRooms()
}

const openEditModal = (room) => {
  editRoom.value = { ...room }
  roomImageFile.value = null
  if (roomImagePreview.value) URL.revokeObjectURL(roomImagePreview.value)
  roomImagePreview.value = null
}

const cancelEditRoom = () => {
  editRoom.value = null
  if (roomImagePreview.value) URL.revokeObjectURL(roomImagePreview.value)
  roomImageFile.value = null
  roomImagePreview.value = null
}

const updateRoom = async () => {
  try {
    const formData = new FormData()
    formData.append("room_number", editRoom.value.room_number)
    formData.append("lab_id", editRoom.value.lab_id)
    formData.append("status", editRoom.value.status)

    await axios.post(`/admin/rooms/${editRoom.value.id}?_method=PUT`, formData, {
      headers: { "Content-Type": "multipart/form-data" },
    })
    cancelEditRoom()
    fetchRooms()
  } catch (err) {
    console.error('Failed to update room', err)
  }
}

const openDeleteModal = (room) => {
  deleteRoom.value = room
}

const confirmDeleteRoom = async () => {
  try {
    await axios.delete(`/admin/rooms/${deleteRoom.value.id}`)
    deleteRoom.value = null
    fetchRooms()
  } catch (err) {
    console.error('Failed to delete room', err)
  }
}


onMounted(fetchRooms)
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
