// eslint-disable-next-line vue/block-lang
<script setup lang="ts">
//import ThreeStoryScene from '../components/ThreeStoryScene.vue'
import { onMounted, ref } from 'vue'
import XStarFieldBG from '../components/XStarFieldBG.vue'
import XTickerTape from '../components/XTickerTape.vue'


const storyRef = ref(null)

onMounted(() => {
    const el = storyRef.value
    const sections = el.querySelectorAll('.section')

    const updateActive = () => {
        const scrollTop = el.scrollTop
        const height = el.clientHeight

        const index = Math.round(scrollTop / height)

        sections.forEach((section, i) => {
            const panels = section.querySelectorAll('.panel')
            panels.forEach((panel) => {
                if (i === index) {
                    panel.classList.add('active')
                } else {
                    panel.classList.remove('active')
                }
            });
        })
    }

    el.addEventListener('scroll', updateActive)

    // initialize first section
    updateActive()
})

// eslint-disable-next-line import/order
import { Link } from '@inertiajs/vue3';
// eslint-disable-next-line import/order
import { dashboard, login, register } from '@/routes';

withDefaults(
    defineProps<{
        canRegister: boolean;
    }>(),
    {
        canRegister: true,
    },
);

</script>

<template>
    <XStarFieldBG />
    <div class="story  overflow-x-hidden z-100" ref="storyRef">
        <section class=" flex flex-col section opacity-80">
            <XTickerTape />
            <div class="flex flex-col lg:flex-row flex-1">
                <div
                    class="panel left  w-full lg:w-[75vw] overflow-visible  p-4 opacity-70 flex flex-col gap-6 md:flex-row justify-center items-center lg:gap-3">
                    <div class="flex flex-col">
                        <span class=" text-5xl font-semibold text-center">Garry M. Cacho's Portfolio</span>
                        <div class="flex flex-wrap gap-2 justify-center">
                            <span class=" text-2xl font-semibold text-center p-2 rounded-lg hover:bg-amber-700 flex items-center gap-1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#7e7ce4" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-phone-icon lucide-phone"><path d="M13.832 16.568a1 1 0 0 0 1.213-.303l.355-.465A2 2 0 0 1 17 15h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2A18 18 0 0 1 2 4a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v3a2 2 0 0 1-.8 1.6l-.468.351a1 1 0 0 0-.292 1.233 14 14 0 0 0 6.392 6.384"/></svg><a
                                href="tel:+639995202447" target="_blank">Mobile</a> </span>
                            <span class=" text-2xl font-semibold text-center p-2 rounded-lg hover:bg-amber-700 flex items-center gap-1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#7ce488" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-at-sign-icon lucide-at-sign"><circle cx="12" cy="12" r="4"/><path d="M16 8v5a3 3 0 0 0 6 0v-1a10 10 0 1 0-4 8"/></svg><a
                                    href="mailto:gc120978levelup1@gmail.com" target="_blank">Email</a> </span>
                            <span class=" text-2xl font-semibold text-center p-2 rounded-lg hover:bg-amber-700 flex items-center gap-1"> <img src="/linkedin.jpg" width="30" alt=""><a
                                    href="https://www.linkedin.com/in/garry-cacho-28248390" target="_blank">LinkedIn</a>
                            </span>
                            <span class=" text-2xl font-semibold text-center p-2 rounded-lg hover:bg-amber-700 flex items-center gap-1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#afc157" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-folder-git2-icon lucide-folder-git-2"><path d="M18 19a5 5 0 0 1-5-5v8"/><path d="M9 20H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h3.9a2 2 0 0 1 1.69.9l.81 1.2a2 2 0 0 0 1.67.9H20a2 2 0 0 1 2 2v5"/><circle cx="13" cy="12" r="2"/><circle cx="20" cy="19" r="2"/></svg><a
                                    href="https://github.com/gc120978levelup1" target="_blank">Github</a> </span>
                        </div>
                    </div>
                    <div class=" relative top-0">
                        <div class=" absolute top-0">
                            <svg class="animate-spin" style="animation-delay: 1s;animation-duration: 20s;" width="200"
                                height="200" viewBox="0 0 200 200" xmlns="http://w3.org">
                                <!-- Define the path for the text to follow -->
                                <defs>
                                    <path id="circlePath"
                                        d="M 100, 100 m -80, 0 a 80,80 0 1,1 160,0 a 80,80 0 1,1 -160,0" />
                                </defs>
                                <text fill="white" font-size="23" font-family="Arial">
                                    <textPath href="#circlePath">• Backend: Laravel • Frontend: Vue3 • , GIS, AI
                                    </textPath>
                                </text>
                            </svg>
                        </div>
                        <div class="w-[200px] h-[200px] flex justify-center items-center">
                            <div
                                class="w-[150px] h-[150px] bg-amber-50  border-amber-50 border-4 rounded-full opacity-100 overflow-hidden flex justify-center align-middle">
                                <img src="/garry-cacho.jpg" width="120" height="170" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel right bg-red-500 w-full lg:w-[25vw] lg:h-full overflow-visible p-4 opacity-70 flex-1"
                    style="transition-delay: 0.3s;">
                    <span class=" text-7xl font-semibold">Full Stack Web Dev</span>
                    <br>
                    <br>
                    <span class=" text-7xl font-semibold">Laravel & Vue</span>

                </div>
            </div>
        </section>

        <section class=" flex flex-col lg:flex-row section opacity-80">
            <div class="panel left bg-cyan-800 w-full lg:w-[50vw] h-full overflow-hidden p-4 opacity-70 flex flex-col items-center justify-center lg:p-20"
                style="transition-delay: 0.3s;">
                <div class=" animate-ping">
                    <svg xmlns="http://www.w3.org/2000/svg" width="68" height="68" viewBox="0 0 24 24" fill="none"
                        stroke="#e2f019" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-cpu-icon lucide-cpu">
                        <path d="M12 20v2" />
                        <path d="M12 2v2" />
                        <path d="M17 20v2" />
                        <path d="M17 2v2" />
                        <path d="M2 12h2" />
                        <path d="M2 17h2" />
                        <path d="M2 7h2" />
                        <path d="M20 12h2" />
                        <path d="M20 17h2" />
                        <path d="M20 7h2" />
                        <path d="M7 20v2" />
                        <path d="M7 2v2" />
                        <rect x="4" y="4" width="16" height="16" rx="2" />
                        <rect x="8" y="8" width="8" height="8" rx="1" />
                    </svg>
                </div>
                <p class=" text-7xl font-semibold">
                    Tech Stack </p>
                <p class=" text-7xl font-semibold">Experience</p>
            </div>
            <div
                class="panel right  w-full lg:w-[50vw] h-full overflow-visible p-4 opacity-70 flex flex-wrap gap-1 items-center justify-center ml-auto lg:p-20">
                <span class=" text-4xl font-semibold">• Laravel</span> <br>
                <span class=" text-4xl font-semibold">• Vue3</span> <br>
                <span class=" text-4xl font-semibold">• Inertia.js</span> <br>
                <span class=" text-4xl font-semibold text-center">• Pinia State Management</span> <br>
                <span class=" text-4xl font-semibold">• Tailwind CSS</span> <br>
                <span class=" text-4xl font-semibold">• ShadCN</span> <br>
                <span class=" text-4xl font-semibold">• ECharts</span> <br>
                <span class=" text-4xl font-semibold">• Leaflet</span> <br>
                <span class=" text-4xl font-semibold">• Three.js</span> <br>
                <span class=" text-4xl font-semibold">• Docker </span> <br>
                <span class=" text-4xl font-semibold">• AWS </span> <br>
                <span class=" text-4xl font-semibold">• Google Compute </span> <br>
                <span class=" text-4xl font-semibold">• Railway</span> <br>
                <span class=" text-4xl font-semibold">• Vercel</span> <br>
            </div>
        </section>

        <section class=" flex flex-col lg:flex-row section opacity-80">
            <div class="panel left  w-full lg:w-[60vw] h-full overflow-visible p-4 opacity-70 flex flex-wrap gap-1 items-center justify-start ml-auto lg:p-20 "
                style="transition-delay: 0.3s;">
                <ul class="mb-4 flex flex-col lg:mb-6 text-2xl">
                    <li
                        class="relative flex items-center gap-4 py-2 before:absolute before:top-0 before:bottom-0 before:left-[0.4rem] before:border-l before:border-[#e3e3e0] dark:before:border-[#3E3E3A]">
                        <span class="relative bg-white py-1 dark:bg-[#161615]">
                            <span
                                class="flex h-3.5 w-3.5 items-center justify-center rounded-full border border-[#e3e3e0] bg-[#FDFDFC] shadow-[0px_0px_1px_0px_rgba(0,0,0,0.03),0px_1px_2px_0px_rgba(0,0,0,0.06)] dark:border-[#3E3E3A] dark:bg-[#161615]">
                                <span class="h-1.5 w-1.5 rounded-full bg-[#dbdbd7] dark:bg-[#3E3E3A]" />
                            </span>
                        </span>
                        <span>
                            Built with Leaflet + Vue + Inertia
                        </span>
                    </li>
                    <li
                        class="relative flex items-center gap-4 py-2 before:absolute before:top-0 before:bottom-0 before:left-[0.4rem] before:border-l before:border-[#e3e3e0] dark:before:border-[#3E3E3A]">
                        <span class="relative bg-white py-1 dark:bg-[#161615]">
                            <span
                                class="flex h-3.5 w-3.5 items-center justify-center rounded-full border border-[#e3e3e0] bg-[#FDFDFC] shadow-[0px_0px_1px_0px_rgba(0,0,0,0.03),0px_1px_2px_0px_rgba(0,0,0,0.06)] dark:border-[#3E3E3A] dark:bg-[#161615]">
                                <span class="h-1.5 w-1.5 rounded-full bg-[#dbdbd7] dark:bg-[#3E3E3A]" />
                            </span>
                        </span>
                        <span>
                            AI API integration
                        </span>
                    </li>
                    <li
                        class="relative flex items-center gap-4 py-2 before:absolute before:top-0 before:bottom-0 before:left-[0.4rem] before:border-l before:border-[#e3e3e0] dark:before:border-[#3E3E3A]">
                        <span class="relative bg-white py-1 dark:bg-[#161615]">
                            <span
                                class="flex h-3.5 w-3.5 items-center justify-center rounded-full border border-[#e3e3e0] bg-[#FDFDFC] shadow-[0px_0px_1px_0px_rgba(0,0,0,0.03),0px_1px_2px_0px_rgba(0,0,0,0.06)] dark:border-[#3E3E3A] dark:bg-[#161615]">
                                <span class="h-1.5 w-1.5 rounded-full bg-[#dbdbd7] dark:bg-[#3E3E3A]" />
                            </span>
                        </span>
                        <span>
                            Automated workflows and responses
                        </span>
                    </li>
                    <li
                        class="relative flex items-center gap-4 py-2 before:absolute before:top-0 before:bottom-0 before:left-[0.4rem] before:border-l before:border-[#e3e3e0] dark:before:border-[#3E3E3A]">
                        <span class="relative bg-white py-1 dark:bg-[#161615]">
                            <span
                                class="flex h-3.5 w-3.5 items-center justify-center rounded-full border border-[#e3e3e0] bg-[#FDFDFC] shadow-[0px_0px_1px_0px_rgba(0,0,0,0.03),0px_1px_2px_0px_rgba(0,0,0,0.06)] dark:border-[#3E3E3A] dark:bg-[#161615]">
                                <span class="h-1.5 w-1.5 rounded-full bg-[#dbdbd7] dark:bg-[#3E3E3A]" />
                            </span>
                        </span>
                        <span>
                            Computer Vision
                        </span>
                    </li>
                </ul>

                <span class=" text-3xl"><b><i class=" text-amber-400">Key Feature:</i></b><br>
                    &nbsp;&nbsp;&nbsp;Business process automation which boosts 15% in user productivity</span> <br>
            </div>
            <div
                class="panel right bg-red-800 w-full lg:w-[40vw] h-full overflow-hidden p-4 opacity-70 flex flex-col items-center justify-center lg:p-20">
                <div class=" animate-pulse">
                    <svg xmlns="http://www.w3.org/2000/svg" width="68" height="68" viewBox="0 0 24 24" fill="none"
                        stroke="#19f06b" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-folder-git2-icon lucide-folder-git-2">
                        <path d="M18 19a5 5 0 0 1-5-5v8" />
                        <path
                            d="M9 20H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h3.9a2 2 0 0 1 1.69.9l.81 1.2a2 2 0 0 0 1.67.9H20a2 2 0 0 1 2 2v5" />
                        <circle cx="13" cy="12" r="2" />
                        <circle cx="20" cy="19" r="2" />
                    </svg>
                </div>
                <p class=" text-4xl font-semibold">
                    Featured </p>
                <p class=" text-4xl font-semibold">Project</p>
                <p class=" text-7xl font-semibold text-center">
                    AI Chatbot Platform</p>
            </div>
        </section>

        <section class=" flex flex-col lg:flex-row section opacity-80">
            <div class="panel left  w-full lg:w-[60vw] h-full overflow-visible p-4 opacity-70 flex flex-wrap gap-1 items-center justify-start ml-auto lg:p-20"
                style="transition-delay: 0.3s;">

                <ul class="mb-4 flex flex-col lg:mb-6 text-2xl">
                    <li
                        class="relative flex items-center gap-4 py-2 before:absolute before:top-0 before:bottom-0 before:left-[0.4rem] before:border-l before:border-[#e3e3e0] dark:before:border-[#3E3E3A]">
                        <span class="relative bg-white py-1 dark:bg-[#161615]">
                            <span
                                class="flex h-3.5 w-3.5 items-center justify-center rounded-full border border-[#e3e3e0] bg-[#FDFDFC] shadow-[0px_0px_1px_0px_rgba(0,0,0,0.03),0px_1px_2px_0px_rgba(0,0,0,0.06)] dark:border-[#3E3E3A] dark:bg-[#161615]">
                                <span class="h-1.5 w-1.5 rounded-full bg-[#dbdbd7] dark:bg-[#3E3E3A]" />
                            </span>
                        </span>
                        <span>
                            Real-time charts with ECharts
                        </span>
                    </li>
                    <li
                        class="relative flex items-center gap-4 py-2 before:absolute before:top-0 before:bottom-0 before:left-[0.4rem] before:border-l before:border-[#e3e3e0] dark:before:border-[#3E3E3A]">
                        <span class="relative bg-white py-1 dark:bg-[#161615]">
                            <span
                                class="flex h-3.5 w-3.5 items-center justify-center rounded-full border border-[#e3e3e0] bg-[#FDFDFC] shadow-[0px_0px_1px_0px_rgba(0,0,0,0.03),0px_1px_2px_0px_rgba(0,0,0,0.06)] dark:border-[#3E3E3A] dark:bg-[#161615]">
                                <span class="h-1.5 w-1.5 rounded-full bg-[#dbdbd7] dark:bg-[#3E3E3A]" />
                            </span>
                        </span>
                        <span>
                            Backend powered by Laravel
                        </span>
                    </li>
                    <li
                        class="relative flex items-center gap-4 py-2 before:absolute before:top-0 before:bottom-0 before:left-[0.4rem] before:border-l before:border-[#e3e3e0] dark:before:border-[#3E3E3A]">
                        <span class="relative bg-white py-1 dark:bg-[#161615]">
                            <span
                                class="flex h-3.5 w-3.5 items-center justify-center rounded-full border border-[#e3e3e0] bg-[#FDFDFC] shadow-[0px_0px_1px_0px_rgba(0,0,0,0.03),0px_1px_2px_0px_rgba(0,0,0,0.06)] dark:border-[#3E3E3A] dark:bg-[#161615]">
                                <span class="h-1.5 w-1.5 rounded-full bg-[#dbdbd7] dark:bg-[#3E3E3A]" />
                            </span>
                        </span>
                        <span>
                            Optimized with Redis caching
                        </span>
                    </li>

                </ul>

                <span class=" text-3xl"><b><i class=" text-amber-400">Key Feature:</i></b><br>
                    &nbsp;&nbsp;&nbsp;High-performance data rendering which adds 10% in visualization speed</span> <br>
            </div>
            <div
                class="panel still bg-red-800 w-full lg:w-[40vw] h-full overflow-hidden p-4 opacity-70 flex flex-col items-center justify-center lg:p-20">
                <div class=" animate-pulse">
                    <svg xmlns="http://www.w3.org/2000/svg" width="68" height="68" viewBox="0 0 24 24" fill="none"
                        stroke="#19f06b" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-folder-git2-icon lucide-folder-git-2">
                        <path d="M18 19a5 5 0 0 1-5-5v8" />
                        <path
                            d="M9 20H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h3.9a2 2 0 0 1 1.69.9l.81 1.2a2 2 0 0 0 1.67.9H20a2 2 0 0 1 2 2v5" />
                        <circle cx="13" cy="12" r="2" />
                        <circle cx="20" cy="19" r="2" />
                    </svg>
                </div>
                <p class=" text-4xl font-semibold">
                    Featured </p>
                <p class=" text-4xl font-semibold">Project</p>
                <p class=" text-7xl font-semibold text-center">
                    Analytics Dashboard</p>

            </div>
        </section>

        <section class=" flex flex-col lg:flex-row section opacity-80">
            <div class="panel left  w-full lg:w-[60vw] h-full overflow-visible p-4 opacity-70 flex flex-wrap gap-1 items-center justify-start ml-auto lg:p-20 "
                style="transition-delay: 0.3s;">

                <ul class="mb-4 flex flex-col lg:mb-6 text-2xl">
                    <li
                        class="relative flex items-center gap-4 py-2 before:absolute before:top-0 before:bottom-0 before:left-[0.4rem] before:border-l before:border-[#e3e3e0] dark:before:border-[#3E3E3A]">
                        <span class="relative bg-white py-1 dark:bg-[#161615]">
                            <span
                                class="flex h-3.5 w-3.5 items-center justify-center rounded-full border border-[#e3e3e0] bg-[#FDFDFC] shadow-[0px_0px_1px_0px_rgba(0,0,0,0.03),0px_1px_2px_0px_rgba(0,0,0,0.06)] dark:border-[#3E3E3A] dark:bg-[#161615]">
                                <span class="h-1.5 w-1.5 rounded-full bg-[#dbdbd7] dark:bg-[#3E3E3A]" />
                            </span>
                        </span>
                        <span>
                            Built with Leaflet + Vue + Inertia
                        </span>
                    </li>
                    <li
                        class="relative flex items-center gap-4 py-2 before:absolute before:top-0 before:bottom-0 before:left-[0.4rem] before:border-l before:border-[#e3e3e0] dark:before:border-[#3E3E3A]">
                        <span class="relative bg-white py-1 dark:bg-[#161615]">
                            <span
                                class="flex h-3.5 w-3.5 items-center justify-center rounded-full border border-[#e3e3e0] bg-[#FDFDFC] shadow-[0px_0px_1px_0px_rgba(0,0,0,0.03),0px_1px_2px_0px_rgba(0,0,0,0.06)] dark:border-[#3E3E3A] dark:bg-[#161615]">
                                <span class="h-1.5 w-1.5 rounded-full bg-[#dbdbd7] dark:bg-[#3E3E3A]" />
                            </span>
                        </span>
                        <span>
                            Interactive geospatial visualization
                        </span>
                    </li>
                    <li
                        class="relative flex items-center gap-4 py-2 before:absolute before:top-0 before:bottom-0 before:left-[0.4rem] before:border-l before:border-[#e3e3e0] dark:before:border-[#3E3E3A]">
                        <span class="relative bg-white py-1 dark:bg-[#161615]">
                            <span
                                class="flex h-3.5 w-3.5 items-center justify-center rounded-full border border-[#e3e3e0] bg-[#FDFDFC] shadow-[0px_0px_1px_0px_rgba(0,0,0,0.03),0px_1px_2px_0px_rgba(0,0,0,0.06)] dark:border-[#3E3E3A] dark:bg-[#161615]">
                                <span class="h-1.5 w-1.5 rounded-full bg-[#dbdbd7] dark:bg-[#3E3E3A]" />
                            </span>
                        </span>
                        <span>
                            Work order system and warehouse management
                        </span>
                    </li>
                    <li
                        class="relative flex items-center gap-4 py-2 before:absolute before:top-0 before:bottom-0 before:left-[0.4rem] before:border-l before:border-[#e3e3e0] dark:before:border-[#3E3E3A]">
                        <span class="relative bg-white py-1 dark:bg-[#161615]">
                            <span
                                class="flex h-3.5 w-3.5 items-center justify-center rounded-full border border-[#e3e3e0] bg-[#FDFDFC] shadow-[0px_0px_1px_0px_rgba(0,0,0,0.03),0px_1px_2px_0px_rgba(0,0,0,0.06)] dark:border-[#3E3E3A] dark:bg-[#161615]">
                                <span class="h-1.5 w-1.5 rounded-full bg-[#dbdbd7] dark:bg-[#3E3E3A]" />
                            </span>
                        </span>
                        <span>
                            Used Postgres as database server
                        </span>
                    </li>
                </ul>

                <span class=" text-lg lg:text-3xl"><b><i class=" text-amber-400">Key Feature:</i></b><br> &nbsp;&nbsp;&nbsp;Dynamic
                    map layers and filtering which boosts 20% in user productivity</span> <br>
            </div>
            <div
                class="panel still bg-red-800 w-full lg:w-[40vw] h-full overflow-hidden p-4 opacity-70 flex flex-col items-center justify-center lg:p-20">
                <div class=" animate-pulse">
                    <svg xmlns="http://www.w3.org/2000/svg" width="68" height="68" viewBox="0 0 24 24" fill="none"
                        stroke="#19f06b" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-folder-git2-icon lucide-folder-git-2">
                        <path d="M18 19a5 5 0 0 1-5-5v8" />
                        <path
                            d="M9 20H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h3.9a2 2 0 0 1 1.69.9l.81 1.2a2 2 0 0 0 1.67.9H20a2 2 0 0 1 2 2v5" />
                        <circle cx="13" cy="12" r="2" />
                        <circle cx="20" cy="19" r="2" />
                    </svg>
                </div>
                <p class=" text-4xl font-semibold">
                    Featured </p>
                <p class=" text-4xl font-semibold">Project</p>
                <p class=" text-7xl font-semibold text-center">
                    GIS Mapping System</p>
            </div>
        </section>

        <section class=" flex flex-col lg:flex-row section opacity-80">
            <div class="panel left  bg-green-700 w-full lg:w-[30vw] h-full overflow-hidden p-4 opacity-70 flex flex-col items-center justify-center lg:p-20"
                style="transition-delay: 0.3s;">
                <div class=" animate-bounce">
                    <svg xmlns="http://www.w3.org/2000/svg" width="68" height="68" viewBox="0 0 24 24" fill="none"
                        stroke="#f019ac" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-monitor-cloud-icon lucide-monitor-cloud">
                        <path d="M11 13a3 3 0 1 1 2.83-4H14a2 2 0 0 1 0 4z" />
                        <path d="M12 17v4" />
                        <path d="M8 21h8" />
                        <rect x="2" y="3" width="20" height="14" rx="2" />
                    </svg>
                </div>
                <p class=" text-7xl font-semibold">
                    Services </p>

            </div>
            <div
                class="panel right  w-full lg:w-[70vw] h-full overflow-visible p-4 opacity-70 flex flex-wrap gap-1 items-center justify-start ml-auto lg:p-20">
                <span class=" text-2xl font-semibold">• Full Stack Web Development</span> <br>
                <span class=" text-2xl font-semibold">• Dashboard & Data Visualization</span> <br>
                <span class=" text-2xl font-semibold">• AI Integration (Chatbots, Automation, Computer Vision)</span>
                <br>
                <span class=" text-2xl font-semibold">• GIS Web application</span> <br>
                <span class=" text-2xl font-semibold">• Warehousing Sytems</span> <br>
                <span class=" text-2xl font-semibold">• Work Order Systems</span> <br>
                <span class=" text-2xl font-semibold">• Cloud Deployment</span> <br>
            </div>
        </section>

        <section class=" flex flex-col lg:flex-row section opacity-80">

            <div
                class="panel left w-full lg:w-[70vw] h-full overflow-visible p-4 opacity-70 flex flex-wrap gap-1 items-center justify-start ml-auto lg:p-20">
                <span class=" text-2xl font-semibold">• Uses modern framework to enable fast development</span> <br>
                <span class=" text-2xl font-semibold">• Clean, maintainable code</span> <br>
                <span class=" text-2xl font-semibold">• Eager to solve problems</span> <br>
                <span class=" text-2xl font-semibold">• Strong Engineering backround</span> <br>
                <span class=" text-2xl font-semibold">• Uses AI-assisted productivity tools</span> <br>
                <span class=" text-2xl font-semibold">• Always willing to learn new things</span> <br>
                <span class=" text-2xl font-semibold">• Strives hard to deliver commitments</span> <br>
            </div>
            <div class="panel right bg-orange-600 w-full lg:w-[30vw] h-full overflow-hidden p-4 opacity-70 flex flex-col items-center justify-center lg:p-20"
                style="transition-delay: 0.3s;">
                <div class=" animate-bounce">
                    <svg xmlns="http://www.w3.org/2000/svg" width="68" height="68" viewBox="0 0 24 24" fill="none"
                        stroke="#e2f019" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-contact-round-icon lucide-contact-round">
                        <path d="M16 2v2" />
                        <path d="M17.915 22a6 6 0 0 0-12 0" />
                        <path d="M8 2v2" />
                        <circle cx="12" cy="12" r="4" />
                        <rect x="3" y="4" width="18" height="18" rx="2" />
                    </svg>
                </div>
                <p class=" text-7xl font-semibold text-center">
                    Why Hire Me? </p>
            </div>

        </section>

        <section class="section">
            <div class=" flex min-h-screen flex-col items-center  p-6 text-[#1b1b18] md:justify-center lg:p-8 ">
                <header class="panel left mb-6 w-full max-w-[335px] text-sm not-has-[nav]:hidden md:max-w-4xl"
                    style="transition-delay: 0.3s;">
                    <nav class="flex flex-col md:flex-row items-center gap-4">
                        <div class=" text-3xl font-extrabold text-white">DEMO WEBAPP</div>
                        <div class="ml-auto"></div>
                        <Link v-if="$page.props.auth.user" :href="dashboard()"
                            class="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]">
                            Dashboard
                        </Link>
                        <template v-else>
                            <Link :href="login()"
                                class="inline-block rounded-sm border border-transparent px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#19140035] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]">
                                Log in
                            </Link>
                            <Link v-if="canRegister" :href="register()"
                                class="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]">
                                Register
                            </Link>
                        </template>
                    </nav>
                </header>
                <div
                    class="flex w-full items-center justify-center opacity-100 transition-opacity duration-750 lg:grow starting:opacity-0">
                    <main
                        class="flex w-full max-w-[335px] flex-col-reverse overflow-hidden rounded-lg md:max-w-4xl lg:max-w-4xl md:flex-row">
                        <div class="panel left md:w-[300px] rounded-br-lg rounded-bl-lg bg-white p-4 text-[13px] leading-[20px] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] lg:rounded-tl-lg lg:rounded-br-none dark:bg-[#161615] dark:text-[#EDEDEC] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d]"
                            style="transition-delay: 0.6s;">
                            <h1 class="mb-1 font-medium">Please visit my demo web app</h1>
                            <p class="mb-2 text-[#706f6c] dark:text-[#A1A09A]">
                                This demo web app showcases my capabilities as a full stack developer. <br> Note that all interactions are not
                                permanently
                                recorded.
                            </p>
                            <ul class="mb-4 flex flex-col lg:mb-6">
                                <li
                                    class="relative flex items-center gap-4 py-2 before:absolute before:top-0 before:bottom-0 before:left-[0.4rem] before:border-l before:border-[#e3e3e0] dark:before:border-[#3E3E3A]">
                                    <span class="relative bg-white py-1 dark:bg-[#161615]">
                                        <span
                                            class="flex h-3.5 w-3.5 items-center justify-center rounded-full border border-[#e3e3e0] bg-[#FDFDFC] shadow-[0px_0px_1px_0px_rgba(0,0,0,0.03),0px_1px_2px_0px_rgba(0,0,0,0.06)] dark:border-[#3E3E3A] dark:bg-[#161615]">
                                            <span class="h-1.5 w-1.5 rounded-full bg-[#dbdbd7] dark:bg-[#3E3E3A]" />
                                        </span>
                                    </span>
                                    <span>
                                        You already read the above portfolio, please feel free to register
                                    </span>
                                </li>
                                <li
                                    class="relative flex items-center gap-4 py-2 before:absolute before:top-0 before:bottom-0 before:left-[0.4rem] before:border-l before:border-[#e3e3e0] dark:before:border-[#3E3E3A]">
                                    <span class="relative bg-white py-1 dark:bg-[#161615]">
                                        <span
                                            class="flex h-3.5 w-3.5 items-center justify-center rounded-full border border-[#e3e3e0] bg-[#FDFDFC] shadow-[0px_0px_1px_0px_rgba(0,0,0,0.03),0px_1px_2px_0px_rgba(0,0,0,0.06)] dark:border-[#3E3E3A] dark:bg-[#161615]">
                                            <span class="h-1.5 w-1.5 rounded-full bg-[#dbdbd7] dark:bg-[#3E3E3A]" />
                                        </span>
                                    </span>
                                    <span>
                                        Or you can use your own facebook, linkedin or google account to login.
                                    </span>
                                </li>
                                <li
                                    class="relative flex items-center gap-4 py-2 before:absolute before:top-0 before:bottom-0 before:left-[0.4rem] before:border-l before:border-[#e3e3e0] dark:before:border-[#3E3E3A]">
                                    <span class="relative bg-white py-1 dark:bg-[#161615]">
                                        <span
                                            class="flex h-3.5 w-3.5 items-center justify-center rounded-full border border-[#e3e3e0] bg-[#75755a] shadow-[0px_0px_1px_0px_rgba(0,0,0,0.03),0px_1px_2px_0px_rgba(0,0,0,0.06)] dark:border-[#3E3E3A] dark:bg-[#a4a476]">
                                            <span class="h-1.5 w-1.5 rounded-full bg-[#dbdbd7] dark:bg-[#3E3E3A]" />
                                        </span>
                                    </span>
                                    <span>
                                        Happy testing!
                                    </span>
                                </li>
                            </ul>

                        </div>
                        <div class="panel right h-[100%] overflow-hidden flex-1" style="transition-delay: 0.9s;">
                            <div class="w-[100%]">
                                <!--div
                        class="absolute inset-0 rounded-t-lg shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d] lg:overflow-hidden lg:rounded-r-lg lg:rounded-t-none" /-->
                                <video autoplay muted loop class="w-[100%]">
                                    <source src="/dt.mp4" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                        </div>
                    </main>
                </div>
                <div class="hidden h-14.5 lg:block"></div>
            </div>
        </section>

    </div>
