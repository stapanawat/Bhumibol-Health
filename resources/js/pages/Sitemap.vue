<script setup lang="ts">
import PublicLayout from '@/layouts/PublicLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ExternalLink, Link as LinkIcon, Map } from 'lucide-vue-next';

defineProps<{
    categories: any[];
}>();
</script>

<template>
    <Head title="Sitemap" />
    <PublicLayout>
        <div class="bg-gradient-to-b from-slate-50 to-white min-h-[50vh]">
            <!-- Hero Section -->
            <div class="bg-slate-900 text-white py-16 md:py-24 relative overflow-hidden">
                <div class="absolute inset-0 bg-[url('/images/pattern.svg')] opacity-10"></div>
                <!-- Dynamic Theme Background Overlay -->
                <div class="absolute inset-0 bg-primary/20 pointer-events-none"></div>
                
                <div class="container mx-auto px-4 relative z-10 text-center">
                    <div class="inline-flex items-center justify-center p-3 bg-white/10 rounded-2xl mb-6 backdrop-blur-sm">
                        <Map class="w-8 h-8 text-primary-foreground" />
                    </div>
                    <h1 class="text-4xl md:text-5xl font-bold mb-4">Sitemap</h1>
                    <p class="text-slate-300 text-lg max-w-2xl mx-auto">
                        Overview of all pages and links on Bhumibol Adulyadej Hospital website.
                    </p>
                </div>
            </div>

            <div class="container mx-auto px-4 py-12 md:py-16">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    
                    <div v-for="category in categories" :key="category.id" class="space-y-4">
                        <h2 class="text-xl font-bold text-slate-800 border-b border-primary/20 pb-2 flex items-center gap-2">
                             <div class="w-2 h-6 bg-primary rounded-full"></div>
                             {{ category.name_th }}
                             <span v-if="category.name_en" class="text-sm font-normal text-muted-foreground ml-2">({{ category.name_en }})</span>
                        </h2>
                        
                        <ul class="space-y-3">
                            <li v-for="sitemap in category.sitemaps" :key="sitemap.id">
                                <a :href="sitemap.link" target="_blank" class="group flex items-start gap-2 text-slate-600 hover:text-primary transition-colors">
                                    <LinkIcon class="w-4 h-4 mt-1 text-slate-400 group-hover:text-primary transition-colors" />
                                    <span>{{ sitemap.title_th }}</span>
                                </a>
                            </li>
                            <li v-if="category.sitemaps && category.sitemaps.length === 0" class="text-sm text-slate-400 italic">
                                No links available.
                            </li>
                        </ul>
                    </div>

                    <div v-if="categories.length === 0" class="col-span-full text-center py-12 text-muted-foreground">
                        Sitemap is currently empty.
                    </div>

                </div>
            </div>
        </div>
    </PublicLayout>
</template>
