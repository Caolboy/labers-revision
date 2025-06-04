<script setup lang="ts">
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import { LayoutGrid, Calendar, BookOpen, Users, Building2, Wrench, ChevronRight } from 'lucide-vue-next';

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
        icon: LayoutGrid,
    },
    {
        title: 'Calendar',
        href: '/calendar',
        icon: Calendar,
    },
    {
        title: 'Bookings',
        href: '/allbookings',
        icon: BookOpen,
    },
    {
        title: 'Users',
        href: '/usermanage',
        icon: Users,
        children: [
            {
                title: 'View Users',
                href: 'allusers',
            },
            {
                title: 'Add Users',
                href: 'addusers',
            },
        ]
    },
    {
        title: 'Facilities',
        href: '/roomsmanage',
        icon: Building2,
        children: [
            {
                title: 'View Facilities',
                href: 'allrooms',
            },
            {
                title: 'Add Facilities',
                href: 'addrooms',
            },
        ]
    },
    {
        title: 'Equipments',
        href: '/equipmentsmanage',
        icon: Wrench,
        children: [
            {
                title: 'View Equipments',
                href: 'allequipments',
            },
            {
                title: 'Add Equipments',
                href: 'addequipments',
            },
        ]
    },                                                  
];
</script>

<template>
    <Sidebar collapsible="icon" class="text-white">

        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <Link :href="route('dashboard')">
                        <img src="/labers1transparent.png" style="display: block; margin: 0 auto; width: 150px;">
                    </Link>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>
        <SidebarFooter>
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
