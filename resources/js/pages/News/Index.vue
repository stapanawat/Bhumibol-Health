<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import PublicLayout from '@/layouts/PublicLayout.vue';
import { route } from 'ziggy-js';
import { ref, watch } from 'vue';
import { debounce } from 'lodash';

const props = defineProps<{
    posts: {
        data: Array<any>;
        links: Array<any>;
    };
    categories: Array<any>;
    filters: {
        search?: string;
        category?: string;
    };
}>();

const search = ref(props.filters.search || '');

// Using a custom debounce since lodash might not be fully available or types issues
let timeout: any = null;
const handleSearch = () => {
    clearTimeout(timeout);
    timeout = setTimeout(() => {
        router.get(route('news.index'), { 
            search: search.value,
            category: props.filters.category 
        }, { preserveState: true, replace: true });
    }, 500);
};

const formatDate = (date: string) => {
    return new Date(date).toLocaleDateString('th-TH', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    });
};
</script>

<template>
    <Head title="News & Updates" />

    <PublicLayout>
        <div class="bg-blue-600 py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-3xl font-extrabold text-white sm:text-4xl">News & Updates</h1>
                <p class="mt-4 text-xl text-blue-100 max-w-2xl mx-auto">
                    Stay informed with the latest announcements, medical articles, and activities from Bhumibol Health.
                </p>
                
                <!-- Search Bar -->
                <div class="mt-8 max-w-xl mx-auto">
                    <div class="relative rounded-md shadow-sm">
                        <input v-model="search" @input="handleSearch" type="text" class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-4 pr-12 sm:text-sm border-gray-300 rounded-full py-3" placeholder="Search news...">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="lg:grid lg:grid-cols-4 lg:gap-8">
                <!-- Sidebar -->
                <div class="hidden lg:block">
                    <h3 class="font-semibold text-slate-900 mb-4 px-2">Categories</h3>
                    <nav class="space-y-1">
                        <Link :href="route('news.index')" :class="{'bg-blue-50 text-blue-700': !filters.category, 'text-slate-600 hover:bg-slate-50': filters.category}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md">
                            All News
                        </Link>
                         <Link v-for="cat in categories" :key="cat.id" :href="route('news.index', { category: cat.slug })" :class="{'bg-blue-50 text-blue-700': filters.category === cat.slug, 'text-slate-600 hover:bg-slate-50': filters.category !== cat.slug}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md">
                            {{ cat.name_th }}
                        </Link>
                    </nav>
                </div>

                <!-- Main Content -->
                <div class="mt-8 lg:mt-0 lg:col-span-3">
                    <!-- Mobile Categories (Dropdown) -->
                    <div class="lg:hidden mb-6">
                        <label for="tabs" class="sr-only">Select a category</label>
                        <select id="tabs" name="tabs" class="block w-full focus:ring-blue-500 focus:border-blue-500 border-gray-300 rounded-md" @change="router.visit(route('news.index', { category: ($event.target as HTMLSelectElement).value }))">
                            <option value="">All News</option>
                            <option v-for="cat in categories" :key="cat.id" :value="cat.slug" :selected="filters.category === cat.slug">{{ cat.name_th }}</option>
                        </select>
                    </div>

                    <!-- News Grid -->
                    <div v-if="posts.data.length > 0" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                         <article v-for="news in posts.data" :key="news.id" class="flex flex-col bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden border border-slate-100">
                             <div class="h-48 w-full bg-slate-100 relative overflow-hidden">
                                <img v-if="news.image" :src="`/storage/${news.image}`" class="w-full h-full object-cover" :alt="news.title_th">
                                <div v-else class="w-full h-full flex items-center justify-center text-slate-300">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                             </div>
                             <div class="p-5 flex-1 flex flex-col">
                                 <div class="text-xs text-blue-600 font-semibold mb-2 uppercase">{{ news.category?.name_th }}</div>
                                 <h3 class="text-lg font-bold text-slate-900 mb-2 line-clamp-2">
                                     <Link :href="route('news.show', news.slug)" class="hover:text-blue-600">{{ news.title_th }}</Link>
                                 </h3>
                                 <p class="text-slate-500 text-sm line-clamp-3 mb-4 flex-1">
                                     {{ news.excerpt_th }}
                                 </p>
                                 <div class="flex items-center justify-between mt-auto">
                                     <span class="text-xs text-slate-400">{{ formatDate(news.created_at) }}</span>
                                     <Link :href="route('news.show', news.slug)" class="text-blue-600 font-semibold text-sm hover:underline">Read More</Link>
                                 </div>
                             </div>
                         </article>
                    </div>
                    
                    <div v-else class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No news found</h3>
                        <p class="mt-1 text-sm text-gray-500">Try adjusting your search or filter.</p>
                    </div>

                    <!-- Pagination -->
                     <div v-if="posts.links.length > 3" class="mt-8 flex justify-center">
                         <div class="flex gap-1">
                             <component :is="link.url ? Link : 'span'" v-for="(link, i) in posts.links" :key="i" :href="link.url" 
                                v-html="link.label"
                                class="px-4 py-2 text-sm rounded-md transition-colors"
                                :class="{
                                    'bg-blue-600 text-white font-bold': link.active,
                                    'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200': !link.active && link.url,
                                    'text-slate-400': !link.url
                                }"
                             />
                         </div>
                     </div>
                </div>
            </div>
        </div>
    </PublicLayout>
</template>
