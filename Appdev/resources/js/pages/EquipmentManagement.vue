<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import AllEquipments from '@/pages/admin/AllEquipments.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'View Equipments',
        href: '/allequipments',
    },
];
</script>

<template>
    <Head title="All Equipments" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <AllEquipments />
        </div>
    </AppLayout>
</template>
