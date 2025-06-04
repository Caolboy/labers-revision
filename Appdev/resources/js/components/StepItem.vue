<template>
  <div class="min-w-full bg-gray-50 p-4">
    <div class="mb-6">
      <div class="flex items-center mb-3">
        <div class="bg-orange-500 text-white rounded-full w-8 h-8 flex items-center justify-center text-sm font-semibold mr-3">
          2
        </div>
        <h2 class="text-xl font-semibold text-orange-600">Select a Room or Equipment</h2>
      </div>
      <p class="text-sm text-gray-600 ml-11">Choose the room or equipment you want to book.</p>
    </div>

    <div class="space-y-3 mb-8 ml-11">
      <div
        v-for="item in items"
        :key="item.id"
        @click="selectItem(item)"
        :class="[
          'border rounded-lg p-4 cursor-pointer transition-all duration-200',
          selectedItem?.id === item.id 
            ? 'border-orange-500 bg-orange-50' 
            : 'border-gray-200 hover:border-gray-300'
        ]"
      >
        <div class="flex items-center">
          <div class="flex-shrink-0 mr-4">
            <div :class="[
              'w-5 h-5 rounded-full border-2 flex items-center justify-center',
              selectedItem?.id === item.id 
                ? 'border-orange-500 bg-orange-500' 
                : 'border-gray-300'
            ]">
              <div v-if="selectedItem?.id === item.id" class="w-2 h-2 bg-white rounded-full"></div>
            </div>
          </div>
          <div class="flex-1">
            <div class="flex items-center mb-1">
              <div class="text-orange-500 mr-3">
                <svg v-if="item.type === 'room'" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4zm2 2h8v8H6V6z" clip-rule="evenodd" />
                </svg>
                <svg v-else class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z" clip-rule="evenodd" />
                </svg>
              </div>
              <h3 class="font-medium text-gray-800">{{ item.name }}</h3>
            </div>
            
            <template v-if="item.type === 'room'">
              <p v-if="item.lab_description" class="text-sm text-gray-600 mb-1">
                {{ item.lab_description }}
              </p>
              <p v-if="item.lab_name" class="text-sm text-gray-500 italic">{{ item.lab_name }}</p>
            </template>

            <template v-else>
              <p v-if="item.description" class="text-sm text-gray-600">
                {{ item.description }}
              </p>
            </template>
          </div>
        </div>
      </div>
    </div>

    <div class="flex justify-between">
      <button
        class="px-6 py-2 rounded-lg font-medium transition-all duration-200 bg-gray-200 text-gray-700 hover:bg-gray-300"
        @click="$emit('back')"
      >
        ← Back
      </button>
      <button
        :class="[
          'px-6 py-2 rounded-lg font-medium transition-all duration-200',
          selectedItem 
            ? 'bg-orange-500 text-white hover:bg-orange-600' 
            : 'bg-gray-200 text-gray-400 cursor-not-allowed'
        ]"
        :disabled="!selectedItem"
        @click="$emit('next')"
      >
        Next →
      </button>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  items: Array,
  selectedItem: Object,
})

const emit = defineEmits(['update:selectedItem', 'next', 'back'])

function selectItem(item) {
  emit('update:selectedItem', item)
}
</script>