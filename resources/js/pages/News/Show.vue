<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import PublicLayout from '@/layouts/PublicLayout.vue';
import { route } from 'ziggy-js';
import { Eye, Heart, Share2, MessageCircle, Twitter } from 'lucide-vue-next';

defineProps<{
    post: any;
    relatedPosts: Array<any>;
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
    <Head :title="post.title_th" />

    <PublicLayout>
        <!-- Article Header -->
        <div class="relative w-full h-64 md:h-96 bg-slate-900 overflow-hidden">
             <img v-if="post.image" :src="`/storage/${post.image}`" class="w-full h-full object-cover opacity-60" :alt="post.title_th">
             <div v-else class="w-full h-full bg-gradient-to-r from-blue-900 to-indigo-900 opacity-90"></div>
             
             <div class="absolute inset-0 flex items-center">
                 <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
                     <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-600 text-white mb-4 uppercase tracking-wider">
                         {{ post.category?.name_th }}
                     </span>
                     <h1 class="text-3xl md:text-5xl font-extrabold text-white leading-tight mb-4 shadow-sm">
                         {{ post.title_th }}
                     </h1>
                     <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                         <div class="flex items-center text-blue-100 text-sm">
                             <span class="mr-4">{{ formatDate(post.created_at) }}</span>
                             <span class="w-1 h-1 bg-blue-400 rounded-full mr-4"></span>
                             <span class="flex items-center">
                                 <Eye class="w-4 h-4 mr-1" />
                                 {{ post.views }}
                             </span>
                         </div>

                         <!-- Interaction Buttons -->
                         <div class="flex items-center gap-3">
                             <button class="flex items-center justify-center w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 backdrop-blur-sm transition-all duration-200 text-white group" title="Like">
                                 <Heart class="w-5 h-5 group-hover:text-red-400 group-hover:fill-red-400 transition-colors" />
                             </button>
                             <button class="flex items-center justify-center w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 backdrop-blur-sm transition-all duration-200 text-white group" title="Comment">
                                 <MessageCircle class="w-5 h-5 group-hover:text-blue-400 transition-colors" />
                             </button>
                             <button class="flex items-center justify-center w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 backdrop-blur-sm transition-all duration-200 text-white group" title="Share">
                                 <Share2 class="w-5 h-5 group-hover:text-green-400 transition-colors" />
                             </button>
                             <a :href="`https://twitter.com/intent/tweet?text=${post.title_th}&url=${route('news.show', post.slug)}`" target="_blank" class="flex items-center justify-center w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 backdrop-blur-sm transition-all duration-200 text-white group" title="Tweet">
                                 <Twitter class="w-5 h-5 group-hover:text-sky-400 transition-colors" />
                             </a>
                         </div>
                     </div>
                 </div>
             </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="lg:grid lg:grid-cols-12 lg:gap-12">
                <!-- Main Content -->
                <article class="lg:col-span-8 bg-white p-6 md:p-10 rounded-2xl shadow-sm border border-slate-100">
                    <div class="prose prose-lg prose-blue max-w-none text-slate-700">
                        <p class="lead font-medium text-xl text-slate-900 mb-8 border-l-4 border-blue-500 pl-4 italic">
                            {{ post.excerpt_th }}
                        </p>
                        
                        <!-- Content HTML -->
                        <div v-html="post.content_th"></div>
                    </div>
                </article>

                <!-- Sidebar (Related News) -->
                <aside class="mt-12 lg:mt-0 lg:col-span-4 space-y-8">
                    <div class="bg-slate-50 rounded-2xl p-6 border border-slate-100">
                        <h3 class="text-lg font-bold text-slate-900 mb-4 border-b pb-2">Related News</h3>
                        <div class="space-y-6">
                            <div v-for="related in relatedPosts" :key="related.id" class="group flex gap-4">
                                <Link :href="route('news.show', related.slug)" class="shrink-0 w-20 h-20 rounded-lg overflow-hidden bg-slate-200">
                                    <img v-if="related.image" :src="`/storage/${related.image}`" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                </Link>
                                <div>
                                    <h4 class="text-sm font-semibold text-slate-900 group-hover:text-blue-600 line-clamp-2 leading-snug mb-1">
                                        <Link :href="route('news.show', related.slug)">{{ related.title_th }}</Link>
                                    </h4>
                                    <span class="text-xs text-slate-500">{{ formatDate(related.created_at) }}</span>
                                </div>
                            </div>
                            <div v-if="relatedPosts.length === 0" class="text-slate-500 text-sm">
                                No related news found.
                            </div>
                        </div>
                    </div>

                    <!-- Banner / Call to Action -->
                    <div class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl p-6 text-white text-center">
                        <h3 class="font-bold text-xl mb-2">Need an appointment?</h3>
                        <p class="text-blue-100 text-sm mb-6">Book your visit online effortlessly via our patient portal.</p>
                        <button class="bg-white text-blue-600 font-bold py-2.5 px-6 rounded-full w-full hover:bg-blue-50 transition-colors">
                            Book Now
                        </button>
                    </div>
                </aside>
            </div>
        </div>
    </PublicLayout>
</template>
