<script setup lang="ts">

import InputError from '@/components/InputError.vue';
import Recaptcha from '@/components/Recaptcha.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import AuthBase from '@/layouts/AuthLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    phone: '',
    password: '',
    password_confirmation: '',
    'g-recaptcha-response': '',
});
</script>

<template>
    <AuthBase
        title="Create an account"
        description="Enter your details below to create your account"
    >
        <Head title="Register" />

        <form
            @submit.prevent="form.post(route('register'), {
                onFinish: () => form.reset('password', 'password_confirmation'),
            })"
            class="flex flex-col gap-6"
        >
            <div class="grid gap-6">
                <div class="grid gap-2">
                    <Label for="name">Name</Label>
                    <Input
                        id="name"
                        type="text"
                        required
                        autofocus
                        :tabindex="1"
                        autocomplete="name"
                        name="name"
                        placeholder="Full name"
                        v-model="form.name"
                    />
                    <InputError :message="form.errors.name" />
                </div>

                <div class="grid gap-2">
                    <Label for="email">Email address</Label>
                    <Input
                        id="email"
                        type="email"
                        required
                        :tabindex="2"
                        autocomplete="email"
                        name="email"
                        placeholder="email@example.com"
                        v-model="form.email"
                    />
                    <InputError :message="form.errors.email" />
                </div>

                <div class="grid gap-2">
                    <Label for="phone">Phone Number</Label>
                    <Input
                        id="phone"
                        type="text"
                        :tabindex="3"
                        autocomplete="tel"
                        name="phone"
                        placeholder="081xxxxxxx"
                        v-model="form.phone"
                    />
                    <InputError :message="form.errors.phone" />
                </div>

                <div class="grid gap-2">
                    <Label for="password">Password</Label>
                    <Input
                        id="password"
                        type="password"
                        required
                        :tabindex="3"
                        autocomplete="new-password"
                        name="password"
                        placeholder="Password"
                        v-model="form.password"
                    />
                    <InputError :message="form.errors.password" />
                </div>

                <div class="grid gap-2">
                    <Label for="password_confirmation">Confirm password</Label>
                    <Input
                        id="password_confirmation"
                        type="password"
                        required
                        :tabindex="4"
                        autocomplete="new-password"
                        name="password_confirmation"
                        placeholder="Confirm password"
                        v-model="form.password_confirmation"
                    />
                    <InputError :message="form.errors.password_confirmation" />
                </div>

                <!-- Recaptcha -->
                <Recaptcha @verify="(token) => form['g-recaptcha-response'] = token" />
                <InputError :message="form.errors['g-recaptcha-response']" />

                <Button
                    type="submit"
                    class="mt-2 w-full"
                    tabindex="5"
                    :disabled="form.processing"
                    data-test="register-user-button"
                >
                    <Spinner v-if="form.processing" />
                    Create account
                </Button>

                <div class="relative my-4">
                    <div class="absolute inset-0 flex items-center">
                        <span class="w-full border-t" />
                    </div>
                    <div class="relative flex justify-center text-xs uppercase">
                        <span class="bg-background px-2 text-muted-foreground">
                            Or register with
                        </span>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <Button variant="outline" as-child class="w-full">
                        <a :href="route('social.redirect', 'google')">
                            <!-- Google Icon -->
                            <svg class="mr-2 h-4 w-4" aria-hidden="true" focusable="false" data-prefix="fab" data-icon="google" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 488 512"><path fill="currentColor" d="M488 261.8C488 403.3 391.1 504 248 504 110.8 504 0 393.2 0 256S110.8 8 248 8c66.8 0 123 24.5 166.3 64.9l-67.5 64.9C258.5 52.6 94.3 116.6 94.3 256c0 86.5 69.1 156.6 153.7 156.6 98.2 0 135-70.4 140.8-106.9H248v-85.3h236.1c2.3 12.7 3.9 24.9 3.9 41.4z"></path></svg>
                            Google
                        </a>
                    </Button>
                    <Button variant="outline" as-child class="w-full">
                        <a :href="route('social.redirect', 'twitter')">
                            <!-- X (Twitter) Icon -->
                            <svg class="mr-2 h-4 w-4" aria-hidden="true" focusable="false" data-prefix="fab" data-icon="x-twitter" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"></path></svg>
                            X
                        </a>
                    </Button>
                    <Button variant="outline" as-child class="w-full">
                        <a :href="route('social.redirect', 'facebook')">
                            <!-- Facebook Icon -->
                            <svg class="mr-2 h-4 w-4" aria-hidden="true" focusable="false" data-prefix="fab" data-icon="facebook" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M504 256C504 119 393 8 256 8S8 119 8 256c0 123.78 90.69 226.38 209.25 245V327.69h-63V256h63v-54.64c0-62.15 37-96.48 93.67-96.48 27.14 0 55.52 4.84 55.52 4.84v61h-31.28c-30.8 0-40.41 19.12-40.41 38.73V256h68.78l-11 71.69h-57.78V501C413.31 482.38 504 379.78 504 256z"></path></svg>
                            Facebook
                        </a>
                    </Button>
                    <Button variant="outline" as-child class="w-full">
                        <a :href="route('social.redirect', 'line')">
                            <!-- LINE Icon -->
                             <svg class="mr-2 h-4 w-4" aria-hidden="true" focusable="false" data-prefix="fab" data-icon="line" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M272.1 204.2v71.1c0 1.8-1.4 3.2-3.2 3.2h-11.4c-1.1 0-2.1-.6-2.6-1.3l-32.6-44v42.2c0 1.8-1.4 3.2-3.2 3.2h-11.4c-1.8 0-3.2-1.4-3.2-3.2v-71.1c0-1.8 1.4-3.2 3.2-3.2h11.4c1.1 0 2.1 .6 2.6 1.3l32.6 44v-42.2c0-1.8 1.4-3.2 3.2-3.2h11.4c1.8 0 3.2 1.4 3.2 3.2zm-97.4 0v71.1c0 1.8-1.4 3.2-3.2 3.2h-11.4c-1.8 0-3.2-1.4-3.2-3.2v-71.1c0-1.8 1.4-3.2 3.2-3.2h11.4c1.8 0 3.2 1.4 3.2 3.2zm-57.1-3.2c1.8 0 3.2 1.4 3.2 3.2v71.1c0 1.8-1.4 3.2-3.2 3.2H83.8c-1.8 0-3.2-1.4-3.2-3.2v-71.1c0-1.8 1.4-3.2 3.2-3.2h33.8zm96.3-64.8c93.1 0 168.7 60.9 168.7 136 0 75.1-75.6 136-168.7 136-18.4 0-36-2.5-52.6-6.6a8.4 8.4 0 0 0 -5 1.1l-36.9 25.1a5.6 5.6 0 0 1 -8.3-6.9l11.6-32.2a9.1 9.1 0 0 0 .1-6.1c-43.1-27.4-69-69.6-69-116.3 0-75.1 75.6-136 168.7-136zM322 230.1h-29.3v-22.7c0-1.8-1.4-3.2-3.2-3.2h-11.4c-1.8 0-3.2 1.4-3.2 3.2v47.4c0 1.8 1.4 3.2 3.2 3.2h43.9c1.8 0 3.2-1.4 3.2-3.2v-11.4c0-1.8-1.4-3.2-3.2-3.2z"></path></svg>
                            LINE
                        </a>
                    </Button>
                </div>
            </div>

            <div class="text-center text-sm text-muted-foreground">
                Already have an account?
                <Link
                    :href="route('login')"
                    class="underline underline-offset-4 hover:text-primary"
                    :tabindex="6"
                    >Log in</Link
                >
            </div>
        </form>
    </AuthBase>
</template>
```
