<script setup lang="ts">
import { ref } from 'vue';
import UserAppLayout from '@/layouts/UserAppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

const props = defineProps<{
  labs: Array<{ id: number; name: string; description: string; image: string | null }>
  equipment: Array<{ id: number; name: string; description: string; image: string | null }>
}>();

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Labs & Equipment',
    href: '/labsandequipment',
  },
];

const activeTab = ref<'laboratories' | 'equipment'>('laboratories');

const switchTab = (tab: 'laboratories' | 'equipment') => {
  activeTab.value = tab;
};
</script>
 
<template>
  <Head title="Labs & Equipment" />

  <UserAppLayout :breadcrumbs="breadcrumbs">
    <div class="min-w-full p-10">
        <div class="bg-gradient-to-r from-orange-400 to-orange-500 text-white p-6 rounded-2xl mb-6">
          <h1 class="text-2xl font-bold mb-2">Laboratory and Equipment</h1>
          <p class="text-orange-100 text-sm sm:text-base">Explore GC CCS state-of-the-art laboratories and equipment.</p>
        </div>

        <div class="bg-white px-6 sm:px-8 rounded-t-2xl border-b border-gray-200">
          <div class="flex">
            <button
              @click="switchTab('laboratories')"
              :class="[
                'px-4 sm:px-6 py-3 sm:py-4 font-medium border-b-2 transition-colors duration-200 text-sm sm:text-base',
                activeTab === 'laboratories' 
                  ? 'border-orange-500 text-orange-600' 
                  : 'border-transparent text-gray-500 hover:text-gray-700'
              ]"
            >
              Laboratories
            </button>
            <button
              @click="switchTab('equipment')"
              :class="[
                'px-4 sm:px-6 py-3 sm:py-4 font-medium border-b-2 transition-colors duration-200 text-sm sm:text-base',
                activeTab === 'equipment' 
                  ? 'border-orange-500 text-orange-600' 
                  : 'border-transparent text-gray-500 hover:text-gray-700'
              ]"
            >
              Equipment
            </button>
          </div>
        </div>

        <div class="px-6 sm:px-8 py-6 sm:py-8 bg-white rounded-b-2xl shadow-sm">
          <div v-show="activeTab === 'laboratories'" class="transition-all duration-300">
            <div class="flex justify-between items-center mb-6">
              <h2 class="text-xl sm:text-2xl font-bold text-gray-800">Our Academic Workplaces</h2>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 sm:gap-8">
              <div
                v-for="lab in props.labs"
                :key="lab.id"
                class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-200 p-4 sm:p-6 border border-gray-100"
              >
                <div class="mb-4">
                  <img
                    v-if="lab.image"
                    :src="'/' + lab.image"
                    :alt="lab.name"
                    class="w-full h-40 sm:h-48 object-cover rounded-lg bg-orange-50"
                  />
                  <div
                    v-else
                    class="w-full h-40 sm:h-48 bg-orange-50 rounded-lg flex items-center justify-center"
                  >
                    <span class="text-orange-300 text-sm">No Image</span>
                  </div>
                </div>

                <div>
                  <h3 class="text-lg sm:text-xl font-semibold text-orange-600 mb-3">{{ lab.name }}</h3>
                  <div class="text-sm text-gray-600 text-justify">
                    <p class="leading-relaxed">{{ lab.description }}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div v-show="activeTab === 'equipment'" class="transition-all duration-300">
            <div class="flex justify-between items-center mb-6">
              <h2 class="text-xl sm:text-2xl font-bold text-gray-800">Useful Tools for Learning</h2>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 sm:gap-8">
              <div
                v-for="eq in props.equipment"
                :key="eq.id"
                class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-200 p-4 sm:p-6 border border-gray-100"
              >
                <div class="mb-4">
                  <img
                    v-if="eq.image"
                    :src="'/' + eq.image"
                    :alt="eq.name"
                    class="w-full h-40 sm:h-48 object-cover rounded-lg bg-orange-50"
                  />
                  <div
                    v-else
                    class="w-full h-40 sm:h-48 bg-orange-50 rounded-lg flex items-center justify-center"
                  >
                    <span class="text-orange-300 text-sm">No Image</span>
                  </div>
                </div>

                <div>
                  <h3 class="text-lg sm:text-xl font-semibold text-orange-600 mb-3">{{ eq.name }}</h3>
                  <div class="text-sm text-gray-600 text-justify">
                    <p class="leading-relaxed">{{ eq.description }}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
  </UserAppLayout>
</template>