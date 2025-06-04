<script setup lang="ts">
import { Head } from '@inertiajs/vue3';

import AppearanceTabs from '@/components/AppearanceTabs.vue';
import HeadingSmall from '@/components/HeadingSmall.vue';
import { type BreadcrumbItem } from '@/types';

import UserAppLayout from '@/layouts/UserAppLayout.vue';
import SettingsLayout from '@/layouts/settings/UserLayout.vue';

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Appearance',
        href: '/settings/userappearance',
    },
];
</script>

<template>
    <UserAppLayout :breadcrumbs="breadcrumbItems">
        <Head title="Appearance" />

        <SettingsLayout>
            <div class="space-y-6">
                <HeadingSmall title="Theme Settings" />
                <AppearanceTabs />
            </div>
        </SettingsLayout>
    </UserAppLayout>
</template>
