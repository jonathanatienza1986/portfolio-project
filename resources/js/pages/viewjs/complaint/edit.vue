<!-- eslint-disable import/order -->
<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
//------------------------------------------------------------basic ui comps frm shadcn
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

//------------------------------------------------------------routed
import { template, dashboard } from '@/routes';
// eslint-disable-next-line vue/no-dupe-keys
import complaint from '@/routes/complaint';

//------------------------------------------------------------code starts here
// access page info such as user
// eslint-disable-next-line @typescript-eslint/no-unused-vars
const page = usePage();
// replace 'complaint' with real object
interface Props {
    complaint: object,
}
const props = defineProps<Props>();

// eslint-disable-next-line @typescript-eslint/no-unused-vars
const form = ref({
    //user_id: page.props.auth.user.email,
    //name: page.props.auth.user.email,
    accountnumber: "",
    name: "",
    address: "",
    complaint: "",
    description: "",
    image_file: null
});

onMounted(() => { // invoked when page ready
    // Vanilla JS: Get a URL parameter
    const params = new URLSearchParams(window.location.search);
    const userId = params.get('id');
    console.log("User ID from URL:", userId); // If the URL is /products?category=electronics&sort=price

    form.value = { ...form.value, ...props.complaint }; // merge key:value pair
    file_base64.value = form.value.picture;
    //form.value.name = page.props.auth.user.email;
    //console.log("Garry Cacho ", page.props.auth.user.email);
});

//---------------------------------------------------------- Prev and Next Page Buttons
const isDisabled = ref(false)
const prev_page_loading = ref(false);
const prev_page = () => {
    prev_page_loading.value = true;
    isDisabled.value = true;
    const form_payload = useForm(form.value);
    form_payload.get(complaint.show(form_payload.id).url, { 'id': form_payload.id });
};

const next_page_loading = ref(false);
const next_page = () => {
    next_page_loading.value = true;
    isDisabled.value = true;
    const form_payload = useForm(form.value);
    form_payload.post(complaint.update(form_payload.id).url, { 'id': form_payload.id });
};

defineOptions({
    layout: {
        breadcrumbs: [{
                title: 'Edit Complaint',
                href: template(),
        },],
    },
});

//--------------------------------------------------------------------------- navigation-menu
import { /*CircleCheckIcon,*/ CircleHelpIcon, CircleIcon } from 'lucide-vue-next'
import {
    NavigationMenu,
    NavigationMenuContent,
    NavigationMenuItem,
    NavigationMenuLink,
    NavigationMenuList,
    NavigationMenuTrigger,
} from '@/components/ui/navigation-menu';

// --------------------------------------------------------------------------- Input file image/*
const file_base64 = ref("");
//---------------------------------------------------------------------------- drivers licnese
const file_change = (data) => {
    file_base64.value = URL.createObjectURL(data.target.files[0]);
    form.value.image_file = data.target.files[0];
    console.log(form.value.image_file);
}
//--------------------------------------------------------------------------- dialog
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog';

// --------------------------------------------------------------------------- simple-vue-camera
import SimpleVueCamera from 'simple-vue-camera';
const camera = ref(null);

const takePhoto = async () => {
    const blob = await camera.value?.snapshot();
    file_base64.value = URL.createObjectURL(blob);
    form.value.image_file = new File([blob], "zzmyimage12345.png", { type: blob.type, lastModified: Date.now() });
    console.log(blob);
    console.log(form.value.image_file);
};

</script>

