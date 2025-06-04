<script setup lang="ts">
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import { LayoutGrid, Calendar, BookOpen, Users, Building2, Wrench, ChevronRight, Monitor, Settings, LogOut } from 'lucide-vue-next';

const mainNavItems: NavItem[] = [
  { title: 'Dashboard', href: '/bookinghistory', icon: LayoutGrid },
  { title: 'Book', href: '/booking', icon: BookOpen },
  { title: 'Calendar', href: '/usercalendar', icon: Calendar },
  { title: 'Laboratories', href: '/labsandequipment', icon: Monitor },
  { title: 'Settings', href: '/settings/userprofile', icon: Settings },
];
</script>

<template>
    <Sidebar collapsible="icon" class="text-white">

        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <Link :href="route('bookinghistory')">
                        <br>
                        <img src="/labers1transparent.png" style="display: block; margin: 0 auto; width: 135px;">
                        <br>
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
