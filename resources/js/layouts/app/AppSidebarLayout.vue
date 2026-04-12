<script setup lang="ts">
import AppContent from '@/components/AppContent.vue';
import AppShell from '@/components/AppShell.vue';
import AppSidebar from '@/components/AppSidebar.vue';
import AppSidebarHeader from '@/components/AppSidebarHeader.vue';
import type { BreadcrumbItem } from '@/types';

type Props = {
    breadcrumbs?: BreadcrumbItem[];
};

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});
</script>

<template>
    <AppShell variant="sidebar" class=" overflow-hidden bg-green-700">
        <AppSidebar class=" bg-green-800 p-20 absolute top-0 blur-3xl"/>
        <AppContent variant="sidebar">
            <div class="absolute  top-0 flex flex-col h-full w-full overflow-hidden">
                <div class="flex flex-row h-14 w-full border-b-2">
                    <div class="ml-auto"></div>
                    <AppSidebarHeader :breadcrumbs="breadcrumbs"/>
                </div>

                <slot />
            </div>
        </AppContent>
    </AppShell>
</template>
