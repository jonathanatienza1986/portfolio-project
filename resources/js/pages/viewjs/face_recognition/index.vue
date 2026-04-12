<!-- eslint-disable import/order -->
<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
//------------------------------------------------------------basic ui comps frm shadcn
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
//------------------------------------------------------------routed
//import { template, dashboard } from '@/routes';
// eslint-disable-next-line vue/no-dupe-keys
import face_recognition from '@/routes/face_recognition';

//------------------------------------------------------------code starts here
// access page info such as user
const page = usePage();

// obtain data from webserver, replace 'complaint' with real object
interface Props {
    customers: { type: Array, },
}
const props = defineProps<Props>();

// form data
// eslint-disable-next-line @typescript-eslint/no-unused-vars
const form = ref({
    account_number: "",
    email: "",
    name: "",
    address: "",
    phone: "",
    birth_place: "",
    birth_date: "",
    sex: "",
    marital_status: "",
    license_image: null,
    license_id_no: "",
    license_expity_date: "",
    govt_id_image: null,
    govt_id_no: "",
    govt_id_type: "",
    portrait_image: null,
    pic1_image: null,
    pic2_image: null,
    pic3_image: null,
});

onMounted(() => { // invoked when page ready
    // Vanilla JS: Get a URL parameter
    const params = new URLSearchParams(window.location.search);
    const userId = params.get('id');
    console.log("User ID from URL:", userId); // If the URL is /products?category=electronics&sort=price

    form.value = { ...form.value, ...props.customers }; // merge key:value pair
    //form.value.name = page.props.auth.user.email;
    console.log("Login User id ", page.props.auth.user.id);
    console.log("Login User Email ", page.props.auth.user.email);

    //scroll page to the table header element
    video.value?.scrollIntoView({ behavior: 'smooth' });

    //------------------------------------ start of face recognition
    faceRecog.value.startWebcam(); // maybe not needed
    faceRecog.value.loadModels("/models"); // be sure that /models exists with weight files
    setTimeout(() => {
        faceRecog.value.trainFaceMatching(training_data); // upon finish it will emit handleTrainingDone(xLabeledFaces) in which xLabeledFaces will be save externally
        // or
        // faceRecog.value.obtainFaceMatchingData (xLabeledFaces)
    }, 1000);
    setTimeout(() => {
        faceRecog.value.startFaceMatching();
    }, 4000); // the length of this setTimeout depends on size of training_data
});

//-------------------------------------------- Prev and Next Page Buttons
const isDisabled = ref(false)
const prev_page_loading = ref(false);
const prev_page = () => {
    prev_page_loading.value = true;
    isDisabled.value = true;
    const form_payload = useForm();
    form_payload.get(customer.index().url, {
        //----------------------------------------- force ajax parameters
        preserveScroll: true,
        preserveState: true,
    });
};

const next_page_loading = ref(false);
const next_page = () => {
    next_page_loading.value = true;
    isDisabled.value = true;
    const form_payload = useForm(form.value);
    form_payload.post(customer.post().url, {
        //----------------------------------------- force ajax parameters
        preserveScroll: true,
        preserveState: true,
    });
}

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Face Recognition',
                href: face_recognition.index(),
            },
        ],
    },
});

//--------------------------------------------------------------------------- navigation-menu
import { /* CircleCheckIcon,*/ CircleHelpIcon, CircleIcon } from 'lucide-vue-next'
import {
    NavigationMenu,
    NavigationMenuContent,
    NavigationMenuItem,
    NavigationMenuLink,
    NavigationMenuList,
    NavigationMenuTrigger,
} from '@/components/ui/navigation-menu';

// Refs and Variable Area

/*
const training_data = [
    {
        name: "Herrel Mikaela Espino",
        images: [
            "/face_data/mikmik1.png", "/face_data/mikmik2.png",
        ],
    },
    {
        name: "Naria Lolita Cacho",
        images: [
            "/face_data/MaLo1.jpg", "/face_data/MaLo2.jpg",
        ],
    },
    {
        name: "Gina Lou Cacho",
        images: [
            "/face_data/gina1.png", "/face_data/gina2.png", "/face_data/gina3.png", "/face_data/gina4.png",
        ],
    },
    {
        name: "Garry",
        images: [
            "/face_data/garry1.jpg", "/face_data/garry2.jpg", "/face_data/garry3.jpg", "/face_data/garry5.jpg",
        ],
    },
    {
        name: "Grace dela Cruz",
        images: [
            "/face_data/grace1.jpg", "/face_data/grace2.jpg",
        ],
    },
];
*/

// declare an empty training data
const training_data = [];

// load customers to training data
for (const customer of props.customers) {
    const training_item = {
        name: customer.name,
        images: [
            customer.portrait_link,
            customer.pic1_link,
            customer.pic2_link,
            customer.pic3_link,
        ],
    }
    training_data.push(training_item);
}

