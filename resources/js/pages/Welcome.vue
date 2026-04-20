<script setup lang="ts">
import XAnimatedSections from '../components/XAnimatedSections.vue'

</script>

<template>

    <Head title="Welcome">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>
    <div class="flex flex-col w-screen h-screen overflow-hidden">
        <XAnimatedSections :canRegister="true" />
    </div>
</template>
