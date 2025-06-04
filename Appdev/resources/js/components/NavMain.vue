<script setup lang="ts">
import { SidebarGroup, SidebarGroupLabel, SidebarMenu, SidebarMenuButton, SidebarMenuItem, SidebarMenuSub, SidebarMenuSubButton, SidebarMenuSubItem } from '@/components/ui/sidebar';
import { type NavItem, type SharedData } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';
import { ChevronRight } from 'lucide-vue-next'
import { Collapsible, CollapsibleContent, CollapsibleTrigger } from './ui/collapsible'

defineProps<{
    items: NavItem[];
}>();

const page = usePage<SharedData>();

function isChildActive(item: { children: any[], href: string }) {
    return item.children?.some(child => child.href === page.url) || item.href === page.url
}
</script>

<template>
    <SidebarGroup class="px-3 py-5">
        <SidebarMenu class="space-y-2">
            <template v-for="item in items" :key="item.title">
                <SidebarMenuItem v-if="!item.children">
        <!--            <SidebarMenuButton as-child :is-active="item.href === page.url" :tooltip="item.title"
                        :class="[
                            'flex items-center gap-5 px-6 py-6 rounded-xl transition-colors relative',
                            item.href === page.url ? 'font-extrabold' : 'font-normal',
                            'hover:bg-[#FD7C21]/40 text-lg'
                        ]">
                        <Link :href="item.href" class="flex items-center gap-4 w-full pl-6 relative">
                            <span v-if="item.href === page.url" class="absolute left-0 top-1/2 -translate-y-1/2 h-15 w-2 rounded-full bg-white"/>
                            <component :is="item.icon" :class="[item.href === page.url ? 'text-white' : 'text-white', 'w-10 h-10 z-10']" />
                            <span :class="[item.href === page.url ? 'text-white' : 'text-white', 'z-10']">{{ item.title }}</span>
                        </Link>
                    </SidebarMenuButton> -->
                    <SidebarMenuButton as-child :is-active="item.href === page.url" :tooltip="item.title">
                        <Link :href="item.href">
                        <component :is="item.icon" />
                        <span>{{ item.title }}</span>
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>

                <Collapsible v-else :default-open="isChildActive({ children: item.children || [], href: item.href })"
                    class="group/collapsible">
                    <SidebarMenuItem>
                        <CollapsibleTrigger as-child>
                <!--            <SidebarMenuButton
                                :is-active="isChildActive({ children: item.children || [], href: item.href })"
                                :tooltip="item.title"
                                :class="[
                                    'flex items-center gap-5 px-6 py-6 rounded-xl transition-colors relative',
                                    isChildActive({ children: item.children || [], href: item.href }) ? 'bg-[#FD7C21]/40 font-extrabold' : 'font-normal',
                                    'hover:bg-[#FD7C21]/40 text-lg'
                                ]">
                                <span v-if="isChildActive({ children: item.children || [], href: item.href })" class="absolute left-0 top-1/2 -translate-y-1/2 h-15 w-2 rounded-full bg-[#FD7C21]" />
                                <component :is="item.icon" v-if="item.icon" :class="[isChildActive({ children: item.children || [], href: item.href }) ? 'text-[#FD7C21]' : 'text-white', 'w-10 h-10 z-10']" />
                                <span :class="[isChildActive({ children: item.children || [], href: item.href }) ? 'text-[#FD7C21]' : 'text-white', 'z-10']">{{ item.title }}</span>
                                <ChevronRight
                                    class="ml-auto transition-transform duration-200 group-data-[state=open]/collapsible:rotate-90 text-white" />
                            </SidebarMenuButton> -->
                            <SidebarMenuButton
                                :is-active="isChildActive({ children: item.children || [], href: item.href })"
                                :tooltip="item.title">
                                <component :is="item.icon" v-if="item.icon" />
                                <span>{{ item.title }}</span>
                                <ChevronRight
                                    class="ml-auto transition-transform duration-200 group-data-[state=open]/collapsible:rotate-90" />
                            </SidebarMenuButton>
                        </CollapsibleTrigger>
                        <CollapsibleContent>
                            <SidebarMenuSub>
        <!--                        <SidebarMenuSubItem v-for="subItem in item.children" :key="subItem.title">
                                    <SidebarMenuSubButton as-child :is-active="subItem.href === page.url"
                                        :class="[
                                            'flex items-center gap-5 px-5 py-5 rounded-xl transition-colors relative',
                                            subItem.href === page.url ? 'bg-[#FD7C21] font-extrabold' : 'font-normal',
                                            'hover:bg-[#FD7C21]/40 text-base'
                                        ]">

                                        <Link :href="subItem.href" class="flex items-center gap-4 w-full pl-8 relative">
                                            <span v-if="subItem.href === page.url" class="absolute left-0 top-1/2 -translate-y-1/2 h-15 w-2 rounded-full bg-[#FD7C21]" />
                                            <span :class="[subItem.href === page.url ? 'text-[#FD7C21]' : 'text-white', 'z-10']">{{ subItem.title }}</span>
                                        </Link>
                                    </SidebarMenuSubButton>
                                </SidebarMenuSubItem> -->
                                <SidebarMenuSubItem v-for="subItem in item.children" :key="subItem.title">
                                    <SidebarMenuSubButton as-child :is-active="subItem.href === page.url"class=" hover:bg-[#FD7C21]/40 text-base">
                                        <Link :href="subItem.href">
                                        <span class="text-white">{{ subItem.title }}</span>
                                        </Link>
                                    </SidebarMenuSubButton>
                                </SidebarMenuSubItem>                                
                            </SidebarMenuSub>
                        </CollapsibleContent>
                    </SidebarMenuItem>
                </Collapsible>
            </template>
        </SidebarMenu>
    </SidebarGroup>
</template>
