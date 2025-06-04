<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import LabBookingCalendar from '@/pages/admin/LabBookingCalendar.vue'

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Calendar',
        href: '/calendar',
    },
];
</script>

<template>
    <Head title="Calendar" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="min-h-screen">
            <LabBookingCalendar />
        </div>
    </AppLayout>
</template>
