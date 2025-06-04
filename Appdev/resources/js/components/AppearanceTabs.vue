<script setup lang="ts">
import { useAppearance } from '@/composables/useAppearance';
import { Monitor, Moon, Sun } from 'lucide-vue-next';

const { appearance, updateAppearance } = useAppearance();
</script>

<template>
    <div class="space-y-4">        
        <div class="grid grid-cols-3 gap-3">
            <div 
                @click="updateAppearance('light')"
                :class="[
                    'cursor-pointer rounded-lg border-2 p-3 transition-all',
                    appearance === 'light' 
                        ? 'border-orange-500 shadow-md' 
                        : 'border-gray-200 hover:border-gray-300 dark:border-gray-700 dark:hover:border-gray-600'
                ]"
            >
                <div class="bg-white rounded-md p-3 shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between mb-2">
                        <div class="w-8 h-2 bg-gray-200 rounded"></div>
                        <div class="w-4 h-4 bg-gray-300 rounded-full"></div>
                    </div>
                    <div class="space-y-1">
                        <div class="w-full h-1 bg-gray-100 rounded"></div>
                        <div class="w-3/4 h-1 bg-gray-100 rounded"></div>
                    </div>
                </div>
                <div class="flex items-center justify-center mt-2">
                    <Sun class="w-3 h-3 mr-1 text-gray-600" />
                    <p class="text-xs font-medium text-gray-700 dark:text-gray-300">Light</p>
                </div>
            </div>

<!--            <div 
                @click="updateAppearance('dark')"
                :class="[
                    'cursor-pointer rounded-lg border-2 p-3 transition-all',
                    appearance === 'dark' 
                        ? 'border-orange-500 shadow-md' 
                        : 'border-gray-200 hover:border-gray-300 dark:border-gray-700 dark:hover:border-gray-600'
                ]"
            >
                <div class="bg-gray-800 rounded-md p-3 shadow-sm">
                    <div class="flex items-center justify-between mb-2">
                        <div class="w-8 h-2 bg-gray-600 rounded"></div>
                        <div class="w-4 h-4 bg-gray-500 rounded-full"></div>
                    </div>
                    <div class="space-y-1">
                        <div class="w-full h-1 bg-gray-700 rounded"></div>
                        <div class="w-3/4 h-1 bg-gray-700 rounded"></div>
                    </div>
                </div>
                <div class="flex items-center justify-center mt-2">
                    <Moon class="w-3 h-3 mr-1 text-gray-600 dark:text-gray-400" />
                    <p class="text-xs font-medium text-gray-700 dark:text-gray-300">Dark</p>
                </div>
            </div>

            <div 
                @click="updateAppearance('system')"
                :class="[
                    'cursor-pointer rounded-lg border-2 p-3 transition-all',
                    appearance === 'system' 
                        ? 'border-orange-500 shadow-md' 
                        : 'border-gray-200 hover:border-gray-300 dark:border-gray-700 dark:hover:border-gray-600'
                ]"
            >
                <div class="relative bg-white rounded-md p-3 shadow-sm border border-gray-100 overflow-hidden">
                    <div class="absolute inset-0 flex">
                        <div class="w-1/2 bg-white p-2">
                            <div class="flex items-center justify-between mb-1">
                                <div class="w-4 h-1 bg-gray-200 rounded"></div>
                                <div class="w-2 h-2 bg-gray-300 rounded-full"></div>
                            </div>
                            <div class="space-y-0.5">
                                <div class="w-full h-0.5 bg-gray-100 rounded"></div>
                                <div class="w-2/3 h-0.5 bg-gray-100 rounded"></div>
                            </div>
                        </div>
                        <div class="w-1/2 bg-gray-800 p-2">
                            <div class="flex items-center justify-between mb-1">
                                <div class="w-4 h-1 bg-gray-600 rounded"></div>
                                <div class="w-2 h-2 bg-gray-500 rounded-full"></div>
                            </div>
                            <div class="space-y-0.5">
                                <div class="w-full h-0.5 bg-gray-700 rounded"></div>
                                <div class="w-2/3 h-0.5 bg-gray-700 rounded"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-center mt-2">
                    <Monitor class="w-3 h-3 mr-1 text-gray-600 dark:text-gray-400" />
                    <p class="text-xs font-medium text-gray-700 dark:text-gray-300">System</p>
                </div>
            </div>
        </div>
        
        <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed">
            System theme will automatically switch between light and dark based on your device settings 
        </p> -->
        </div>
    </div>
</template>