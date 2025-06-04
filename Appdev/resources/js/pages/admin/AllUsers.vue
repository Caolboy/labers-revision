<script setup>
import { ref, computed, onMounted } from 'vue'
import axios from 'axios'

const users = ref([])
const search = ref('')
const currentPage = ref(1)
const perPage = 10
const selectedUser = ref(null)
const selectedUserBookings = ref(null)
const editUser = ref(null)
const deleteUser = ref(null)
const activeBookingView = ref('lab')

const fetchUsers = async () => {
  try {
    const res = await axios.get('/admin/users', { params: { search: search.value } })
    users.value = res.data
  } catch (err) {
    console.error('Failed to fetch users', err)
  }
}

const handleSearch = () => {
  currentPage.value = 1
  fetchUsers()
}

const paginatedUsers = computed(() => {
  const start = (currentPage.value - 1) * perPage
  return users.value.slice(start, start + perPage)
})

const totalPages = computed(() => Math.ceil(users.value.length / perPage))

const nextPage = () => {
  if (currentPage.value < totalPages.value) currentPage.value++
}

const prevPage = () => {
  if (currentPage.value > 1) currentPage.value--
}

const openBookingsModal = async (user) => {
  selectedUser.value = user
  activeBookingView.value = 'lab' 
  try {
    const res = await axios.get(`/admin/users/${user.id}/bookings`)
    selectedUserBookings.value = res.data
  } catch {
    selectedUserBookings.value = { lab_bookings: [], equipment_bookings: [] }
  }
}

const closeBookingsModal = () => {
  selectedUser.value = null
  selectedUserBookings.value = null
}

const openEditModal = (user) => {
  editUser.value = { 
    ...user,
    is_admin: !!user.is_admin
  }
}

const updateUser = async () => {
  try {
    const userData = {
      ...editUser.value,
      is_admin: editUser.value.is_admin ? 1 : 0
    }
    
    await axios.put(`/admin/users/${editUser.value.id}`, userData)
    editUser.value = null
    fetchUsers()
  } catch (err) {
    console.error('Failed to update user', err)
    alert('Failed to update user. Please try again.')
  }
}

const openDeleteModal = (user) => {
  deleteUser.value = user
}

const confirmDeleteUser = async () => {
  try {
    await axios.delete(`/admin/users/${deleteUser.value.id}`)
    deleteUser.value = null
    fetchUsers()
  } catch (err) {
    console.error('Failed to delete user', err)
  }
}

onMounted(fetchUsers)
</script>

