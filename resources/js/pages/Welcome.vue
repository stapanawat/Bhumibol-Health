

<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { Eye, Heart, Share2 } from 'lucide-vue-next';
import PublicLayout from '@/layouts/PublicLayout.vue';
import { route } from 'ziggy-js';
import { ref, onMounted, onUnmounted } from 'vue';

const props = defineProps<{
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
    doctors: Array<{
        id: number;
        name_th: string;
        specialty_th: string;
        image: string;
    }>;
    introPages?: Array<{
        id: number;
        title: string;
        media_path: string;
        link?: string;
        display_duration?: number;
    }>;
}>();

const formatDate = (date: string) => {
    return new Date(date).toLocaleDateString('th-TH', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    });
};

const currentSlide = ref(0);
let slideTimer: any = null;

const startSlideTimer = () => {
    if (props.introPages && props.introPages.length > 1) {
        clearInterval(slideTimer);
        const duration = (props.introPages![currentSlide.value].display_duration || 5) * 1000;
        slideTimer = setInterval(() => {
            currentSlide.value = (currentSlide.value + 1) % props.introPages!.length;
        }, duration);
    }
};

onMounted(() => {
    if (props.introPages && props.introPages.length > 0) {
        startSlideTimer();
    }
});

onUnmounted(() => {
    if (slideTimer) clearInterval(slideTimer);
});
</script>

