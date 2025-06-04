<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import UserAppLayout from '@/layouts/UserAppLayout.vue';
import SettingsLayout from '@/layouts/settings/UserLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

import HeadingSmall from '@/components/HeadingSmall.vue';
import AppearanceTabs from '@/components/AppearanceTabs.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { type BreadcrumbItem } from '@/types';

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Password & Appearance',
        href: '/settings/userpassword',
    },
];

const passwordInput = ref<HTMLInputElement | null>(null);
const currentPasswordInput = ref<HTMLInputElement | null>(null);

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const updatePassword = () => {
    form.put(route('userpassword.update'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: (errors: any) => {
            if (errors.password) {
                form.reset('password', 'password_confirmation');
                if (passwordInput.value instanceof HTMLInputElement) {
                    passwordInput.value.focus();
                }
            }

            if (errors.current_password) {
                form.reset('current_password');
                if (currentPasswordInput.value instanceof HTMLInputElement) {
                    currentPasswordInput.value.focus();
                }
            }
        },
    });
};
</script>

<template>
    <UserAppLayout :breadcrumbs="breadcrumbItems">
        <Head title="Change Password and Appearance" />

        <SettingsLayout>
            <div class="space-y-8 bg-white">
                <HeadingSmall 
                    title="Change Password and Appearance" 
                    description="Update your account's security and customize how the interface looks." 
                />

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Password Section -->
                    <div class="space-y-6">
                        <HeadingSmall title="Update Password" description="Ensure your account is using a long, random password to stay secure" />

                        <form @submit.prevent="updatePassword" class="space-y-6">
                            <div class="grid gap-2">
                                <Label for="current_password">Current Password</Label>
                                <Input
                                    id="current_password"
                                    ref="currentPasswordInput"
                                    v-model="form.current_password"
                                    type="password"
                                    class="mt-1 block w-full"
                                    autocomplete="current-password"
                                    placeholder="Enter your current password"
                                />
                                <InputError :message="form.errors.current_password" />
                            </div>

                            <div class="grid gap-2">
                                <Label for="password">New Password</Label>
                                <Input
                                    id="password"
                                    ref="passwordInput"
                                    v-model="form.password"
                                    type="password"
                                    class="mt-1 block w-full"
                                    autocomplete="new-password"
                                    placeholder="Enter your new password"
                                />
                                <InputError :message="form.errors.password" />
                            </div>

                            <div class="grid gap-2">
                                <Label for="password_confirmation">Confirm New Password</Label>
                                <Input
                                    id="password_confirmation"
                                    v-model="form.password_confirmation"
                                    type="password"
                                    class="mt-1 block w-full"
                                    autocomplete="new-password"
                                    placeholder="Confirm your new password"
                                />
                                <InputError :message="form.errors.password_confirmation" />
                            </div>

                            <div class="flex items-center gap-4">
                                <Button type="button" variant="outline">Cancel</Button>
                                <Button :disabled="form.processing">Update</Button>

                                <Transition
                                    enter-active-class="transition ease-in-out"
                                    enter-from-class="opacity-0"
                                    leave-active-class="transition ease-in-out"
                                    leave-to-class="opacity-0"
                                >
                                    <p v-show="form.recentlySuccessful" class="text-sm text-neutral-600">Saved.</p>
                                </Transition>
                            </div>
                        </form>
                    </div>

                    <!-- Theme Settings -->
                    <div class="space-y-6">
                        <HeadingSmall title="Theme Settings" />
                        <AppearanceTabs />
                    </div>
                </div>
            </div>
        </SettingsLayout>
    </UserAppLayout>
</template>