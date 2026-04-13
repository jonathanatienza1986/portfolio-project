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
import chat from '@/routes/chat';

//------------------------------------------------------------code starts here
// access page info such as user
const page = usePage();

// obtain data from webserver, replace 'complaint' with real object
interface Props {
    response: object,
}
const props = defineProps<Props>();

// form data
// eslint-disable-next-line @typescript-eslint/no-unused-vars
const form = ref({
    message: "",
    messages: [],
});

onMounted(() => { // invoked when page ready
    // Vanilla JS: Get a URL parameter
    const params = new URLSearchParams(window.location.search);
    const userId = params.get('id');
    console.log("User ID from URL:", userId); // If the URL is /products?category=electronics&sort=price

    //scroll page to the table header element
    msg_div.value?.scrollIntoView({ behavior: 'smooth' });
    console.log("response: ", props.response);
    //form.value = { ...form.value, ...props.customer }; // merge key:value pair
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
    form_payload.get(chat.index().url, {
        //----------------------------------------- force ajax parameters
        preserveScroll: true,
        preserveState: true,
    });
};

const next_page_loading = ref(false);
const next_page = async () => {
    next_page_loading.value = true;
    isDisabled.value = true;

    // store the latest message from text box
    form.value.messages.push({
           role: "user",
        content: form.value.message,
    });
    const form_payload = useForm(form.value);
    form_payload.get(chat.index().url, {
        //----------------------------------------- force ajax parameters
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            // envoke data management
            //console.log("response: ",props.response);
            if (props.response) {
                form.value.messages.push(props.response);
                form.value.message = "";
                console.log("Messages: ",form.value.messages);
                next_page_loading.value = false;
                isDisabled.value = false;
            }
        },
    });

}

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'ChatBot',
                href: chat.index(),
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
                <div class=" border-b w-full" v-for="(item, index) in form.messages" :key="index">
                   <span class=" font-bold text-2xl"> {{ item.role }}</span>
                   <p class=" whitespace-pre-wrap">{{ item.content }}</p>
                   <br>
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