<template>

    <Head title="complaint.edit" />

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
                                        <a :href="complaint.create().url" class="flex-row items-center gap-2">
                                            <CircleHelpIcon />
                                            Raise New Complaint
                                        </a>
                                    </NavigationMenuLink>
                                    <NavigationMenuLink as-child>
                                        <a :href="complaint.index().url" class="flex-row items-center gap-2">
                                            <CircleIcon />
                                            List of Complaints
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

            <!-- Activity Progress Indicator-->
            <div class="flex flex-row gap-2 p-2 lg:gap-6 lg:p-6 bg w-full justify-center border overflow-hidden">
                <div class="w-full border-t-4 text-mauve-200 dark:text-mauve-800 text-center">
                    Raise a Complaint
                </div>
                <div class="w-full border-t-4 text-mauve-200 dark:text-mauve-800 text-center">
                    View
                </div>
                <div
                    class="w-full border-t-8 border-blue-400 dark:border-blue-800 text-blue-400 dark:text-blue-800 text-center p-2 font-bold">
                    Modify
                </div>
                <div class="w-full border-t-4 text-mauve-200 dark:text-mauve-800 text-center">
                    Master List
                </div>
            </div>

            <!-- Title -->
            <div class="flex gap-4 items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-pencil-icon lucide-pencil">
                    <path
                        d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z" />
                    <path d="m15 5 4 4" />
                </svg>
                <span class="lg:text-2xl font-semibold">
                    Edit Complaint # {{ form.id }}
                </span>
            </div>

            <!-- Get Complaint Image 1 -->
            <div class="flex flex-col lg:flex-row gap-6">
                Image 1
                <div class="lg:w-[65%] flex flex-col gap-2 mb-0 border-2 rounded-xl min-w-72 overflow-hidden">
                    <img :src="file_base64" alt="x" style="object-fit: cover; margin: auto;  height: 100%;" />
                </div>
                <div class="lg:w-[35%]">
                    <div class="w-full flex flex-col gap-2 mb-0">
                        <Label class="font-bold" for="marital_status">Upload Complaint Picture</Label>
                        <div class="w-full h-10 rounded-lg mb-1 border overflow-hidden">
                            <Label htmlFor="image_file7"
                                class="h-full w-full border justify-center flex flex-row text-white bg-black dark:bg-mauve-100 dark:text-black">Select
                                a file</Label>
                            <Input id="image_file7" type="file" accept="image/*" name="image_file7"
                                @change="file_change" class="hidden" />
                        </div>
                    </div>
                    <div class="w-full flex flex-col gap-2 mb-0">
                        <Label class="font-bold" for="marital_status">or</Label>
                        <!-- Take Photo Camera Dialog Start Lincese Photo-->
                        <Dialog>
                            <DialogTrigger as-child>
                                <Button class="active:bg-amber-300 w-[100%]">Obtain from Web Cam</Button>
                            </DialogTrigger>
                            <DialogContent class="w-[100%]">
                                <DialogHeader>
                                    <DialogTitle>Web Cam</DialogTitle>
                                    <DialogDescription>
                                        Take a good look at the camera...
                                    </DialogDescription>
                                </DialogHeader>
                                <!-- Dialog Body Starts-->
                                <div class="grid gap-4">
                                    <simple-vue-camera ref="camera" :width="640" :height="480" image-format="jpeg" />
                                </div>
                                <!-- Dialog Body Ended -->
                                <DialogFooter>
                                    <DialogClose as-child>
                                        <Button @click="takePhoto">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-camera-icon lucide-camera">
                                                <path
                                                    d="M13.997 4a2 2 0 0 1 1.76 1.05l.486.9A2 2 0 0 0 18.003 7H20a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2h1.997a2 2 0 0 0 1.759-1.048l.489-.904A2 2 0 0 1 10.004 4z" />
                                                <circle cx="12" cy="13" r="3" />
                                            </svg>Take Photo</Button>
                                    </DialogClose>
                                </DialogFooter>
                            </DialogContent>
                        </Dialog>
                        <!-- Take Photo Camera Dialog Ended Lincese Photo-->
                    </div>
                </div>
            </div>

            <div class="flex flex-col lg:flex-row gap-6">
                <div class="w-full flex flex-col gap-2 mb-0">
                    <Label class="ont-bold" for="name"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-folder-pen-icon lucide-folder-pen">
                            <path
                                d="M2 11.5V5a2 2 0 0 1 2-2h3.9c.7 0 1.3.3 1.7.9l.8 1.2c.4.6 1 .9 1.7.9H20a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-9.5" />
                            <path
                                d="M11.378 13.626a1 1 0 1 0-3.004-3.004l-5.01 5.012a2 2 0 0 0-.506.854l-.837 2.87a.5.5 0 0 0 .62.62l2.87-.837a2 2 0 0 0 .854-.506z" />
                        </svg>Name</Label>
                    <Input type="text" placeholder="ex. Cacho, Garry M." name="name" v-model="form.name" />
                </div>
                <div class="w-full flex flex-col gap-2 mb-0">
                    <Label class="ont-bold" for="accountnumber"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-circle-user-round-icon lucide-circle-user-round">
                            <path d="M17.925 20.056a6 6 0 0 0-11.851.001" />
                            <circle cx="12" cy="11" r="4" />
                            <circle cx="12" cy="12" r="10" />
                        </svg>Coop Account Number</Label>
                    <Input type="text" placeholder="ex. 4564765745" name="accountnumber" v-model="form.accountnumber" />
                </div>
                <div class="w-full flex flex-col gap-2 mb-0">
                    <Label class="font-bold" for="address"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-map-pin-house-icon lucide-map-pin-house">
                            <path
                                d="M15 22a1 1 0 0 1-1-1v-4a1 1 0 0 1 .445-.832l3-2a1 1 0 0 1 1.11 0l3 2A1 1 0 0 1 22 17v4a1 1 0 0 1-1 1z" />
                            <path d="M18 10a8 8 0 0 0-16 0c0 4.993 5.539 10.193 7.399 11.799a1 1 0 0 0 .601.2" />
                            <path d="M18 22v-3" />
                            <circle cx="10" cy="10" r="3" />
                        </svg>Address</Label>
                    <Input type="text" placeholder="ex. McArthur Park, Beverly Hills, Samar, Philipines" name="address"
                        v-model="form.address" />
                </div>
            </div>

            <div class="flex flex-col lg:flex-row gap-6">
                <div class="w-full lg:w-[35%] flex flex-col gap-2 mb-0">
                    <Label class="font-bold" for="email_address"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-barrel-icon lucide-barrel">
                            <path d="M10 3a41 41 0 0 0 0 18" />
                            <path d="M14 3a41 41 0 0 1 0 18" />
                            <path
                                d="M17 3a2 2 0 0 1 1.68.92 15.25 15.25 0 0 1 0 16.16A2 2 0 0 1 17 21H7a2 2 0 0 1-1.68-.92 15.25 15.25 0 0 1 0-16.16A2 2 0 0 1 7 3z" />
                            <path d="M3.84 17h16.32" />
                            <path d="M3.84 7h16.32" />
                        </svg>Complaint</Label>
                    <Input type="text" placeholder="ex. sigepalong ang transformer" name="complaint"
                        v-model="form.complaint" />
                </div>
                <div class="w-full lg:w-[65%] flex flex-col gap-2 mb-0">
                    <Label class="font-bold" for="email_address"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-align-horizontal-distribute-start-icon lucide-align-horizontal-distribute-start">
                            <rect width="6" height="14" x="4" y="5" rx="2" />
                            <rect width="6" height="10" x="14" y="7" rx="2" />
                            <path d="M4 2v20" />
                            <path d="M14 2v20" />
                        </svg>Description</Label>
                    <Input type="text" placeholder="ex. daghay ga reklamo na kunsumante" name="description"
                        v-model="form.description" />
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
                    Cancel Page
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