</template>

<style scoped>
/*
This is the scroll
*/
.story {
    padding: 0;
    margin: 0;
    height: 100%;
    width: 100vw;
    overflow-y: scroll;
    scroll-snap-type: y mandatory;
}

.section {
    position: relative;
    top: 0;
    left: 0;
    padding: 0;
    margin: 0;
    height: 100%;
    width: 100vw;
    color: white;
    scroll-snap-align: start;
}

.panel {
    overflow: hidden;
    opacity: 0;
    transform: translateX(0px) scale(1);
    transition: all 0.1s cubic-bezier(0.22, 1, 0.36, 1);
}

.panel.still {
    opacity: 1;
    transform: translateX(0) scale(1);

}

.panel.left {
    opacity: 0;
    transform: translateX(-620px) scale(0.95);
    transition: all 0.1s cubic-bezier(0.22, 1, 0.36, 1);
}

.panel.right {
    opacity: 0;
    transform: translateX(620px) scale(0.95);
    transition: all 0.1s cubic-bezier(0.22, 1, 0.36, 1);
}

.panel.left.active {
    opacity: 1;
    transform: translateX(0) scale(1);
    transition: all 0.4s cubic-bezier(0.22, 1, 0.36, 1);
}

.panel.right.active {
    opacity: 1;
    transform: translateX(0) scale(1);
    transition: all 0.4s cubic-bezier(0.22, 1, 0.36, 1);
}
</style>
