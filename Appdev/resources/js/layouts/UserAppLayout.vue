<script setup lang="ts">
import UserAppLayout from '@/layouts/app/UserSidebarLayout.vue';
import type { BreadcrumbItemType } from '@/types';

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});
</script>

<template>
    <UserAppLayout :breadcrumbs="breadcrumbs">
        <slot />
    </UserAppLayout>
</template>
