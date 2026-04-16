<script setup lang="ts">
import type { HTMLAttributes } from "vue"
import { PanelLeftClose, PanelLeftOpen } from "lucide-vue-next"
import { cn } from "@/lib/utils"
import { Button } from '@/components/ui/button'
import { useSidebar } from "./utils"

const props = defineProps<{
    class?: HTMLAttributes["class"]
}>()

const { isMobile, state, toggleSidebar } = useSidebar()
</script>

<template>
    <Button data-sidebar="trigger" data-slot="sidebar-trigger" variant="ghost" size="icon"
        :class="cn(' h-8 w-8 rounded-full border', props.class)" @click="toggleSidebar">
        <div v-if="isMobile || state === 'collapsed'">
            <svg xmlns="http://www.w3.org/2000/svg" width="120" height="120" viewBox="0 0 24 24" fill="none"
                stroke="#867ef7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-menu-icon lucide-menu">
                <path d="M4 5h16" />
                <path d="M4 12h16" />
                <path d="M4 19h16" />
            </svg>
        </div>
        <div v-else >
            <svg xmlns="http://www.w3.org/2000/svg" width="120" height="120" viewBox="0 0 24 24" fill="none"
                stroke="#ff2929" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-x-icon lucide-x">
                <path d="M18 6 6 18" />
                <path d="m6 6 12 12" />
            </svg>
        </div>
        <div v-show="false">
            <PanelLeftOpen v-if="isMobile || state === 'collapsed'" />
            <PanelLeftClose v-else />
        </div>
        <span class="sr-only">Toggle sidebar</span>
    </Button>
</template>