<template>
  <div class="p-6 bg-white rounded-2xl shadow-md mt-8 font-sans">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
      <h2 class="text-2xl font-semibold text-orange-600">All Users</h2>
      <input
        v-model="search"
        @input="handleSearch"
        type="text"
        placeholder="Search by name, email, or role"
        class="px-3 py-2 border border-orange-300 rounded-md text-sm w-full sm:w-72 focus:outline-none focus:ring-2 focus:ring-orange-400"
      />
    </div>

    <!-- Table -->
    <div class="overflow-x-auto border border-orange-200 rounded-2xl">
      <table class="min-w-full text-sm text-gray-700">
        <thead class="bg-orange-100 text-orange-700">
          <tr>
            <th class="py-3 px-4 font-semibold text-left">#</th>
            <th class="py-3 px-4 font-semibold text-left">Name</th>
            <th class="py-3 px-4 font-semibold text-left">Email</th>
            <th class="py-3 px-4 font-semibold text-center">Role</th>
            <th class="py-3 px-4 font-semibold text-center">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="user in paginatedUsers"
            :key="user.id"
            class="border-t border-orange-100 hover:bg-blue-50 transition"
          >
            <td class="py-3 px-4">{{ user.id }}</td>
            <td class="py-3 px-4">{{ user.name }}</td>
            <td class="py-3 px-4">{{ user.email }}</td>
            <td class="py-3 px-4 text-center">
              <span
                :class="user.is_admin ? 'bg-gray-700' : 'bg-orange-500'"
                class="inline-block px-3 py-1 rounded-full text-white text-xs font-semibold"
              >
                {{ user.is_admin ? 'Admin' : 'User' }}
              </span>
            </td>
            <td class="py-3 px-4 text-center space-x-2">
              <button @click="openBookingsModal(user)" class="bg-orange-500 hover:bg-orange-600 text-white px-3 py-1 rounded text-xs">
                View Bookings
              </button>
              <button @click="openEditModal(user)" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs">
                Edit
              </button>
              <button @click="openDeleteModal(user)" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs">
                Delete
              </button>
            </td>
          </tr>
          <tr v-if="users.length === 0">
            <td colspan="5" class="p-4 text-center text-gray-500">No users found.</td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="flex justify-center mt-6 gap-4">
      <button @click="prevPage" :disabled="currentPage === 1" class="bg-orange-300 hover:bg-orange-400 text-white px-4 py-1 rounded disabled:opacity-50">
        Previous
      </button>
      <span class="text-sm text-gray-700 mt-1">Page {{ currentPage }} of {{ totalPages }}</span>
      <button @click="nextPage" :disabled="currentPage === totalPages" class="bg-orange-300 hover:bg-orange-400 text-white px-4 py-1 rounded disabled:opacity-50">
        Next
      </button>
    </div>

    <!-- View Bookings Modal -->
    <transition name="fade-scale">
      <div
        v-if="selectedUserBookings"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/30 backdrop-blur-sm px-4"
        @click.self="closeBookingsModal"
      >
        <div class="bg-white p-6 rounded-xl w-full max-w-3xl shadow-lg max-h-[80vh] overflow-auto">
          <h2 class="text-xl font-semibold text-orange-600 mb-4">Bookings for {{ selectedUser.name }}</h2>

          <div class="mb-4 flex justify-center space-x-4">
            <button
              @click="activeBookingView = 'lab'"
              :class="[
                'px-4 py-2 rounded-md font-semibold',
                activeBookingView === 'lab' ? 'bg-orange-500 text-white' : 'bg-orange-100 text-orange-600'
              ]"
            >
              Lab Bookings
            </button>
            <button
              @click="activeBookingView = 'equipment'"
              :class="[
                'px-4 py-2 rounded-md font-semibold',
                activeBookingView === 'equipment' ? 'bg-orange-500 text-white' : 'bg-orange-100 text-orange-600'
              ]"
            >
              Equipment Bookings
            </button>
          </div>

          <transition name="fade-scale" mode="out-in">
            <div :key="activeBookingView">

              <!-- Lab Bookings Table -->
              <div v-show="activeBookingView === 'lab'" class="overflow-x-auto">
                <h3 class="font-semibold text-lg mb-2 text-orange-600">Lab Bookings</h3>
                <table class="min-w-full text-sm border border-orange-200 rounded-md">
                  <thead class="bg-orange-100 text-orange-700">
                    <tr>
                      <th class="p-3 border-b border-orange-200">Room</th>
                      <th class="p-3 border-b border-orange-200 text-center">Date</th>
                      <th class="p-3 border-b border-orange-200 text-center">Time</th>
                      <th class="p-3 border-b border-orange-200 text-center">Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr
                      v-for="(booking, i) in selectedUserBookings.lab_bookings"
                      :key="i"
                      class="border-b border-orange-100"
                    >
                      <td class="p-3">{{ booking.room }}</td>
                      <td class="p-3 text-center">{{ booking.date }}</td>
                      <td class="p-3 text-center">{{ booking.slot }}</td>
                      <td class="p-3 text-center">
                        <span
                          :class="[
                            'capitalize px-3 py-1 rounded-full text-white text-xs font-semibold',
                            booking.status === 'approved'
                              ? 'bg-green-500'
                              : booking.status === 'cancelled'
                              ? 'bg-red-500'
                              : booking.status === 'returned'
                              ? 'bg-blue-500'
                              : 'bg-yellow-400'
                          ]"
                        >
                          {{ booking.status }}
                        </span>
                      </td>
                    </tr>
                    <tr v-if="selectedUserBookings.lab_bookings.length === 0">
                      <td colspan="4" class="p-4 text-center text-gray-500">No lab bookings found.</td>
                    </tr>
                  </tbody>
                </table>
              </div>

              <!-- Equipment Bookings Table -->
              <div v-show="activeBookingView === 'equipment'" class="overflow-x-auto">
                <h3 class="font-semibold text-lg mb-2 text-orange-600">Equipment Bookings</h3>
                <table class="min-w-full text-sm border border-orange-200 rounded-md">
                  <thead class="bg-orange-100 text-orange-700">
                    <tr>
                      <th class="p-3 border-b border-orange-200">Equipment</th>
                      <th class="p-3 border-b border-orange-200 text-center">Date</th>
                      <th class="p-3 border-b border-orange-200 text-center">Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr
                      v-for="(booking, i) in selectedUserBookings.equipment_bookings"
                      :key="i"
                      class="border-b border-orange-100"
                    >
                      <td class="p-3">{{ booking.equipment }}</td>
                      <td class="p-3 text-center">{{ booking.date }}</td>
                      <td class="p-3 text-center">
                        <span
                          :class="[
                            'capitalize px-3 py-1 rounded-full text-white text-xs font-semibold',
                            booking.status === 'approved'
                              ? 'bg-green-500'
                              : booking.status === 'cancelled'
                              ? 'bg-red-500'
                              : booking.status === 'returned'
                              ? 'bg-blue-500'
                              : 'bg-yellow-400'
                          ]"
                        >
                          {{ booking.status }}
                        </span>
                      </td>
                    </tr>
                    <tr v-if="selectedUserBookings.equipment_bookings.length === 0">
                      <td colspan="3" class="p-4 text-center text-gray-500">No equipment bookings found.</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </transition>

          <div class="mt-6 text-right">
            <button
              @click="closeBookingsModal"
              class="bg-orange-500 hover:bg-orange-600 text-white px-5 py-2 rounded-md font-semibold"
            >
              Close
            </button>
          </div>
        </div>
      </div>
    </transition>

    <!-- Edit Modal -->
    <transition name="fade-scale">
      <div
        v-if="editUser"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/30 backdrop-blur-sm px-4"
        @click.self="editUser = null"
      >
        <div class="bg-white p-6 rounded-xl w-full max-w-md shadow-lg">
          <h2 class="text-xl font-semibold text-orange-600 mb-4 text-center">Edit User</h2>

          <form @submit.prevent="updateUser" class="space-y-4">
            <div>
              <label class="block mb-1 font-semibold">Name</label>
              <input v-model="editUser.name" type="text" class="w-full border border-orange-300 rounded px-3 py-2" required />
            </div>
            <div>
              <label class="block mb-1 font-semibold">Email</label>
              <input v-model="editUser.email" type="email" class="w-full border border-orange-300 rounded px-3 py-2" required />
            </div>
            <div>
              <label class="flex items-center space-x-3 cursor-pointer">
                <input 
                  v-model="editUser.is_admin" 
                  type="checkbox" 
                  class="w-5 h-5 text-orange-600 border-2 border-orange-300 rounded focus:ring-orange-500 focus:ring-2"
                />
                <span class="font-semibold text-gray-700">
                  Admin User
                  <span class="block text-sm text-gray-500 font-normal">
                    Check this box to give admin privileges
                  </span>
                </span>
              </label>
            </div>

            <div class="text-right space-x-2">
              <button
                type="button"
                @click="editUser = null"
                class="bg-gray-300 hover:bg-gray-400 px-4 py-2 rounded-md font-semibold"
              >
                Cancel
              </button>
              <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-md font-semibold">
                Save
              </button>
            </div>
          </form>
        </div>
      </div>
    </transition>

    <!-- Delete Modal -->
    <transition name="fade-scale">
      <div
        v-if="deleteUser"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/30 backdrop-blur-sm px-4"
        @click.self="deleteUser = null"
      >
        <div class="bg-white p-6 rounded-xl w-full max-w-sm shadow-lg">
          <h2 class="text-xl font-semibold text-red-600 mb-4">Confirm Delete</h2>
          <p>Are you sure you want to delete user <strong>{{ deleteUser.name }}</strong>?</p>
          <div class="mt-6 flex justify-end space-x-4">
            <button
              @click="deleteUser = null"
              class="bg-gray-300 hover:bg-gray-400 px-4 py-2 rounded-md font-semibold"
            >
              Cancel
            </button>
            <button
              @click="confirmDeleteUser"
              class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md font-semibold"
            >
              Delete
            </button>
          </div>
        </div>
      </div>
    </transition>
  </div>
</template>

<style scoped>
.fade-scale-enter-active,
.fade-scale-leave-active {
  transition: all 0.3s ease;
}
.fade-scale-enter-from,
.fade-scale-leave-to {
  opacity: 0;
  transform: scale(0.95); 
}
</style>