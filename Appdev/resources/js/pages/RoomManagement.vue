<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import AllRooms from '@/pages/admin/AllRooms.vue';
import AllLabs from '@/pages/admin/AllLabs.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'View Facilities',
        href: '/allrooms',
    },
];
</script>

<template>
    <Head title="All Facilities" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <AllLabs />
        </div>

        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <AllRooms />
        </div>
    </AppLayout>
</template>
