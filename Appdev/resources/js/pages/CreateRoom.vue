<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import CreateRooms from '@/pages/admin/CreateRooms.vue';
import CreateLabs from '@/pages/admin/CreateLabs.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Add Facilities',
        href: '/addrooms',
    },
];
</script>

<template>
    <Head title="Add Facilities" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="w-full max-w-none grid grid-cols-1 lg:grid-cols-2 gap-6 p-4">
            <div class="flex flex-col gap-4 rounded-xl p-4 bg-white shadow-sm">
                <CreateLabs />
            </div>

            <div class="flex flex-col gap-4 rounded-xl p-4 bg-white shadow-sm">
                <CreateRooms />
            </div>
        </div>
    </AppLayout>
</template>