<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import PublicLayout from '@/layouts/PublicLayout.vue';
import { Construction } from 'lucide-vue-next';

defineProps<{
    title: string;
}>();
</script>

<template>
    <Head :title="title" />

    <PublicLayout>
        <div class="min-h-[60vh] flex flex-col items-center justify-center p-8 text-center">
            <div class="h-24 w-24 bg-blue-50 rounded-full flex items-center justify-center mb-6 animate-bounce">
                <Construction class="h-12 w-12 text-blue-600" />
            </div>
            <h1 class="text-4xl font-bold text-slate-900 mb-4">{{ title }}</h1>
            <p class="text-xl text-slate-600 max-w-lg">
                This page is currently under development. Please check back later.
            </p>
            <div class="mt-8">
                <a href="/" class="text-blue-600 font-semibold hover:underline">
                    &larr; Back to Home
                </a>
            </div>
        </div>
    </PublicLayout>
</template>