<template>
    <Head title="Welcome to Bhumibol Health" />

    <PublicLayout>
        <!-- Intro Slideshow (If Available) -->
        <div v-if="introPages && introPages.length > 0" class="relative bg-black overflow-hidden h-[500px] md:h-[600px]">
             <div 
                v-for="(slide, index) in introPages" 
                :key="slide.id"
                class="absolute inset-0 transition-opacity duration-1000 ease-in-out"
                :class="{'opacity-100 relative z-10': currentSlide === index, 'opacity-0 z-0': currentSlide !== index}"
            >
                <img :src="`/storage/${slide.media_path}`" class="w-full h-full object-cover opacity-80" :alt="slide.title">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent flex items-end justify-center pb-20">
                     <div class="text-center px-4 max-w-4xl mx-auto">
                        <h2 class="text-3xl md:text-5xl font-bold text-white mb-4 drop-shadow-lg">{{ slide.title }}</h2>
                        <a v-if="slide.link" :href="slide.link" class="inline-block px-8 py-3 bg-primary text-white font-medium rounded-full hover:bg-primary/90 transition-colors shadow-lg">
                            Learn More
                        </a>
                     </div>
                </div>
            </div>

            <!-- Slide Indicators -->
            <div v-if="introPages.length > 1" class="absolute bottom-8 left-0 right-0 z-20 flex justify-center space-x-2">
                <button 
                    v-for="(slide, index) in introPages" 
                    :key="index"
                    @click="currentSlide = index; startSlideTimer()"
                    class="w-3 h-3 rounded-full transition-all duration-300"
                    :class="currentSlide === index ? 'bg-primary w-8' : 'bg-white/50 hover:bg-white'"
                ></button>
            </div>
        </div>

        <!-- Static Hero Section (Fallback) -->
        <div v-else class="relative bg-white overflow-hidden">
            <div class="max-w-7xl mx-auto">
                <div class="relative z-10 pb-8 bg-white sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
                    <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                        <div class="sm:text-center lg:text-left">
                            <h1 class="text-4xl tracking-tight font-extrabold text-slate-900 sm:text-5xl md:text-6xl">
                                <span class="block xl:inline">World-class care</span>
                                <span class="block text-primary xl:inline"> close to you</span>
                            </h1>
                            <p class="mt-3 text-base text-slate-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                                Bhumibol Adulyadej Hospital provides premium healthcare services with advanced technology and expert medical specialists.
                            </p>
                            
                            <!-- Hero News (Pinned) -->
                            <div v-if="heroPost" class="mt-8 p-6 bg-secondary/30 rounded-2xl border border-primary/20 shadow-sm relative overflow-hidden group">
                                <div class="absolute top-0 right-0 p-2 opacity-10">
                                    <svg class="w-24 h-24 text-primary" fill="currentColor" viewBox="0 0 24 24"><path d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                                </div>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary/10 text-primary/80 mb-2">
                                    {{ heroPost.category?.name_th }}
                                </span>
                                <h3 class="text-xl font-bold text-slate-900 group-hover:text-primary transition-colors">
                                    <Link :href="route('news.show', heroPost.slug)">{{ heroPost.title_th }}</Link>
                                </h3>
                                <p class="mt-2 text-slate-600 text-sm line-clamp-2">
                                    {{ heroPost.excerpt_th }}
                                </p>
                                <div class="mt-4">
                                     <Link :href="route('news.show', heroPost.slug)" class="text-primary font-semibold hover:text-primary/80 text-sm flex items-center">
                                        Read More <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                     </Link>
                                </div>
                            </div>
                            
                            <div v-else class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                                <div class="rounded-md shadow">
                                    <Link href="/news" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-primary hover:bg-primary/90 md:py-4 md:text-lg md:px-10">
                                        Read News
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>
            </div>
            
            <!-- Hero Image -->
            <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2 bg-secondary/30">
                 <img v-if="heroPost?.image" :src="`/storage/${heroPost.image}`" class="h-56 w-full object-cover sm:h-72 md:h-96 lg:w-full lg:h-full opacity-90" alt="Hero Image">
                 <div v-else class="flex items-center justify-center w-full h-full text-primary/20 font-bold text-9xl select-none opacity-20">HEALTH</div>
            </div>
        </div>



        <!-- Latest News Grid -->
        <div class="py-16 bg-slate-50" v-if="latestNews.length > 0">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-end mb-8">
                     <div>
                        <h2 class="text-primary font-semibold tracking-wide uppercase">Update</h2>
                        <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-slate-900 sm:text-4xl">
                            Latest News
                        </p>
                     </div>
                     <Link href="/news" class="hidden sm:flex text-slate-500 hover:text-primary font-medium items-center transition-colors">
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
                                <span class="bg-white/90 backdrop-blur text-primary/80 text-xs font-bold px-3 py-1 rounded-full shadow-sm">
                                    {{ news.category?.name_th }}
                                </span>
                            </div>
                        </div>
                        <div class="flex-1 p-6 flex flex-col justify-between">
                            <div>
                                <div class="text-sm text-slate-500 mb-2">{{ formatDate(news.created_at) }}</div>
                                <h3 class="text-xl font-bold text-slate-900 mb-3 group-hover:text-primary transition-colors line-clamp-2">
                                    <Link :href="route('news.show', news.slug)">{{ news.title_th }}</Link>
                                </h3>
                                <p class="text-slate-600 text-sm line-clamp-3">
                                    {{ news.excerpt_th }}
                                </p>
                            </div>
                            <div class="mt-6 pt-6 border-t border-slate-100 flex items-center justify-between">
                                <div class="flex items-center space-x-4 text-xs text-slate-400">
                                     <span class="flex items-center">
                                         <Eye class="w-3.5 h-3.5 mr-1" />
                                         {{ (news as any).views }}
                                     </span>
                                     <span class="flex items-center">
                                         <Heart class="w-3.5 h-3.5 mr-1" />
                                         0
                                     </span>
                                     <span class="flex items-center">
                                         <Share2 class="w-3.5 h-3.5 mr-1" />
                                         0
                                     </span>
                                </div>
                                <Link :href="route('news.show', news.slug)" class="text-primary font-semibold text-sm hover:underline">
                                    Read Full Story &rarr;
                                </Link>
                            </div>
                        </div>
                    </article>
                </div>
                
                <div class="mt-8 text-center sm:hidden">
                    <Link href="/news" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-primary hover:bg-primary/90">
                        View All News
                    </Link>
                </div>
            </div>
        </div>
                <!-- Our Specialists Section -->
        <div class="py-16 bg-white overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="text-base font-semibold text-primary tracking-wide uppercase">Expert Care</h2>
                    <p class="mt-1 text-3xl font-extrabold text-slate-900 sm:text-4xl sm:tracking-tight lg:text-5xl">
                        Our Specialists
                    </p>
                    <p class="max-w-xl mt-5 mx-auto text-xl text-slate-500">
                        Meet our team of dedicated medical professionals committed to providing the best healthcare services.
                    </p>
                </div>

                <div class="mt-12 grid gap-8 grid-cols-1 sm:grid-cols-2 lg:grid-cols-4">
                    <div v-for="doctor in doctors" :key="doctor.id" class="group text-center">
                        <div class="relative w-40 h-40 mx-auto rounded-full overflow-hidden bg-slate-100 ring-4 ring-blue-50 group-hover:ring-blue-100 transition-all mb-6">
                             <img v-if="doctor.image" :src="`/storage/${doctor.image}`" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500" :alt="doctor.name_th">
                             <div v-else class="w-full h-full flex items-center justify-center text-slate-300">
                                <svg class="w-20 h-20" fill="currentColor" viewBox="0 0 24 24"><path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                             </div>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900 group-hover:text-primary transition-colors">{{ doctor.name_th }}</h3>
                        <p class="text-primary text-sm font-medium mt-1">{{ doctor.specialty_th }}</p>
                    </div>
                </div>

                 <div class="mt-10 text-center">
                    <Link :href="route('doctors.index')" class="inline-flex items-center text-primary font-semibold hover:text-primary/80 transition-colors">
                        View All Doctors <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </Link>
                </div>
            </div>
        </div>
    </PublicLayout>
</template>
