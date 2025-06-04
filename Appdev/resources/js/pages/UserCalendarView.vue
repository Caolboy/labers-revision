<script setup lang="ts">
import UserAppLayout from '@/layouts/UserAppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import UserCalendar from '@/pages/user/UserCalendar.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Availability Calendar',
        href: '/usercalendar',
    },
];
</script>

<template>
    <Head title="Availability Calendar" />

    <UserAppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <UserCalendar />
        </div>
    </UserAppLayout>
</template>