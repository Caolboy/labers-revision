<template>
  <div class="bg-orange-500 text-white shadow-md p-4">
    <div class="max-w-6xl mx-auto flex justify-between items-center">
      <!-- Logo or Branding -->
      <div class="text-lg font-semibold">
        <RouterLink href="/" class="text-white hover:text-gray-200">MyApp</RouterLink>
      </div>

      <!-- Navbar Links (Desktop) -->
      <div class="hidden md:flex space-x-6">
        <RouterLink
          href="/userpanel"
          class="px-3 py-2 rounded hover:bg-red-700"
          :class="{ 'bg-red-700': $page.url === '/userpanel' }"
        >
          User Panel
        </RouterLink>

        <RouterLink
          href="/booking"
          class="px-3 py-2 rounded hover:bg-red-700"
          :class="{ 'bg-red-700': $page.url === '/booking' }"
        >
          Booking
        </RouterLink>

        <RouterLink
          href="/labsandequipment"
          class="px-3 py-2 rounded hover:bg-red-700"
          :class="{ 'bg-red-700': $page.url === '/labsandequipment' }"
        >
          Labs & Equipment
        </RouterLink>
      </div>

      <!-- Mobile Hamburger Menu -->
      <div class="md:hidden">
        <button @click="toggleMenu" class="text-white">
          <i class="fas fa-bars"></i> <!-- Use a hamburger icon here -->
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { Link as RouterLink } from '@inertiajs/vue3';

const menuOpen = ref(false);

const toggleMenu = () => {
  menuOpen.value = !menuOpen.value;
};
</script>

<style scoped>
/* Add styles to toggle the mobile menu */
</style>
