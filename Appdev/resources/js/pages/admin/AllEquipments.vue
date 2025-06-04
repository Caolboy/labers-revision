<template>
  <div class="p-6 bg-white rounded-2xl shadow-md mt-8 font-sans">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
      <h2 class="text-2xl font-semibold text-orange-600">All Equipments</h2>
      <input
        v-model="searchQuery"
        @input="fetchEquipments"
        type="text"
        placeholder="Search name or description"
        class="px-3 py-2 border border-orange-300 rounded-md text-sm w-full sm:w-72 focus:outline-none focus:ring-2 focus:ring-orange-400"
      />
    </div>

    <!-- Table -->
    <div class="overflow-x-auto border border-orange-200 rounded-2xl">
      <table class="min-w-full text-sm text-gray-700">
        <thead class="bg-orange-100 text-orange-700">
          <tr>
            <th class="py-3 px-4 font-semibold text-left">Image</th>
            <th class="py-3 px-4 font-semibold text-left">Name</th>
            <th class="py-3 px-4 font-semibold text-left">Description</th>
            <th class="py-3 px-4 font-semibold text-center">Quantity</th>
            <th class="py-3 px-4 font-semibold text-center">Status</th>
            <th class="py-3 px-4 font-semibold text-center">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="equipment in paginatedEquipments"
            :key="equipment.id"
            class="border-t border-orange-100 hover:bg-blue-50 transition"
          >
            <td class="py-3 px-4">
              <img
                v-if="equipment.image"
                :src="'/' + equipment.image"
                alt="equipment"
                class="h-10 w-10 object-cover rounded border border-gray-200"
              />
            </td>
            <td class="py-3 px-4">{{ equipment.name }}</td>
            <td class="py-3 px-4 max-w-xs whitespace-normal break-words text-gray-600">
              {{ equipment.description }}
            </td>
            <td class="py-3 px-4 text-center">{{ equipment.quantity }}</td>
            <td class="py-3 px-4 text-center">
              <span
                :class="equipment.status === 'available' ? 'bg-green-500' : 'bg-red-500'"
                class="inline-block px-3 py-1 rounded-full text-white text-xs font-semibold"
              >
                {{ equipment.status === 'available' ? 'Availabe' : 'Unavailable' }}
              </span>
            </td>
            <td class="py-3 px-4 text-center space-x-2">
              <button
                @click="openEditModal(equipment)"
                class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs"
              >
                Edit
              </button>
              <button
                @click="openDeleteModal(equipment)"
                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs"
              >
                Delete
              </button>
            </td>
          </tr>
          <tr v-if="equipments.length === 0">
            <td colspan="6" class="p-4 text-center text-gray-500">No equipment found.</td>
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

    <!-- Edit Modal -->
    <transition name="fade-scale">
      <div
        v-if="showEditModal"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/30 backdrop-blur-sm px-4"
        @click.self="closeEditModal"
      >
        <div class="bg-white p-6 rounded-xl w-full max-w-md shadow-lg" @click.stop>
          <h3 class="text-xl font-semibold text-orange-600 mb-4 text-center">Edit Equipment</h3>
          <form @submit.prevent="updateEquipment" class="space-y-4">
            <label class="block mb-1 font-semibold">Name</label>
            <input type="text" v-model="editEquipment.name" placeholder="Name" class="w-full border border-orange-300 rounded-md p-2" />
            <label class="block mb-1 font-semibold">Description</label>
            <textarea v-model="editEquipment.description" placeholder="Description" class="w-full border border-orange-300 rounded-md p-2 min-h-[100px]"></textarea>
            <label class="block mb-1 font-semibold">Quantity</label>
            <input type="number" v-model="editEquipment.quantity" placeholder="Quantity" class="w-full border border-orange-300 rounded-md p-2" />
            <label class="block mb-1 font-semibold">Status</label>
            <select v-model="editEquipment.status" class="w-full border border-orange-300 rounded-md p-2">
              <option value="available">Available</option>
              <option value="unavailable">Unavailable</option>
            </select>

            <label class="block mb-1 font-semibold">Image</label>
            <div
              class="mb-4 border-2 border-dashed border-orange-400 rounded-md p-4 text-center cursor-pointer flex flex-col items-center justify-center hover:bg-orange-50 transition"
              @dragover.prevent
              @drop.prevent="handleDrop"
            >
              <label class="text-orange-600 font-semibold cursor-pointer">
                <span class="block mb-1">Choose or Drop File</span>
                <input type="file" @change="handleImageUpload" class="hidden" />
              </label>
              <p class="text-sm text-gray-600 mt-1">{{ newImage ? newImage.name : "No file chosen" }}</p>
            </div>

            <div v-if="newImage" class="mb-4 flex justify-center">
              <img :src="newImagePreview" alt="New Preview" class="h-24 rounded object-cover border border-orange-400" />
            </div>
            <div v-else-if="editEquipment.image" class="mb-4 flex justify-center">
              <img :src="'/' + editEquipment.image" alt="Existing Preview" class="h-20 rounded object-cover border border-gray-300" />
            </div>

            <div class="flex justify-end gap-3 pt-2">
              <button type="button" @click="closeEditModal" class="bg-gray-300 hover:bg-gray-400 px-4 py-2 rounded-md font-semibold">
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
        v-if="showDeleteModal"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/30 backdrop-blur-sm px-4"
        @click.self="closeDeleteModal"
      >
        <div class="bg-white p-6 rounded-xl w-full max-w-sm shadow-lg text-center" @click.stop>
          <h3 class="text-xl font-semibold text-orange-600 mb-3">Delete Equipment</h3>
          <p class="text-gray-700 mb-5">Are you sure you want to delete <strong>{{ deleteEquipment.name }}</strong>?</p>
          <div class="flex justify-center gap-4">
            <button @click="confirmDeleteEquipment" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md font-semibold">Delete</button>
            <button @click="closeDeleteModal" class="bg-gray-300 hover:bg-gray-400 px-4 py-2 rounded-md font-semibold">Cancel</button>
          </div>
        </div>
      </div>
    </transition>

    <transition name="fade-scale">
      <div
        v-if="showFileErrorModal"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/30 backdrop-blur-sm px-4"
        @click.self="showFileErrorModal = false"
      >
        <div class="bg-white p-6 rounded-xl w-full max-w-sm shadow-lg text-center" @click.stop>
          <h3 class="text-xl font-semibold text-red-600 mb-4">File Upload Error</h3>
          <p class="text-sm text-gray-700 mb-4">{{ fileErrorMessage }}</p>
          <button @click="showFileErrorModal = false" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-md">
            OK
          </button>
        </div>
      </div>
    </transition>
  </div>
