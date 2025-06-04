<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Head, useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';

interface Props {
    token: string;
    email: string;
}

const props = defineProps<Props>();

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('password.store'), {
        onFinish: () => {
            form.reset('password', 'password_confirmation');
        },
    });
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
        
        <div class="absolute left-1/2 -translate-x-1/2 bottom-6 md:left-6 md:translate-x-0 md:bottom-6 text-xs text-[#4E413B] whitespace-nowrap">
            By resetting your password, you agree to our <a href="#" class="text-[#FD7C21]">Terms and Conditions</a>.
        </div>
        
        <div class="flex-1 flex flex-col justify-center px-4 py-8 md:py-0 md:px-12 lg:px-20 pt-20">
            <div class="max-w-md w-full mx-auto">
                <h1 class="font-semibold text-[#FD7C21] mb-2 text-center text-[2.75rem]">Reset Password</h1>
                <p class="text-[#4E413B] mb-12 text-center text-sm">Please enter your new password below.</p>
                
                <Head title="Reset password" />
                
                <form @submit.prevent="submit" class="flex flex-col">
                    <div class="mb-4">
                        <Label for="email" class="text-[#4E413B] font-semibold mb-2 block text-base">Email</Label>
                        <Input
                            id="email"
                            type="email"
                            name="email"
                            autocomplete="email"
                            v-model="form.email"
                            class="text-base border border-white/30 focus:border-white focus:ring-1 focus:ring-white placeholder:text-gray-400 placeholder:text-lg h-10 text-[#4E413B] bg-white"
                            readonly
                        />
                        <InputError :message="form.errors.email" class="text-[#FD7C21] mt-2" />
                    </div>
                    
                    <div class="mb-4">
                        <Label for="password" class="text-[#4E413B] font-semibold mb-2 block text-base">New Password</Label>
                        <Input
                            id="password"
                            type="password"
                            name="password"
                            autocomplete="new-password"
                            v-model="form.password"
                            placeholder="Enter your new password"
                            class="text-base border border-white/30 focus:border-white focus:ring-1 focus:ring-white placeholder:text-white placeholder:text-lg placeholder:text-white/70 h-10 bg-white"
                            autofocus
                            required
                        />
                        <InputError :message="form.errors.password" class="text-[#FD7C21] mt-2" />
                    </div>
                    
                    <div class="mb-4">
                        <Label for="password_confirmation" class="text-[#4E413B] font-semibold mb-2 block text-base">Confirm Password</Label>
                        <Input
                            id="password_confirmation"
                            type="password"
                            name="password_confirmation"
                            autocomplete="new-password"
                            v-model="form.password_confirmation"
                            placeholder="Confirm your new password"
                            class="text-base border border-white/30 focus:border-white focus:ring-1 focus:ring-white placeholder:text-white placeholder:text-lg placeholder:text-white/70 h-10 bg-white"
                            required
                        />
                        <InputError :message="form.errors.password_confirmation" class="text-[#FD7C21] mt-2" />
                    </div>
                    
                    <!-- Reset Password Button -->
                    <Button 
                        type="submit" 
                        class="w-full h-10 bg-gradient-to-r from-[#FD7C21] to-[#FF9D00] text-white shadow-md hover:from-[#FD7C21]/90 hover:to-[#FF9D00]/90 mt-6" 
                        :disabled="form.processing"
                    >
                        <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                        Reset Password
                    </Button>
                    
                    <!-- Back to Login Link -->
                    <div class="text-center text-sm text-[#4E413B] mt-5">
                        Remember your password?
                        <a href="/login" class="text-[#FD7C21] !text-[#FD7C21] !no-underline">Back to Login</a>
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