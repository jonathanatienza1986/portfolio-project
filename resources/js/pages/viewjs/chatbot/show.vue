<!-- eslint-disable import/order -->
<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
//------------------------------------------------------------basic ui comps frm shadcn
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

//------------------------------------------------------------routed
//import { template, dashboard } from '@/routes';
// eslint-disable-next-line vue/no-dupe-keys
import chatbot from '@/routes/chatbot';

//------------------------------------------------------------code starts here
// access page info such as user
const page = usePage();

// obtain data from webserver, replace 'complaint' with real object
interface Props {
    error: object,
    chatbot: object,
    chatbots: { type: Array, },
}
const props = defineProps<Props>();

// form data
// eslint-disable-next-line @typescript-eslint/no-unused-vars
const form = ref({
    user_id: -10,
    chatbot_id: -10,
    role: "",
    message: "",
    pic1_file: null,
    pic2_file: null,
    pic3_file: null,
    pic4_file: null,
    pic1_link: null,
    pic2_link: null,
    pic3_link: null,
    pic4_link: null,
});

onMounted(() => { // invoked when page ready
    // Vanilla JS: Get a URL parameter
    const params = new URLSearchParams(window.location.search);
    const userId = params.get('id');
    console.log("User ID from URL:", userId); // If the URL is /products?category=electronics&sort=price

    //scroll page to the table header element
    msg_div.value?.scrollIntoView({ behavior: 'smooth' });
    console.log("response: ", props.response);

    if (props.error) {
        console.log("props.error ", props.error);
    }

    form.value = { ...form.value, ...props.chatbot }; // merge key:value pair
    form.value.message = ""
    form.value.is_chathead = false;
    form.value.pic1_file = null;
    form.value.pic2_file = null;
    form.value.pic3_file = null;
    form.value.pic4_file = null;
    form.value.pic1_link = null;
    form.value.pic2_link = null;
    form.value.pic3_link = null;
    form.value.pic4_link = null;
    check_if_some_pending_messages();
    //form.value.name = page.props.auth.user.email;
    console.log("Login User id ", page.props.auth.user.id);
    console.log("Login User Email ", page.props.auth.user.email);
});

const check_if_some_pending_messages = () => {
    let role = "";
    let chatbot_id = -10;

    for (const item of props.chatbots) {
        console.log("item", item);
        role = item.role;
        chatbot_id = item.chatbot_id;
    }

    // if the last role is user, it means it has pending transaction
    // with the AI since it has missing AI reply.
    if (role === "user") {
        const form_payload = useForm();
        form_payload.post(chatbot.send_to_ai2(chatbot_id).url, {
            //----------------------------------------- force ajax parameters
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
                form.value = { ...form.value, ...props.chatbot };
                form.value.message = "";
                form.value.is_chathead = false;
                form.value.pic1_file = null;
                form.value.pic2_file = null;
                form.value.pic3_file = null;
                form.value.pic4_file = null;
                form.value.pic1_link = null;
                form.value.pic2_link = null;
                form.value.pic3_link = null;
                form.value.pic4_link = null;
            },
        });
    }
}

//-------------------------------------------- Prev and Next Page Buttons
const isDisabled = ref(false)
const prev_page_loading = ref(false);
const prev_page = () => {
    prev_page_loading.value = true;
    isDisabled.value = true;
    const form_payload = useForm();
    form_payload.get(chatbot.index().url, {
        //----------------------------------------- force ajax parameters
        preserveScroll: true,
        preserveState: true,
    });
};

const next_page_loading = ref(false);
const next_page = async () => {
    next_page_loading.value = true;
    isDisabled.value = true;
    form.value.is_chathead = false;
    const form_payload = useForm(form.value);
    form_payload.post(chatbot.send_to_ai3().url, {
        //----------------------------------------- force ajax parameters
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            form.value.message = "";
            next_page_loading.value = false;
            isDisabled.value = false;
            form.value.message = "";
            form.value.is_chathead = false;
            form.value.pic1_file = null;
            form.value.pic2_file = null;
            form.value.pic3_file = null;
            form.value.pic4_file = null;
            form.value.pic1_link = null;
            form.value.pic2_link = null;
            form.value.pic3_link = null;
            form.value.pic4_link = null;
        },

    });

}

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'ChatBot',
                href: chatbot.index(),
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

