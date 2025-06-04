<script setup lang="ts">
import UserAppLayout from '@/layouts/UserAppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import BookingHistory from '@/pages/user/BookingHistory.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'My Bookings',
        href: '/bookinghistory',
    },
];
</script>

<template>
    <Head title="My Bookings" />

    <UserAppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <BookingHistory />
        </div>
    </UserAppLayout>
</template>