console.log("training_data: ",training_data)

import { Vue3FaceRecog } from 'vue3-face-recog';
const video = ref();
const canvas2 = ref();
const faceRecog = ref();
const recog_name = ref("");
const if_face_recog_is_ready = ref(false);

const handleTrainingDone = (event) => {
    console.log("Training Done  ", event);
    if_face_recog_is_ready.value = true;
};

const handleMatchFace = (event) => {
    console.log("MatchFace Done  ", event);

    if (event._distance > 0.15) {
        recog_name.value = event._label
    }
};
</script>

<template>

    <Head title="face_recognition.index" />

    <!-- Main Frame DIV -->
    <div class=" z-0 h-full w-full overflow-auto p-0 m-0 justify-center">

        <!-- Page Main Menu -->
        <div class=" absolute top-0 h-12 pt-3 z-50 flex w-[300px]">
            <NavigationMenu :viewport="false" class="">
                <NavigationMenuList>
                    <NavigationMenuItem>
                        <NavigationMenuTrigger>Go to</NavigationMenuTrigger>
                        <NavigationMenuContent>
                            <ul class="grid w-[200px] gap-4">
                                <li>
                                    <NavigationMenuLink as-child>
                                        <a :href="face_recognition.index().url" class="flex-row items-center gap-2">
                                            <CircleHelpIcon />
                                            Register New Customer
                                        </a>
                                    </NavigationMenuLink>
                                    <NavigationMenuLink as-child>
                                        <a :href="face_recognition.index().url" class="flex-row items-center gap-2">
                                            <CircleIcon />
                                            List of Customer
                                        </a>
                                    </NavigationMenuLink>
                                </li>
                            </ul>
                        </NavigationMenuContent>
                    </NavigationMenuItem>
                </NavigationMenuList>
            </NavigationMenu>
        </div>

        <!-- Form Frame -->
        <div class="p-8 flex flex-col w-full lg:w-[90%] gap-7">

            <!-- Title -->
            <div class="flex gap-4 items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-smile-icon lucide-smile">
                    <circle cx="12" cy="12" r="10" />
                    <path d="M8 14s1.5 2 4 2 4-2 4-2" />
                    <line x1="9" x2="9.01" y1="9" y2="9" />
                    <line x1="15" x2="15.01" y1="9" y2="9" />
                </svg>
                <span class="lg:text-2xl font-semibold">
                    Face Recognition
                </span>
            </div>

            <div class="w-full">
                <div class="relative m-0 p-0 border rounded-lg overflow-hidden w-[600px] h-[450]">
                    <video ref="video" width="600" height="450" autoplay class="border rounded-lg"></video>
                    <canvas ref="canvas2" width="600" height="450"
                        class="absolute top-0 left-0 border rounded-lg"></canvas>
                    <Vue3FaceRecog ref="faceRecog" :video="video" :canvas="canvas2" @onTrainingDone="handleTrainingDone"
                        @onMatchFace="handleMatchFace" />
                </div>
                <br>
                <div v-show="if_face_recog_is_ready" class="flex flex-row gap-3">
                    <Input type="text" v-model="recog_name" class="border  rounded-lg p-3" />
                    <Button
                        class="bg-black text-amber-100 px-4 rounded-lg hover:cursor-pointer hover:bg-gray-700 active:bg-gray-500">Save</Button>
                </div>
            </div>

            <!-- prev next buttons-->
            <div class="flex flex-row  mb-20 mt-10 pt-10 border-t">
                <Button :disabled="isDisabled" class=" cursor-pointer active:bg-amber-200 h-14" @click="prev_page">
                    <div v-show="!prev_page_loading">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-arrow-left-to-line-icon lucide-arrow-left-to-line">
                            <path d="M3 19V5" />
                            <path d="m13 6-6 6 6 6" />
                            <path d="M7 12h14" />
                        </svg>
                    </div>
                    <div v-show="prev_page_loading" class=" animate-spin">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-loader-circle-icon lucide-loader-circle">
                            <path d="M21 12a9 9 0 1 1-6.219-8.56" />
                        </svg>
                    </div>
                    List Page
                </Button>
                <div class="ml-auto"></div>
                <Button :disabled="isDisabled" class=" cursor-pointer active:bg-amber-200 h-14" @click="next_page">
                    <div v-show="next_page_loading" class=" animate-spin">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-loader-circle-icon lucide-loader-circle">
                            <path d="M21 12a9 9 0 1 1-6.219-8.56" />
                        </svg>
                    </div>
                    Save Page
                    <div v-show="!next_page_loading">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-arrow-right-to-line-icon lucide-arrow-right-to-line">
                            <path d="M17 12H3" />
                            <path d="m11 18 6-6-6-6" />
                            <path d="M21 5v14" />
                        </svg>
                    </div>
                </Button>
            </div>
        </div>
    </div>
</template>