const msg_div = ref();

//import VueMarkdown from 'vue-markdown-render';
import ChatMessage from "./ChatMessage.vue";

// --------------------------------------------------------------------------- Input file image/*
const file_base64 = ref();

const file_change = (data) => { // drivers licnese
    file_base64.value = URL.createObjectURL(data.target.files[0]);
    form.value.pic1_link = file_base64.value;
    form.value.pic1_file = data.target.files[0];
    const form_payload = useForm(form.value);
    form_payload.post(chatbot.post2().url, {
        //----------------------------------------- force ajax parameters
        preserveScroll: true,
        preserveState: true,
    });
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
    form.value.pic1_link = file_base64.value;
    form.value.pic1_file = new File([blob], "myimage12345-0.png", { type: blob.type, lastModified: Date.now() });
    const form_payload = useForm(form.value);
    form_payload.post(chatbot.post2().url, {
        //----------------------------------------- force ajax parameters
        preserveScroll: true,
        preserveState: true,
    });
};

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
                    Messages
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
                    class="lucide lucide-bot-message-square-icon lucide-bot-message-square">
                    <path d="M12 6V2H8" />
                    <path d="M15 11v2" />
                    <path d="M2 12h2" />
                    <path d="M20 12h2" />
                    <path
                        d="M20 16a2 2 0 0 1-2 2H8.828a2 2 0 0 0-1.414.586l-2.202 2.202A.71.71 0 0 1 4 20.286V8a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2z" />
                    <path d="M9 11v2" />
                </svg>
                <span class="lg:text-2xl font-semibold">
                    Chat
                </span>
            </div>

            <!-- ChatBot Results Messages -->
            <div class="flex flex-col gap-6">
                <div class=" border-b w-full" v-for="(item, index) in chatbots" :key="index">
                    <span class=" font-bold text-2xl text-blue-700"> {{ item.role }}</span>
                    <div class="flex flex-col gap-2">
                        <ChatMessage :content="item.message" />
                        <div v-show="item.pic1_link">
                            <img :src="item.pic1_link" alt="">
                        </div>
                        <div v-show="item.pic2_link">
                            <img :src="item.pic2_link" alt="">
                        </div>
                        <div v-show="item.pic3_link">
                            <img :src="item.pic3_link" alt="">
                        </div>
                        <div v-show="item.pic4_link">
                            <img :src="item.pic4_link" alt="">
                        </div>
                    </div>
                </div>
            </div>

            <!-- User Message to Chatbot -->
            <div ref="msg_div" class="flex flex-col lg:flex-row gap-6">
                <div class="w-full flex flex-col gap-2 mb-0">
                    <Label class="font-bold" for="message">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-mail-plus-icon lucide-mail-plus">
                            <path d="M22 13V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v12c0 1.1.9 2 2 2h8" />
                            <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                            <path d="M19 16v6" />
                            <path d="M16 19h6" />
                        </svg>Message</Label>
                    <Input type="text" placeholder="ex. McArthur Park, Beverly Hills, Samar, Philipines" name="message"
                        v-model="form.message" />
                </div>
            </div>

            <!-- Get Image -->
            <div class="flex flex-col lg:flex-row gap-6">
                Image
                <div class="lg:w-[65%] flex flex-col gap-2 mb-0 border-2 rounded-xl min-w-72 overflow-hidden">
                    <img :src="form.pic1_link" alt="x" style="object-fit: cover; margin: auto;  height: 100%;" />
                </div>
                <div class="lg:w-[35%]">
                    <div class="w-full flex flex-col gap-2 mb-0">
                        <Label class="font-bold" for="marital_status">Upload Picture</Label>
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
                    Send Msg
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