</template>


<script setup>
import { ref, computed, onMounted } from "vue";
import axios from "axios";

const equipments = ref([]);
const searchQuery = ref("");
const currentPage = ref(1);
const itemsPerPage = 10;

const showEditModal = ref(false);
const showDeleteModal = ref(false);
const editEquipment = ref({});
const deleteEquipment = ref({});
const newImage = ref(null);
const newImagePreview = ref(null);

const showFileErrorModal = ref(false);
const fileErrorMessage = ref("");

const fetchEquipments = async () => {
  try {
    const response = await axios.get("/admin/equipments", {
      params: { search: searchQuery.value },
    });
    equipments.value = response.data;
  } catch (error) {
    console.error(error);
  }
};

const paginatedEquipments = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage;
  return equipments.value.slice(start, start + itemsPerPage);
});

const totalPages = computed(() => Math.ceil(equipments.value.length / itemsPerPage));
const nextPage = () => currentPage.value < totalPages.value && currentPage.value++;
const prevPage = () => currentPage.value > 1 && currentPage.value--;

const openEditModal = (equipment) => {
  editEquipment.value = { ...equipment };
  newImage.value = null;
  newImagePreview.value = null;
  showEditModal.value = true;
};

const closeEditModal = () => {
  showEditModal.value = false;
  if (newImagePreview.value) URL.revokeObjectURL(newImagePreview.value);
  newImage.value = null;
  newImagePreview.value = null;
};

const isValidImage = (file) => {
  const validTypes = ["image/jpeg", "image/jpg", "image/png", "image/gif"];
  return validTypes.includes(file.type);
};

const setImage = (file) => {
  if (newImagePreview.value) URL.revokeObjectURL(newImagePreview.value);
  newImage.value = file;
  newImagePreview.value = URL.createObjectURL(file);
};

const handleImageUpload = (event) => {
  const file = event.target.files[0];
  if (file && isValidImage(file)) {
    setImage(file);
  } else {
    fileErrorMessage.value = "Invalid file type. Only jpeg, jpg, png, and gif are allowed.";
    showFileErrorModal.value = true;
    event.target.value = "";
  }
};

const handleDrop = (event) => {
  const file = event.dataTransfer.files[0];
  if (file && isValidImage(file)) {
    setImage(file);
  } else {
    fileErrorMessage.value = "Invalid file type. Only jpeg, jpg, png, and gif are allowed.";
    showFileErrorModal.value = true;
  }
};

const updateEquipment = async () => {
  const formData = new FormData();
  formData.append("name", editEquipment.value.name);
  formData.append("description", editEquipment.value.description);
  formData.append("quantity", editEquipment.value.quantity);
  formData.append("status", editEquipment.value.status);
  if (newImage.value) formData.append("image", newImage.value);

  try {
    await axios.post(`/admin/equipments/${editEquipment.value.id}?_method=PUT`, formData, {
      headers: { "Content-Type": "multipart/form-data" },
    });
    await fetchEquipments();
    closeEditModal();
  } catch (error) {
    console.error(error);
  }
};

const openDeleteModal = (equipment) => {
  deleteEquipment.value = equipment;
  showDeleteModal.value = true;
};

const closeDeleteModal = () => {
  showDeleteModal.value = false;
};

const confirmDeleteEquipment = async () => {
  try {
    await axios.delete(`/admin/equipments/${deleteEquipment.value.id}`);
    await fetchEquipments();
    closeDeleteModal();
  } catch (error) {
    console.error(error);
  }
};

onMounted(fetchEquipments);
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