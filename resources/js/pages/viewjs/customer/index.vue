<!-- eslint-disable import/order -->
<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { Head, useForm, usePage, } from '@inertiajs/vue3';
//------------------------------------------------------------basic ui comps frm shadcn
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

//------------------------------------------------------------ import routes
import { template } from '@/routes';
// eslint-disable-next-line vue/no-dupe-keys
import customer from '@/routes/customer';

//------------------------------------------------------------code starts here
// access page info such as user
// eslint-disable-next-line @typescript-eslint/no-unused-vars
const page = usePage();

// obtain data from webserver, replace 'complaint' with real object
interface Props {
    customers: { type: Array, },
    name: string,
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

    //form.value = { ...form.value, ...props.complaint }; // merge key:value pair
    console.log("props.customers: ", props.customers)

    //fetch search filter from props, props data comes from webserver
    search_filter.value = props.name;
    console.log("search_filter.value: ", search_filter.value);

    //scroll page to the table header element
    table_header.value?.scrollIntoView({ behavior: 'smooth' });
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

//--------------------------------------------------------------- bread crumbs
defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Customer Index',
                href: template(),
            },
        ],
    },
});

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
const isDialogOpen = ref();

//---------------------------------------------------------------------- qr code reader
import { StreamQrcodeBarcodeReader } from 'vue3-barcode-qrcode-reader';
const onQRCodeScanResult = (data: Result | undefined) => {
    if (data) {
        search_filter.value = data.text;
        isDialogOpen.value = false;  // close the above dialog
        search_filter_clicked();
        table_header.value?.scrollIntoView({ behavior: 'smooth' });
    }
    //console.log(data);
}

//---------------------------------------------------------------------- search filter
const search_filter = ref("");
const search_filter_clicked = () => {
    const form_payload = useForm({
        name: search_filter.value,
    });
    // ajax call
    form_payload.get(customer.index({ name: search_filter.value }).url, { //------------------------- force ajax parameter
        preserveScroll: true,
        preserveState: true,
    });
}

//--------------------------------------------------------------- reference to table_header DOM element
const table_header = ref();

// --------------------------- new complaint button clicked
const new_item = () => {
    const form_payload = useForm();
    form_payload.get(customer.create(form_payload.id).url, { 'id': form_payload.id });
}
</script>

