<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { Workflow, BotMessageSquare, ScanFace, Users, BookOpen, FolderGit2, LayoutGrid, BookDashed, Command, MapPinned } from 'lucide-vue-next';
import { ref, onMounted } from "vue";
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

const SidebarHeaderRef = ref();
const mouseX = ref(0);
const mouseY = ref(0);
const updateMousePosition = (e: MouseEvent) => {
    if (SidebarHeaderRef.value) {
        const rect = SidebarHeaderRef.value.$el.getBoundingClientRect();
        mouseX.value = e.clientX - rect.left;
        mouseY.value = e.clientY - rect.top;
    }
};

onMounted(() => {
    window.addEventListener('mousemove', updateMousePosition);
});

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
        title: 'Chatbot',
        href: chatbot.index(),
        icon: BotMessageSquare,
    },
    {
        title: 'Automation',
        href: chat.index_automation(),
        icon: Workflow,
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
    <Sidebar collapsible="icon" variant="inset"
        class="bg-mauve-900/10 backdrop-blur-md  bg-linear-to-br  from-mauve-900/20 to-green-800/10 border-r border-r-white/20 shadow-2xl">
        <SidebarHeader ref="SidebarHeaderRef" id="SidebarHeaderRef"
            class=" bg-mauve-950/10 backdrop-blur-sm  bg-linear-to-br  from-mauve-800/20 to-blue-800/20  border-b-3 border-b-blue-700/20">
            <SidebarMenu class=" bg-transparent">
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="dashboard()">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent
            class="bg-mauve-900/10 backdrop-blur-md  bg-linear-to-br  from-mauve-900/20 to-red-800/10  border-b-3 border-b-red-700/20">
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter
            class="bg-mauve-900/10 backdrop-blur-md  bg-linear-to-br  from-mauve-900/20 to-green-800/10 border-b-3 border-b-green-700/20">
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
