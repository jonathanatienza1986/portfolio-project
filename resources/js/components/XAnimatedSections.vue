// eslint-disable-next-line vue/block-lang
<script setup lang="ts">
//import ThreeStoryScene from '../components/ThreeStoryScene.vue'
import { Link } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue'
import { Button as ubtn } from '@/components/ui/button';
import { dashboard, login, register } from '@/routes';
import XStarFieldBG from '../components/XStarFieldBG.vue'
import XTickerTape from '../components/XTickerTape.vue'



const storyRef = ref(null)
const showLoading = ref(true);
const ToBeDelayedDOM = ref<HTMLElement | null>(null);


onMounted(() => {
    const el = storyRef.value
    const sections = el.querySelectorAll('.section')

    const updateActive = () => {
        const scrollTop = el.scrollTop
        const height = el.clientHeight
        let index = Math.round(scrollTop / height)

        if (index === 0) {
            ToBeDelayedDOM.value?.scrollIntoView({ behavior: 'smooth' });
            index = Math.round(scrollTop / height);
        }

        sections.forEach((section: { querySelectorAll: (arg0: string) => any; }, i: number) => {
            console.log("i: ", i);
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


    setTimeout(() => {
        showLoading.value = false;
        el.addEventListener('scroll', updateActive);
    }, 500);
    setTimeout(() => {
        ToBeDelayedDOM.value?.scrollIntoView({ behavior: 'smooth' });
    }, 1000);

    //spot light
    const spotlight = document.querySelectorAll('.spotlight');
    spotlight.forEach((elem) => {
        elem.addEventListener('mousemove', (e) => {
            const rect = elem.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;

            // Set variables that the CSS radial-gradient uses
            elem.style.setProperty('--x', `${x}px`);
            elem.style.setProperty('--y', `${y}px`);
        })
    })


});


const dialog1Open = ref(false);
const dlg_bg_show = ref();
const dlg_show = ref();

const aboutMeClicked = () => {
    dialog1Open.value = !dialog1Open.value;

    if (dialog1Open.value) {
        dlg_bg_show.value.classList.add('dialogbgShow');
        dlg_show.value.classList.add('dialogbgShow');
        dlg_bg_show.value.classList.add('z-1500');
        dlg_bg_show.value.classList.remove('-z-1');
    } else {
        dlg_bg_show.value.classList.remove('dialogbgShow');
        dlg_show.value.classList.remove('dialogbgShow');
        dlg_bg_show.value.classList.remove('z-1500');
        dlg_bg_show.value.classList.add('-z-1');
    }
}

const dialog1Open_techStack = ref(false);
const dlg_bg_show_techStack = ref();
const dlg_show_techStack = ref();

const techStackClick = () => {

    dialog1Open_techStack.value = !dialog1Open_techStack.value;
    console.log("click ", dialog1Open_techStack.value)

    if (dialog1Open_techStack.value) {
        dlg_bg_show_techStack.value.classList.add('dialogbgShow');
        dlg_show_techStack.value.classList.add('dialogbgShow');
        dlg_bg_show_techStack.value.classList.add('z-1500');
        dlg_bg_show_techStack.value.classList.remove('-z-1');
    } else {
        dlg_bg_show_techStack.value.classList.remove('dialogbgShow');
        dlg_show_techStack.value.classList.remove('dialogbgShow');
        dlg_bg_show_techStack.value.classList.remove('z-1500');
        dlg_bg_show_techStack.value.classList.add('-z-1');
    }
}

const dialog1Open_chatbot = ref(false);
const dlg_bg_show_chatbot = ref();
const dlg_show_chatbot = ref();

const dialog1Open_analytics = ref(false);
const dlg_bg_show_analytics = ref();
const dlg_show_analytics = ref();

const dialog1Open_gis = ref(false);
const dlg_bg_show_gis = ref();
const dlg_show_gis = ref();

const chatbotClick = () => {

    dialog1Open_chatbot.value = !dialog1Open_chatbot.value;

    if (dialog1Open_chatbot.value) {
        dlg_bg_show_chatbot.value.classList.add('dialogbgShow');
        dlg_show_chatbot.value.classList.add('dialogbgShow');
        dlg_bg_show_chatbot.value.classList.add('z-1500');
        dlg_bg_show_chatbot.value.classList.remove('-z-1');
    } else {
        dlg_bg_show_chatbot.value.classList.remove('dialogbgShow');
        dlg_show_chatbot.value.classList.remove('dialogbgShow');
        dlg_bg_show_chatbot.value.classList.remove('z-1500');
        dlg_bg_show_chatbot.value.classList.add('-z-1');
    }
}

const analyticsClick = () => {

    dialog1Open_analytics.value = !dialog1Open_analytics.value;

    if (dialog1Open_analytics.value) {
        dlg_bg_show_analytics.value.classList.add('dialogbgShow');
        dlg_show_analytics.value.classList.add('dialogbgShow');
        dlg_bg_show_analytics.value.classList.add('z-1500');
        dlg_bg_show_analytics.value.classList.remove('-z-1');
    } else {
        dlg_bg_show_analytics.value.classList.remove('dialogbgShow');
        dlg_show_analytics.value.classList.remove('dialogbgShow');
        dlg_bg_show_analytics.value.classList.remove('z-1500');
        dlg_bg_show_analytics.value.classList.add('-z-1');
    }
}

const gisClick = () => {

    dialog1Open_gis.value = !dialog1Open_gis.value;

    if (dialog1Open_gis.value) {
        dlg_bg_show_gis.value.classList.add('dialogbgShow');
        dlg_show_gis.value.classList.add('dialogbgShow');
        dlg_bg_show_gis.value.classList.add('z-1500');
        dlg_bg_show_gis.value.classList.remove('-z-1');
    } else {
        dlg_bg_show_gis.value.classList.remove('dialogbgShow');
        dlg_show_gis.value.classList.remove('dialogbgShow');
        dlg_bg_show_gis.value.classList.remove('z-1500');
        dlg_bg_show_gis.value.classList.add('-z-1');
    }
}


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
    <div v-if="showLoading" class=" m-0 p-0 w-screen h-screen z-5000 absolute top-0 left-0 bg-black flex items-center justify-center text-center">
        <div class=" animate-spin  z-5001" v-show="showLoading">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="#0357c4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-loader-circle-icon lucide-loader-circle">
                <path d="M21 12a9 9 0 1 1-6.219-8.56" />
            </svg>
        </div>
    </div>
    <!-- Take Photo Camera Dialog Start Lincese Photo-->
    <div class="story overflow-hidden  overflow-x-hidden z-100" ref="storyRef">
        <!-- Empty 0th page-->
        <section class=" flex flex-col items-center justify-center text-center section">
        </section>

        <!-- Hero -->
        <section ref="ToBeDelayedDOM" class="flex flex-col section">
            <XTickerTape />
            <div class="flex flex-col lg:flex-row flex-1">
                <div
                    class="panel left  w-full lg:w-[75vw] overflow-visible  p-4 opacity-70 flex flex-col gap-6 md:flex-row justify-center items-center lg:gap-3">
                    <div class="flex flex-col">
                        <span class=" text-5xl font-semibold text-center">Garry M. Cacho's <i
                                class=" font-mono text-6x text-blue-500">Portfolio</i></span>
                        <div class="flex flex-wrap gap-2 justify-center">
                            <span
                                class=" text-2xl font-semibold text-center p-2 rounded-lg hover:bg-amber-700 flex items-center gap-1"><svg
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="#7e7ce4" stroke-width="1.25" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-phone-icon lucide-phone">
                                    <path
                                        d="M13.832 16.568a1 1 0 0 0 1.213-.303l.355-.465A2 2 0 0 1 17 15h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2A18 18 0 0 1 2 4a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v3a2 2 0 0 1-.8 1.6l-.468.351a1 1 0 0 0-.292 1.233 14 14 0 0 0 6.392 6.384" />
                                </svg><a href="tel:+639995202447" target="_blank">Mobile</a> </span>
                            <span
                                class=" text-2xl font-semibold text-center p-2 rounded-lg hover:bg-amber-700 flex items-center gap-1"><svg
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="#7ce488" stroke-width="1.25" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-at-sign-icon lucide-at-sign">
                                    <circle cx="12" cy="12" r="4" />
                                    <path d="M16 8v5a3 3 0 0 0 6 0v-1a10 10 0 1 0-4 8" />
                                </svg><a href="mailto:gc120978levelup1@gmail.com" target="_blank">Email</a> </span>
                            <span
                                class=" text-2xl font-semibold text-center p-2 rounded-lg hover:bg-amber-700 flex items-center gap-1">
                                <img src="/linkedin.jpg" width="30" alt=""><a
                                    href="https://www.linkedin.com/in/garry-cacho-28248390" target="_blank">LinkedIn</a>
                            </span>
                            <span
                                class=" text-2xl font-semibold text-center p-2 rounded-lg hover:bg-amber-700 flex items-center gap-1">
                                <svg fill="#ffffff" width="30px" height="30px" viewBox="0 -0.5 25 25"
                                    xmlns="http://www.w3.org/2000/svg" stroke="#ffffff">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0" />
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" />
                                    <g id="SVGRepo_iconCarrier">
                                        <path
                                            d="m12.301 0h.093c2.242 0 4.34.613 6.137 1.68l-.055-.031c1.871 1.094 3.386 2.609 4.449 4.422l.031.058c1.04 1.769 1.654 3.896 1.654 6.166 0 5.406-3.483 10-8.327 11.658l-.087.026c-.063.02-.135.031-.209.031-.162 0-.312-.054-.433-.144l.002.001c-.128-.115-.208-.281-.208-.466 0-.005 0-.01 0-.014v.001q0-.048.008-1.226t.008-2.154c.007-.075.011-.161.011-.249 0-.792-.323-1.508-.844-2.025.618-.061 1.176-.163 1.718-.305l-.076.017c.573-.16 1.073-.373 1.537-.642l-.031.017c.508-.28.938-.636 1.292-1.058l.006-.007c.372-.476.663-1.036.84-1.645l.009-.035c.209-.683.329-1.468.329-2.281 0-.045 0-.091-.001-.136v.007c0-.022.001-.047.001-.072 0-1.248-.482-2.383-1.269-3.23l.003.003c.168-.44.265-.948.265-1.479 0-.649-.145-1.263-.404-1.814l.011.026c-.115-.022-.246-.035-.381-.035-.334 0-.649.078-.929.216l.012-.005c-.568.21-1.054.448-1.512.726l.038-.022-.609.384c-.922-.264-1.981-.416-3.075-.416s-2.153.152-3.157.436l.081-.02q-.256-.176-.681-.433c-.373-.214-.814-.421-1.272-.595l-.066-.022c-.293-.154-.64-.244-1.009-.244-.124 0-.246.01-.364.03l.013-.002c-.248.524-.393 1.139-.393 1.788 0 .531.097 1.04.275 1.509l-.01-.029c-.785.844-1.266 1.979-1.266 3.227 0 .025 0 .051.001.076v-.004c-.001.039-.001.084-.001.13 0 .809.12 1.591.344 2.327l-.015-.057c.189.643.476 1.202.85 1.693l-.009-.013c.354.435.782.793 1.267 1.062l.022.011c.432.252.933.465 1.46.614l.046.011c.466.125 1.024.227 1.595.284l.046.004c-.431.428-.718 1-.784 1.638l-.001.012c-.207.101-.448.183-.699.236l-.021.004c-.256.051-.549.08-.85.08-.022 0-.044 0-.066 0h.003c-.394-.008-.756-.136-1.055-.348l.006.004c-.371-.259-.671-.595-.881-.986l-.007-.015c-.198-.336-.459-.614-.768-.827l-.009-.006c-.225-.169-.49-.301-.776-.38l-.016-.004-.32-.048c-.023-.002-.05-.003-.077-.003-.14 0-.273.028-.394.077l.007-.003q-.128.072-.08.184c.039.086.087.16.145.225l-.001-.001c.061.072.13.135.205.19l.003.002.112.08c.283.148.516.354.693.603l.004.006c.191.237.359.505.494.792l.01.024.16.368c.135.402.38.738.7.981l.005.004c.3.234.662.402 1.057.478l.016.002c.33.064.714.104 1.106.112h.007c.045.002.097.002.15.002.261 0 .517-.021.767-.062l-.027.004.368-.064q0 .609.008 1.418t.008.873v.014c0 .185-.08.351-.208.466h-.001c-.119.089-.268.143-.431.143-.075 0-.147-.011-.214-.032l.005.001c-4.929-1.689-8.409-6.283-8.409-11.69 0-2.268.612-4.393 1.681-6.219l-.032.058c1.094-1.871 2.609-3.386 4.422-4.449l.058-.031c1.739-1.034 3.835-1.645 6.073-1.645h.098-.005zm-7.64 17.666q.048-.112-.112-.192-.16-.048-.208.032-.048.112.112.192.144.096.208-.032zm.497.545q.112-.08-.032-.256-.16-.144-.256-.048-.112.08.032.256.159.157.256.047zm.48.72q.144-.112 0-.304-.128-.208-.272-.096-.144.08 0 .288t.272.112zm.672.673q.128-.128-.064-.304-.192-.192-.32-.048-.144.128.064.304.192.192.32.044zm.913.4q.048-.176-.208-.256-.24-.064-.304.112t.208.24q.24.097.304-.096zm1.009.08q0-.208-.272-.176-.256 0-.256.176 0 .208.272.176.256.001.256-.175zm.929-.16q-.032-.176-.288-.144-.256.048-.224.24t.288.128.225-.224z" />
                                    </g>
                                </svg>
                                <a href="https://github.com/gc120978levelup1" target="_blank">Github</a> </span>
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
                <div class="panel right  w-full lg:w-[25vw] lg:h-full overflow-visible flex-1 flex flex-col bg-red-500/10 backdrop-blur-sm border-t lg:border-l lg:border-l-white/20 bg-linear-to-br  from-red-800/20 to-blue-800/20"
                    style="transition-delay: 1.3s;">
                    <div style="background: radial-gradient(2000px circle at var(--x) var(--y), rgba(255,255,255,0.2), transparent 10%);"
                        class="spotlight p-4 w-[100%] h-[100%]  flex-1 flex flex-col">
                        <span class=" text-6xl font-semibold"><i class=" font-stretch-condensed text-purple-500 ">Full
                                Stack</i> Web Dev</span>
                        <span class=" text-6xl font-semibold">
                            <span class="text-[#F05340] font-stretch-condensed nunito-sans-100">
                                Laravel
                            </span> &
                            <span
                                class="inter-200 font-extrabold bg-linear-to-r from-[#41B883] to-[#415fb8] bg-clip-text text-transparent">
                                Vue
                            </span>
                        </span>
                        <div class="flex flex-col  mt-auto ml-auto mr-3">
                            <div class=" animate-bounce ">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="#ccff00" stroke-width="2.5" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="lucide lucide-arrow-down-to-line-icon lucide-arrow-down-to-line">
                                    <path d="M12 17V3" />
                                    <path d="m6 11 6 6 6-6" />
                                    <path d="M19 21H5" />
                                </svg>
                            </div>
                            <ubtn @click="aboutMeClicked" class=" bg-transparent hover:bg-transparent p-0 w-fit">
                                <span class="flex flex-row  hover:cursor-pointer text-white gap-2">
                                    About Me <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="#0357c4" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-chevron-right-icon lucide-chevron-right">
                                        <path d="m9 18 6-6-6-6" />
                                    </svg>
                                </span>
                            </ubtn>
                        </div>
                    </div>
                </div>
                <!-- make shift dialog box -->
                <!-- // v-show="dialog1Open" -->
                <div ref="dlg_bg_show"
                    class="dialogbg-hidden absolute top-0 -z-1 flex flex-col lg:flex row text-center justify-center items-center bg-black w-full h-full bg-red-500/10 backdrop-blur-lg border-t lg:border-l lg:border-l-white/20 bg-linear-to-br  from-black/40 to-blue-800/40">
                    <div ref="dlg_show"
                        class="dialog-hidden w-screen lg:w-[70vw] h-[80vh] rounded-2xl flex flex-col bg-black border-2 shadow-2xl shadow-black p-4 overflow-hidden overflow-y-auto">
                        <div class=" text-justify text-shadow-blue-300">
                            <p class=" text-4xl font-extrabold font-stretch-condensed nunito-sans-100">
                                About Garry
                            </p>
                            <p class=" text-2xl text-gray-500 nunito-sans-100 font-extrabold">
                                Moving past the title to analyze the details.!
                            </p>
                            <br>
                            <p>
                                My journey in tech began with a desire to solve real-world problems. Today, as a
                                Software Engineer,
                                I
                                combine that curiosity with modern technologies like Laravel, Vue.js and Tailwind CSS to
                                build
                                intuitive,
                                full-stack digital experiences that matter.
                            </p>
                            <br>
                            <p>
                                While my foundation lies in creating polished JavaScript front-ends, I am actively
                                evolving my skill
                                set
                                to include Laravel and AI backend development. By leveraging Inertia.JS, I am focused on
                                engineering the
                                efficient, server-side infrastructure that powers modern web apps.
                            </p>
                            <br>
                            <p>
                                I love working with teams to solve tough problems, focusing on building meaningful,
                                innovative
                                solutions
                                that truly make a difference for users.
                            </p>
                            <br>
                            <br>
                            <div class="w-[80%] h-[2px] border-b mx-auto"></div>
                        </div>
                        <ubtn @click="aboutMeClicked"
                            class=" bg-transparent hover:bg-transparent p-0 mt-auto ml-auto mr-3 w-fit">
                            <span class="flex flex-row  hover:cursor-pointer text-white gap-2">
                                <i class=" text-red-800">Close</i> <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="#0357c4" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-chevron-right-icon lucide-chevron-right">
                                    <path d="m9 18 6-6-6-6" />
                                </svg>
                            </span>
                        </ubtn>
                    </div>
                </div>
            </div>
        </section>

        <!-- Tech Stack -->
        <section class=" flex flex-col lg:flex-row section">
            <div class="panel left w-full lg:w-[50vw] h-full overflow-hidden flex flex-col lg:flex-row items-center justify-start bg-cyan-700/10 backdrop-blur-sm border-b lg:border-r border-white/20 bg-linear-to-br  from-cyan-800/20 to-yellow-800/20"
                style="transition-delay: 1.3s;">
                <div class="spotlight w-[100%] h-[100%] m-0 p-4 lg:p-20"
                    style="background: radial-gradient(2000px circle at var(--x) var(--y), rgba(255,255,255,0.2), transparent 10%);">
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
                    <button @click="techStackClick">
                        <div
                            class="p-4 hover:bg-amber-600/10 hover:cursor-pointer border hover:shadow-2xl shadow-black border-amber-100 rounded-2xl">
                            <p class=" text-7xl font-semibold text-center">
                                Tech Stack Experience</p>
                        </div>
                    </button>
                </div>
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
            <!-- make shift dialog box -->
            <!-- // v-show="dialog1Open" -->
            <div ref="dlg_bg_show_techStack"
                class="dialogbg-hidden absolute top-0 -z-1 flex flex-col lg:flex row text-center justify-center items-center bg-black w-full h-full bg-red-500/10 backdrop-blur-lg border-t lg:border-l lg:border-l-white/20 bg-linear-to-br  from-black/40 to-blue-800/40">
                <div ref="dlg_show_techStack"
                    class="dialog-hidden w-screen lg:w-[70vw] h-[80vh] rounded-2xl flex flex-col bg-black border-2 shadow-2xl shadow-black p-4 overflow-hidden overflow-y-auto">
                    <div class=" text-justify text-shadow-blue-300">
                        <p class=" text-4xl font-extrabold font-stretch-condensed nunito-sans-100">
                            My Skills and Toolsets
                        </p>
                        <p class=" text-2xl text-gray-500 nunito-sans-100 font-extrabold">
                            Learning through experience and self discoveries.
                        </p>
                        <br>
                        <p>
                            As an expert Full-Stack Engineer, I build high-performance web applications using a modern,
                            battle-tested stack. My focus is on creating seamless user experiences backed by scalable,
                            cloud-native architecture.
                        </p>
                        <br>
                        <p class=" text-lg font-bold nunito-sans-100">
                            My Stack
                        </p>
                        <ul class="ml-4">
                            <ui class="relative flex items-center gap-4 py-2 before:absolute before:top-0 before:bottom-0
                                before:left-[1.2rem] before:border-l before:border-[#e3e3e0]
                                dark:before:border-[#3E3E3A]">
                                <span class="relative py-1">
                                    <span
                                        class="flex h-10 w-10 items-center justify-center rounded-full border-2 border-[#e3e3e0] bg-[#FDFDFC] shadow-[0px_0px_1px_0px_rgba(0,0,0,0.03),0px_1px_2px_0px_rgba(0,0,0,0.06)] dark:border-[#3E3E3A] dark:bg-[#161615]">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://w3.org">
                                            <!-- Outer Circuit Hexagon -->
                                            <path d="M12 2L4 6.5v11L12 22l8-4.5v-11L12 2z" stroke="#38BDF8"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            <!-- Central Spark/Intelligence Core -->
                                            <path d="M12 8v8M8 12h8" stroke="#FFFFFF" stroke-width="2"
                                                stroke-linecap="round" />
                                            <!-- Neural Nodes -->
                                            <circle cx="12" cy="12" r="2" fill="#38BDF8" />
                                            <circle cx="12" cy="5" r="1.5" fill="#FFFFFF" />
                                            <circle cx="12" cy="19" r="1.5" fill="#FFFFFF" />
                                        </svg>
                                    </span>
                                </span>
                                <p class=" text-2xl text-gray-500 nunito-sans-100 font-bold">
                                    AI Models
                                </p>
                                <div class="p-3 flex flex-wrap gap-2">
                                    <div class="flex gap-2 rounded-md p-3 border border-amber-600">
                                        <svg width="20" height="20" viewBox="0 0 24 24" xmlns="http://w3.org">
                                            <path fill="currentColor"
                                                d="M22.282 9.821a5.985 5.985 0 0 0-.516-4.91 6.046 6.046 0 0 0-4.047-3.124 6.12 6.12 0 0 0-5.111.921 6.079 6.079 0 0 0-4.516-2.036 6.056 6.056 0 0 0-5.29 3.056A6.056 6.056 0 0 0 .396 10.23a6.056 6.056 0 0 0 2.11 5.23 6.056 6.056 0 0 0 .516 4.91 6.046 6.046 0 0 0 4.047 3.124 6.12 6.12 0 0 0 5.111-.921 6.079 6.079 0 0 0 4.516 2.036 6.056 6.056 0 0 0 5.29-3.056 6.056 6.056 0 0 0 2.21-6.531 6.056 6.056 0 0 0-2.11-5.231zm-8.29 9.518a4.472 4.472 0 0 1-2.143.543 4.498 4.498 0 0 1-3.535-1.721l6.13-3.541a.43.43 0 0 0 .219-.375v-8.67l2.235 1.29a4.47 4.47 0 0 1 1.759 3.518 4.48 4.48 0 0 1-4.665 4.956zm-11.424-3.73a4.472 4.472 0 0 1-.543-2.143 4.498 4.498 0 0 1 1.721-3.535l6.13 3.541a.43.43 0 0 0 .375.011l7.507-4.335v2.58a4.47 4.47 0 0 1-1.759 3.518l-13.431 7.864zm-2.174-11.239a4.472 4.472 0 0 1 2.143-.543 4.498 4.498 0 0 1 3.535 1.721L4.01 9.07a.43.43 0 0 0-.219.375v8.67L1.556 16.825a4.47 4.47 0 0 1-1.759-3.518 4.48 4.48 0 0 1 4.665-4.956zm11.424 3.73a4.472 4.472 0 0 1 .543 2.143 4.498 4.498 0 0 1-1.721 3.535l-6.13-3.541a.43.43 0 0 0-.375-.011L3.064 12.35v-2.58a4.47 4.47 0 0 1 1.759-3.518L18.254 3.1zM9.544 8.859l-2.235-1.29a4.47 4.47 0 0 1-1.759-3.518A4.48 4.48 0 0 1 10.215 1.01a4.472 4.472 0 0 1 2.143-.543 4.498 4.498 0 0 1 3.535 1.721l-6.13 3.541a.43.43 0 0 0-.219.375v8.67zM12 14.5a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5z" />
                                        </svg>
                                        openai/gpt-oss-120b
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 24 24" xmlns="http://w3.org">
                                            <path fill="#0668E1"
                                                d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm4.184 14.646c-.52.52-1.36.52-1.88 0l-1.304-1.304c-.663.418-1.442.658-2.274.658-.832 0-1.61-.24-2.274-.658l-1.304 1.304c-.52.52-1.36.52-1.88 0-.52-.52-.52-1.36 0-1.88l1.304-1.304c-.418-.663-.658-1.442-.658-2.274 0-.832.24-1.61.658-2.274l-1.304-1.304c-.52-.52-.52-1.36 0-1.88.52-.52 1.36-.52 1.88 0l1.304 1.304c.663-.418 1.442-.658 2.274-.658.832 0 1.61.24 2.274.658l1.304-1.304c.52-.52 1.36-.52 1.88 0 .52.52.52 1.36 0 1.88l-1.304 1.304c.418.663.658 1.442.658 2.274 0 .832-.24 1.61-.658 2.274l1.304 1.304c.52.52.52 1.36 0 1.88z" />
                                        </svg>
                                        llama-3.1-8b-instant
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 24 24" xmlns="http://w3.org">
                                            <path fill="#0668E1"
                                                d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm4.184 14.646c-.52.52-1.36.52-1.88 0l-1.304-1.304c-.663.418-1.442.658-2.274.658-.832 0-1.61-.24-2.274-.658l-1.304 1.304c-.52.52-1.36.52-1.88 0-.52-.52-.52-1.36 0-1.88l1.304-1.304c-.418-.663-.658-1.442-.658-2.274 0-.832.24-1.61.658-2.274l-1.304-1.304c-.52-.52-.52-1.36 0-1.88.52-.52 1.36-.52 1.88 0l1.304 1.304c.663-.418 1.442-.658 2.274-.658.832 0 1.61.24 2.274.658l1.304-1.304c.52-.52 1.36-.52 1.88 0 .52.52.52 1.36 0 1.88l-1.304 1.304c.418.663.658 1.442.658 2.274 0 .832-.24 1.61-.658 2.274l1.304 1.304c.52.52.52 1.36 0 1.88z" />
                                        </svg>
                                        meta-llama/llama-4-scout
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 24 24" xmlns="http://w3.org">
                                            <!-- NVIDIA Green background circle -->
                                            <circle cx="12" cy="12" r="10" fill="#76B900" />
                                            <!-- Simplified Eye/Spiral Mark -->
                                            <path
                                                d="M12 6.5c-3.038 0-5.5 2.462-5.5 5.5s2.462 5.5 5.5 5.5c1.933 0 3.633-1.001 4.604-2.5h-1.604c-.75 1-1.875 1.5-3 1.5-2.21 0-4-1.79-4-4s1.79-4 4-4c1.125 0 2.25.5 3 1.5h1.604C15.633 7.501 13.933 6.5 12 6.5z"
                                                fill="#FFFFFF" />
                                            <circle cx="12" cy="12" r="1.5" fill="#FFFFFF" />
                                        </svg>
                                        nvidia/nemotron-3
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://w3.org">
                                            <path
                                                d="M12 2c0 5.523 4.477 10 10 10-5.523 0-10 4.477-10 10 0-5.523-4.477-10-10-10 5.523 0 10-4.477 10-10z"
                                                fill="url(#gemini-gradient)" />
                                            <defs>
                                                <linearGradient id="gemini-gradient" x1="2" y1="12" x2="22" y2="12"
                                                    gradientUnits="userSpaceOnUse">
                                                    <stop stop-color="#4E82EE" />
                                                    <stop offset="1" stop-color="#B162F0" />
                                                </linearGradient>
                                            </defs>
                                        </svg>
                                        gemini-3-flash-preview
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://w3.org">
                                            <!-- The Tesseract "T" Cube/Network shape -->
                                            <path d="M12 2L3 7v10l9 5 9-5V7l-9-5z" stroke="#5ca9e1" stroke-width="1.5"
                                                stroke-linejoin="round" />
                                            <path d="M12 22V12M12 12L3 7M12 12l9-5" stroke="#5ca9e1"
                                                stroke-width="1.5" />
                                            <!-- OCR/Text representation (White for Dark Mode) -->
                                            <path d="M8 11h8M8 14h5" stroke="white" stroke-width="1.5"
                                                stroke-linecap="round" />
                                        </svg>
                                        Tesserct JS
                                    </div>

                                </div>
                            </ui>

                            <ui class="relative flex items-center gap-4 py-2 before:absolute before:top-0 before:bottom-0
                                before:left-[1.2rem] before:border-l before:border-[#e3e3e0]
                                dark:before:border-[#3E3E3A]">
                                <span class="relative py-1">
                                    <span
                                        class="flex h-10 w-10 items-center justify-center rounded-full border-2 border-[#e3e3e0] bg-[#FDFDFC] shadow-[0px_0px_1px_0px_rgba(0,0,0,0.03),0px_1px_2px_0px_rgba(0,0,0,0.06)] dark:border-[#3E3E3A] dark:bg-[#161615]">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://w3.org">
                                            <!-- Code Brackets (HTML/Logic) -->
                                            <path d="M7 8l-4 4 4 4M17 8l4 4-4 4" stroke="#60A5FA" stroke-width="2.5"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <!-- Central Brush (Styling/UI) -->
                                            <path d="M14 4l-4 16" stroke="#F472B6" stroke-width="2.5"
                                                stroke-linecap="round" />
                                        </svg>
                                    </span>
                                </span>
                                <p class=" text-2xl text-gray-500 nunito-sans-100 font-bold">
                                    Front End Stack
                                </p>
                                <div class="p-3 flex flex-wrap gap-2">
                                    <div class="flex gap-2 rounded-md p-3 border border-amber-600">
                                        <svg width="20" height="20" viewBox="0 0 512 512" xmlns="http://w3.org">
                                            <path fill="#E34F26" d="M71,460 L37,0 475,0 441,460 256,512z" />
                                            <path fill="#EF652A" d="M256,472 L405,431 431,73 256,73z" />
                                            <path fill="#EBEBEB"
                                                d="M256,208 L181,208 176,150 256,150 256,94 115,94 125,213 130,265 256,265z M256,355 L255,355 192,338 188,293 132,293 140,381 256,412z" />
                                            <path fill="#FFFFFF"
                                                d="M256,208 L256,265 325,265 318,337 256,354 256,412 371,381 372,370 384,213 385,208z M256,94 L256,150 392,150 397,94z" />
                                        </svg>
                                        HTML
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 512 512" xmlns="http://w3.org">
                                            <path fill="#264DE4" d="M71,460 L37,0 475,0 441,460 256,512z" />
                                            <path fill="#2965F1" d="M256,472 L405,431 431,73 256,73z" />
                                            <path fill="#EBEBEB"
                                                d="M256,151 L177,151 181,208 256,208 256,265 185,265 189,313 256,331 256,389 140,357 127,213 125,188 122,94 256,94z" />
                                            <path fill="#FFFFFF"
                                                d="M256,151 L256,94 390,94 388,119 380,213 376,265 256,265 256,208 319,208 323,151z M256,331 L256,389 372,357 384,208 385,208 377,293 320,311z" />
                                        </svg>
                                        CSS
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 24 24" xmlns="http://w3.org">
                                            <path fill="#38bdf8"
                                                d="M12.001 4.8c-3.2 0-5.2 1.6-6 4.8 1.2-1.6 2.6-2.2 4.2-1.8 0.913 0.228 1.565 0.89 2.288 1.624C13.666 10.618 15.027 12 18.001 12c3.2 0 5.2-1.6 6-4.8-1.2 1.6-2.6 2.2-4.2 1.8-0.913-0.228-1.565-0.89-2.288-1.624C16.337 6.182 14.976 4.8 12.001 4.8zm-6 7.2c-3.2 0-5.2 1.6-6 4.8 1.2-1.6 2.6-2.2 4.2-1.8 0.913 0.228 1.565 0.89 2.288 1.624 1.177 1.194 2.538 2.576 5.512 2.576 3.2 0 5.2-1.6 6-4.8-1.2 1.6-2.6 2.2-4.2 1.8-0.913-0.228-1.565-0.89-2.288-1.624C8.337 13.382 6.976 12 4.001 12z" />
                                        </svg>
                                        Tailwind CSS
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 630 630" xmlns="http://w3.org">
                                            <rect width="630" height="630" fill="#f7df1e" />
                                            <path
                                                d="m423.2 492.19c12.69 20.72 29.2 35.95 58.4 35.95 24.53 0 40.2-12.26 40.2-29.2 0-20.3-16.1-27.49-43.1-39.3l-14.8-6.35c-42.72-18.2-71.1-41-71.1-89.2 0-44.4 33.83-77.23 86.63-77.23 37.64 0 64.7 14.38 84.18 47.38l-46.1 29.6c-10.15-18.2-21.1-25.37-38.1-25.37-17.34 0-28.33 9.3-28.33 21.15 0 16.5 10.15 23.26 36.37 34.68l14.8 6.34c54.55 23.26 79.1 42.3 79.1 94.3 0 54.55-43.6 81.65-95.6 81.65-49.5 0-77.02-22.84-93.53-52.13zm-215.1-5.11c12.69 21.6 27.06 37.3 54.1 37.3 21.6 0 35.53-10.57 35.53-50.76v-187.9h57.1v188.3c0 73.15-42.3 102.76-92.63 102.76-45.7 0-74-21.6-90.1-53.74z" />
                                        </svg>
                                        JavaScript
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 256 221" xmlns="http://w3.org">
                                            <path fill="#41B883"
                                                d="M204.8 0H256L128 220.8 0 0h51.2L128 132.48 204.8 0z" />
                                            <path fill="#35495E"
                                                d="M165.12 0H204.8L128 132.48 51.2 0h39.68L128 66.24 165.12 0z" />
                                        </svg>
                                        VueJS
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 24 24" xmlns="http://w3.org">
                                            <path fill="#9553E9"
                                                d="M11.5 5.5l6 6.5-6 6.5h4.5l6-6.5-6-6.5h-4.5zm-9 0l6 6.5-6 6.5h4.5l6-6.5-6-6.5h-4.5z" />
                                        </svg>
                                        InertiaJS
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://w3.org">
                                            <!-- Top Leaves (Green) -->
                                            <path
                                                d="M12 2c-.8 0-1.5.5-1.8 1.2C9.5 3 8.8 3.5 8.5 4.2c-.3.7-.2 1.5.2 2.1l3.3.2 3.3-.2c.4-.6.5-1.4.2-2.1-.3-.7-1-1.2-1.7-1-.3-.7-1-1.2-1.8-1.2z"
                                                fill="#606f21" />
                                            <!-- Body (Yellow) -->
                                            <path
                                                d="M12 6c-2.5 0-4.5 2-4.5 4.5 0 1 .3 1.9.9 2.6L4.5 20c-.3.6-.5 1.3-.5 2 0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2 0-.7-.2-1.4-.5-2l-3.9-6.9c.6-.7.9-1.6.9-2.6 0-2.5-2-4.5-4.5-4.5z"
                                                fill="#ffe066" />
                                            <!-- Eyes (Dark Green) -->
                                            <circle cx="10" cy="11.5" r="0.8" fill="#606f21" />
                                            <circle cx="14" cy="11.5" r="0.8" fill="#606f21" />
                                            <!-- Smile (Dark Green) -->
                                            <path d="M11 13.5c.3.3.7.5 1 .5s.7-.2 1-.5" stroke="#606f21"
                                                stroke-width="0.6" stroke-linecap="round" />
                                        </svg>
                                        Pinia
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://w3.org">
                                            <path d="M20 5L5 20M17 3L3 17" stroke="currentColor" stroke-width="3"
                                                stroke-linecap="round" />
                                        </svg>
                                        shadcn-vue
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 512 512"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill="#5470c6" d="M120 454L55 352l128-228 73 130-136 200z" />
                                            <path fill="#91cc75" d="M256 58l-73 130 136 200 65-102L256 58z" />
                                            <path fill="#fac858" d="M392 454l65-102-128-228-73 130 136 200z" />
                                        </svg>
                                        Apache eCharts
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 24 24" xmlns="http://w3.org">
                                            <!-- Right Leaf -->
                                            <path fill="#7EB03C"
                                                d="M11.5 2.5c0 0 7.5 1 9.5 9s-2 10-2 10-6.5-1-8.5-8.5 1-10.5 1-10.5z" />
                                            <!-- Left Leaf -->
                                            <path fill="#99C04F"
                                                d="M12.5 2.5c0 0-7.5 1-9.5 9s2 10 2 10 6.5-1 8.5-8.5-1-10.5-1-10.5z" />
                                        </svg>
                                        Leaflet
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 256 256" xmlns="http://w3.org">
                                            <path fill="currentColor"
                                                d="M128 32l96 160H32L128 32zm0 37.33L67.2 165.33h121.6L128 69.33z" />
                                        </svg>
                                        ThreeJS
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 256 256" xmlns="http://w3.org"
                                            preserveAspectRatio="xMidYMid">
                                            <path fill="#CB3837" d="M0 0h256v256H0z" />
                                            <path fill="#FFF" d="M48 48h160v160h-32V80h-32v128H48z" />
                                        </svg>
                                        npm
                                    </div>

                                </div>
                            </ui>

                            <ui class="relative flex items-center gap-4 py-2 before:absolute before:top-0 before:bottom-0
                                before:left-[1.2rem] before:border-l before:border-[#e3e3e0]
                                dark:before:border-[#3E3E3A]">
                                <span class="relative py-1">
                                    <span
                                        class="flex h-10 w-10 items-center justify-center rounded-full border-2 border-[#e3e3e0] bg-[#FDFDFC] shadow-[0px_0px_1px_0px_rgba(0,0,0,0.03),0px_1px_2px_0px_rgba(0,0,0,0.06)] dark:border-[#3E3E3A] dark:bg-[#161615]">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://w3.org">
                                            <!-- Server/Database Layer -->
                                            <path d="M4 6h16M4 12h16M4 18h16" stroke="#34D399" stroke-width="2.5"
                                                stroke-linecap="round" />
                                            <!-- Processing/Gear Logic -->
                                            <circle cx="12" cy="12" r="3" stroke="#FBBF24" stroke-width="2.5" />
                                            <path d="M12 8V6M12 18v-2M8 12H6m12 0h-2" stroke="#FBBF24"
                                                stroke-width="2.5" stroke-linecap="round" />
                                        </svg>
                                    </span>
                                </span>
                                <p class=" text-2xl text-gray-500 nunito-sans-100 font-bold">
                                    Back End Stack
                                </p>
                                <div class="p-3 flex flex-wrap gap-2">
                                    <div class="flex gap-2 rounded-md p-3 border border-amber-600">
                                        <svg width="20" height="20" viewBox="0 0 24 24" xmlns="http://w3.org">
                                            <path fill="#FF2D20"
                                                d="M19.333 4.125h-5.25v2.25h2.25v13.5h-10.5v-3.375h-2.25v3.375c0 .414.336.75.75.75h14.25c.414 0 .75-.336.75-.75V4.875c0-.414-.336-.75-.75-.75zm-6-2.25H2.333v13.5h2.25v-10.5h10.5v2.25h2.25V2.625c0-.414-.336-.75-.75-.75H13.333z" />
                                        </svg>
                                        Laravel
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 24 24" xmlns="http://w3.org">
                                            <path fill="#000000"
                                                d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm5.068 18.23c-1.396.657-3.05 1.01-4.72 1.01-4.14 0-7.394-2.583-7.394-6.43 0-3.336 2.45-6.195 6.452-6.195 1.63 0 2.97.4 3.99 1.03l-.78 1.93c-.88-.47-1.84-.71-2.94-.71-2.61 0-4.09 1.84-4.09 4.01 0 2.49 2.05 3.96 4.88 3.96.95 0 1.95-.19 2.76-.54l-.06-3.14h-2.31v-1.85h4.26l.1 6.87z" />
                                        </svg>
                                        Symfony
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">

                                        Socialite
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">

                                        Fortify
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">

                                        PhP Artisan
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 24 24" xmlns="http://w3.org">
                                            <path fill="#5E4E3C"
                                                d="M12.4 2.8c-1 .3-1.6 1.4-1.3 2.4.2.8.9 1.3 1.7 1.3.1 0 .2 0 .4-.1.4 1.1.2 2.3-.5 3.3l-.3.4c-.6.8-1.5 1.3-2.5 1.3h-.5c-.8 0-1.5-.4-1.9-1.1-.1-.2-.2-.4-.2-.7 0-.5.2-.9.5-1.3l.3-.4c.7-1 1-2.2.8-3.4-.2-1.1-1.1-2-2.3-2.1-1.3-.2-2.5.8-2.6 2.1-.1.7.2 1.4.7 1.9.3.3.7.5 1.1.6-.2 1.5-.9 2.8-2 3.8-.5.5-.8 1.1-.9 1.8 0 .8.3 1.5.8 2 .9.9 2.1 1.4 3.4 1.4h.8c1.3 0 2.5-.5 3.4-1.4.5-.5.8-1.2.8-2 0-.7-.3-1.3-.8-1.8-1.1-1-1.8-2.3-2-3.8.4-.1.8-.3 1.1-.6.5-.5.8-1.2.7-1.9-.1-1.3-1.3-2.3-2.6-2.1z" />
                                            <path fill="#755839"
                                                d="M12 21.2c-4.4 0-8-3.6-8-8 0-1.1.2-2.1.6-3.1 1.1-1 1.8-2.3 2-3.8-.4.1-.8.3-1.1.6-.5.5-.8 1.2-.7 1.9.1 1.3 1.3 2.3 2.6 2.1 1.2-.1 2.1-1 2.3-2.1.2-1.2-.1-2.4-.8-3.4L8.6 5c-.3.4-.5.8-.5 1.3 0 .3.1.5.2.7.4.7 1.1 1.1 1.9 1.1h.5c1 0 1.9-.5 2.5-1.3l.3-.4c.7-1 .9-2.2.5-3.3-.2.1-.3.1-.4.1-.8 0-1.5-.5-1.7-1.3-.3-1 .3-2.1 1.3-2.4 1.3-.3 2.5.7 2.6 2.1.1.7-.2 1.4-.7 1.9-.3.3-.7.5-1.1.6.2 1.5.9 2.8 2 3.8-.4 1-1.2 1.8-2.2 2.3.4 1 1.2 1.8 2.2 2.3-.4 1.1-.6 2.3-.6 3.5 0 4.4-3.6 8-8 8z" />
                                        </svg>
                                        Composer
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 24 24" xmlns="http://w3.org">
                                            <path fill="#00758F"
                                                d="M12.24 2c-4.22 0-7.85 2.15-7.85 4.8 0 .44.11.86.3 1.25-.45.34-.84.74-1.15 1.18-.8 1.15-1.04 2.58-.69 4.03.35 1.45 1.27 2.65 2.59 3.38.3.17.61.31.93.43-.01.12-.02.24-.02.37 0 2.21 1.79 4 4 4 1.1 0 2.1-.45 2.83-1.17.47.11.95.17 1.45.17 3.31 0 6-2.69 6-6V6.8c0-2.65-3.63-4.8-7.85-4.8l-.54.01v.01zM12 18.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5zm6.5-6.17c-.37.33-.8.61-1.27.83-.8.37-1.7.57-2.65.57-.46 0-.91-.05-1.34-.14-.26-.06-.51-.13-.76-.23-.6-.24-1.14-.59-1.59-1.03-.43-.43-.76-.94-.96-1.51-.2-.57-.29-1.18-.26-1.8.03-.62.18-1.23.44-1.8.26-.57.62-1.08 1.08-1.51.46-.43 1-.77 1.6-1.01.6-.24 1.25-.37 1.91-.37s1.31.13 1.91.37c.6.24 1.14.58 1.6 1.01.46.43.82.94 1.08 1.51.26.57.41 1.18.44 1.8.03.62-.06 1.23-.26 1.8-.2.57-.53 1.08-.96 1.51z" />
                                        </svg>
                                        mySQL
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 24 24" xmlns="http://w3.org">
                                            <path fill="#003545"
                                                d="M12.12 2C8.16 2 4.93 4.23 4.93 6.98c0 .35.05.7.15 1.03-.83 1.15-.99 2.65-.43 4.04.57 1.41 1.93 2.38 3.52 2.61.01.21.03.41.08.6.17.65.51 1.22.97 1.66.75.7 1.77 1.08 2.9 1.08.43 0 .86-.06 1.26-.17.72.71 1.73 1.15 2.85 1.15 2.21 0 4-1.79 4-4v-8C20.21 4.23 16.58 2 12.62 2l-.5-.01V2zM12 16.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" />
                                        </svg>
                                        MariaDB
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 24 24" xmlns="http://w3.org">
                                            <path fill="#336791"
                                                d="M12.1 2c-.3 0-.5.1-.7.2-2.3 1.1-4 3.3-4.5 5.8-.1.4-.1.8-.1 1.2 0 .4.1.7.2 1.1.2.6.5 1.1.9 1.5.3.3.6.6 1 .8.4.2.8.3 1.2.4.4.1.8.1 1.2.1.8 0 1.5-.1 2.2-.4.7-.3 1.3-.7 1.7-1.3.4-.6.7-1.3.8-2.1.1-.7.1-1.5-.1-2.2-.2-.7-.5-1.4-.9-2-.4-.6-.9-1.1-1.5-1.5-.6-.4-1.2-.7-1.9-.9-.7-.3-1.4-.4-2.1-.4-.4 0-.8 0-1.1.1 1.5-1.4 3.7-2.1 5.9-1.8.9.1 1.8.4 2.6.8.8.4 1.5 1 2.1 1.7.6.7 1 1.5 1.2 2.4.2.9.3 1.8.1 2.7-.2.9-.5 1.8-1.1 2.5s-1.2 1.3-2 1.8c-.8.5-1.7.8-2.6 1-.9.2-1.8.2-2.7.1-.4 0-.8-.1-1.2-.2 1.3.8 2.8 1.2 4.4 1.1 1.2-.1 2.4-.4 3.4-1.1 1-.6 1.9-1.5 2.5-2.5.6-1.1.9-2.3 1-3.6 0-1.3-.3-2.5-.9-3.6-.6-1.1-1.5-2.1-2.5-2.8C18.6 3.1 17.3 2.5 16 2.2c-1.3-.3-2.6-.3-3.9-.2z" />
                                        </svg>
                                        PostGres
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 24 24" xmlns="http://w3.org">
                                            <path fill="#D82C20"
                                                d="M21.6 12.3c0-.4-.2-.8-.6-1l-8.4-4.6c-.4-.2-.8-.2-1.2 0L3 11.3c-.4.2-.6.6-.6 1s.2.8.6 1l8.4 4.6c.2.1.4.2.6.2s.4-.1.6-.2l8.4-4.6c.4-.2.6-.6.6-1zM12 15.3l-6.1-3.3L12 8.7l6.1 3.3L12 15.3zm9.6-7c0-.4-.2-.8-.6-1L12.6 2.7c-.4-.2-.8-.2-1.2 0L3 7.3c-.4.2-.6.6-.6 1s.2.8.6 1l2.4 1.3 1.2-.6L5.4 9 12 5.4 18.6 9l-1.2.7 1.2.6 2.4-1.3c.4-.2.6-.6.6-1zm0 8.6c0-.4-.2-.8-.6-1l-2.4-1.3-1.2.7 1.2.6 1.2.7-6.6 3.6-6.6-3.6 1.2-.7-1.2-.6-2.4 1.3c-.4.2-.6.6-.6 1s.2.8.6 1l8.4 4.6c.2.1.4.2.6.2s.4-.1.6-.2l8.4-4.6c.4-.2.6-.6.6-1z" />
                                        </svg>
                                        Redis
                                    </div>

                                </div>
                            </ui>

                            <ui class="relative flex items-center gap-4 py-2 before:absolute before:top-0 before:bottom-0
                                before:left-[1.2rem] before:border-l before:border-[#e3e3e0]
                                dark:before:border-[#3E3E3A]">
                                <span class="relative py-1">
                                    <span
                                        class="flex h-10 w-10 items-center justify-center rounded-full border-2 border-[#e3e3e0] bg-[#FDFDFC] shadow-[0px_0px_1px_0px_rgba(0,0,0,0.03),0px_1px_2px_0px_rgba(0,0,0,0.06)] dark:border-[#3E3E3A] dark:bg-[#161615]">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://w3.org">
                                            <!-- Wrench (Utility/Setup) -->
                                            <path
                                                d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.7-3.7a2.1 2.1 0 0 0-3-3l-3.7 3.7z"
                                                fill="#94A3B8" />
                                            <path d="M18.3 10.6L13.4 15.5a4 4 0 1 1-5.6-5.6l4.9-4.9" stroke="#94A3B8"
                                                stroke-width="2.5" stroke-linecap="round" />
                                            <!-- Screwdriver (Fine-tuning/Code) -->
                                            <path d="M4.5 16.5L11 10" stroke="#F87171" stroke-width="2.5"
                                                stroke-linecap="round" />
                                            <path d="M3 21l3-3" stroke="#F87171" stroke-width="3"
                                                stroke-linecap="round" />
                                        </svg>
                                    </span>
                                </span>
                                <p class=" text-2xl text-gray-500 nunito-sans-100 font-bold">
                                    Coding Tools
                                </p>
                                <div class="p-3 flex flex-wrap gap-2">
                                    <div class="flex gap-2 rounded-md p-3 border border-amber-600">
                                        <svg width="20" height="20" viewBox="0 0 128 128" xmlns="http://w3.org">
                                            <path fill="#007ACC" d="M102.3 16.7L18.4 64l83.9 47.3V16.7z" />
                                            <path fill="#1F9CF0"
                                                d="M102.3 16.7L81.7 2.3c-2.3-1.6-5.5-1.1-7.2 1.1L35.8 51.5l38.7 12.5 27.8-47.3z" />
                                            <path fill="#1F9CF0"
                                                d="M102.3 111.3L81.7 125.7c-2.3 1.6-5.5 1.1-7.2-1.1L35.8 76.5l38.7-12.5 27.8 47.3z" />
                                            <path fill="#0065A9"
                                                d="M35.8 51.5L8.5 31.6c-2.1-1.5-5-.9-6.4 1.3L.7 35.2c-1 1.6-1 3.7 0 5.3l15.6 23.5-15.6 23.5c-1 1.6-1 3.7 0 5.3l1.4 2.3c1.4 2.2 4.3 2.8 6.4 1.3l27.3-19.9V51.5z" />
                                        </svg>
                                        VSCode
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://w3.org">
                                            <path
                                                d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z"
                                                fill="url(#copilot_gradient)" />
                                            <path
                                                d="M16 11.5C16 13.9853 13.9853 16 11.5 16C9.01472 16 7 13.9853 7 11.5C7 9.01472 9.01472 7 11.5 7C13.9853 7 16 9.01472 16 11.5Z"
                                                fill="white" fill-opacity="0.3" />
                                            <defs>
                                                <linearGradient id="copilot_gradient" x1="2" y1="2" x2="22" y2="22"
                                                    gradientUnits="userSpaceOnUse">
                                                    <stop stop-color="#3ACEF9" />
                                                    <stop offset="0.33" stop-color="#1167B1" />
                                                    <stop offset="0.66" stop-color="#A259FF" />
                                                    <stop offset="1" stop-color="#FF5F5F" />
                                                </linearGradient>
                                            </defs>
                                        </svg>
                                        Copilot
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 24 24" xmlns="http://w3.org">
                                            <path fill="#460CF1"
                                                d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm0 18.75c-3.728 0-6.75-3.022-6.75-6.75S8.272 5.25 12 5.25s6.75 3.022 6.75 6.75-3.022 6.75-6.75 6.75z" />
                                        </svg>
                                        Insomnia
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 24 24" xmlns="http://w3.org">
                                            <path fill="#2496ED"
                                                d="M13.983 11.078h2.119c.102 0 .186.084.186.186v2.119a.186.186 0 0 1-.186.186h-2.119a.185.185 0 0 1-.185-.186v-2.119c0-.102.083-.186.185-.186zm-2.954-2.565h2.118c.103 0 .187.083.187.186v2.119a.186.186 0 0 1-.187.186h-2.118a.185.185 0 0 1-.185-.186V8.699c0-.103.083-.186.185-.186zm0 2.565h2.118c.103 0 .187.084.187.186v2.119a.186.186 0 0 1-.187.186h-2.118a.185.185 0 0 1-.185-.186v-2.119c0-.102.083-.186.185-.186zm-2.954 0h2.119c.102 0 .185.084.185.186v2.119a.186.186 0 0 1-.185.186H8.075a.186.186 0 0 1-.186-.186v-2.119c0-.102.084-.186.186-.186zm5.908-2.565h2.118c.103 0 .187.083.187.186v2.119a.186.186 0 0 1-.187.186h-2.118a.185.185 0 0 1-.185-.186V8.699c0-.103.083-.186.185-.186zm-2.954-2.565h2.119c.102 0 .185.084.185.186v2.119a.186.186 0 0 1-.185.186h-2.119a.186.186 0 0 1-.186-.186V6.134c0-.102.084-.186.186-.186zm-2.954 0h2.118c.103 0 .187.084.187.186v2.119a.186.186 0 0 1-.187.186h-2.118a.185.185 0 0 1-.185-.186V6.134c0-.102.083-.186.185-.186zm-2.954 0h2.119c.102 0 .185.084.185.186v2.119a.186.186 0 0 1-.185.186H5.12c-.102 0-.185-.084-.185-.186V6.134c0-.102.083-.186.185-.186zm-2.954 0h2.119c.102 0 .185.084.185.186v2.119a.186.186 0 0 1-.185.186H2.165c-.102 0-.185-.084-.185-.186V6.134c0-.102.083-.186.185-.186zm0 2.565h2.119c.102 0 .185.084.185.186v2.119a.186.186 0 0 1-.185.186H2.165c-.102 0-.185-.084-.185-.186v-2.119c0-.102.083-.186.185-.186zm0 2.565h2.119c.102 0 .185.084.185.186v2.119a.186.186 0 0 1-.185.186H2.165c-.102 0-.185-.084-.185-.186v-2.119c0-.102.083-.186.185-.186zm16.174-2.565c-.34.004-.736.096-1.136.21a4.4 4.4 0 0 0 .606 2.354c.712.051 1.46.076 2.237.076.127 0 .23-.103.23-.23V8.699a2.384 2.384 0 0 0-1.937-2.565zM.001 13.988c.056 1.539.46 3.049 1.14 4.407.359.714.884 1.354 1.454 1.83 2.383 2 6.993 2.018 10.636 2.018 7.707 0 10.628-2.31 10.628-6.134 0-.046-.014-.096-.042-.132l-.419-.552c-.157-.206-.46-.225-.6-.033-1.164 1.618-3.01 2.126-4.838 2.063-4.69-.164-6.684-2.519-6.684-2.519l-.339-.34a.188.188 0 0 0-.26 0l-.35.35s-2.044 2.203-6.706 2.1c-1.312-.029-2.5-.531-3.51-1.077z" />
                                        </svg>
                                        Docker
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 24 24" xmlns="http://w3.org">
                                            <path fill="#F05032"
                                                d="M23.546 10.93L13.067.452a1.49 1.49 0 0 0-2.135 0l-1.957 1.957 2.532 2.532a1.5 1.5 0 0 1 2.11 2.11l2.544 2.544a1.5 1.5 0 1 1-1.06 1.06l-2.544-2.544v5.185a1.5 1.5 0 1 1-1.5 0V8.213L8.513 5.67l-8.06 8.06a1.49 1.49 0 0 0 0 2.135l10.479 10.479a1.49 1.49 0 0 0 2.135 0l10.479-10.479a1.49 1.49 0 0 0 0-2.135z" />
                                        </svg>
                                        Git
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 24 24" xmlns="http://w3.org">
                                            <path fill="currentColor"
                                                d="M12 2C6.477 2 2 6.477 2 12c0 4.42 2.865 8.17 6.839 9.49.5.092.682-.218.682-.484 0-.236-.009-.866-.014-1.699-2.782.605-3.369-1.34-3.369-1.34-.454-1.156-1.11-1.464-1.11-1.464-.908-.62.069-.608.069-.608 1.003.07 1.531 1.03 1.531 1.03.892 1.529 2.341 1.087 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.11-4.555-4.943 0-1.091.39-1.984 1.029-2.683-.103-.253-.446-1.27.098-2.647 0 0 .84-.269 2.75 1.025A9.578 9.578 0 0112 6.836c.85.004 1.705.114 2.504.336 1.909-1.294 2.747-1.025 2.747-1.025.546 1.377.202 2.394.1 2.647.64.699 1.028 1.592 1.028 2.683 0 3.842-2.339 4.687-4.566 4.935.359.309.678.919.678 1.852 0 1.336-.012 2.415-.012 2.743 0 .267.18.578.688.48C19.138 20.161 22 16.416 22 12c0-5.523-4.477-10-10-10z" />
                                        </svg>
                                        Github
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://w3.org">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm4.5 13.5l-1.5 1.5-3-3-3 3-1.5-1.5 3-3-3-3 1.5-1.5 3 3 3-3 1.5 1.5-3 3 3 3z"
                                                fill="#FF2D20" />
                                        </svg>
                                        Herd
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 24 24" xmlns="http://w3.org">
                                            <!-- The main XAMPP Orange rounded square -->
                                            <rect width="24" height="24" rx="4" fill="#fb7a24" />
                                            <!-- The characteristic white "X" arrows -->
                                            <path
                                                d="M7 7l3.5 5L7 17h2.5l2.25-3.25L14 17h2.5l-3.5-5 3.5-5h-2.5L12.25 10.25 10 7H7z"
                                                fill="#ffffff" />
                                            <!-- The small white circles in the corners -->
                                            <circle cx="5" cy="5" r="1.2" fill="#ffffff" />
                                            <circle cx="19" cy="5" r="1.2" fill="#ffffff" />
                                            <circle cx="5" cy="19" r="1.2" fill="#ffffff" />
                                            <circle cx="19" cy="19" r="1.2" fill="#ffffff" />
                                        </svg>
                                        XAMPP
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 24 24" xmlns="http://w3.org">
                                            <!-- The characteristic phpMyAdmin blue/orange globe -->
                                            <path fill="#6c78af"
                                                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2z" />
                                            <path fill="#f3921f" d="M12 4c-4.41 0-8 3.59-8 8s3.59 8 8 8V4z" />
                                            <!-- The stylized 'pMA' letters -->
                                            <path fill="#ffffff"
                                                d="M7 9h2v6H7V9zm3 0h3c1.1 0 2 .9 2 2v1c0 1.1-.9 2-2 2h-1v2h-2V9zm2 2v2h1v-2h-1zm4-2h4v2h-4v1h3v2h-3v1h4v2h-6V9z" />
                                        </svg>
                                        myPHPAdmin
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 256 256" xmlns="http://w3.org">
                                            <!-- Adminer "Diamond/Grid" stylized logo -->
                                            <path fill="#45668e" d="M128 0L32 96l96 160 96-160L128 0z" />
                                            <path fill="#ffffff" fill-opacity="0.3" d="M128 40L64 104h128L128 40z" />
                                            <path fill="#ffffff" fill-opacity="0.1" d="M128 210l60-100H68l60 100z" />
                                        </svg>
                                        Adminer
                                    </div>
                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 24 24" xmlns="http://w3.org">
                                            <!-- The Tray -->
                                            <path fill="#BCBBBB" d="M18 15v4H6v-4H4v6h16v-6h-2z" />
                                            <!-- The Stacked Bars -->
                                            <path fill="#F48024"
                                                d="M8 12.5h8v2H8v-2zm.4-3.2l7.7 2 1 1.7-7.7-2-1-1.7zm1.8-3.1l6.8 4 1.3-1.3-6.8-4-1.3 1.3zm3-2.5l5.2 5.9 1.7-.8-5.2-5.9-1.7.8z" />
                                        </svg>
                                        Stackoverflow
                                    </div>
                                </div>
                            </ui>

                            <ui class="relative flex items-center gap-4 py-2 before:absolute before:top-0 before:bottom-0
                                before:left-[1.2rem] before:border-l before:border-[#e3e3e0]
                                dark:before:border-[#3E3E3A]">
                                <span class="relative py-1">
                                    <span
                                        class="flex h-10 w-10 items-center justify-center rounded-full border-2 border-[#e3e3e0] bg-[#FDFDFC] shadow-[0px_0px_1px_0px_rgba(0,0,0,0.03),0px_1px_2px_0px_rgba(0,0,0,0.06)] dark:border-[#3E3E3A] dark:bg-[#161615]">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://w3.org">
                                            <!-- Rocket (Ship/Launch) -->
                                            <path d="M12 2s.5 4 0 7c-3 0-7-.5-7-.5L12 2z" fill="#A78BFA" />
                                            <path d="M12 2s-.5 4 0 7c3 0 7-.5 7-.5L12 2z" fill="#8B5CF6" />
                                            <!-- Launch Base / Platform -->
                                            <path d="M5 20h14" stroke="#FFFFFF" stroke-width="2.5"
                                                stroke-linecap="round" />
                                            <!-- Blast Off / Smoke -->
                                            <path d="M9 16l-2 2M15 16l2 2M12 15v4" stroke="#F87171" stroke-width="2"
                                                stroke-linecap="round" />
                                        </svg>
                                    </span>
                                </span>
                                <p class=" text-2xl text-gray-500 nunito-sans-100 font-bold">
                                    Deployment
                                </p>
                                <div class="p-3 flex flex-wrap gap-2">
                                    <div class="flex gap-2 rounded-md p-3 border border-amber-600">
                                        <svg width="20" height="20" viewBox="0 0 24 24" xmlns="http://w3.org">
                                            <!-- AWS Smile Arrow (Official Orange) -->
                                            <path fill="#FF9900"
                                                d="M19.3 16.5c-2.4 1.7-5.5 2.1-8.3 1.1-2.1-.7-3.9-2.1-5-4-.2-.3-.5-.1-.4.2.8 1.8 2.2 3.2 3.9 4 3 1.4 6.6 1.2 9.4-.5.3-.2.4-.6.1-.8-.1-.1-.4-.2-.7 0z" />
                                            <path fill="#FF9900"
                                                d="M20 14.8c-.2-.3-.6-.3-.8 0l-.8 1c-.1.2-.1.5.1.7.3.3.7.3 1 0l.8-1c.1-.2.1-.5-.3-.7z" />
                                            <!-- "aws" Lettering (White for Dark Mode) -->
                                            <path fill="#FFFFFF"
                                                d="M5.5 13.1c-.8 0-1.2-.4-1.2-1 0-.7.5-1.1 1.2-1.1.7 0 1.2.4 1.2 1.1 0 .6-.4 1-1.2 1zm0-3.3c-1.3 0-2.3.9-2.3 2.3s1 2.3 2.3 2.3c.7 0 1.4-.3 1.8-.8v.6h1.1V8.3H7.3v.7c-.4-.5-1.1-.7-1.8-.7zm6.7.7c-.5 0-.9.3-.9.9v3.1h1.1v-2.8c0-.4.2-.6.5-.6.4 0 .6.2.6.6v2.8h1.1v-3.1c0-.9-.6-1.4-1.4-1.4-.4 0-.8.2-1 .5-.2-.3-.6-.5-1-.5zm5.7 0c-.8 0-1.4.4-1.6 1.1l-.1-.9h-1.1v4.4h1.1v-2c0-.7.3-1.1.9-1.1s.9.4.9 1.1v2h1.1v-2.3c0-1.3-.7-2.3-2.1-2.3z" />
                                        </svg>
                                        AWS EC2
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://w3.org">
                                            <!-- Outer Square structure (Google Cloud Blue) -->
                                            <path d="M2 7L12 2l10 5v10l-10 5-10-5V7z" fill="#4285F4" />
                                            <!-- Inner Circuitry/Grid (White for Dark Mode Contrast) -->
                                            <path d="M12 6L7 8.5v7l5 2.5 5-2.5v-7L12 6z" fill="#FFFFFF" />
                                            <!-- Central Core (Google Blue) -->
                                            <path d="M12 9l-3 1.5v3l3 1.5 3-1.5v-3L12 9z" fill="#4285F4" />
                                        </svg>
                                        Google Compute Engine
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://w3.org">
                                            <!-- Main VM Box (Azure Blue) -->
                                            <path d="M3 6l9-4 9 4v12l-9 4-9-4V6z" fill="#0078D4" />
                                            <!-- "Virtual" Screen Layer (White for Dark Mode Contrast) -->
                                            <path d="M7 8h10v7H7V8z" fill="#FFFFFF" />
                                            <!-- Screen Content Detail -->
                                            <path d="M9 10h6v3H9v-3z" fill="#0078D4" />
                                            <!-- Front Perspective Edge (Darker Blue) -->
                                            <path d="M12 22l-9-4V6l9 4v12z" fill="#005A9E" fill-opacity="0.3" />
                                        </svg>
                                        Azure VM
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://w3.org">
                                            <!-- The Render "R" Ribbon -->
                                            <path
                                                d="M19 4H5C3.34315 4 2 5.34315 2 7V17C2 18.6569 3.34315 20 5 20H19C20.6569 20 22 18.6569 22 17V7C22 5.34315 20.6569 4 19 4Z"
                                                fill="#46E3B7" />
                                            <path
                                                d="M8 8V16M8 8H12C13.1046 8 14 8.89543 14 10C14 11.1046 13.1046 12 12 12H8M12 12L15 16"
                                                stroke="white" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                        Render.com
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://w3.org">
                                            <!-- The Railway "R" track icon -->
                                            <path d="M4 4V20H20V12H12V20M12 12V4H20" stroke="white" stroke-width="2.5"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        Railway.com
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 24 24" xmlns="http://w3.org">
                                            <path d="M12 1L24 22H0L12 1Z" fill="#FFFFFF" />
                                        </svg>
                                        Vercel
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://w3.org">
                                            <!-- The Netlify Geometric Diamond -->
                                            <path
                                                d="M12.012 1.488l-3.324 6.648L2 11.46l6.688 3.324 3.324 6.648 3.324-6.648 6.688-3.324-6.688-3.324-3.324-6.648z"
                                                fill="#00C7B7" />
                                            <!-- Inner Detail (White for Dark Mode Contrast) -->
                                            <path d="M12.012 7.5l-1.5 3 1.5 1.5 1.5-1.5-1.5-3z" fill="white" />
                                        </svg>
                                        Netlify
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 24 24" xmlns="http://w3.org">
                                            <!-- Docker Whale (White for Dark Mode) -->
                                            <path fill="#FFFFFF"
                                                d="M13.983 11.078h2.119c.102 0 .186.084.186.186v2.119a.186.186 0 0 1-.186.186h-2.119a.185.185 0 0 1-.185-.186v-2.119c0-.102.083-.186.185-.186zm-2.954-2.565h2.118c.103 0 .187.083.187.186v2.119a.186.186 0 0 1-.187.186h-2.118a.185.185 0 0 1-.185-.186V8.699c0-.103.083-.186.185-.186zm0 2.565h2.118c.103 0 .187.084.187.186v2.119a.186.186 0 0 1-.187.186h-2.118a.185.185 0 0 1-.185-.186v-2.119c0-.102.083-.186.185-.186zm-2.954 0h2.119c.102 0 .185.084.185.186v2.119a.186.186 0 0 1-.185.186H8.075a.186.186 0 0 1-.186-.186v-2.119c0-.102.084-.186.186-.186zm5.908-2.565h2.118c.103 0 .187.083.187.186v2.119a.186.186 0 0 1-.187.186h-2.118a.185.185 0 0 1-.185-.186V8.699c0-.103.083-.186.185-.186zm-2.954-2.565h2.119c.102 0 .185.084.185.186v2.119a.186.186 0 0 1-.185.186h-2.119a.186.186 0 0 1-.186-.186V6.134c0-.102.084-.186.186-.186zm-2.954 0h2.118c.103 0 .187.084.187.186v2.119a.186.186 0 0 1-.187.186h-2.118a.185.185 0 0 1-.185-.186V6.134c0-.102.083-.186.185-.186zm-2.954 0h2.119c.102 0 .185.084.185.186v2.119a.186.186 0 0 1-.185.186H5.12c-.102 0-.185-.084-.185-.186V6.134c0-.102.083-.186.185-.186zm-2.954 0h2.119c.102 0 .185.084.185.186v2.119a.186.186 0 0 1-.185.186H2.165c-.102 0-.185-.084-.185-.186V6.134c0-.102.083-.186.185-.186zm0 2.565h2.119c.102 0 .185.084.185.186v2.119a.186.186 0 0 1-.185.186H2.165c-.102 0-.185-.084-.185-.186v-2.119c0-.102.083-.186.185-.186zm0 2.565h2.119c.102 0 .185.084.185.186v2.119a.186.186 0 0 1-.185.186H2.165c-.102 0-.185-.084-.185-.186v-2.119c0-.102.083-.186.185-.186zm16.174-2.565c-.34.004-.736.096-1.136.21a4.4 4.4 0 0 0 .606 2.354c.712.051 1.46.076 2.237.076.127 0 .23-.103.23-.23V8.699a2.384 2.384 0 0 0-1.937-2.565zM.001 13.988c.056 1.539.46 3.049 1.14 4.407.359.714.884 1.354 1.454 1.83 2.383 2 6.993 2.018 10.636 2.018 7.707 0 10.628-2.31 10.628-6.134 0-.046-.014-.096-.042-.132l-.419-.552c-.157-.206-.46-.225-.6-.033-1.164 1.618-3.01 2.126-4.838 2.063-4.69-.164-6.684-2.519-6.684-2.519l-.339-.34a.188.188 0 0 0-.26 0l-.35.35s-2.044 2.203-6.706 2.1c-1.312-.029-2.5-.531-3.51-1.077z" />
                                        </svg>
                                        DockerHub
                                    </div>


                                </div>
                            </ui>

                        </ul>
                        <br>
                        <br>
                        <div class="w-[80%] h-[2px] border-b mx-auto"></div>
                    </div>
                    <ubtn @click="techStackClick"
                        class=" bg-transparent hover:bg-transparent p-0 mt-auto ml-auto mr-3 w-fit">
                        <span class="flex flex-row  hover:cursor-pointer text-white gap-2">
                            <i class=" text-red-800">Close</i> <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" viewBox="0 0 24 24" fill="none" stroke="#0357c4" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-chevron-right-icon lucide-chevron-right">
                                <path d="m9 18 6-6-6-6" />
                            </svg>
                        </span>
                    </ubtn>
                </div>
            </div>
        </section>

        <!-- AI Project -->
        <section class=" flex flex-col lg:flex-row section">
            <div class="panel left  w-full lg:w-[60vw] h-full overflow-visible p-4 flex flex-wrap gap-1 items-center justify-start ml-auto lg:p-20 "
                style="transition-delay: 1.3s;">
                <p class="text-2xl font-bold">Description</p>
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
                            Built with Laravel + Vue + Inertia
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
                class="panel right bg-red-800/10 backdrop-blur-sm border-t lg:border-l lg:border-l-white/20 bg-linear-to-br  from-red-800/20 to-yellow-600/40 w-full lg:w-[40vw] h-full overflow-hidden flex flex-col items-center justify-center">
                <div class="spotlight w-[100%] h-[100%] m-0 p-4 lg:p-20"
                    style="background: radial-gradient(2000px circle at var(--x) var(--y), rgba(255,255,255,0.2), transparent 10%);">
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
                    <button @click="chatbotClick">
                        <div
                            class="p-4 hover:bg-amber-600/10 hover:cursor-pointer border hover:shadow-2xl shadow-black border-amber-100 rounded-2xl">
                            <p class=" text-7xl font-semibold text-center">
                                AI Chatbot Platform</p>
                        </div>
                    </button>
                </div>
            </div>
            <!-- make shift dialog box -->
            <!-- // v-show="dialog1Open" -->
            <div ref="dlg_bg_show_chatbot"
                class="dialogbg-hidden absolute top-0 -z-1 flex flex-col lg:flex row text-center justify-center items-center bg-black w-full h-full bg-red-500/10 backdrop-blur-lg border-t lg:border-l lg:border-l-white/20 bg-linear-to-br  from-black/40 to-blue-800/40">
                <div ref="dlg_show_chatbot"
                    class="dialog-hidden w-screen lg:w-[70vw] h-[80vh] rounded-2xl flex flex-col bg-black border-2 shadow-2xl shadow-black p-4 overflow-hidden overflow-y-auto">
                    <div class=" text-justify text-shadow-blue-300">
                        <p class=" text-4xl font-extrabold font-stretch-condensed nunito-sans-100">
                            AI Chatbot Platform
                        </p>
                        <p class=" text-2xl text-gray-500 nunito-sans-100 font-extrabold">
                            The chatbot is instructed by the system to assume the role of an expert practitioner. The
                            bot waits for any user query and gives back the answer promptly. </p>
                        <br>
                        <p>
                            The AI chat bot employs a very fast AI model by Meta called Llama 4 scout. It can generate
                            intelligent conversational text and also accepts images as part of the input. The image
                            input will the be submitted from the chatbot server to a remote meta AI server through an
                            Open AI compatible protocol. The AI server will then analyze the image according to the
                            instruction of the user and answers back as soon as its inference engine is done
                            calculating. The response will be in a standard JSON format which will then be saved and
                            shown to the user.
                        </p>
                        <br>
                        <p class=" text-lg font-extrabold nunito-sans-100">
                            Tech Stack Employed
                        </p>
                        <ul class="ml-4">
                            <ui class="relative flex items-center gap-4 py-2 before:absolute before:top-0 before:bottom-0
                                before:left-[1.2rem] before:border-l before:border-[#e3e3e0]
                                dark:before:border-[#3E3E3A]">
                                <span class="relative py-1">
                                    <span
                                        class="flex h-10 w-10 items-center justify-center rounded-full border-2 border-[#e3e3e0] bg-[#FDFDFC] shadow-[0px_0px_1px_0px_rgba(0,0,0,0.03),0px_1px_2px_0px_rgba(0,0,0,0.06)] dark:border-[#3E3E3A] dark:bg-[#161615]">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://w3.org">
                                            <!-- Outer Circuit Hexagon -->
                                            <path d="M12 2L4 6.5v11L12 22l8-4.5v-11L12 2z" stroke="#38BDF8"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            <!-- Central Spark/Intelligence Core -->
                                            <path d="M12 8v8M8 12h8" stroke="#FFFFFF" stroke-width="2"
                                                stroke-linecap="round" />
                                            <!-- Neural Nodes -->
                                            <circle cx="12" cy="12" r="2" fill="#38BDF8" />
                                            <circle cx="12" cy="5" r="1.5" fill="#FFFFFF" />
                                            <circle cx="12" cy="19" r="1.5" fill="#FFFFFF" />
                                        </svg>
                                    </span>
                                </span>
                                <p class=" text-2xl text-gray-500 nunito-sans-100 font-bold">
                                    AI Models
                                </p>
                                <div class="p-3 flex flex-wrap gap-2">

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 24 24" xmlns="http://w3.org">
                                            <path fill="#0668E1"
                                                d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm4.184 14.646c-.52.52-1.36.52-1.88 0l-1.304-1.304c-.663.418-1.442.658-2.274.658-.832 0-1.61-.24-2.274-.658l-1.304 1.304c-.52.52-1.36.52-1.88 0-.52-.52-.52-1.36 0-1.88l1.304-1.304c-.418-.663-.658-1.442-.658-2.274 0-.832.24-1.61.658-2.274l-1.304-1.304c-.52-.52-.52-1.36 0-1.88.52-.52 1.36-.52 1.88 0l1.304 1.304c.663-.418 1.442-.658 2.274-.658.832 0 1.61.24 2.274.658l1.304-1.304c.52-.52 1.36-.52 1.88 0 .52.52.52 1.36 0 1.88l-1.304 1.304c.418.663.658 1.442.658 2.274 0 .832-.24 1.61-.658 2.274l1.304 1.304c.52.52.52 1.36 0 1.88z" />
                                        </svg>
                                        meta-llama/llama-4-scout
                                    </div>
                                </div>
                            </ui>

                            <ui class="relative flex items-center gap-4 py-2 before:absolute before:top-0 before:bottom-0
                                before:left-[1.2rem] before:border-l before:border-[#e3e3e0]
                                dark:before:border-[#3E3E3A]">
                                <span class="relative py-1">
                                    <span
                                        class="flex h-10 w-10 items-center justify-center rounded-full border-2 border-[#e3e3e0] bg-[#FDFDFC] shadow-[0px_0px_1px_0px_rgba(0,0,0,0.03),0px_1px_2px_0px_rgba(0,0,0,0.06)] dark:border-[#3E3E3A] dark:bg-[#161615]">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://w3.org">
                                            <!-- Code Brackets (HTML/Logic) -->
                                            <path d="M7 8l-4 4 4 4M17 8l4 4-4 4" stroke="#60A5FA" stroke-width="2.5"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <!-- Central Brush (Styling/UI) -->
                                            <path d="M14 4l-4 16" stroke="#F472B6" stroke-width="2.5"
                                                stroke-linecap="round" />
                                        </svg>
                                    </span>
                                </span>
                                <p class=" text-2xl text-gray-500 nunito-sans-100 font-bold">
                                    Front End Stack
                                </p>
                                <div class="p-3 flex flex-wrap gap-2">
                                    <div class="flex gap-2 rounded-md p-3 border border-amber-600">
                                        <svg width="20" height="20" viewBox="0 0 512 512" xmlns="http://w3.org">
                                            <path fill="#E34F26" d="M71,460 L37,0 475,0 441,460 256,512z" />
                                            <path fill="#EF652A" d="M256,472 L405,431 431,73 256,73z" />
                                            <path fill="#EBEBEB"
                                                d="M256,208 L181,208 176,150 256,150 256,94 115,94 125,213 130,265 256,265z M256,355 L255,355 192,338 188,293 132,293 140,381 256,412z" />
                                            <path fill="#FFFFFF"
                                                d="M256,208 L256,265 325,265 318,337 256,354 256,412 371,381 372,370 384,213 385,208z M256,94 L256,150 392,150 397,94z" />
                                        </svg>
                                        HTML
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 512 512" xmlns="http://w3.org">
                                            <path fill="#264DE4" d="M71,460 L37,0 475,0 441,460 256,512z" />
                                            <path fill="#2965F1" d="M256,472 L405,431 431,73 256,73z" />
                                            <path fill="#EBEBEB"
                                                d="M256,151 L177,151 181,208 256,208 256,265 185,265 189,313 256,331 256,389 140,357 127,213 125,188 122,94 256,94z" />
                                            <path fill="#FFFFFF"
                                                d="M256,151 L256,94 390,94 388,119 380,213 376,265 256,265 256,208 319,208 323,151z M256,331 L256,389 372,357 384,208 385,208 377,293 320,311z" />
                                        </svg>
                                        CSS
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 24 24" xmlns="http://w3.org">
                                            <path fill="#38bdf8"
                                                d="M12.001 4.8c-3.2 0-5.2 1.6-6 4.8 1.2-1.6 2.6-2.2 4.2-1.8 0.913 0.228 1.565 0.89 2.288 1.624C13.666 10.618 15.027 12 18.001 12c3.2 0 5.2-1.6 6-4.8-1.2 1.6-2.6 2.2-4.2 1.8-0.913-0.228-1.565-0.89-2.288-1.624C16.337 6.182 14.976 4.8 12.001 4.8zm-6 7.2c-3.2 0-5.2 1.6-6 4.8 1.2-1.6 2.6-2.2 4.2-1.8 0.913 0.228 1.565 0.89 2.288 1.624 1.177 1.194 2.538 2.576 5.512 2.576 3.2 0 5.2-1.6 6-4.8-1.2 1.6-2.6 2.2-4.2 1.8-0.913-0.228-1.565-0.89-2.288-1.624C8.337 13.382 6.976 12 4.001 12z" />
                                        </svg>
                                        Tailwind CSS
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 630 630" xmlns="http://w3.org">
                                            <rect width="630" height="630" fill="#f7df1e" />
                                            <path
                                                d="m423.2 492.19c12.69 20.72 29.2 35.95 58.4 35.95 24.53 0 40.2-12.26 40.2-29.2 0-20.3-16.1-27.49-43.1-39.3l-14.8-6.35c-42.72-18.2-71.1-41-71.1-89.2 0-44.4 33.83-77.23 86.63-77.23 37.64 0 64.7 14.38 84.18 47.38l-46.1 29.6c-10.15-18.2-21.1-25.37-38.1-25.37-17.34 0-28.33 9.3-28.33 21.15 0 16.5 10.15 23.26 36.37 34.68l14.8 6.34c54.55 23.26 79.1 42.3 79.1 94.3 0 54.55-43.6 81.65-95.6 81.65-49.5 0-77.02-22.84-93.53-52.13zm-215.1-5.11c12.69 21.6 27.06 37.3 54.1 37.3 21.6 0 35.53-10.57 35.53-50.76v-187.9h57.1v188.3c0 73.15-42.3 102.76-92.63 102.76-45.7 0-74-21.6-90.1-53.74z" />
                                        </svg>
                                        JavaScript
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 256 221" xmlns="http://w3.org">
                                            <path fill="#41B883"
                                                d="M204.8 0H256L128 220.8 0 0h51.2L128 132.48 204.8 0z" />
                                            <path fill="#35495E"
                                                d="M165.12 0H204.8L128 132.48 51.2 0h39.68L128 66.24 165.12 0z" />
                                        </svg>
                                        VueJS
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 24 24" xmlns="http://w3.org">
                                            <path fill="#9553E9"
                                                d="M11.5 5.5l6 6.5-6 6.5h4.5l6-6.5-6-6.5h-4.5zm-9 0l6 6.5-6 6.5h4.5l6-6.5-6-6.5h-4.5z" />
                                        </svg>
                                        InertiaJS
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://w3.org">
                                            <!-- Top Leaves (Green) -->
                                            <path
                                                d="M12 2c-.8 0-1.5.5-1.8 1.2C9.5 3 8.8 3.5 8.5 4.2c-.3.7-.2 1.5.2 2.1l3.3.2 3.3-.2c.4-.6.5-1.4.2-2.1-.3-.7-1-1.2-1.7-1-.3-.7-1-1.2-1.8-1.2z"
                                                fill="#606f21" />
                                            <!-- Body (Yellow) -->
                                            <path
                                                d="M12 6c-2.5 0-4.5 2-4.5 4.5 0 1 .3 1.9.9 2.6L4.5 20c-.3.6-.5 1.3-.5 2 0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2 0-.7-.2-1.4-.5-2l-3.9-6.9c.6-.7.9-1.6.9-2.6 0-2.5-2-4.5-4.5-4.5z"
                                                fill="#ffe066" />
                                            <!-- Eyes (Dark Green) -->
                                            <circle cx="10" cy="11.5" r="0.8" fill="#606f21" />
                                            <circle cx="14" cy="11.5" r="0.8" fill="#606f21" />
                                            <!-- Smile (Dark Green) -->
                                            <path d="M11 13.5c.3.3.7.5 1 .5s.7-.2 1-.5" stroke="#606f21"
                                                stroke-width="0.6" stroke-linecap="round" />
                                        </svg>
                                        Pinia
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://w3.org">
                                            <path d="M20 5L5 20M17 3L3 17" stroke="currentColor" stroke-width="3"
                                                stroke-linecap="round" />
                                        </svg>
                                        shadcn-vue
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 256 256" xmlns="http://w3.org"
                                            preserveAspectRatio="xMidYMid">
                                            <path fill="#CB3837" d="M0 0h256v256H0z" />
                                            <path fill="#FFF" d="M48 48h160v160h-32V80h-32v128H48z" />
                                        </svg>
                                        npm
                                    </div>

                                </div>
                            </ui>

                            <ui class="relative flex items-center gap-4 py-2 before:absolute before:top-0 before:bottom-0
                                before:left-[1.2rem] before:border-l before:border-[#e3e3e0]
                                dark:before:border-[#3E3E3A]">
                                <span class="relative py-1">
                                    <span
                                        class="flex h-10 w-10 items-center justify-center rounded-full border-2 border-[#e3e3e0] bg-[#FDFDFC] shadow-[0px_0px_1px_0px_rgba(0,0,0,0.03),0px_1px_2px_0px_rgba(0,0,0,0.06)] dark:border-[#3E3E3A] dark:bg-[#161615]">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://w3.org">
                                            <!-- Server/Database Layer -->
                                            <path d="M4 6h16M4 12h16M4 18h16" stroke="#34D399" stroke-width="2.5"
                                                stroke-linecap="round" />
                                            <!-- Processing/Gear Logic -->
                                            <circle cx="12" cy="12" r="3" stroke="#FBBF24" stroke-width="2.5" />
                                            <path d="M12 8V6M12 18v-2M8 12H6m12 0h-2" stroke="#FBBF24"
                                                stroke-width="2.5" stroke-linecap="round" />
                                        </svg>
                                    </span>
                                </span>
                                <p class=" text-2xl text-gray-500 nunito-sans-100 font-bold">
                                    Back End Stack
                                </p>
                                <div class="p-3 flex flex-wrap gap-2">
                                    <div class="flex gap-2 rounded-md p-3 border border-amber-600">
                                        <svg width="20" height="20" viewBox="0 0 24 24" xmlns="http://w3.org">
                                            <path fill="#FF2D20"
                                                d="M19.333 4.125h-5.25v2.25h2.25v13.5h-10.5v-3.375h-2.25v3.375c0 .414.336.75.75.75h14.25c.414 0 .75-.336.75-.75V4.875c0-.414-.336-.75-.75-.75zm-6-2.25H2.333v13.5h2.25v-10.5h10.5v2.25h2.25V2.625c0-.414-.336-.75-.75-.75H13.333z" />
                                        </svg>
                                        Laravel
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 24 24" xmlns="http://w3.org">
                                            <path fill="#000000"
                                                d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm5.068 18.23c-1.396.657-3.05 1.01-4.72 1.01-4.14 0-7.394-2.583-7.394-6.43 0-3.336 2.45-6.195 6.452-6.195 1.63 0 2.97.4 3.99 1.03l-.78 1.93c-.88-.47-1.84-.71-2.94-.71-2.61 0-4.09 1.84-4.09 4.01 0 2.49 2.05 3.96 4.88 3.96.95 0 1.95-.19 2.76-.54l-.06-3.14h-2.31v-1.85h4.26l.1 6.87z" />
                                        </svg>
                                        Symfony
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">

                                        Socialite
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">

                                        Fortify
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">

                                        PhP Artisan
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 24 24" xmlns="http://w3.org">
                                            <path fill="#5E4E3C"
                                                d="M12.4 2.8c-1 .3-1.6 1.4-1.3 2.4.2.8.9 1.3 1.7 1.3.1 0 .2 0 .4-.1.4 1.1.2 2.3-.5 3.3l-.3.4c-.6.8-1.5 1.3-2.5 1.3h-.5c-.8 0-1.5-.4-1.9-1.1-.1-.2-.2-.4-.2-.7 0-.5.2-.9.5-1.3l.3-.4c.7-1 1-2.2.8-3.4-.2-1.1-1.1-2-2.3-2.1-1.3-.2-2.5.8-2.6 2.1-.1.7.2 1.4.7 1.9.3.3.7.5 1.1.6-.2 1.5-.9 2.8-2 3.8-.5.5-.8 1.1-.9 1.8 0 .8.3 1.5.8 2 .9.9 2.1 1.4 3.4 1.4h.8c1.3 0 2.5-.5 3.4-1.4.5-.5.8-1.2.8-2 0-.7-.3-1.3-.8-1.8-1.1-1-1.8-2.3-2-3.8.4-.1.8-.3 1.1-.6.5-.5.8-1.2.7-1.9-.1-1.3-1.3-2.3-2.6-2.1z" />
                                            <path fill="#755839"
                                                d="M12 21.2c-4.4 0-8-3.6-8-8 0-1.1.2-2.1.6-3.1 1.1-1 1.8-2.3 2-3.8-.4.1-.8.3-1.1.6-.5.5-.8 1.2-.7 1.9.1 1.3 1.3 2.3 2.6 2.1 1.2-.1 2.1-1 2.3-2.1.2-1.2-.1-2.4-.8-3.4L8.6 5c-.3.4-.5.8-.5 1.3 0 .3.1.5.2.7.4.7 1.1 1.1 1.9 1.1h.5c1 0 1.9-.5 2.5-1.3l.3-.4c.7-1 .9-2.2.5-3.3-.2.1-.3.1-.4.1-.8 0-1.5-.5-1.7-1.3-.3-1 .3-2.1 1.3-2.4 1.3-.3 2.5.7 2.6 2.1.1.7-.2 1.4-.7 1.9-.3.3-.7.5-1.1.6.2 1.5.9 2.8 2 3.8-.4 1-1.2 1.8-2.2 2.3.4 1 1.2 1.8 2.2 2.3-.4 1.1-.6 2.3-.6 3.5 0 4.4-3.6 8-8 8z" />
                                        </svg>
                                        Composer
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 24 24" xmlns="http://w3.org">
                                            <path fill="#336791"
                                                d="M12.1 2c-.3 0-.5.1-.7.2-2.3 1.1-4 3.3-4.5 5.8-.1.4-.1.8-.1 1.2 0 .4.1.7.2 1.1.2.6.5 1.1.9 1.5.3.3.6.6 1 .8.4.2.8.3 1.2.4.4.1.8.1 1.2.1.8 0 1.5-.1 2.2-.4.7-.3 1.3-.7 1.7-1.3.4-.6.7-1.3.8-2.1.1-.7.1-1.5-.1-2.2-.2-.7-.5-1.4-.9-2-.4-.6-.9-1.1-1.5-1.5-.6-.4-1.2-.7-1.9-.9-.7-.3-1.4-.4-2.1-.4-.4 0-.8 0-1.1.1 1.5-1.4 3.7-2.1 5.9-1.8.9.1 1.8.4 2.6.8.8.4 1.5 1 2.1 1.7.6.7 1 1.5 1.2 2.4.2.9.3 1.8.1 2.7-.2.9-.5 1.8-1.1 2.5s-1.2 1.3-2 1.8c-.8.5-1.7.8-2.6 1-.9.2-1.8.2-2.7.1-.4 0-.8-.1-1.2-.2 1.3.8 2.8 1.2 4.4 1.1 1.2-.1 2.4-.4 3.4-1.1 1-.6 1.9-1.5 2.5-2.5.6-1.1.9-2.3 1-3.6 0-1.3-.3-2.5-.9-3.6-.6-1.1-1.5-2.1-2.5-2.8C18.6 3.1 17.3 2.5 16 2.2c-1.3-.3-2.6-.3-3.9-.2z" />
                                        </svg>
                                        PostGres
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 24 24" xmlns="http://w3.org">
                                            <path fill="#D82C20"
                                                d="M21.6 12.3c0-.4-.2-.8-.6-1l-8.4-4.6c-.4-.2-.8-.2-1.2 0L3 11.3c-.4.2-.6.6-.6 1s.2.8.6 1l8.4 4.6c.2.1.4.2.6.2s.4-.1.6-.2l8.4-4.6c.4-.2.6-.6.6-1zM12 15.3l-6.1-3.3L12 8.7l6.1 3.3L12 15.3zm9.6-7c0-.4-.2-.8-.6-1L12.6 2.7c-.4-.2-.8-.2-1.2 0L3 7.3c-.4.2-.6.6-.6 1s.2.8.6 1l2.4 1.3 1.2-.6L5.4 9 12 5.4 18.6 9l-1.2.7 1.2.6 2.4-1.3c.4-.2.6-.6.6-1zm0 8.6c0-.4-.2-.8-.6-1l-2.4-1.3-1.2.7 1.2.6 1.2.7-6.6 3.6-6.6-3.6 1.2-.7-1.2-.6-2.4 1.3c-.4.2-.6.6-.6 1s.2.8.6 1l8.4 4.6c.2.1.4.2.6.2s.4-.1.6-.2l8.4-4.6c.4-.2.6-.6.6-1z" />
                                        </svg>
                                        Redis
                                    </div>

                                </div>
                            </ui>

                            <ui class="relative flex items-center gap-4 py-2 before:absolute before:top-0 before:bottom-0
                                before:left-[1.2rem] before:border-l before:border-[#e3e3e0]
                                dark:before:border-[#3E3E3A]">
                                <span class="relative py-1">
                                    <span
                                        class="flex h-10 w-10 items-center justify-center rounded-full border-2 border-[#e3e3e0] bg-[#FDFDFC] shadow-[0px_0px_1px_0px_rgba(0,0,0,0.03),0px_1px_2px_0px_rgba(0,0,0,0.06)] dark:border-[#3E3E3A] dark:bg-[#161615]">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://w3.org">
                                            <!-- Rocket (Ship/Launch) -->
                                            <path d="M12 2s.5 4 0 7c-3 0-7-.5-7-.5L12 2z" fill="#A78BFA" />
                                            <path d="M12 2s-.5 4 0 7c3 0 7-.5 7-.5L12 2z" fill="#8B5CF6" />
                                            <!-- Launch Base / Platform -->
                                            <path d="M5 20h14" stroke="#FFFFFF" stroke-width="2.5"
                                                stroke-linecap="round" />
                                            <!-- Blast Off / Smoke -->
                                            <path d="M9 16l-2 2M15 16l2 2M12 15v4" stroke="#F87171" stroke-width="2"
                                                stroke-linecap="round" />
                                        </svg>
                                    </span>
                                </span>
                                <p class=" text-2xl text-gray-500 nunito-sans-100 font-bold">
                                    Deployment
                                </p>
                                <div class="p-3 flex flex-wrap gap-2">

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://w3.org">
                                            <!-- The Railway "R" track icon -->
                                            <path d="M4 4V20H20V12H12V20M12 12V4H20" stroke="white" stroke-width="2.5"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        Railway.com
                                    </div>

                                </div>
                            </ui>

                        </ul>
                        <p class=" text-lg font-extrabold nunito-sans-100">
                            Features
                        </p>
                        <ul class="flex flex-col">
                            <ui>
                                <span class="mx-2 font-extrabold">Artificial Intelligence:</span>
                                <span class="text-justify text-gray-400">Understands user context through text chat and
                                    images</span>
                            </ui>
                            <ui>
                                <span class="mx-2 font-extrabold">Robust Security:</span>
                                <span class="text-justify text-gray-400">Aside from Laravel's fortify, users can also
                                    login using google, facebook or linkedin accounts.</span>
                            </ui>
                            <ui>
                                <span class="mx-2 font-extrabold">User-Centric Design:</span>
                                <span class="text-justify text-gray-400">Minimalist and modern user interface
                                    design</span>
                            </ui>
                            <ui>
                                <span class="mx-2 font-extrabold">Adaptive Architecture:</span>
                                <span class="text-justify text-gray-400">Engineering fluid, mobile-first layouts that
                                    ensure a consistent experience across the device spectrum.</span>
                            </ui>
                        </ul>
                        <br>
                        <p class=" text-lg font-extrabold nunito-sans-100">
                            Challenges
                        </p>
                        <ul class="flex flex-col">
                            <ui>
                                <span class="mx-2 font-extrabold">Choice of AI Platform:</span>
                                <span class="text-justify text-gray-400">Nowadays, many companies are offering different
                                    AI products and service. Selecting the optimized model for the required job is
                                    difficult.</span>
                            </ui>
                            <ui>
                                <span class="mx-2 font-extrabold">Security:</span>
                                <span class="text-justify text-gray-400">Malicious users may inject bad code to the
                                    system. Filtering the user input proves to be hard.</span>
                            </ui>
                            <ui>
                                <span class="mx-2 font-extrabold">Prompt Engineering:</span>
                                <span class="text-justify text-gray-400">AI LLMs are so powerful however the quality of
                                    system prompt may hinder or boost the AI response to the user. Designing the right
                                    system prompt is quite a challenge.</span>
                            </ui>
                            <ui>
                                <span class="mx-2 font-extrabold">Adaptive User Interface:</span>
                                <span class="text-justify text-gray-400">User experience is a very important aspect in
                                    the design of any web app. Making the app appeal to may kinds of user device is
                                    tough.</span>
                            </ui>
                        </ul>
                        <br>
                        <p class=" text-lg font-extrabold nunito-sans-100">
                            Learnings
                        </p>
                        <ul class="flex flex-col">
                            <ui>
                                <span class="mx-2 font-extrabold">AI Platform Adaption:</span>
                                <span class="text-justify text-gray-400">Having done AI integration, I realized the
                                    endless potential of AI in improving web application in order to lessen fixed
                                    business logic. The ease of changing business logic using natural human language can
                                    greatly improve productivity by 50%</span>
                            </ui>
                            <ui>
                                <span class="mx-2 font-extrabold">Improve Security:</span>
                                <span class="text-justify text-gray-400">The need to improve security is an utmost
                                    requirement in developing web app that involves AI. A way to mitigate bad actors
                                    from exploiting user input AI must be involved in data validation before an actual
                                    post is taken into action.</span>
                            </ui>
                            <ui>
                                <span class="mx-2 font-extrabold">Study Prompt Engineering More:</span>
                                <span class="text-justify text-gray-400">Prompt engineering should be improved in order
                                    to optimize and maximize the potential usage of AI.</span>
                            </ui>
                            <ui>
                                <span class="mx-2 font-extrabold">AI Ready User Interface:</span>
                                <span class="text-justify text-gray-400">AI response that are used to take actual
                                    actions can now be easily done. It is up to the front end developer how to
                                    visualized the AI output into something usefull and presentable to human users for
                                    improved insights.</span>
                            </ui>
                        </ul>
                        <br>
                        <div class="w-[80%] h-[2px] border-b mx-auto"></div>
                    </div>
                    <ubtn @click="chatbotClick"
                        class=" bg-transparent hover:bg-transparent p-0 mt-auto ml-auto mr-3 w-fit">
                        <span class="flex flex-row  hover:cursor-pointer text-white gap-2">
                            <i class=" text-red-800">Close</i> <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" viewBox="0 0 24 24" fill="none" stroke="#0357c4" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-chevron-right-icon lucide-chevron-right">
                                <path d="m9 18 6-6-6-6" />
                            </svg>
                        </span>
                    </ubtn>
                </div>
            </div>
        </section>

        <!-- Analytics Project -->
        <section class=" flex flex-col lg:flex-row section">
            <div class="panel left  w-full lg:w-[60vw] h-full overflow-visible p-4 opacity-70 flex flex-col gap-1 items-center justify-start ml-auto lg:p-20"
                style="transition-delay: 1.3s;">
                <p class="text-2xl font-bold mr-auto">Description</p>
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
                class="panel still bg-red-800/10 backdrop-blur-sm border-t lg:border-l lg:border-l-white/20 bg-linear-to-br  from-red-800/20 to-yellow-600/40  w-full lg:w-[40vw] h-full overflow-hidden flex flex-col items-center justify-start">
                <div class="spotlight w-[100%] h-[100%] m-0 p-4 lg:p-10 text-start"
                    style="background: radial-gradient(2000px circle at var(--x) var(--y), rgba(255,255,255,0.2), transparent 10%);">
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

                    <button @click="analyticsClick">
                        <div
                            class="p-4 hover:bg-amber-600/10 hover:cursor-pointer border hover:shadow-2xl shadow-black border-amber-100 rounded-2xl">
                            <p class=" text-7xl font-semibold text-center mr-auto">
                                Analytics Dashboard</p>
                        </div>
                    </button>
                </div>
            </div>
            <!-- make shift dialog box -->
            <!-- // v-show="dialog1Open" -->
            <div ref="dlg_bg_show_analytics"
                class="dialogbg-hidden absolute top-0 -z-1 flex flex-col lg:flex row text-center justify-center items-center bg-black w-full h-full bg-red-500/10 backdrop-blur-lg border-t lg:border-l lg:border-l-white/20 bg-linear-to-br  from-black/40 to-blue-800/40">
                <div ref="dlg_show_analytics"
                    class="dialog-hidden w-screen lg:w-[70vw] h-[80vh] rounded-2xl flex flex-col bg-black border-2 shadow-2xl shadow-black p-4 overflow-hidden overflow-y-auto">
                    <div class=" text-justify text-shadow-blue-300">
                        <p class=" text-4xl font-extrabold font-stretch-condensed nunito-sans-100">
                            Analytics Dashboard
                        </p>
                        <p class=" text-2xl text-gray-500 nunito-sans-100 font-extrabold">Uses eCharts to visualize data
                            from database</p>
                        <br>
                        <p>
                            The analytics system web app accepts raw data input from the users. It then saves the input data into the database. It then later retreives the data and plot it on charts that where made by eCharts.
                        </p>
                        <br>
                        <p class=" text-lg font-extrabold nunito-sans-100">
                            Tech Stack Employed
                        </p>
                        <ul class="ml-4">

                            <ui class="relative flex items-center gap-4 py-2 before:absolute before:top-0 before:bottom-0
                                before:left-[1.2rem] before:border-l before:border-[#e3e3e0]
                                dark:before:border-[#3E3E3A]">
                                <span class="relative py-1">
                                    <span
                                        class="flex h-10 w-10 items-center justify-center rounded-full border-2 border-[#e3e3e0] bg-[#FDFDFC] shadow-[0px_0px_1px_0px_rgba(0,0,0,0.03),0px_1px_2px_0px_rgba(0,0,0,0.06)] dark:border-[#3E3E3A] dark:bg-[#161615]">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://w3.org">
                                            <!-- Code Brackets (HTML/Logic) -->
                                            <path d="M7 8l-4 4 4 4M17 8l4 4-4 4" stroke="#60A5FA" stroke-width="2.5"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <!-- Central Brush (Styling/UI) -->
                                            <path d="M14 4l-4 16" stroke="#F472B6" stroke-width="2.5"
                                                stroke-linecap="round" />
                                        </svg>
                                    </span>
                                </span>
                                <p class=" text-2xl text-gray-500 nunito-sans-100 font-bold">
                                    Front End Stack
                                </p>
                                <div class="p-3 flex flex-wrap gap-2">
                                    <div class="flex gap-2 rounded-md p-3 border border-amber-600">
                                        <svg width="20" height="20" viewBox="0 0 512 512" xmlns="http://w3.org">
                                            <path fill="#E34F26" d="M71,460 L37,0 475,0 441,460 256,512z" />
                                            <path fill="#EF652A" d="M256,472 L405,431 431,73 256,73z" />
                                            <path fill="#EBEBEB"
                                                d="M256,208 L181,208 176,150 256,150 256,94 115,94 125,213 130,265 256,265z M256,355 L255,355 192,338 188,293 132,293 140,381 256,412z" />
                                            <path fill="#FFFFFF"
                                                d="M256,208 L256,265 325,265 318,337 256,354 256,412 371,381 372,370 384,213 385,208z M256,94 L256,150 392,150 397,94z" />
                                        </svg>
                                        HTML
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 512 512" xmlns="http://w3.org">
                                            <path fill="#264DE4" d="M71,460 L37,0 475,0 441,460 256,512z" />
                                            <path fill="#2965F1" d="M256,472 L405,431 431,73 256,73z" />
                                            <path fill="#EBEBEB"
                                                d="M256,151 L177,151 181,208 256,208 256,265 185,265 189,313 256,331 256,389 140,357 127,213 125,188 122,94 256,94z" />
                                            <path fill="#FFFFFF"
                                                d="M256,151 L256,94 390,94 388,119 380,213 376,265 256,265 256,208 319,208 323,151z M256,331 L256,389 372,357 384,208 385,208 377,293 320,311z" />
                                        </svg>
                                        CSS
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 630 630" xmlns="http://w3.org">
                                            <rect width="630" height="630" fill="#f7df1e" />
                                            <path
                                                d="m423.2 492.19c12.69 20.72 29.2 35.95 58.4 35.95 24.53 0 40.2-12.26 40.2-29.2 0-20.3-16.1-27.49-43.1-39.3l-14.8-6.35c-42.72-18.2-71.1-41-71.1-89.2 0-44.4 33.83-77.23 86.63-77.23 37.64 0 64.7 14.38 84.18 47.38l-46.1 29.6c-10.15-18.2-21.1-25.37-38.1-25.37-17.34 0-28.33 9.3-28.33 21.15 0 16.5 10.15 23.26 36.37 34.68l14.8 6.34c54.55 23.26 79.1 42.3 79.1 94.3 0 54.55-43.6 81.65-95.6 81.65-49.5 0-77.02-22.84-93.53-52.13zm-215.1-5.11c12.69 21.6 27.06 37.3 54.1 37.3 21.6 0 35.53-10.57 35.53-50.76v-187.9h57.1v188.3c0 73.15-42.3 102.76-92.63 102.76-45.7 0-74-21.6-90.1-53.74z" />
                                        </svg>
                                        JavaScript
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 256 221" xmlns="http://w3.org">
                                            <path fill="#41B883"
                                                d="M204.8 0H256L128 220.8 0 0h51.2L128 132.48 204.8 0z" />
                                            <path fill="#35495E"
                                                d="M165.12 0H204.8L128 132.48 51.2 0h39.68L128 66.24 165.12 0z" />
                                        </svg>
                                        VueJS
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 24 24" xmlns="http://w3.org">
                                            <path fill="#9553E9"
                                                d="M11.5 5.5l6 6.5-6 6.5h4.5l6-6.5-6-6.5h-4.5zm-9 0l6 6.5-6 6.5h4.5l6-6.5-6-6.5h-4.5z" />
                                        </svg>
                                        InertiaJS
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://w3.org">
                                            <!-- Top Leaves (Green) -->
                                            <path
                                                d="M12 2c-.8 0-1.5.5-1.8 1.2C9.5 3 8.8 3.5 8.5 4.2c-.3.7-.2 1.5.2 2.1l3.3.2 3.3-.2c.4-.6.5-1.4.2-2.1-.3-.7-1-1.2-1.7-1-.3-.7-1-1.2-1.8-1.2z"
                                                fill="#606f21" />
                                            <!-- Body (Yellow) -->
                                            <path
                                                d="M12 6c-2.5 0-4.5 2-4.5 4.5 0 1 .3 1.9.9 2.6L4.5 20c-.3.6-.5 1.3-.5 2 0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2 0-.7-.2-1.4-.5-2l-3.9-6.9c.6-.7.9-1.6.9-2.6 0-2.5-2-4.5-4.5-4.5z"
                                                fill="#ffe066" />
                                            <!-- Eyes (Dark Green) -->
                                            <circle cx="10" cy="11.5" r="0.8" fill="#606f21" />
                                            <circle cx="14" cy="11.5" r="0.8" fill="#606f21" />
                                            <!-- Smile (Dark Green) -->
                                            <path d="M11 13.5c.3.3.7.5 1 .5s.7-.2 1-.5" stroke="#606f21"
                                                stroke-width="0.6" stroke-linecap="round" />
                                        </svg>
                                        Pinia
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://w3.org">
                                            <path d="M20 5L5 20M17 3L3 17" stroke="currentColor" stroke-width="3"
                                                stroke-linecap="round" />
                                        </svg>
                                        shadcn-vue
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 512 512"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill="#5470c6" d="M120 454L55 352l128-228 73 130-136 200z" />
                                            <path fill="#91cc75" d="M256 58l-73 130 136 200 65-102L256 58z" />
                                            <path fill="#fac858" d="M392 454l65-102-128-228-73 130 136 200z" />
                                        </svg>
                                        Apache eCharts
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 256 256" xmlns="http://w3.org">
                                            <path fill="currentColor"
                                                d="M128 32l96 160H32L128 32zm0 37.33L67.2 165.33h121.6L128 69.33z" />
                                        </svg>
                                        ThreeJS
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 256 256" xmlns="http://w3.org"
                                            preserveAspectRatio="xMidYMid">
                                            <path fill="#CB3837" d="M0 0h256v256H0z" />
                                            <path fill="#FFF" d="M48 48h160v160h-32V80h-32v128H48z" />
                                        </svg>
                                        npm
                                    </div>

                                </div>
                            </ui>

                            <ui class="relative flex items-center gap-4 py-2 before:absolute before:top-0 before:bottom-0
                                before:left-[1.2rem] before:border-l before:border-[#e3e3e0]
                                dark:before:border-[#3E3E3A]">
                                <span class="relative py-1">
                                    <span
                                        class="flex h-10 w-10 items-center justify-center rounded-full border-2 border-[#e3e3e0] bg-[#FDFDFC] shadow-[0px_0px_1px_0px_rgba(0,0,0,0.03),0px_1px_2px_0px_rgba(0,0,0,0.06)] dark:border-[#3E3E3A] dark:bg-[#161615]">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://w3.org">
                                            <!-- Server/Database Layer -->
                                            <path d="M4 6h16M4 12h16M4 18h16" stroke="#34D399" stroke-width="2.5"
                                                stroke-linecap="round" />
                                            <!-- Processing/Gear Logic -->
                                            <circle cx="12" cy="12" r="3" stroke="#FBBF24" stroke-width="2.5" />
                                            <path d="M12 8V6M12 18v-2M8 12H6m12 0h-2" stroke="#FBBF24"
                                                stroke-width="2.5" stroke-linecap="round" />
                                        </svg>
                                    </span>
                                </span>
                                <p class=" text-2xl text-gray-500 nunito-sans-100 font-bold">
                                    Back End Stack
                                </p>
                                <div class="p-3 flex flex-wrap gap-2">
                                    <div class="flex gap-2 rounded-md p-3 border border-amber-600">
                                        <svg width="20" height="20" viewBox="0 0 24 24" xmlns="http://w3.org">
                                            <path fill="#FF2D20"
                                                d="M19.333 4.125h-5.25v2.25h2.25v13.5h-10.5v-3.375h-2.25v3.375c0 .414.336.75.75.75h14.25c.414 0 .75-.336.75-.75V4.875c0-.414-.336-.75-.75-.75zm-6-2.25H2.333v13.5h2.25v-10.5h10.5v2.25h2.25V2.625c0-.414-.336-.75-.75-.75H13.333z" />
                                        </svg>
                                        Laravel
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 24 24" xmlns="http://w3.org">
                                            <path fill="#000000"
                                                d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm5.068 18.23c-1.396.657-3.05 1.01-4.72 1.01-4.14 0-7.394-2.583-7.394-6.43 0-3.336 2.45-6.195 6.452-6.195 1.63 0 2.97.4 3.99 1.03l-.78 1.93c-.88-.47-1.84-.71-2.94-.71-2.61 0-4.09 1.84-4.09 4.01 0 2.49 2.05 3.96 4.88 3.96.95 0 1.95-.19 2.76-.54l-.06-3.14h-2.31v-1.85h4.26l.1 6.87z" />
                                        </svg>
                                        Symfony
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">

                                        Socialite
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">

                                        Fortify
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">

                                        PhP Artisan
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 24 24" xmlns="http://w3.org">
                                            <path fill="#5E4E3C"
                                                d="M12.4 2.8c-1 .3-1.6 1.4-1.3 2.4.2.8.9 1.3 1.7 1.3.1 0 .2 0 .4-.1.4 1.1.2 2.3-.5 3.3l-.3.4c-.6.8-1.5 1.3-2.5 1.3h-.5c-.8 0-1.5-.4-1.9-1.1-.1-.2-.2-.4-.2-.7 0-.5.2-.9.5-1.3l.3-.4c.7-1 1-2.2.8-3.4-.2-1.1-1.1-2-2.3-2.1-1.3-.2-2.5.8-2.6 2.1-.1.7.2 1.4.7 1.9.3.3.7.5 1.1.6-.2 1.5-.9 2.8-2 3.8-.5.5-.8 1.1-.9 1.8 0 .8.3 1.5.8 2 .9.9 2.1 1.4 3.4 1.4h.8c1.3 0 2.5-.5 3.4-1.4.5-.5.8-1.2.8-2 0-.7-.3-1.3-.8-1.8-1.1-1-1.8-2.3-2-3.8.4-.1.8-.3 1.1-.6.5-.5.8-1.2.7-1.9-.1-1.3-1.3-2.3-2.6-2.1z" />
                                            <path fill="#755839"
                                                d="M12 21.2c-4.4 0-8-3.6-8-8 0-1.1.2-2.1.6-3.1 1.1-1 1.8-2.3 2-3.8-.4.1-.8.3-1.1.6-.5.5-.8 1.2-.7 1.9.1 1.3 1.3 2.3 2.6 2.1 1.2-.1 2.1-1 2.3-2.1.2-1.2-.1-2.4-.8-3.4L8.6 5c-.3.4-.5.8-.5 1.3 0 .3.1.5.2.7.4.7 1.1 1.1 1.9 1.1h.5c1 0 1.9-.5 2.5-1.3l.3-.4c.7-1 .9-2.2.5-3.3-.2.1-.3.1-.4.1-.8 0-1.5-.5-1.7-1.3-.3-1 .3-2.1 1.3-2.4 1.3-.3 2.5.7 2.6 2.1.1.7-.2 1.4-.7 1.9-.3.3-.7.5-1.1.6.2 1.5.9 2.8 2 3.8-.4 1-1.2 1.8-2.2 2.3.4 1 1.2 1.8 2.2 2.3-.4 1.1-.6 2.3-.6 3.5 0 4.4-3.6 8-8 8z" />
                                        </svg>
                                        Composer
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 24 24" xmlns="http://w3.org">
                                            <path fill="#00758F"
                                                d="M12.24 2c-4.22 0-7.85 2.15-7.85 4.8 0 .44.11.86.3 1.25-.45.34-.84.74-1.15 1.18-.8 1.15-1.04 2.58-.69 4.03.35 1.45 1.27 2.65 2.59 3.38.3.17.61.31.93.43-.01.12-.02.24-.02.37 0 2.21 1.79 4 4 4 1.1 0 2.1-.45 2.83-1.17.47.11.95.17 1.45.17 3.31 0 6-2.69 6-6V6.8c0-2.65-3.63-4.8-7.85-4.8l-.54.01v.01zM12 18.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5zm6.5-6.17c-.37.33-.8.61-1.27.83-.8.37-1.7.57-2.65.57-.46 0-.91-.05-1.34-.14-.26-.06-.51-.13-.76-.23-.6-.24-1.14-.59-1.59-1.03-.43-.43-.76-.94-.96-1.51-.2-.57-.29-1.18-.26-1.8.03-.62.18-1.23.44-1.8.26-.57.62-1.08 1.08-1.51.46-.43 1-.77 1.6-1.01.6-.24 1.25-.37 1.91-.37s1.31.13 1.91.37c.6.24 1.14.58 1.6 1.01.46.43.82.94 1.08 1.51.26.57.41 1.18.44 1.8.03.62-.06 1.23-.26 1.8-.2.57-.53 1.08-.96 1.51z" />
                                        </svg>
                                        mySQL
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 24 24" xmlns="http://w3.org">
                                            <path fill="#D82C20"
                                                d="M21.6 12.3c0-.4-.2-.8-.6-1l-8.4-4.6c-.4-.2-.8-.2-1.2 0L3 11.3c-.4.2-.6.6-.6 1s.2.8.6 1l8.4 4.6c.2.1.4.2.6.2s.4-.1.6-.2l8.4-4.6c.4-.2.6-.6.6-1zM12 15.3l-6.1-3.3L12 8.7l6.1 3.3L12 15.3zm9.6-7c0-.4-.2-.8-.6-1L12.6 2.7c-.4-.2-.8-.2-1.2 0L3 7.3c-.4.2-.6.6-.6 1s.2.8.6 1l2.4 1.3 1.2-.6L5.4 9 12 5.4 18.6 9l-1.2.7 1.2.6 2.4-1.3c.4-.2.6-.6.6-1zm0 8.6c0-.4-.2-.8-.6-1l-2.4-1.3-1.2.7 1.2.6 1.2.7-6.6 3.6-6.6-3.6 1.2-.7-1.2-.6-2.4 1.3c-.4.2-.6.6-.6 1s.2.8.6 1l8.4 4.6c.2.1.4.2.6.2s.4-.1.6-.2l8.4-4.6c.4-.2.6-.6.6-1z" />
                                        </svg>
                                        Redis
                                    </div>

                                </div>
                            </ui>

                            <ui class="relative flex items-center gap-4 py-2 before:absolute before:top-0 before:bottom-0
                                before:left-[1.2rem] before:border-l before:border-[#e3e3e0]
                                dark:before:border-[#3E3E3A]">
                                <span class="relative py-1">
                                    <span
                                        class="flex h-10 w-10 items-center justify-center rounded-full border-2 border-[#e3e3e0] bg-[#FDFDFC] shadow-[0px_0px_1px_0px_rgba(0,0,0,0.03),0px_1px_2px_0px_rgba(0,0,0,0.06)] dark:border-[#3E3E3A] dark:bg-[#161615]">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://w3.org">
                                            <!-- Rocket (Ship/Launch) -->
                                            <path d="M12 2s.5 4 0 7c-3 0-7-.5-7-.5L12 2z" fill="#A78BFA" />
                                            <path d="M12 2s-.5 4 0 7c3 0 7-.5 7-.5L12 2z" fill="#8B5CF6" />
                                            <!-- Launch Base / Platform -->
                                            <path d="M5 20h14" stroke="#FFFFFF" stroke-width="2.5"
                                                stroke-linecap="round" />
                                            <!-- Blast Off / Smoke -->
                                            <path d="M9 16l-2 2M15 16l2 2M12 15v4" stroke="#F87171" stroke-width="2"
                                                stroke-linecap="round" />
                                        </svg>
                                    </span>
                                </span>
                                <p class=" text-2xl text-gray-500 nunito-sans-100 font-bold">
                                    Deployment
                                </p>
                                <div class="p-3 flex flex-wrap gap-2">

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://w3.org">
                                            <!-- The Render "R" Ribbon -->
                                            <path
                                                d="M19 4H5C3.34315 4 2 5.34315 2 7V17C2 18.6569 3.34315 20 5 20H19C20.6569 20 22 18.6569 22 17V7C22 5.34315 20.6569 4 19 4Z"
                                                fill="#46E3B7" />
                                            <path
                                                d="M8 8V16M8 8H12C13.1046 8 14 8.89543 14 10C14 11.1046 13.1046 12 12 12H8M12 12L15 16"
                                                stroke="white" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                        Render.com
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 24 24" xmlns="http://w3.org">
                                            <!-- Docker Whale (White for Dark Mode) -->
                                            <path fill="#FFFFFF"
                                                d="M13.983 11.078h2.119c.102 0 .186.084.186.186v2.119a.186.186 0 0 1-.186.186h-2.119a.185.185 0 0 1-.185-.186v-2.119c0-.102.083-.186.185-.186zm-2.954-2.565h2.118c.103 0 .187.083.187.186v2.119a.186.186 0 0 1-.187.186h-2.118a.185.185 0 0 1-.185-.186V8.699c0-.103.083-.186.185-.186zm0 2.565h2.118c.103 0 .187.084.187.186v2.119a.186.186 0 0 1-.187.186h-2.118a.185.185 0 0 1-.185-.186v-2.119c0-.102.083-.186.185-.186zm-2.954 0h2.119c.102 0 .185.084.185.186v2.119a.186.186 0 0 1-.185.186H8.075a.186.186 0 0 1-.186-.186v-2.119c0-.102.084-.186.186-.186zm5.908-2.565h2.118c.103 0 .187.083.187.186v2.119a.186.186 0 0 1-.187.186h-2.118a.185.185 0 0 1-.185-.186V8.699c0-.103.083-.186.185-.186zm-2.954-2.565h2.119c.102 0 .185.084.185.186v2.119a.186.186 0 0 1-.185.186h-2.119a.186.186 0 0 1-.186-.186V6.134c0-.102.084-.186.186-.186zm-2.954 0h2.118c.103 0 .187.084.187.186v2.119a.186.186 0 0 1-.187.186h-2.118a.185.185 0 0 1-.185-.186V6.134c0-.102.083-.186.185-.186zm-2.954 0h2.119c.102 0 .185.084.185.186v2.119a.186.186 0 0 1-.185.186H5.12c-.102 0-.185-.084-.185-.186V6.134c0-.102.083-.186.185-.186zm-2.954 0h2.119c.102 0 .185.084.185.186v2.119a.186.186 0 0 1-.185.186H2.165c-.102 0-.185-.084-.185-.186V6.134c0-.102.083-.186.185-.186zm0 2.565h2.119c.102 0 .185.084.185.186v2.119a.186.186 0 0 1-.185.186H2.165c-.102 0-.185-.084-.185-.186v-2.119c0-.102.083-.186.185-.186zm0 2.565h2.119c.102 0 .185.084.185.186v2.119a.186.186 0 0 1-.185.186H2.165c-.102 0-.185-.084-.185-.186v-2.119c0-.102.083-.186.185-.186zm16.174-2.565c-.34.004-.736.096-1.136.21a4.4 4.4 0 0 0 .606 2.354c.712.051 1.46.076 2.237.076.127 0 .23-.103.23-.23V8.699a2.384 2.384 0 0 0-1.937-2.565zM.001 13.988c.056 1.539.46 3.049 1.14 4.407.359.714.884 1.354 1.454 1.83 2.383 2 6.993 2.018 10.636 2.018 7.707 0 10.628-2.31 10.628-6.134 0-.046-.014-.096-.042-.132l-.419-.552c-.157-.206-.46-.225-.6-.033-1.164 1.618-3.01 2.126-4.838 2.063-4.69-.164-6.684-2.519-6.684-2.519l-.339-.34a.188.188 0 0 0-.26 0l-.35.35s-2.044 2.203-6.706 2.1c-1.312-.029-2.5-.531-3.51-1.077z" />
                                        </svg>
                                        DockerHub
                                    </div>


                                </div>
                            </ui>

                        </ul>
                        <p class=" text-lg font-extrabold nunito-sans-100">
                            Features
                        </p>
                        <ul class="flex flex-col">
                            <ui>
                                <span class="mx-2 font-extrabold">Robust Data Storage and Retreival:</span>
                                <span class="text-justify text-gray-400">It has fast data storage and retreival because it utilizes cacheing using Redis. </span>
                            </ui>
                            <ui>
                                <span class="mx-2 font-extrabold">Stable Security:</span>
                                <span class="text-justify text-gray-400">Employs Laravel fortify module to authenticate users and utilizes regex for data validation thereby preventing malicious code injection.</span>
                            </ui>
                            <ui>
                                <span class="mx-2 font-extrabold">User-Centric Design:</span>
                                <span class="text-justify text-gray-400">Minimalist and modern user interface
                                    design</span>
                            </ui>
                            <ui>
                                <span class="mx-2 font-extrabold">Adaptive Architecture:</span>
                                <span class="text-justify text-gray-400">Engineering fluid, mobile-first layouts that
                                    ensure a consistent experience across the device spectrum.</span>
                            </ui>
                        </ul>
                        <br>
                        <p class=" text-lg font-extrabold nunito-sans-100">
                            Challenges
                        </p>
                        <ul class="flex flex-col">
                            <ui>
                                <span class="mx-2 font-extrabold">Choice of Chart Provider:</span>
                                <span class="text-justify text-gray-400">Nowadays, many companies are offering different
                                    chart products and service. Selecting the optimized model for the required job is
                                    crucial.</span>
                            </ui>
                            <ui>
                                <span class="mx-2 font-extrabold">Security:</span>
                                <span class="text-justify text-gray-400">Malicious users may inject bad code to the
                                    system. Filtering the user input proves to be hard.</span>
                            </ui>

                            <ui>
                                <span class="mx-2 font-extrabold">Adaptive User Interface:</span>
                                <span class="text-justify text-gray-400">User experience is a very important aspect in
                                    the design of any web app. Making the app appeal to may kinds of user device is
                                    tough.</span>
                            </ui>
                        </ul>
                        <br>
                        <p class=" text-lg font-extrabold nunito-sans-100">
                            Learnings
                        </p>
                        <ul class="flex flex-col">
                            <ui>
                                <span class="mx-2 font-extrabold">Selection of Charts Platform:</span>
                                <span class="text-justify text-gray-400">eCharts was finally selected because of its versatility with many readily available charts that are considered production ready. Raw data can easily be pushed into the chart with minimal coding effort.</span>
                            </ui>
                            <ui>
                                <span class="mx-2 font-extrabold">Security:</span>
                                <span class="text-justify text-gray-400">Regex data validation was employed in order to prevent malicious data injection that may expose the system to further attacks.</span>
                            </ui>

                            <ui>
                                <span class="mx-2 font-extrabold">Adaptive User Interface:</span>
                                <span class="text-justify text-gray-400">The web app employs the use of Laravel starter kit to lessen the burden of setting up responsive UI/UX.</span>
                            </ui>
                        </ul>
                        <br>
                        <div class="w-[80%] h-[2px] border-b mx-auto"></div>
                    </div>
                    <ubtn @click="analyticsClick"
                        class=" bg-transparent hover:bg-transparent p-0 mt-auto ml-auto mr-3 w-fit">
                        <span class="flex flex-row  hover:cursor-pointer text-white gap-2">
                            <i class=" text-red-800">Close</i> <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" viewBox="0 0 24 24" fill="none" stroke="#0357c4" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-chevron-right-icon lucide-chevron-right">
                                <path d="m9 18 6-6-6-6" />
                            </svg>
                        </span>
                    </ubtn>
                </div>
            </div>
        </section>

        <!-- GIS Project -->
        <section class=" flex flex-col lg:flex-row section">
            <div class="panel left  w-full lg:w-[60vw] h-full overflow-visible p-4 opacity-70 flex flex-wrap gap-1 items-center justify-start ml-auto lg:p-20 "
                style="transition-delay: 1.3s;">
                <p class="text-2xl font-bold">Description</p>
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

                <span class=" text-lg lg:text-3xl"><b><i class=" text-amber-400">Key Feature:</i></b><br>
                    &nbsp;&nbsp;&nbsp;Dynamic
                    map layers and filtering which boosts 20% in user productivity</span> <br>
            </div>
            <div
                class="panel still bg-red-800/10 backdrop-blur-sm border-t lg:border-l lg:border-l-white/20  bg-linear-to-br  from-red-800/20 to-yellow-600/40  w-full lg:w-[40vw] h-full overflow-hidden flex flex-col items-center justify-start">
                <div class="spotlight w-[100%] h-[100%] m-0 p-4 lg:p-10 text-start"
                    style="background: radial-gradient(2000px circle at var(--x) var(--y), rgba(255,255,255,0.2), transparent 10%);">
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
                    <button @click="gisClick">
                        <div
                            class="p-4 hover:bg-amber-600/10 hover:cursor-pointer border hover:shadow-2xl shadow-black border-amber-100 rounded-2xl">
                            <p class=" text-7xl font-semibold text-center">
                                GIS Mapping System</p>
                        </div>
                    </button>
                </div>
            </div>
            <!-- make shift dialog box -->
            <!-- // v-show="dialog1Open" -->
            <div ref="dlg_bg_show_gis"
                class="dialogbg-hidden absolute top-0 -z-1 flex flex-col lg:flex row text-center justify-center items-center bg-black w-full h-full bg-red-500/10 backdrop-blur-lg border-t lg:border-l lg:border-l-white/20 bg-linear-to-br  from-black/40 to-blue-800/40">
                <div ref="dlg_show_gis"
                    class="dialog-hidden w-screen lg:w-[70vw] h-[80vh] rounded-2xl flex flex-col bg-black border-2 shadow-2xl shadow-black p-4 overflow-hidden overflow-y-auto">
                    <div class=" text-justify text-shadow-blue-300">
                        <p class=" text-4xl font-extrabold font-stretch-condensed nunito-sans-100">
                            GIS Mapping System
                        </p>
                        <p class=" text-2xl text-gray-500 nunito-sans-100 font-extrabold">
                            Fast access to map data using GEOJSON format. It utilizes AI to extract user data through scanning of valid ID's and converting it to JSON.</p>
                        <br>
                        <p>
                            AI computer vision is used for user authentication through face recognition and valid ID data extraction. User input are fed into Postgres database and is cached using redis. Map is visualized using Leaflet.
                        </p>
                        <br>
                        <p class=" text-lg font-extrabold nunito-sans-100">
                            Tech Stack Employed
                        </p>
                        <ul class="ml-4">
                            <ui class="relative flex items-center gap-4 py-2 before:absolute before:top-0 before:bottom-0
                                before:left-[1.2rem] before:border-l before:border-[#e3e3e0]
                                dark:before:border-[#3E3E3A]">
                                <span class="relative py-1">
                                    <span
                                        class="flex h-10 w-10 items-center justify-center rounded-full border-2 border-[#e3e3e0] bg-[#FDFDFC] shadow-[0px_0px_1px_0px_rgba(0,0,0,0.03),0px_1px_2px_0px_rgba(0,0,0,0.06)] dark:border-[#3E3E3A] dark:bg-[#161615]">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://w3.org">
                                            <!-- Outer Circuit Hexagon -->
                                            <path d="M12 2L4 6.5v11L12 22l8-4.5v-11L12 2z" stroke="#38BDF8"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            <!-- Central Spark/Intelligence Core -->
                                            <path d="M12 8v8M8 12h8" stroke="#FFFFFF" stroke-width="2"
                                                stroke-linecap="round" />
                                            <!-- Neural Nodes -->
                                            <circle cx="12" cy="12" r="2" fill="#38BDF8" />
                                            <circle cx="12" cy="5" r="1.5" fill="#FFFFFF" />
                                            <circle cx="12" cy="19" r="1.5" fill="#FFFFFF" />
                                        </svg>
                                    </span>
                                </span>
                                <p class=" text-2xl text-gray-500 nunito-sans-100 font-bold">
                                    AI Models
                                </p>
                                <div class="p-3 flex flex-wrap gap-2">

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 24 24" xmlns="http://w3.org">
                                            <path fill="#0668E1"
                                                d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm4.184 14.646c-.52.52-1.36.52-1.88 0l-1.304-1.304c-.663.418-1.442.658-2.274.658-.832 0-1.61-.24-2.274-.658l-1.304 1.304c-.52.52-1.36.52-1.88 0-.52-.52-.52-1.36 0-1.88l1.304-1.304c-.418-.663-.658-1.442-.658-2.274 0-.832.24-1.61.658-2.274l-1.304-1.304c-.52-.52-.52-1.36 0-1.88.52-.52 1.36-.52 1.88 0l1.304 1.304c.663-.418 1.442-.658 2.274-.658.832 0 1.61.24 2.274.658l1.304-1.304c.52-.52 1.36-.52 1.88 0 .52.52.52 1.36 0 1.88l-1.304 1.304c.418.663.658 1.442.658 2.274 0 .832-.24 1.61-.658 2.274l1.304 1.304c.52.52.52 1.36 0 1.88z" />
                                        </svg>
                                        meta-llama/llama-4-scout
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://w3.org">
                                            <!-- The Tesseract "T" Cube/Network shape -->
                                            <path d="M12 2L3 7v10l9 5 9-5V7l-9-5z" stroke="#5ca9e1" stroke-width="1.5"
                                                stroke-linejoin="round" />
                                            <path d="M12 22V12M12 12L3 7M12 12l9-5" stroke="#5ca9e1"
                                                stroke-width="1.5" />
                                            <!-- OCR/Text representation (White for Dark Mode) -->
                                            <path d="M8 11h8M8 14h5" stroke="white" stroke-width="1.5"
                                                stroke-linecap="round" />
                                        </svg>
                                        Tesserct JS
                                    </div>

                                </div>
                            </ui>

                            <ui class="relative flex items-center gap-4 py-2 before:absolute before:top-0 before:bottom-0
                                before:left-[1.2rem] before:border-l before:border-[#e3e3e0]
                                dark:before:border-[#3E3E3A]">
                                <span class="relative py-1">
                                    <span
                                        class="flex h-10 w-10 items-center justify-center rounded-full border-2 border-[#e3e3e0] bg-[#FDFDFC] shadow-[0px_0px_1px_0px_rgba(0,0,0,0.03),0px_1px_2px_0px_rgba(0,0,0,0.06)] dark:border-[#3E3E3A] dark:bg-[#161615]">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://w3.org">
                                            <!-- Code Brackets (HTML/Logic) -->
                                            <path d="M7 8l-4 4 4 4M17 8l4 4-4 4" stroke="#60A5FA" stroke-width="2.5"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <!-- Central Brush (Styling/UI) -->
                                            <path d="M14 4l-4 16" stroke="#F472B6" stroke-width="2.5"
                                                stroke-linecap="round" />
                                        </svg>
                                    </span>
                                </span>
                                <p class=" text-2xl text-gray-500 nunito-sans-100 font-bold">
                                    Front End Stack
                                </p>
                                <div class="p-3 flex flex-wrap gap-2">
                                    <div class="flex gap-2 rounded-md p-3 border border-amber-600">
                                        <svg width="20" height="20" viewBox="0 0 512 512" xmlns="http://w3.org">
                                            <path fill="#E34F26" d="M71,460 L37,0 475,0 441,460 256,512z" />
                                            <path fill="#EF652A" d="M256,472 L405,431 431,73 256,73z" />
                                            <path fill="#EBEBEB"
                                                d="M256,208 L181,208 176,150 256,150 256,94 115,94 125,213 130,265 256,265z M256,355 L255,355 192,338 188,293 132,293 140,381 256,412z" />
                                            <path fill="#FFFFFF"
                                                d="M256,208 L256,265 325,265 318,337 256,354 256,412 371,381 372,370 384,213 385,208z M256,94 L256,150 392,150 397,94z" />
                                        </svg>
                                        HTML
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 512 512" xmlns="http://w3.org">
                                            <path fill="#264DE4" d="M71,460 L37,0 475,0 441,460 256,512z" />
                                            <path fill="#2965F1" d="M256,472 L405,431 431,73 256,73z" />
                                            <path fill="#EBEBEB"
                                                d="M256,151 L177,151 181,208 256,208 256,265 185,265 189,313 256,331 256,389 140,357 127,213 125,188 122,94 256,94z" />
                                            <path fill="#FFFFFF"
                                                d="M256,151 L256,94 390,94 388,119 380,213 376,265 256,265 256,208 319,208 323,151z M256,331 L256,389 372,357 384,208 385,208 377,293 320,311z" />
                                        </svg>
                                        CSS
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 24 24" xmlns="http://w3.org">
                                            <path fill="#38bdf8"
                                                d="M12.001 4.8c-3.2 0-5.2 1.6-6 4.8 1.2-1.6 2.6-2.2 4.2-1.8 0.913 0.228 1.565 0.89 2.288 1.624C13.666 10.618 15.027 12 18.001 12c3.2 0 5.2-1.6 6-4.8-1.2 1.6-2.6 2.2-4.2 1.8-0.913-0.228-1.565-0.89-2.288-1.624C16.337 6.182 14.976 4.8 12.001 4.8zm-6 7.2c-3.2 0-5.2 1.6-6 4.8 1.2-1.6 2.6-2.2 4.2-1.8 0.913 0.228 1.565 0.89 2.288 1.624 1.177 1.194 2.538 2.576 5.512 2.576 3.2 0 5.2-1.6 6-4.8-1.2 1.6-2.6 2.2-4.2 1.8-0.913-0.228-1.565-0.89-2.288-1.624C8.337 13.382 6.976 12 4.001 12z" />
                                        </svg>
                                        Tailwind CSS
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 630 630" xmlns="http://w3.org">
                                            <rect width="630" height="630" fill="#f7df1e" />
                                            <path
                                                d="m423.2 492.19c12.69 20.72 29.2 35.95 58.4 35.95 24.53 0 40.2-12.26 40.2-29.2 0-20.3-16.1-27.49-43.1-39.3l-14.8-6.35c-42.72-18.2-71.1-41-71.1-89.2 0-44.4 33.83-77.23 86.63-77.23 37.64 0 64.7 14.38 84.18 47.38l-46.1 29.6c-10.15-18.2-21.1-25.37-38.1-25.37-17.34 0-28.33 9.3-28.33 21.15 0 16.5 10.15 23.26 36.37 34.68l14.8 6.34c54.55 23.26 79.1 42.3 79.1 94.3 0 54.55-43.6 81.65-95.6 81.65-49.5 0-77.02-22.84-93.53-52.13zm-215.1-5.11c12.69 21.6 27.06 37.3 54.1 37.3 21.6 0 35.53-10.57 35.53-50.76v-187.9h57.1v188.3c0 73.15-42.3 102.76-92.63 102.76-45.7 0-74-21.6-90.1-53.74z" />
                                        </svg>
                                        JavaScript
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 256 221" xmlns="http://w3.org">
                                            <path fill="#41B883"
                                                d="M204.8 0H256L128 220.8 0 0h51.2L128 132.48 204.8 0z" />
                                            <path fill="#35495E"
                                                d="M165.12 0H204.8L128 132.48 51.2 0h39.68L128 66.24 165.12 0z" />
                                        </svg>
                                        VueJS
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 24 24" xmlns="http://w3.org">
                                            <path fill="#9553E9"
                                                d="M11.5 5.5l6 6.5-6 6.5h4.5l6-6.5-6-6.5h-4.5zm-9 0l6 6.5-6 6.5h4.5l6-6.5-6-6.5h-4.5z" />
                                        </svg>
                                        InertiaJS
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://w3.org">
                                            <!-- Top Leaves (Green) -->
                                            <path
                                                d="M12 2c-.8 0-1.5.5-1.8 1.2C9.5 3 8.8 3.5 8.5 4.2c-.3.7-.2 1.5.2 2.1l3.3.2 3.3-.2c.4-.6.5-1.4.2-2.1-.3-.7-1-1.2-1.7-1-.3-.7-1-1.2-1.8-1.2z"
                                                fill="#606f21" />
                                            <!-- Body (Yellow) -->
                                            <path
                                                d="M12 6c-2.5 0-4.5 2-4.5 4.5 0 1 .3 1.9.9 2.6L4.5 20c-.3.6-.5 1.3-.5 2 0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2 0-.7-.2-1.4-.5-2l-3.9-6.9c.6-.7.9-1.6.9-2.6 0-2.5-2-4.5-4.5-4.5z"
                                                fill="#ffe066" />
                                            <!-- Eyes (Dark Green) -->
                                            <circle cx="10" cy="11.5" r="0.8" fill="#606f21" />
                                            <circle cx="14" cy="11.5" r="0.8" fill="#606f21" />
                                            <!-- Smile (Dark Green) -->
                                            <path d="M11 13.5c.3.3.7.5 1 .5s.7-.2 1-.5" stroke="#606f21"
                                                stroke-width="0.6" stroke-linecap="round" />
                                        </svg>
                                        Pinia
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://w3.org">
                                            <path d="M20 5L5 20M17 3L3 17" stroke="currentColor" stroke-width="3"
                                                stroke-linecap="round" />
                                        </svg>
                                        shadcn-vue
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 512 512"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill="#5470c6" d="M120 454L55 352l128-228 73 130-136 200z" />
                                            <path fill="#91cc75" d="M256 58l-73 130 136 200 65-102L256 58z" />
                                            <path fill="#fac858" d="M392 454l65-102-128-228-73 130 136 200z" />
                                        </svg>
                                        Apache eCharts
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 24 24" xmlns="http://w3.org">
                                            <!-- Right Leaf -->
                                            <path fill="#7EB03C"
                                                d="M11.5 2.5c0 0 7.5 1 9.5 9s-2 10-2 10-6.5-1-8.5-8.5 1-10.5 1-10.5z" />
                                            <!-- Left Leaf -->
                                            <path fill="#99C04F"
                                                d="M12.5 2.5c0 0-7.5 1-9.5 9s2 10 2 10 6.5-1 8.5-8.5-1-10.5-1-10.5z" />
                                        </svg>
                                        Leaflet
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 256 256" xmlns="http://w3.org">
                                            <path fill="currentColor"
                                                d="M128 32l96 160H32L128 32zm0 37.33L67.2 165.33h121.6L128 69.33z" />
                                        </svg>
                                        ThreeJS
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 256 256" xmlns="http://w3.org"
                                            preserveAspectRatio="xMidYMid">
                                            <path fill="#CB3837" d="M0 0h256v256H0z" />
                                            <path fill="#FFF" d="M48 48h160v160h-32V80h-32v128H48z" />
                                        </svg>
                                        npm
                                    </div>

                                </div>
                            </ui>

                            <ui class="relative flex items-center gap-4 py-2 before:absolute before:top-0 before:bottom-0
                                before:left-[1.2rem] before:border-l before:border-[#e3e3e0]
                                dark:before:border-[#3E3E3A]">
                                <span class="relative py-1">
                                    <span
                                        class="flex h-10 w-10 items-center justify-center rounded-full border-2 border-[#e3e3e0] bg-[#FDFDFC] shadow-[0px_0px_1px_0px_rgba(0,0,0,0.03),0px_1px_2px_0px_rgba(0,0,0,0.06)] dark:border-[#3E3E3A] dark:bg-[#161615]">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://w3.org">
                                            <!-- Server/Database Layer -->
                                            <path d="M4 6h16M4 12h16M4 18h16" stroke="#34D399" stroke-width="2.5"
                                                stroke-linecap="round" />
                                            <!-- Processing/Gear Logic -->
                                            <circle cx="12" cy="12" r="3" stroke="#FBBF24" stroke-width="2.5" />
                                            <path d="M12 8V6M12 18v-2M8 12H6m12 0h-2" stroke="#FBBF24"
                                                stroke-width="2.5" stroke-linecap="round" />
                                        </svg>
                                    </span>
                                </span>
                                <p class=" text-2xl text-gray-500 nunito-sans-100 font-bold">
                                    Back End Stack
                                </p>
                                <div class="p-3 flex flex-wrap gap-2">
                                    <div class="flex gap-2 rounded-md p-3 border border-amber-600">
                                        <svg width="20" height="20" viewBox="0 0 24 24" xmlns="http://w3.org">
                                            <path fill="#FF2D20"
                                                d="M19.333 4.125h-5.25v2.25h2.25v13.5h-10.5v-3.375h-2.25v3.375c0 .414.336.75.75.75h14.25c.414 0 .75-.336.75-.75V4.875c0-.414-.336-.75-.75-.75zm-6-2.25H2.333v13.5h2.25v-10.5h10.5v2.25h2.25V2.625c0-.414-.336-.75-.75-.75H13.333z" />
                                        </svg>
                                        Laravel
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 24 24" xmlns="http://w3.org">
                                            <path fill="#000000"
                                                d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm5.068 18.23c-1.396.657-3.05 1.01-4.72 1.01-4.14 0-7.394-2.583-7.394-6.43 0-3.336 2.45-6.195 6.452-6.195 1.63 0 2.97.4 3.99 1.03l-.78 1.93c-.88-.47-1.84-.71-2.94-.71-2.61 0-4.09 1.84-4.09 4.01 0 2.49 2.05 3.96 4.88 3.96.95 0 1.95-.19 2.76-.54l-.06-3.14h-2.31v-1.85h4.26l.1 6.87z" />
                                        </svg>
                                        Symfony
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">

                                        Socialite
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">

                                        Fortify
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">

                                        PhP Artisan
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 24 24" xmlns="http://w3.org">
                                            <path fill="#5E4E3C"
                                                d="M12.4 2.8c-1 .3-1.6 1.4-1.3 2.4.2.8.9 1.3 1.7 1.3.1 0 .2 0 .4-.1.4 1.1.2 2.3-.5 3.3l-.3.4c-.6.8-1.5 1.3-2.5 1.3h-.5c-.8 0-1.5-.4-1.9-1.1-.1-.2-.2-.4-.2-.7 0-.5.2-.9.5-1.3l.3-.4c.7-1 1-2.2.8-3.4-.2-1.1-1.1-2-2.3-2.1-1.3-.2-2.5.8-2.6 2.1-.1.7.2 1.4.7 1.9.3.3.7.5 1.1.6-.2 1.5-.9 2.8-2 3.8-.5.5-.8 1.1-.9 1.8 0 .8.3 1.5.8 2 .9.9 2.1 1.4 3.4 1.4h.8c1.3 0 2.5-.5 3.4-1.4.5-.5.8-1.2.8-2 0-.7-.3-1.3-.8-1.8-1.1-1-1.8-2.3-2-3.8.4-.1.8-.3 1.1-.6.5-.5.8-1.2.7-1.9-.1-1.3-1.3-2.3-2.6-2.1z" />
                                            <path fill="#755839"
                                                d="M12 21.2c-4.4 0-8-3.6-8-8 0-1.1.2-2.1.6-3.1 1.1-1 1.8-2.3 2-3.8-.4.1-.8.3-1.1.6-.5.5-.8 1.2-.7 1.9.1 1.3 1.3 2.3 2.6 2.1 1.2-.1 2.1-1 2.3-2.1.2-1.2-.1-2.4-.8-3.4L8.6 5c-.3.4-.5.8-.5 1.3 0 .3.1.5.2.7.4.7 1.1 1.1 1.9 1.1h.5c1 0 1.9-.5 2.5-1.3l.3-.4c.7-1 .9-2.2.5-3.3-.2.1-.3.1-.4.1-.8 0-1.5-.5-1.7-1.3-.3-1 .3-2.1 1.3-2.4 1.3-.3 2.5.7 2.6 2.1.1.7-.2 1.4-.7 1.9-.3.3-.7.5-1.1.6.2 1.5.9 2.8 2 3.8-.4 1-1.2 1.8-2.2 2.3.4 1 1.2 1.8 2.2 2.3-.4 1.1-.6 2.3-.6 3.5 0 4.4-3.6 8-8 8z" />
                                        </svg>
                                        Composer
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 24 24" xmlns="http://w3.org">
                                            <path fill="#336791"
                                                d="M12.1 2c-.3 0-.5.1-.7.2-2.3 1.1-4 3.3-4.5 5.8-.1.4-.1.8-.1 1.2 0 .4.1.7.2 1.1.2.6.5 1.1.9 1.5.3.3.6.6 1 .8.4.2.8.3 1.2.4.4.1.8.1 1.2.1.8 0 1.5-.1 2.2-.4.7-.3 1.3-.7 1.7-1.3.4-.6.7-1.3.8-2.1.1-.7.1-1.5-.1-2.2-.2-.7-.5-1.4-.9-2-.4-.6-.9-1.1-1.5-1.5-.6-.4-1.2-.7-1.9-.9-.7-.3-1.4-.4-2.1-.4-.4 0-.8 0-1.1.1 1.5-1.4 3.7-2.1 5.9-1.8.9.1 1.8.4 2.6.8.8.4 1.5 1 2.1 1.7.6.7 1 1.5 1.2 2.4.2.9.3 1.8.1 2.7-.2.9-.5 1.8-1.1 2.5s-1.2 1.3-2 1.8c-.8.5-1.7.8-2.6 1-.9.2-1.8.2-2.7.1-.4 0-.8-.1-1.2-.2 1.3.8 2.8 1.2 4.4 1.1 1.2-.1 2.4-.4 3.4-1.1 1-.6 1.9-1.5 2.5-2.5.6-1.1.9-2.3 1-3.6 0-1.3-.3-2.5-.9-3.6-.6-1.1-1.5-2.1-2.5-2.8C18.6 3.1 17.3 2.5 16 2.2c-1.3-.3-2.6-.3-3.9-.2z" />
                                        </svg>
                                        PostGres
                                    </div>

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 24 24" xmlns="http://w3.org">
                                            <path fill="#D82C20"
                                                d="M21.6 12.3c0-.4-.2-.8-.6-1l-8.4-4.6c-.4-.2-.8-.2-1.2 0L3 11.3c-.4.2-.6.6-.6 1s.2.8.6 1l8.4 4.6c.2.1.4.2.6.2s.4-.1.6-.2l8.4-4.6c.4-.2.6-.6.6-1zM12 15.3l-6.1-3.3L12 8.7l6.1 3.3L12 15.3zm9.6-7c0-.4-.2-.8-.6-1L12.6 2.7c-.4-.2-.8-.2-1.2 0L3 7.3c-.4.2-.6.6-.6 1s.2.8.6 1l2.4 1.3 1.2-.6L5.4 9 12 5.4 18.6 9l-1.2.7 1.2.6 2.4-1.3c.4-.2.6-.6.6-1zm0 8.6c0-.4-.2-.8-.6-1l-2.4-1.3-1.2.7 1.2.6 1.2.7-6.6 3.6-6.6-3.6 1.2-.7-1.2-.6-2.4 1.3c-.4.2-.6.6-.6 1s.2.8.6 1l8.4 4.6c.2.1.4.2.6.2s.4-.1.6-.2l8.4-4.6c.4-.2.6-.6.6-1z" />
                                        </svg>
                                        Redis
                                    </div>

                                </div>
                            </ui>

                            <ui class="relative flex items-center gap-4 py-2 before:absolute before:top-0 before:bottom-0
                                before:left-[1.2rem] before:border-l before:border-[#e3e3e0]
                                dark:before:border-[#3E3E3A]">
                                <span class="relative py-1">
                                    <span
                                        class="flex h-10 w-10 items-center justify-center rounded-full border-2 border-[#e3e3e0] bg-[#FDFDFC] shadow-[0px_0px_1px_0px_rgba(0,0,0,0.03),0px_1px_2px_0px_rgba(0,0,0,0.06)] dark:border-[#3E3E3A] dark:bg-[#161615]">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://w3.org">
                                            <!-- Rocket (Ship/Launch) -->
                                            <path d="M12 2s.5 4 0 7c-3 0-7-.5-7-.5L12 2z" fill="#A78BFA" />
                                            <path d="M12 2s-.5 4 0 7c3 0 7-.5 7-.5L12 2z" fill="#8B5CF6" />
                                            <!-- Launch Base / Platform -->
                                            <path d="M5 20h14" stroke="#FFFFFF" stroke-width="2.5"
                                                stroke-linecap="round" />
                                            <!-- Blast Off / Smoke -->
                                            <path d="M9 16l-2 2M15 16l2 2M12 15v4" stroke="#F87171" stroke-width="2"
                                                stroke-linecap="round" />
                                        </svg>
                                    </span>
                                </span>
                                <p class=" text-2xl text-gray-500 nunito-sans-100 font-bold">
                                    Deployment
                                </p>
                                <div class="p-3 flex flex-wrap gap-2">

                                    <div class="flex gap-2 rounded-md p-3 border border-orange-600">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://w3.org">
                                            <!-- The Railway "R" track icon -->
                                            <path d="M4 4V20H20V12H12V20M12 12V4H20" stroke="white" stroke-width="2.5"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        Railway.com
                                    </div>

                                </div>
                            </ui>

                        </ul>
                        <p class=" text-lg font-extrabold nunito-sans-100">
                            Features
                        </p>
                        <ul class="flex flex-col">
                            <ui>
                                <span class="mx-2 font-extrabold">Artificial Intelligence:</span>
                                <span class="text-justify text-gray-400">Understands user context through text chat and
                                    images</span>
                            </ui>
                            <ui>
                                <span class="mx-2 font-extrabold">Robust Security:</span>
                                <span class="text-justify text-gray-400">Aside from Laravel's fortify, users can also
                                    login using google, facebook or linkedin accounts.</span>
                            </ui>
                            <ui>
                                <span class="mx-2 font-extrabold">User-Centric Design:</span>
                                <span class="text-justify text-gray-400">Minimalist and modern user interface
                                    design</span>
                            </ui>
                            <ui>
                                <span class="mx-2 font-extrabold">Adaptive Architecture:</span>
                                <span class="text-justify text-gray-400">Engineering fluid, mobile-first layouts that
                                    ensure a consistent experience across the device spectrum.</span>
                            </ui>
                        </ul>
                        <br>
                        <p class=" text-lg font-extrabold nunito-sans-100">
                            Challenges
                        </p>
                        <ul class="flex flex-col">
                            <ui>
                                <span class="mx-2 font-extrabold">Choice of AI Platform:</span>
                                <span class="text-justify text-gray-400">Nowadays, many companies are offering different
                                    AI products and service. Selecting the optimized model for the required job is
                                    difficult.</span>
                            </ui>
                            <ui>
                                <span class="mx-2 font-extrabold">Security:</span>
                                <span class="text-justify text-gray-400">Malicious users may inject bad code to the
                                    system. Filtering the user input proves to be hard.</span>
                            </ui>
                            <ui>
                                <span class="mx-2 font-extrabold">Prompt Engineering:</span>
                                <span class="text-justify text-gray-400">AI LLMs are so powerful however the quality of
                                    system prompt may hinder or boost the AI response to the user. Designing the right
                                    system prompt is quite a challenge.</span>
                            </ui>
                            <ui>
                                <span class="mx-2 font-extrabold">Adaptive User Interface:</span>
                                <span class="text-justify text-gray-400">User experience is a very important aspect in
                                    the design of any web app. Making the app appeal to may kinds of user device is
                                    tough.</span>
                            </ui>
                        </ul>
                        <br>
                        <p class=" text-lg font-extrabold nunito-sans-100">
                            Learnings
                        </p>
                        <ul class="flex flex-col">
                            <ui>
                                <span class="mx-2 font-extrabold">Choice of AI Platform:</span>
                                <span class="text-justify text-gray-400">Nowadays, many companies are offering different
                                    AI products and service. Selecting the optimized model for the required job is
                                    difficult.</span>
                            </ui>
                            <ui>
                                <span class="mx-2 font-extrabold">Security:</span>
                                <span class="text-justify text-gray-400">Malicious users may inject bad code to the
                                    system. Filtering the user input proves to be hard.</span>
                            </ui>
                            <ui>
                                <span class="mx-2 font-extrabold">Prompt Engineering:</span>
                                <span class="text-justify text-gray-400">AI LLMs are so powerful however the quality of
                                    system prompt may hinder or boost the AI response to the user. Designing the right
                                    system prompt is quite a challenge.</span>
                            </ui>
                            <ui>
                                <span class="mx-2 font-extrabold">Adaptive User Interface:</span>
                                <span class="text-justify text-gray-400">User experience is a very important aspect in
                                    the design of any web app. Making the app appeal to may kinds of user device is
                                    tough.</span>
                            </ui>
                        </ul>
                        <br>
                        <div class="w-[80%] h-[2px] border-b mx-auto"></div>
                    </div>
                    <ubtn @click="gisClick" class=" bg-transparent hover:bg-transparent p-0 mt-auto ml-auto mr-3 w-fit">
                        <span class="flex flex-row  hover:cursor-pointer text-white gap-2">
                            <i class=" text-red-800">Close</i> <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" viewBox="0 0 24 24" fill="none" stroke="#0357c4" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-chevron-right-icon lucide-chevron-right">
                                <path d="m9 18 6-6-6-6" />
                            </svg>
                        </span>
                    </ubtn>
                </div>
            </div>
        </section>

        <!-- Services -->
        <section class=" flex flex-col lg:flex-row section">
            <div
                class="panel left  bg-green-700/10 backdrop-blur-sm border-b lg:border-r lg:border-r-white/30  bg-linear-to-br  from-green-800/20 to-red-800/20  w-full lg:w-[30vw] h-full overflow-hidden p-4 flex flex-col items-center justify-center lg:p-20">
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
            <div class="panel right  w-full lg:w-[70vw] h-full overflow-visible p-4 opacity-70 flex flex-wrap gap-1 items-center justify-start ml-auto lg:p-20"
                style="transition-delay: 1.3s;">
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

        <!-- Why Hire Me? -->
        <section class=" flex flex-col lg:flex-row section">
            <div class="panel left w-full lg:w-[70vw] h-full overflow-visible p-4 opacity-70 flex flex-wrap gap-1 items-center justify-end text-right ml-auto lg:p-20"
                style="transition-delay: 1.3s;">
                <ul class="mb-4 flex flex-col lg:mb-6 text-2xl text-right">
                    <li
                        class="relative flex items-center gap-4 py-2 before:absolute before:top-0 before:bottom-0 before:right-[0.4rem] before:border-l before:border-[#e3e3e0] dark:before:border-[#3E3E3A]">
                        <div class="ml-auto"></div>
                        <span>
                            Uses modern framework to enable fast development
                        </span>
                        <span class="relative bg-white py-1 dark:bg-[#161615]">
                            <span
                                class="flex h-3.5 w-3.5 items-center justify-center rounded-full border border-[#e3e3e0] bg-[#FDFDFC] shadow-[0px_0px_1px_0px_rgba(0,0,0,0.03),0px_1px_2px_0px_rgba(0,0,0,0.06)] dark:border-[#3E3E3A] dark:bg-[#161615]">
                                <span class="h-1.5 w-1.5 rounded-full bg-[#dbdbd7] dark:bg-[#3E3E3A]" />
                            </span>
                        </span>

                    </li>
                    <li
                        class="relative flex items-center gap-4 py-2 before:absolute before:top-0 before:bottom-0 before:right-[0.4rem] before:border-l before:border-[#e3e3e0] dark:before:border-[#3E3E3A]">
                        <div class="ml-auto"></div>
                        <span>
                            Clean, maintainable code
                        </span>
                        <span class="relative bg-white py-1 dark:bg-[#161615]">
                            <span
                                class="flex h-3.5 w-3.5 items-center justify-center rounded-full border border-[#e3e3e0] bg-[#FDFDFC] shadow-[0px_0px_1px_0px_rgba(0,0,0,0.03),0px_1px_2px_0px_rgba(0,0,0,0.06)] dark:border-[#3E3E3A] dark:bg-[#161615]">
                                <span class="h-1.5 w-1.5 rounded-full bg-[#dbdbd7] dark:bg-[#3E3E3A]" />
                            </span>
                        </span>

                    </li>
                    <li
                        class="relative flex items-center gap-4 py-2 before:absolute before:top-0 before:bottom-0 before:right-[0.4rem] before:border-l before:border-[#e3e3e0] dark:before:border-[#3E3E3A]">
                        <div class="ml-auto"></div>
                        <span>
                            Eager to solve problems
                        </span>
                        <span class="relative bg-white py-1 dark:bg-[#161615]">
                            <span
                                class="flex h-3.5 w-3.5 items-center justify-center rounded-full border border-[#e3e3e0] bg-[#FDFDFC] shadow-[0px_0px_1px_0px_rgba(0,0,0,0.03),0px_1px_2px_0px_rgba(0,0,0,0.06)] dark:border-[#3E3E3A] dark:bg-[#161615]">
                                <span class="h-1.5 w-1.5 rounded-full bg-[#dbdbd7] dark:bg-[#3E3E3A]" />
                            </span>
                        </span>

                    </li>
                    <li
                        class="relative flex items-center gap-4 py-2 before:absolute before:top-0 before:bottom-0 before:right-[0.4rem] before:border-l before:border-[#e3e3e0] dark:before:border-[#3E3E3A]">
                        <div class="ml-auto"></div><span>
                            Strong Engineering backround
                        </span>
                        <span class="relative bg-white py-1 dark:bg-[#161615]">
                            <span
                                class="flex h-3.5 w-3.5 items-center justify-center rounded-full border border-[#e3e3e0] bg-[#FDFDFC] shadow-[0px_0px_1px_0px_rgba(0,0,0,0.03),0px_1px_2px_0px_rgba(0,0,0,0.06)] dark:border-[#3E3E3A] dark:bg-[#161615]">
                                <span class="h-1.5 w-1.5 rounded-full bg-[#dbdbd7] dark:bg-[#3E3E3A]" />
                            </span>
                        </span>

                    </li>
                    <li
                        class="relative flex items-center gap-4 py-2 before:absolute before:top-0 before:bottom-0 before:right-[0.4rem] before:border-l before:border-[#e3e3e0] dark:before:border-[#3E3E3A]">
                        <div class="ml-auto"></div><span>
                            Uses AI-assisted productivity tools
                        </span>
                        <span class="relative bg-white py-1 dark:bg-[#161615]">
                            <span
                                class="flex h-3.5 w-3.5 items-center justify-center rounded-full border border-[#e3e3e0] bg-[#FDFDFC] shadow-[0px_0px_1px_0px_rgba(0,0,0,0.03),0px_1px_2px_0px_rgba(0,0,0,0.06)] dark:border-[#3E3E3A] dark:bg-[#161615]">
                                <span class="h-1.5 w-1.5 rounded-full bg-[#dbdbd7] dark:bg-[#3E3E3A]" />
                            </span>
                        </span>

                    </li>
                    <li
                        class="relative flex items-center gap-4 py-2 before:absolute before:top-0 before:bottom-0 before:right-[0.4rem] before:border-l before:border-[#e3e3e0] dark:before:border-[#3E3E3A]">
                        <div class="ml-auto"></div><span>
                            Always willing to learn new things
                        </span>
                        <span class="relative bg-white py-1 dark:bg-[#161615]">
                            <span
                                class="flex h-3.5 w-3.5 items-center justify-center rounded-full border border-[#e3e3e0] bg-[#FDFDFC] shadow-[0px_0px_1px_0px_rgba(0,0,0,0.03),0px_1px_2px_0px_rgba(0,0,0,0.06)] dark:border-[#3E3E3A] dark:bg-[#161615]">
                                <span class="h-1.5 w-1.5 rounded-full bg-[#dbdbd7] dark:bg-[#3E3E3A]" />
                            </span>
                        </span>

                    </li>
                    <li
                        class="relative flex items-center gap-4 py-2 before:absolute before:top-0 before:bottom-0 before:right-[0.4rem] before:border-l before:border-[#e3e3e0] dark:before:border-[#3E3E3A]">
                        <div class="ml-auto"></div><span>
                            Strives hard to deliver commitments
                        </span>
                        <span class="relative bg-white py-1 dark:bg-[#161615]">
                            <span
                                class="flex h-3.5 w-3.5 items-center justify-center rounded-full border border-[#e3e3e0] bg-[#FDFDFC] shadow-[0px_0px_1px_0px_rgba(0,0,0,0.03),0px_1px_2px_0px_rgba(0,0,0,0.06)] dark:border-[#3E3E3A] dark:bg-[#161615]">
                                <span class="h-1.5 w-1.5 rounded-full bg-[#dbdbd7] dark:bg-[#3E3E3A]" />
                            </span>
                        </span>

                    </li>
                </ul>
                <!--span class=" text-2xl font-semibold"> • </span> <br>
                <span class=" text-2xl font-semibold">• </span> <br>
                <span class=" text-2xl font-semibold">• </span> <br>
                <span class=" text-2xl font-semibold"> • </span> <br>
                <span class=" text-2xl font-semibold"> • </span> <br>
                <span class=" text-2xl font-semibold"> • </span> <br>
                <span class=" text-2xl font-semibold">• </span> -->
            </div>
            <div
                class="panel right bg-orange-600/10 backdrop-blur-sm border-t lg:border-l lg:border-l-white/20 bg-linear-to-br  from-orange-800/20 to-green-800/20 w-full lg:w-[30vw] h-full overflow-hidden p-4 opacity-70 flex flex-col items-center justify-center lg:p-20">
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

        <!-- Demo App -->
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
                        <div class="panel left md:w-[300px] rounded-br-lg rounded-bl-lg bg-white p-4 text-[13px] leading-[20px] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] lg:rounded-tl-lg lg:rounded-br-none dark:bg-[#161615] dark:text-[#EDEDEC] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d]  bg-linear-to-br  from-green-800/20 to-red-800/20"
                            style="transition-delay: 1.6s;">
                            <h1 class="mb-1 font-medium">Please visit my demo web app</h1>
                            <p class="mb-2 text-[#706f6c] dark:text-[#A1A09A]">
                                This demo web app showcases my capabilities as a full stack developer. <br> Note that
                                all interactions
                                are not
                                permanently
                                recorded.
                            </p>
                            <ul class="mb-4 flex flex-col lg:mb-6">
                                <li
                                    class="relative flex items-center gap-4 py-2 before:absolute before:top-0 before:bottom-0 before:left-[0.4rem] before:border-l before:border-[#e3e3e0] dark:before:border-[#3E3E3A]">
                                    <span class="relative py-1">
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
                                    <span class="relative py-1">
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
                                    <span class="relative  py-1">
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
                        <div class="panel right h-[100%] overflow-hidden flex-1" style="transition-delay: 2.9s;">
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

.dialogbg-hidden.dialogbgShow {
    opacity: 1;
    transform: translateX(0) translateY(0) scale(1);
    transition: all 2.4s cubic-bezier(0.22, 1, 0.36, 1);
}

.dialogbg-hidden {
    opacity: 0;
    transform: translateX(0px) translateY(0px) scale(1);
    transition: all 2.4s cubic-bezier(0.22, 1, 0.36, 1);
}

.dialog-hidden.dialogbgShow {
    transition-delay: 1000ms;
    opacity: 1;
    transform: translateX(0) translateY(0) scale(1);
    transition: all 2.4s cubic-bezier(0.22, 1, 0.36, 1);
}

.dialog-hidden {
    opacity: 1;
    transform: translateX(-170px) translateY(160px) scale(0);
    transition: all 3.4s cubic-bezier(0.22, 1, 0.36, 1);
}

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
    transform: translateX(100px) scale(1);
}

.putSomeDelay {
    transition-delay: 1.3s;
}

.panel.still {
    opacity: 1;
    transform: translateX(0) scale(1);
}

.panel.left {
    opacity: 0;
    transform: translateX(-100px) scale(0.95);
}

.panel.right {
    opacity: 0;
    transform: translateX(100px) scale(0.95);
}

.panel.left.active {
    opacity: 1;
    transform: translateX(0) scale(1);
    transition: all 2.4s cubic-bezier(0.22, 1, 0.36, 1);
}

.panel.right.active {
    opacity: 1;
    transform: translateX(0) scale(1);
    transition: all 2.4s cubic-bezier(0.22, 1, 0.36, 1);
}
</style>
