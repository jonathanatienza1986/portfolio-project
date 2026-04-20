<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
import { dashboard } from '@/routes';

import graph1 from "./graph1.vue"
import graph2 from "./graph2.vue"
import graph3 from "./graph3.vue"
import graph4 from "./graph4.vue"
defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Dashboard',
                href: dashboard(),
            },
        ],
    },
});

</script>

<template>

    <Head title="Dashboard" />
    <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div class="relative aspect-video  rounded-xl border border-sidebar-border/70 dark:border-sidebar-border overflow-hidden">
                <graph2 />
            </div>
            <div
                class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border  overflow-hidden">
                <graph3 />
            </div>
            <div
                class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border  overflow-hidden">
                <graph4 />
            </div>
        </div>
        <div
            class=" flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border  overflow-hidden">
            <div class="w-full p-4">
                <a href="https://echarts.apache.org/examples/en/editor.html?c=pie-nest"  target="_blank" rel="noopener noreferrer">e-charts</a>
            </div>
            <graph1 />
        </div>

    </div>

</template>
