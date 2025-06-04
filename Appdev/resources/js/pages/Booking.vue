<script setup lang="ts">
import UserAppLayout from '@/layouts/UserAppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import BookingFlow from '@/pages/user/BookingFlow.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Booking',
        href: '/booking',
    },
];
</script>

<template>
    <Head title="Booking" />

    <UserAppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <BookingFlow />
        </div>
    </UserAppLayout>
</template>