<template>

    <Head title="customer.index" />

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
                                            List of Customers
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
        <div class="p-8 flex flex-col gap-3 w-full">

            <!-- Activity Progress Indicator -->
            <div class="flex flex-row gap-2 p-2 lg:gap-6 lg:p-6 bg w-full justify-center border overflow-hidden">
                <div class="w-full border-t-4 text-mauve-200 dark:text-mauve-800 text-center">
                    Raise a Complaint
                </div>
                <div class="w-full border-t-4 text-mauve-200 dark:text-mauve-800 text-center">
                    View
                </div>
                <div class="w-full border-t-4 text-mauve-200 dark:text-mauve-800 text-center">
                    Modify
                </div>
                <div
                    class="w-full border-t-8 border-blue-400 dark:border-blue-800 text-blue-400 dark:text-blue-800 text-center p-2 font-bold">
                    Master List
                </div>
            </div>

            <!-- Search Filter -->
            <div class="flex flex-col lg:flex-row gap-2 p-2 lg:gap-6 lg:p-6 align-middle w-full border overflow-hidden">
                <Label>
                    Search Filter Customer Name
                </Label>
                <div class="flex flex-row w-full">
                    <Input type="text" class=" rounded-none rounded-l-full" v-model="search_filter"
                        @keyup="search_filter_clicked" />

                    <!-- Take Photo Camera RQ Code Dialog -->
                    <Dialog v-model:open="isDialogOpen">
                        <DialogTrigger as-child>
                            <Button class=" rounded-none cursor-pointer border-r">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-scan-qr-code-icon lucide-scan-qr-code">
                                    <path d="M17 12v4a1 1 0 0 1-1 1h-4" />
                                    <path d="M17 3h2a2 2 0 0 1 2 2v2" />
                                    <path d="M17 8V7" />
                                    <path d="M21 17v2a2 2 0 0 1-2 2h-2" />
                                    <path d="M3 7V5a2 2 0 0 1 2-2h2" />
                                    <path d="M7 17h.01" />
                                    <path d="M7 21H5a2 2 0 0 1-2-2v-2" />
                                    <rect x="7" y="7" width="5" height="5" rx="1" />
                                </svg>
                                QR Code
                            </Button>
                        </DialogTrigger>
                        <DialogContent class="w-[100%]">
                            <DialogHeader>
                                <DialogTitle>QR Code Reader</DialogTitle>
                                <DialogDescription>
                                    Scan your QR Code here...
                                </DialogDescription>
                            </DialogHeader>
                            <!-- Dialog Body Starts-->
                            <div class="gap-4 scanner-container">
                                <StreamQrcodeBarcodeReader capture="shoot" @onloading="onLoading"
                                    @result="onQRCodeScanResult" class="w-[100%] rounded-2xl">
                                </StreamQrcodeBarcodeReader>
                            </div>
                            <!-- Dialog Body Ended -->
                            <DialogFooter>
                                <DialogClose as-child>
                                </DialogClose>
                            </DialogFooter>
                        </DialogContent>
                    </Dialog>

                    <Button class="rounded-none rounded-r-full cursor-pointer" @click="search_filter_clicked">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-search-icon lucide-search">
                            <path d="m21 21-4.34-4.34" />
                            <circle cx="11" cy="11" r="8" />
                        </svg>
                        Search
                    </Button>
                </div>
            </div>

            <!-- Title -->
            <div class="flex gap-4 items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="#e10e2e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-brick-wall-shield-icon lucide-brick-wall-shield">
                    <path d="M12 9v1.258" />
                    <path d="M16 3v5.46" />
                    <path d="M21 9.118V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h5.75" />
                    <path
                        d="M22 17.5c0 2.499-1.75 3.749-3.83 4.474a.5.5 0 0 1-.335-.005c-2.085-.72-3.835-1.97-3.835-4.47V14a.5.5 0 0 1 .5-.499c1 0 2.25-.6 3.12-1.36a.6.6 0 0 1 .76-.001c.875.765 2.12 1.36 3.12 1.36a.5.5 0 0 1 .5.5z" />
                    <path d="M3 15h7" />
                    <path d="M3 9h12.142" />
                    <path d="M8 15v6" />
                    <path d="M8 3v6" />
                </svg>
                <span class="lg:text-2xl font-semibold">
                    Customers List
                </span>
                <div class="ml-auto"></div>
                <div>
                    <Button class=" bg-green-600 cursor-pointer" @click="new_item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-badge-plus-icon lucide-badge-plus">
                            <path
                                d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z" />
                            <line x1="12" x2="12" y1="8" y2="16" />
                            <line x1="8" x2="16" y1="12" y2="12" />
                        </svg>
                        New Customer
                    </Button>
                </div>
            </div>

            <table ref="table_header">
                <thead>
                    <tr class="align-middle text-justify p-8 border border-b-4">
                        <th class="p-2 text-lg">No.</th>
                        <th class="p-2 text-lg">Date/Time</th>
                        <th class="p-4 text-lg">Picture</th>
                        <th class="p-4 text-lg">Name</th>
                        <th class="p-4 text-lg">Email/Phone</th>
                        <th class="p-4 text-lg">Address</th>
                        <th class="p-4 text-lg cursor-pointer">
                            <a :href="customer.index().url">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="#c8c109" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-list-restart-icon lucide-list-restart">
                                    <path d="M21 5H3" />
                                    <path d="M7 12H3" />
                                    <path d="M7 19H3" />
                                    <path
                                        d="M12 18a5 5 0 0 0 9-3 4.5 4.5 0 0 0-4.5-4.5c-1.33 0-2.54.54-3.41 1.41L11 14" />
                                    <path d="M11 10v4h4" />
                                </svg>
                            </a>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="align-middle text-justify p-8 border" v-for="(item, index) in customers.data"
                        :key="index">
                        <td class="p-2">{{ item.id }}</td>
                        <td class="p-2">{{ item.created_at.replace(".000000Z", "").replace("T", " ") }}</td>
                        <td class="p-1 lg:w-50">
                            <img :src="item.portrait_link" alt="x" width="200" style="object-fit: cover; margin: auto;  width: 200px;" />
                        </td>
                        <td class="p-4">{{ item.name }}</td>
                        <td class="p-4">{{ item.email }} <br> {{ item.phone }}</td>
                        <td class="p-4">{{ item.address }}</td>
                        <td class="p-4">
                            <a :href="customer.show(item.id).url">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="#0e1cdd" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="lucide lucide-square-arrow-out-up-right-icon lucide-square-arrow-out-up-right">
                                    <path d="M21 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h6" />
                                    <path d="m21 3-9 9" />
                                    <path d="M15 3h6v6" />
                                </svg>
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- Table Pagination -->
            <div class="flex flex-row gap-2 p-2 lg:gap-6 lg:p-6 bg w-full border overflow-hidden">
                <div class=" text-blue-600" v-show="customers.prev_page_url">
                    <a :href="customers.prev_page_url">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-arrow-left-to-line-icon lucide-arrow-left-to-line">
                            <path d="M3 19V5" />
                            <path d="m13 6-6 6 6 6" />
                            <path d="M7 12h14" />
                        </svg>
                    </a>
                </div>
                <div v-for="(item, index) in customers.links" :key="index">
                    <a :href="item.url"
                        v-show="(index.toString() == item.label) && (customers.current_page.toString() !== item.label.toString())">
                        {{ item.label }}</a>
                    <div
                        v-show="(index.toString() == item.label) && (customers.current_page.toString() === item.label.toString())">
                        <span class=" underline font-bold text-lg">{{ item.label }}</span>
                    </div>
                </div>
                <div class=" mx-auto">
                    <span>{{ customers.current_page }}&nbsp;out of&nbsp;{{ customers.last_page }} Pages</span>
                </div>
                <div class=" text-blue-600" v-show="customers.next_page_url">
                    <a :href="customers.next_page_url">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-arrow-right-to-line-icon lucide-arrow-right-to-line">
                            <path d="M17 12H3" />
                            <path d="m11 18 6-6-6-6" />
                            <path d="M21 5v14" />
                        </svg>
                    </a>
                </div>
            </div>

        </div>
    </div>
</template>

<style scoped>
.scanner-container {
    width: 100%;
    max-width: 500px;
    /* Adjust maximum width */
    height: auto;
    margin: 0 auto;
}

/* Target the video element directly if needed */
.scanner-container video {
    width: 100%;
    height: auto;
    object-fit: cover;
}
</style>
