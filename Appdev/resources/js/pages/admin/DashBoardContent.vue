<script setup>
import { ref, onMounted, computed } from 'vue'
import axios from 'axios'
import { Bar } from 'vue-chartjs'
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  BarElement,
  CategoryScale,
  LinearScale,
} from 'chart.js'

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)

const totalRoomBookings = ref(0)
const totalEquipmentBookings = ref(0)
const pendingApprovals = ref(0)
const recentActivities = ref([])
const roomBookingChart = ref([])
const equipmentBookingChart = ref([])
const loading = ref(true)

const currentEquipPage = ref(1)
const equipItemsPerPage = 5

const fetchDashboardData = async () => {
  try {
    const res = await axios.get('/admin/dashboard-data')
    totalRoomBookings.value = res.data.totalRoomBookings
    totalEquipmentBookings.value = res.data.totalEquipmentBookings
    pendingApprovals.value = res.data.pendingApprovals
    recentActivities.value = res.data.recentActivities
    roomBookingChart.value = res.data.roomBookingChart
    equipmentBookingChart.value = res.data.equipmentBookingChart
  } catch (err) {
    console.error(err)
  } finally {
    loading.value = false
  }
}

onMounted(fetchDashboardData)

const roomChartData = computed(() => ({
  labels: roomBookingChart.value.map(item => item.room),
  datasets: [{
    label: 'Room Bookings',
    data: roomBookingChart.value.map(item => item.total),
    backgroundColor: '#f97316'
  }]
}))

const pagedEquipmentChart = computed(() => {
  const start = (currentEquipPage.value - 1) * equipItemsPerPage
  return equipmentBookingChart.value.slice(start, start + equipItemsPerPage)
})

const equipmentChartData = computed(() => ({
  labels: pagedEquipmentChart.value.map(item => item.equipment),
  datasets: [{
    label: 'Equipment Bookings',
    data: pagedEquipmentChart.value.map(item => item.total),
    backgroundColor: '#fb923c'
  }]
}))

const equipmentTotalPages = computed(() => {
  return Math.ceil(equipmentBookingChart.value.length / equipItemsPerPage)
})

const nextEquipPage = () => {
  if (currentEquipPage.value < equipmentTotalPages.value) currentEquipPage.value++
}

const prevEquipPage = () => {
  if (currentEquipPage.value > 1) currentEquipPage.value--
}

const chartOptions = {
  plugins: {
    legend: {
      display: false,
      onClick: () => {}
    }
  },
  scales: {
    y: {
      beginAtZero: true,
      ticks: {
        stepSize: 1,
        callback: (value) => (Number.isInteger(value) ? value : null)
      }
    }
  }
}

const statusColor = (status) => {
  if (status === 'approved') return 'bg-green-500'
  if (status === 'cancelled') return 'bg-red-500'
  return 'bg-yellow-400'
}
</script>

<template>
  <div v-if="loading" class="text-center py-10">Loading dashboard...</div>

  <div v-else class="flex flex-col gap-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <div class="bg-white p-6 rounded-2xl shadow text-orange-600">
        <h3 class="font-semibold text-lg mb-1">Total Room Bookings</h3>
        <p class="text-3xl font-bold">{{ totalRoomBookings }}</p>
      </div>
      <div class="bg-white p-6 rounded-2xl shadow text-orange-500">
        <h3 class="font-semibold text-lg mb-1">Total Equipment Bookings</h3>
        <p class="text-3xl font-bold">{{ totalEquipmentBookings }}</p>
      </div>
      <div class="bg-white p-6 rounded-2xl shadow text-orange-400">
        <h3 class="font-semibold text-lg mb-1">Pending Approvals</h3>
        <p class="text-3xl font-bold">{{ pendingApprovals }}</p>
      </div>
    </div>

    <!-- Charts -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <div class="bg-white p-6 rounded-2xl shadow">
        <h3 class="text-lg font-semibold mb-4 text-orange-600">Room Bookings Chart</h3>
        <Bar :data="roomChartData" :options="chartOptions" />
      </div>

      <div class="bg-white p-6 rounded-2xl shadow flex flex-col">
        <h3 class="text-lg font-semibold mb-4 text-orange-600">Equipment Bookings Chart</h3>
        <Bar :data="equipmentChartData" :options="chartOptions" />
        <div class="mt-4 flex justify-center items-center gap-4">
          <button 
            @click="prevEquipPage" 
            :disabled="currentEquipPage === 1"
            class="px-3 py-1 rounded bg-orange-300 disabled:opacity-50"
          >
            Previous
          </button>
          <span>Page {{ currentEquipPage }} of {{ equipmentTotalPages }}</span>
          <button 
            @click="nextEquipPage" 
            :disabled="currentEquipPage === equipmentTotalPages"
            class="px-3 py-1 rounded bg-orange-300 disabled:opacity-50"
          >
            Next
          </button>
        </div>
      </div>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow">
      <h3 class="text-lg font-semibold mb-4 text-orange-600">Recent Activity</h3>
      <ul class="space-y-4">
        <li v-for="(activity, index) in recentActivities" :key="index" class="flex items-start gap-3">
          <div :class="['w-3 h-3 mt-1 rounded-full', statusColor(activity.status)]"></div>
          <div>
            <p class="text-sm">{{ activity.description }}</p>
            <p class="text-xs text-gray-500">{{ activity.timestamp }}</p>
          </div>
        </li>
      </ul>
    </div>
  </div>
</template>
