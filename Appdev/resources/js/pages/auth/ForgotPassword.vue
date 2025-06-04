<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthLayout from '@/layouts/AuthLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';

defineProps<{
    status?: string;
}>();

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
    <div class="min-h-screen w-full flex items-center justify-center relative overflow-hidden"
        style="background: linear-gradient(135deg, rgba(253, 124, 33, 0.9) 0%, rgba(255, 157, 0, 0.9) 100%);">
    <div class="relative z-10 w-[98vw] min-h-[93vh] mx-4 my-4 md:mx-8 md:my-8 rounded-2xl shadow-2xl flex flex-col md:flex-row overflow-hidden p-2 md:p-8 bg-[#F9F4EB]">
        <div class="absolute left-1/2 -translate-x-1/2 top-6 md:left-6 md:translate-x-0 md:top-6">
            <div class="border-2 border-[#FD7C21] text-[#FD7C21] rounded-lg p-2 px-8 inline-block bg-transparent">
                <span class="font-bold">LABERS</span>
            </div>
        </div>
        <div class="flex--1 flex flex-col justify-center px-4 py-8 md:py-0 md:px-12 lg:px-20 pt-20">
            <div class="max-w-md w-full mx-auto">
                <h1 class="font-semibold text-[#FD7C21] mb-2 text-center text-[2.75rem]">Forgot password</h1>
                <p class="text-[#4E413B] mb-12 text-center text-sm">Enter your email to receive a password reset link.</p>
                <Head title="Forgot password" />

                <div v-if="status" class="mb-4 text-center text-sm font-medium text-green-600">
                    {{ status }}
                </div>

                <form @submit.prevent="submit" class="flex flex-col">
                    <div class="mb-4">
                        <Label for="email" class="text-[#4E413B] font-semibold mb-2 block text-base">Student ID</Label>
                        <div class="relative mt-1">
                            <Input
                                id="email"
                                type="text"
                                name="email"
                                autocomplete="off"
                                v-model="form.email"
                                autofocus
                                class="pr-40 text-base border border-white/30 focus:border-white focus:ring-1 focus:ring-white placeholder:text-gray-400 placeholder:text-lg h-10 text-[#4E413B] bg-white"
                            />
                            <span class="absolute inset-y-0 right-3 flex items-center text-[#b0b0b0] text-sm select-none pointer-events-none">@gordoncollege.edu.ph</span>
                        </div>
                        <InputError :message="form.errors.email" />
                    </div>

                    <!-- Reset Button -->
                    <Button type="submit" class="w-full h-10 bg-gradient-to-r from-[#FD7C21] to-[#FF9D00] text-white shadow-md hover:from-[#FD7C21]/90 hover:to-[#FF9D00]/90 mt-6" :disabled="form.processing">
                        <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                        Email password reset link
                    </Button>

                    <div class="text-center text-sm text-[#4E413B] mt-5">
                        Or, return to
                        <TextLink :href="route('login')" class="text-[#FD7C21] !text-[#FD7C21] !no-underline">log in</TextLink>
                    </div>
                </form>
            </div>
        </div>
        <div class="hidden md:flex flex-1 items-center justify-center bg-transparent p-0 m-0 ml-13 relative">
        <div class="relative w-5xl h-5xl">
            <img src="/comlab.jpg" alt="Gordon College" class="object-cover w-full h-full rounded-2xl shadow-xl" />
            <div class="absolute inset-0 bg-gradient-to-br from-orange-600 to-orange-400 opacity-70 rounded-2xl"></div>
        </div>
        <img src="/labers1.png" alt="Gordon College Lab" class="w-xl h-xl absolute rounded-2xl shadow-xl z-10" />
    </div>
    </div>
</div>
</template>
