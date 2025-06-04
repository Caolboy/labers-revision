<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

defineProps<{
  title?: string;
  description?: string;
}>();
</script>

<template>
  <div class="min-h-screen flex flex-col md:flex-row bg-gradient-to-br from-white via-orange-50 to-orange-200">
    <!-- Left: Login Form & Branding -->
    <div class="flex-1 flex flex-col justify-center px-8 py-12 md:py-0 md:px-16 lg:px-24 bg-gradient-to-br from-white to-orange-200 rounded-l-2xl shadow-lg">
      <div class="max-w-md w-full mx-auto">
        <!-- Logo -->
        <div class="flex items-center gap-2 mb-8">
          <img src="/logo-1.png" alt="LABERS Logo" class="h-12 w-auto" />
          <span class="font-bold text-2xl tracking-tight text-[#4E413B]">LABERS</span>
        </div>
        <!-- Welcome Text -->
        <h1 class="text-3xl font-semibold text-[#4E413B] mb-2">Welcome back</h1>
        <p class="text-[#4E413B]/70 mb-8">Please enter your account details to login.</p>
        <!-- Slot for Form -->
        <slot />
      </div>
    </div>
    <!-- Right: Building Image -->
    <div class="hidden md:flex flex-1 items-center justify-center bg-gradient-to-br from-orange-100 to-orange-300 rounded-r-2xl overflow-hidden">
      <img src="/gc.jpg" alt="Building" class="object-cover w-full h-full rounded-r-2xl shadow-xl" />
    </div>
  </div>
</template>

<style scoped>
@media (max-width: 768px) {
  .rounded-l-2xl, .rounded-r-2xl {
    border-radius: 0 !important;
  }
}
</style>
