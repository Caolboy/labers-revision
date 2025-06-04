<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import CreateEquipments from '@/pages/admin/CreateEquipment.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Add Equipments',
        href: '/addequipments',
    },
];
</script> 

<template>
    <Head title="Add Equipments" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="w-full max-w-none gap-6 p-4">
            <div class="flex flex-col gap-4 rounded-xl p-4 bg-white shadow-sm">
                <CreateEquipments />
            </div>
        </div>
    </AppLayout>
</template>
