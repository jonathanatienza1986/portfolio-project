<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { Workflow, BotMessageSquare, ScanFace, Users, BookOpen, FolderGit2, LayoutGrid, BookDashed, Command, MapPinned } from 'lucide-vue-next';
import AppLogo from '@/components/AppLogo.vue';
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
import { dashboard, template } from '@/routes';
import chat from '@/routes/chat';
import chatbot from '@/routes/chatbot';
import complaint from '@/routes/complaint';
import customer from '@/routes/customer';
import face_recognition from '@/routes/face_recognition';
import map from '@/routes/map';

import type { NavItem } from '@/types';

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: dashboard(),
        icon: LayoutGrid,
    },
    {
        title: 'Template',
        href: template(),
        icon: BookDashed,
    },
    {
        title: 'Map',
        href: map.index(),
        icon: MapPinned,
    },
    {
        title: 'Complaint',
        href: complaint.index(),
        icon: Command,
    },
    {
        title: 'Customer',
        href: customer.index(),
        icon: Users,
    },
    {
        title: 'Face Recognition',
        href: face_recognition.index(),
        icon: ScanFace,
    },
    {
        title: 'Chat',
        href: chat.index(),
        icon: BotMessageSquare,
    },
    {
        title: 'Automation',
        href: chat.index_automation(),
        icon: Workflow,
    },
    {
        title: 'Chatbot',
        href: chatbot.index(),
        icon: BotMessageSquare,
    },
];

const footerNavItems: NavItem[] = [
    {
        title: 'Repository',
        href: 'https://github.com/laravel/vue-starter-kit',
        icon: FolderGit2,
    },
    {
        title: 'Documentation',
        href: 'https://laravel.com/docs/starter-kits#vue',
        icon: BookOpen,
    },
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="dashboard()">
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
