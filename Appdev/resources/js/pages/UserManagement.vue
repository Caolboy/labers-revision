<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import AllUsers from '@/pages/admin/AllUsers.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'View Users',
        href: '/allusers',
    },
];
</script>

<template>
    <Head title="All Users" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <AllUsers />
        </div>
    </AppLayout>
</template>
