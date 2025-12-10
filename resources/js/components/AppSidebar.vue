<script setup lang="ts">
import { route } from 'ziggy-js';
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import { BookOpen, Folder, LayoutGrid, FileText, Tags, Settings, UserRound, Palette, MonitorPlay, MessageSquare, Map } from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: route('dashboard'),
        icon: LayoutGrid,
    },
    {
        title: 'Posts (News)',
        href: route('admin.posts.index'),
        icon: FileText,
    },
    {
        title: 'Categories',
        href: route('admin.categories.index'),
        icon: Tags,
    },
    {
        title: 'Doctors',
        href: route('admin.doctors.index'),
        icon: UserRound,
    },
    {
        title: 'Themes',
        href: route('admin.themes.index'),
        icon: Palette,
    },
    {
        title: 'Intro Pages',
        href: route('admin.intro-pages.index'),
        icon: MonitorPlay,
    },
    {
        title: 'Popups',
        href: route('admin.popups.index'),
        icon: MessageSquare,
    },
    {
        title: 'Sitemap',
        href: route('admin.sitemaps.index'),
        icon: Map,
    },
];

const footerNavItems: NavItem[] = [
    {
        title: 'System Logs',
        href: '#',
        icon: Settings,
    },
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="route('dashboard')">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
