<template>
  <div class="min-w-full bg-gray-50 p-4">
    <div class="mb-6">
      <div class="flex items-center mb-3">
        <div class="bg-orange-500 text-white rounded-full w-8 h-8 flex items-center justify-center text-sm font-semibold mr-3">
          1
        </div>
        <h2 class="text-xl font-semibold text-orange-600">Choose A Category</h2>
      </div>
      <p class="text-sm text-gray-600 ml-11">Select whether you need to book a laboratory facility or a specific equipment.</p>
    </div>

    <div class="space-y-3 mb-8 ml-11">
      <div
        v-for="category in categories"
        :key="category.id"
        @click="selectCategory(category)"
        :class="[
          'border rounded-lg p-4 cursor-pointer transition-all duration-200',
          selectedCategory?.id === category.id 
            ? 'border-orange-500 bg-orange-50' 
            : 'border-gray-200 hover:border-gray-300'
        ]"
      >
        <div class="flex items-center">
          <div class="flex-shrink-0 mr-4">
            <div :class="[
              'w-5 h-5 rounded-full border-2 flex items-center justify-center',
              selectedCategory?.id === category.id 
                ? 'border-orange-500 bg-orange-500' 
                : 'border-gray-300'
            ]">
              <div v-if="selectedCategory?.id === category.id" class="w-2 h-2 bg-white rounded-full"></div>
            </div>
          </div>
          <div class="flex-1">
            <div class="flex items-center mb-1">
              <div class="text-orange-500 mr-3">
                <svg v-if="category.name.toLowerCase().includes('facility')" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4zm2 2h8v8H6V6z" clip-rule="evenodd" />
                </svg>
                <svg v-else class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z" clip-rule="evenodd" />
                </svg>
              </div>
              <h3 class="font-medium text-gray-800">{{ category.name }}</h3>
            </div>
            <p class="text-sm text-gray-600">{{ category.description }}</p>
          </div>
        </div>
      </div>
    </div>

    <div class="flex justify-end">
      <button
        :class="[
          'px-6 py-2 rounded-lg font-medium transition-all duration-200',
          selectedCategory 
            ? 'bg-orange-500 text-white hover:bg-orange-600' 
            : 'bg-gray-200 text-gray-400 cursor-not-allowed'
        ]"
        :disabled="!selectedCategory"
        @click="$emit('next')"
      >
        Next →
      </button>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  categories: Array,
  selectedCategory: Object,
})

const emit = defineEmits(['update:selectedCategory', 'next'])

function selectCategory(category) {
  emit('update:selectedCategory', category)
}
</script>