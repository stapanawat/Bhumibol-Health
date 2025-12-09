<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import PublicLayout from '@/layouts/PublicLayout.vue';

defineProps<{
    heroPost?: {
        title_th: string;
        excerpt_th: string;
        image: string;
        slug: string;
        category: { name_th: string };
    } | null;
    latestNews: Array<{
        id: number;
        title_th: string;
        excerpt_th: string;
        image: string;
        slug: string;
        created_at: string;
        category: { name_th: string };
    }>;
}>();

const formatDate = (date: string) => {
    return new Date(date).toLocaleDateString('th-TH', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    });
};
</script>

<template>
    <Head title="Welcome to Bhumibol Health" />

    <PublicLayout>
        <!-- Hero Section -->
        <div class="relative bg-white overflow-hidden">
            <div class="max-w-7xl mx-auto">
                <div class="relative z-10 pb-8 bg-white sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
                    <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                        <div class="sm:text-center lg:text-left">
                            <h1 class="text-4xl tracking-tight font-extrabold text-slate-900 sm:text-5xl md:text-6xl">
                                <span class="block xl:inline">World-class care</span>
                                <span class="block text-blue-600 xl:inline"> close to you</span>
                            </h1>
                            <p class="mt-3 text-base text-slate-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                                Bhumibol Adulyadej Hospital provides premium healthcare services with advanced technology and expert medical specialists.
                            </p>
                            
                            <!-- Hero News (Pinned) -->
                            <div v-if="heroPost" class="mt-8 p-6 bg-blue-50 rounded-2xl border border-blue-100 shadow-sm relative overflow-hidden group">
                                <div class="absolute top-0 right-0 p-2 opacity-10">
                                    <svg class="w-24 h-24 text-blue-600" fill="currentColor" viewBox="0 0 24 24"><path d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                                </div>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mb-2">
                                    {{ heroPost.category?.name_th }}
                                </span>
                                <h3 class="text-xl font-bold text-slate-900 group-hover:text-blue-600 transition-colors">
                                    <Link :href="route('news.show', heroPost.slug)">{{ heroPost.title_th }}</Link>
                                </h3>
                                <p class="mt-2 text-slate-600 text-sm line-clamp-2">
                                    {{ heroPost.excerpt_th }}
                                </p>
                                <div class="mt-4">
                                     <Link :href="route('news.show', heroPost.slug)" class="text-blue-600 font-semibold hover:text-blue-800 text-sm flex items-center">
                                        Read More <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                     </Link>
                                </div>
                            </div>
                            
                            <div v-else class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                                <div class="rounded-md shadow">
                                    <Link href="/news" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 md:py-4 md:text-lg md:px-10">
                                        Read News
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>
            </div>
            
            <!-- Hero Image -->
            <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2 bg-blue-50">
                 <img v-if="heroPost?.image" :src="`/storage/${heroPost.image}`" class="h-56 w-full object-cover sm:h-72 md:h-96 lg:w-full lg:h-full opacity-90" alt="Hero Image">
                 <div v-else class="flex items-center justify-center w-full h-full text-blue-200 font-bold text-9xl select-none opacity-20">HEALTH</div>
            </div>
        </div>

        <!-- Latest News Grid -->
        <div class="py-16 bg-slate-50" v-if="latestNews.length > 0">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-end mb-8">
                     <div>
                        <h2 class="text-blue-600 font-semibold tracking-wide uppercase">Update</h2>
                        <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-slate-900 sm:text-4xl">
                            Latest News
                        </p>
                     </div>
                     <Link href="/news" class="hidden sm:flex text-slate-500 hover:text-blue-600 font-medium items-center transition-colors">
                        View All News <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                     </Link>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <article v-for="news in latestNews" :key="news.id" class="flex flex-col bg-white rounded-2xl shadow-sm hover:shadow-md transition-shadow duration-300 overflow-hidden group">
                        <div class="h-48 w-full bg-slate-200 relative overflow-hidden">
                            <img v-if="news.image" :src="`/storage/${news.image}`" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" :alt="news.title_th">
                            <div v-else class="w-full h-full flex items-center justify-center text-slate-300">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                            <div class="absolute top-4 left-4">
                                <span class="bg-white/90 backdrop-blur text-blue-800 text-xs font-bold px-3 py-1 rounded-full shadow-sm">
                                    {{ news.category?.name_th }}
                                </span>
                            </div>
                        </div>
                        <div class="flex-1 p-6 flex flex-col justify-between">
                            <div>
                                <div class="text-sm text-slate-500 mb-2">{{ formatDate(news.created_at) }}</div>
                                <h3 class="text-xl font-bold text-slate-900 mb-3 group-hover:text-blue-600 transition-colors line-clamp-2">
                                    <Link :href="route('news.show', news.slug)">{{ news.title_th }}</Link>
                                </h3>
                                <p class="text-slate-600 text-sm line-clamp-3">
                                    {{ news.excerpt_th }}
                                </p>
                            </div>
                            <div class="mt-6 pt-6 border-t border-slate-100">
                                <Link :href="route('news.show', news.slug)" class="text-blue-600 font-semibold text-sm hover:underline">
                                    Read Full Story &rarr;
                                </Link>
                            </div>
                        </div>
                    </article>
                </div>
                
                <div class="mt-8 text-center sm:hidden">
                    <Link href="/news" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                        View All News
                    </Link>
                </div>
            </div>
        </div>
    </PublicLayout>
</template>
