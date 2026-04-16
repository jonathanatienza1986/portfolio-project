<!-- eslint-disable import/order -->
<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
//------------------------------------------------------------basic ui comps frm shadcn
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select'
//------------------------------------------------------------routed
//import { template, dashboard } from '@/routes';
// eslint-disable-next-line vue/no-dupe-keys
import customer from '@/routes/customer';

//------------------------------------------------------------code starts here
// access page info such as user
const page = usePage();

interface Props {
    mems: { type: Array, },
    customer: object,
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

    form.value = { ...form.value, ...props.customer }; // merge key:value pair
    //form.value.name = page.props.auth.user.email;
    console.log("Login User id ", page.props.auth.user.id);
    console.log("Login User Email ", page.props.auth.user.email);
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
                title: 'New Customer',
                href: customer.create(),
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

// --------------------------------------------------------------------------- Input file image/*
const file_base64 = ref();

const file_change = (data) => { // drivers licnese
    file_base64.value = URL.createObjectURL(data.target.files[0]);
    form.value.license_image = data.target.files[0];
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
const camera = ref(null);  // drivers licnese

const takePhoto = async () => { // drivers license
    const blob = await camera.value?.snapshot();
    file_base64.value = URL.createObjectURL(blob);
    form.value.license_image = new File([blob], "myimage12345-0.png", { type: blob.type, lastModified: Date.now() });
};


// ------------------------------------------- brightness and contrast
const number1 = ref(40);
const number2 = ref(100);

// ------------------------------------------------------------- IDScan progress
import { Progress } from '@/components/ui/progress';
const progress = ref(0);

// ------------------------------------------------------------ sonner
import { toast } from 'vue-sonner';

// ------------------------------------------------------------ id scanner
import { Vue3OcrPhDriverLicenseParser } from 'vue3-ocr-ph-driver-license-parser';
const parser1 = ref();
const textOutput = ref();
//const imageDOM = ref();
const canvas = ref();
const id_data = ref(null);
const expiry_date_data = ref(null);
const name_data = ref(null);
const address_data = ref(null);

const brightness_changed = () => {
    const ctx = canvas.value.getContext('2d');
    const img = new Image();
    img.onload = () => {
        canvas.value.width = img.width;
        canvas.value.height = img.height;
        ctx.filter = "brightness(" + (2 * number1.value) + "%)  saturate(0%) contrast(" + (5 * number2.value) + "%)";
        ctx.drawImage(img, 0, 0);
    };
    console.log("file_base64.value ", file_base64.value);
    img.src = file_base64.value;
}

const fileScan = async () => {
    if (file_base64.value) {
        brightness_changed();
        const response = await fetch(canvas.value.toDataURL("image/png"));
        const blob = await response.blob();
        const image_file = new File([blob], "myimage12345-4.png", { type: blob.type, lastModified: Date.now() });
        parser1.value.openFile(image_file);
        progress.value = 0;
    }

    if (file_base64.value) {
        brightness_changed();
        const response = await fetch(canvas.value.toDataURL("image/png"));
        const blob = await response.blob();
        const image_file = new File([blob], "myimage12345-4.png", { type: blob.type, lastModified: Date.now() });
        parser1.value.openFile(image_file);
        progress.value = 0;
    }
}

const handleProgress = (event) => {
    progress.value = event;
}

const handleParse = (event) => {
    progress.value = 0;
    console.log("output ng laravel...........", event);
    toast('My first toast');
    id_data.value = event.license_id;
    expiry_date_data.value = event.expiry;
    name_data.value = event.name;
    address_data.value = event.address;
}

const clickme = () => {
    const form_payload = useForm(form.value);
    form_payload.post(customer.scan_id_using_ai().url, {
        //----------------------------------------- force ajax parameters
        preserveScroll: true,
        //preserveState: true,
        onSuccess: () => {
            const scanned_json = JSON.parse(JSON.parse(props?.mems[0]?.value));

            form.value.license_id_no = scanned_json.id_no;
            form.value.license_expity_date = scanned_json.expiry_date;
            form.value.name = scanned_json.full_name;
            form.value.address = scanned_json.address;
            form.value.sex = scanned_json.sex;
            form.value.birth_date = scanned_json.date_of_birth;

            console.log("scanned_json: ", scanned_json);
            console.log("form.value: ", form.value);
        },
    });

}

const copyScannedDataToForm = () => {
    form.value.license_id_no = id_data.value;
    form.value.license_expity_date = expiry_date_data.value;
    form.value.name = name_data.value;
    form.value.address = address_data.value;
    id_data.value = null;
}

</script>

<template>

    <Head title="customer.create" />

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
                                        <a :href="customer.create().url" class="flex-row items-center gap-2">
                                            <CircleHelpIcon />
                                            Register New Customer
                                        </a>
                                    </NavigationMenuLink>
                                    <NavigationMenuLink as-child>
                                        <a :href="customer.index().url" class="flex-row items-center gap-2">
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

            <!-- Activity Progress Indicator-->
            <div class="flex flex-row gap-2 p-2 lg:gap-6 lg:p-6 bg w-full justify-center border overflow-hidden">
                <div
                    class="w-full border-t-8 border-blue-400 dark:border-blue-800 text-blue-400 dark:text-blue-800 text-center p-2 font-bold">
                    Registration
                </div>
                <div class="w-full border-t-4 text-mauve-200 dark:text-mauve-800 text-center">
                    View
                </div>
                <div class="w-full border-t-4 text-mauve-200 dark:text-mauve-800 text-center">
                    Modify
                </div>
                <div class="w-full border-t-4 text-mauve-200 dark:text-mauve-800 text-center">
                    Customer List
                </div>
            </div>

            <!-- Title -->
            <div class="flex gap-4 items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-user-round-plus-icon lucide-user-round-plus">
                    <path d="M2 21a8 8 0 0 1 13.292-6" />
                    <circle cx="10" cy="8" r="5" />
                    <path d="M19 16v6" />
                    <path d="M22 19h-6" />
                </svg>
                <span class="lg:text-2xl font-semibold">
                    Registration of New Customer
                </span>
            </div>

            <!-- Get License Image -->
            <div class="flex flex-col lg:flex-row gap-6">
                Driver's License
                <div class="lg:w-[65%] flex flex-col gap-2 mb-0 border-2 rounded-xl min-w-72 overflow-hidden">
                    <img :src="file_base64" alt="x" style="object-fit: cover; margin: auto;  height: 100%;" />
                </div>
                <div class="lg:w-[35%]">
                    <div class="w-full flex flex-col gap-2 mb-0">
                        <Label class="font-bold" for="marital_status">Upload Driver's License</Label>
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
                    <br>
                    <br>
                    <div class="w-full flex flex-col gap-2 mb-6">
                        <Label class="font-bold" for="license_id">License ID:</Label>
                        <Input type="text" name="license_id" placeholder="ex. 90784389734789"
                            v-model="form.license_id_no" />
                    </div>
                    <div class="w-full flex flex-col gap-2 mb-6">
                        <Label class="font-bold" for="license_id_expiry_date">License Expiry Date</Label>
                        <Input type="text" name="license_id_expiry_date" v-model="form.license_expity_date" />
                    </div>
                    <div>
                        <Button v-show="file_base64"  @click="clickme" class="active:bg-amber-300 w-[100%] mb-3">
                            Scan the ID using AI
                        </Button>
                        <br>
                    </div>
                    <div>

                        <!-- Scan ID and parse it -->
                        <Dialog>
                            <DialogTrigger as-child>
                                <Button v-show="file_base64" class="active:bg-amber-300 w-[100%]">
                                    Scan ID Using Local JS
                                </Button>
                            </DialogTrigger>
                            <DialogContent class="w-[100%]">
                                <DialogHeader>
                                    <DialogTitle>Scan License ID</DialogTitle>
                                    <DialogDescription>
                                        Scans the license id and convert to storable data...
                                    </DialogDescription>
                                </DialogHeader>
                                <!-- Dialog Body Starts-->
                                <div class="w-full h-full flex flex-col gap-2">
                                    <div class="flex flex-row h-[10px] item-center">
                                        <span class="w-30">Brightness</span>
                                        <Input type="range" v-model="number1" @change="fileScan" class="h-[8px] mt-2" />
                                    </div>
                                    <div class="flex flex-row h-[10px] item-center">
                                        <span class="w-30">Contrast</span>
                                        <Input type="range" v-model="number2" class="h-[8px] mt-2" @change="fileScan" />
                                    </div>
                                    <div class="w-full h-full flex flex-col overflow-auto">
                                        <canvas ref="canvas" class="w-full h-full overflow-auto"></canvas>
                                    </div>
                                    <div>
                                        <Progress :model-value="progress" class="w-full" />
                                        <img ref="imageDOM" />
                                        <Vue3OcrPhDriverLicenseParser ref="parser1" :textOutput="textOutput"
                                            :imageDOM="imageDOM" @onProgress="handleProgress" @onParse="handleParse" />
                                    </div>
                                </div>
                                <!-- Dialog Body Ended -->
                                <DialogFooter>
                                    <Button class="cursor-pointer" @click="fileScan">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-scan-text-icon lucide-scan-text">
                                            <path d="M3 7V5a2 2 0 0 1 2-2h2" />
                                            <path d="M17 3h2a2 2 0 0 1 2 2v2" />
                                            <path d="M21 17v2a2 2 0 0 1-2 2h-2" />
                                            <path d="M7 21H5a2 2 0 0 1-2-2v-2" />
                                            <path d="M7 8h8" />
                                            <path d="M7 12h10" />
                                            <path d="M7 16h6" />
                                        </svg>Scan
                                    </Button>
                                    <div class="ml-auto"></div>
                                    <DialogClose as-child>
                                        <Button v-show="id_data" class="cursor-pointer" @click="copyScannedDataToForm">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-star-icon lucide-star">
                                                <path
                                                    d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z" />
                                            </svg>OK
                                        </Button>
                                    </DialogClose>

                                </DialogFooter>
                            </DialogContent>
                        </Dialog>
                    </div>
                </div>
            </div>

            <div class="flex flex-col lg:flex-row gap-6">
                <div class="w-full flex flex-col gap-2 mb-0">
                    <Label class="ont-bold" for="name">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-folder-pen-icon lucide-folder-pen">
                            <path
                                d="M2 11.5V5a2 2 0 0 1 2-2h3.9c.7 0 1.3.3 1.7.9l.8 1.2c.4.6 1 .9 1.7.9H20a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-9.5" />
                            <path
                                d="M11.378 13.626a1 1 0 1 0-3.004-3.004l-5.01 5.012a2 2 0 0 0-.506.854l-.837 2.87a.5.5 0 0 0 .62.62l2.87-.837a2 2 0 0 0 .854-.506z" />
                        </svg>Name</Label>
                    <Input type="text" placeholder="ex. Cacho, Garry M." name="name" v-model="form.name" />
                </div>
                <div class="w-full flex flex-col gap-2 mb-0">
                    <Label class="font-bold" for="address">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
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
                <div class="w-full flex flex-col gap-2 mb-0">
                    <Label class="ont-bold" for="account_number">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-circle-user-round-icon lucide-circle-user-round">
                            <path d="M17.925 20.056a6 6 0 0 0-11.851.001" />
                            <circle cx="12" cy="11" r="4" />
                            <circle cx="12" cy="12" r="10" />
                        </svg>Coop Account Number</Label>
                    <Input type="text" placeholder="ex. 4564765745" name="account_number"
                        v-model="form.account_number" />
                </div>
                <div class="w-full flex flex-col gap-2 mb-0">
                    <Label class="font-bold" for="email_address">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-mail-icon lucide-mail">
                            <path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7" />
                            <rect x="2" y="4" width="20" height="16" rx="2" />
                        </svg>Email Address</Label>
                    <Input type="email" placeholder="ex. myemail@gmail.com" name="email_address" v-model="form.email" />
                </div>
                <div class="w-full flex flex-col gap-2 mb-0">
                    <Label class="font-bold" for="phone_number">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-phone-icon lucide-phone">
                            <path
                                d="M13.832 16.568a1 1 0 0 0 1.213-.303l.355-.465A2 2 0 0 1 17 15h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2A18 18 0 0 1 2 4a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v3a2 2 0 0 1-.8 1.6l-.468.351a1 1 0 0 0-.292 1.233 14 14 0 0 0 6.392 6.384" />
                        </svg>Phone Number</Label>
                    <Input type="tel" placeholder="ex. 0999737423" name="phone_number" v-model="form.phone" />
                </div>
            </div>

            <div class="flex flex-col lg:flex-row gap-6">
                <div class="w-full flex flex-col gap-2 mb-0">
                    <Label class="font-bold" for="birthplace">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-cake-slice-icon lucide-cake-slice">
                            <path d="M16 13H3" />
                            <path d="M16 17H3" />
                            <path
                                d="m7.2 7.9-3.388 2.5A2 2 0 0 0 3 12.01V20a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1v-8.654c0-2-2.44-6.026-6.44-8.026a1 1 0 0 0-1.082.057L10.4 5.6" />
                            <circle cx="9" cy="7" r="2" />
                        </svg>
                        Birthplace
                    </Label>
                    <Input type="text" placeholder="ex. Manila, Philippines" name="birthplace"
                        v-model="form.birth_place" />
                </div>
                <div class="w-full flex flex-col gap-2 mb-0">
                    <Label class="font-bold" for="birthday">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-cake-icon lucide-cake">
                            <path d="M20 21v-8a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v8" />
                            <path d="M4 16s.5-1 2-1 2.5 2 4 2 2.5-2 4-2 2.5 2 4 2 2-1 2-1" />
                            <path d="M2 21h20" />
                            <path d="M7 8v3" />
                            <path d="M12 8v3" />
                            <path d="M17 8v3" />
                            <path d="M7 4h.01" />
                            <path d="M12 4h.01" />
                            <path d="M17 4h.01" />
                        </svg>
                        Birthday
                    </Label>
                    <Input type="date" placeholder="ex. 12/09/1978" name="birthday" v-model="form.birth_date" />
                </div>
            </div>

            <div class="flex flex-col lg:flex-row gap-6">
                <div class="w-full flex flex-col gap-2 mb-0">
                    <Label class="font-bold" for="sex">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-venus-and-mars-icon lucide-venus-and-mars">
                            <path d="M10 20h4" />
                            <path d="M12 16v6" />
                            <path d="M17 2h4v4" />
                            <path d="m21 2-5.46 5.46" />
                            <circle cx="12" cy="11" r="5" />
                        </svg>Sex</Label>
                    <Select name="sex" v-model="form.sex"> <!-- put the v-model in select, ok!-->
                        <SelectTrigger class="w-full">
                            <SelectValue placeholder="ex. Male or Female" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectItem value="Male">
                                Male
                            </SelectItem>
                            <SelectItem value="Female">
                                Female
                            </SelectItem>
                        </SelectContent>
                    </Select>
                </div>
                <div class="w-full flex flex-col gap-2 mb-0">
                    <Label class="font-bold" for="marital_status">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-church-icon lucide-church">
                            <path d="M10 9h4" />
                            <path d="M12 7v5" />
                            <path d="M14 21v-3a2 2 0 0 0-4 0v3" />
                            <path
                                d="m18 9 3.52 2.147a1 1 0 0 1 .48.854V19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2v-6.999a1 1 0 0 1 .48-.854L6 9" />
                            <path d="M6 21V7a1 1 0 0 1 .376-.782l5-3.999a1 1 0 0 1 1.249.001l5 4A1 1 0 0 1 18 7v14" />
                        </svg>Marital Status</Label>

                    <Select name="marital_status" v-model="form.marital_status"> <!-- put the v-model in select, ok!-->
                        <SelectTrigger class="w-full">
                            <SelectValue placeholder="ex. Single, Married, Widower, Widow" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectItem value="Single">
                                Single
                            </SelectItem>
                            <SelectItem value="Married">
                                Married
                            </SelectItem>
                            <SelectItem value="Widower">
                                Widower
                            </SelectItem>
                            <SelectItem value="Widow">
                                Widow
                            </SelectItem>
                        </SelectContent>
                    </Select>
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
