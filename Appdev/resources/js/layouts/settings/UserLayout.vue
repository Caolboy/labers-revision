<script setup lang="ts">
import Heading from '@/components/Heading.vue';
import { Button } from '@/components/ui/button';
import { Separator } from '@/components/ui/separator';
import { type NavItem } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';

const sidebarNavItems: NavItem[] = [
    {
        title: 'Profile Information',
        href: '/settings/userprofile',
    },
    {
        title: 'Security and Appearance',
        href: '/settings/userpassword',
    },
];

const page = usePage();

const currentPath = page.props.ziggy?.location ? new URL(page.props.ziggy.location).pathname : '';
</script>

<template>
    <div class="min-w-full p-10">
        <div class="bg-gradient-to-r from-orange-400 to-orange-500 rounded-2xl px-6 py-6 text-white mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-semibold">Settings</h1>
                    <p class="text-orange-100 mt-1">Manage your account preferences and security settings.</p>
                </div>
            </div>
        </div>

        <div class="bg-white border-b rounded-t-2xl border-gray-200">
            <div class="px-6">
                <nav class="flex space-x-8">
                    <Link
                        v-for="item in sidebarNavItems"
                        :key="item.href"
                        :href="item.href"
                        :class="[
                            'py-4 px-1 border-b-2 font-medium text-sm',
                            currentPath === item.href 
                                ? 'border-orange-500 text-orange-600' 
                                : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'
                        ]"
                    >
                        {{ item.title }}
                    </Link>
                </nav>
            </div>
        </div>

        <div class="px-6 py-8 bg-white rounded-b-2xl">
            <div class="max-w-4xl">
                <slot />
            </div>
        </div>
    </div>
</template>