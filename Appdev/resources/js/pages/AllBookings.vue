<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import AllBookings from '@/pages/admin/AdminBookings.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Bookings',
        href: '/allbookings',
    },
];
</script>

<template>
    <Head title="All Bookings" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <AllBookings />
        </div>
    </AppLayout>
</template>
