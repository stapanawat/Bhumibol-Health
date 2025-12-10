<script setup lang="ts">
import { ref, watch } from 'vue';
import { Input } from '@/components/ui/input';
import { Search, Loader2, FileText, User } from 'lucide-vue-next';
import { Link } from '@inertiajs/vue3';
import axios from 'axios';

const query = ref('');
const results = ref<{
    posts: Array<{ type: string; title: string; subtitle: string; url: string; image: string | null }>;
    doctors: Array<{ type: string; title: string; subtitle: string; url: string; image: string | null }>;
}>({ posts: [], doctors: [] });

const loading = ref(false);
const showResults = ref(false);
let timeout: ReturnType<typeof setTimeout>;

const handleSearch = () => {
    clearTimeout(timeout);
    if (query.value.length < 2) {
        results.value = { posts: [], doctors: [] };
        showResults.value = false;
        return;
    }

    loading.value = true;
    showResults.value = true;

    timeout = setTimeout(async () => {
        try {
            const response = await axios.get(route('search.suggest'), {
                params: { q: query.value }
            });
            results.value = response.data;
        } catch (error) {
            console.error(error);
        } finally {
            loading.value = false;
        }
    }, 300);
};

const closeResults = () => {
    // Delay closing to allow clicking links
    setTimeout(() => {
        showResults.value = false;
    }, 200);
};
</script>

<template>
    <div class="relative w-full max-w-sm">
        <div class="relative">
            <Search class="absolute left-2.5 top-2.5 h-4 w-4 text-slate-500" />
            <Input
                v-model="query"
                @input="handleSearch"
                @focus="handleSearch"
                @blur="closeResults"
                type="search"
                placeholder="Search news, doctors..."
                class="pl-9 bg-slate-100 border-slate-200 focus:bg-white transition-colors rounded-full"
            />
            <Loader2 v-if="loading" class="absolute right-3 top-2.5 h-4 w-4 animate-spin text-slate-400" />
        </div>

        <div
            v-if="showResults && (results.posts.length > 0 || results.doctors.length > 0)"
            class="absolute top-full mt-2 w-full bg-white rounded-xl shadow-xl border border-slate-100 overflow-hidden z-50 animate-in fade-in zoom-in-95 duration-200"
        >
            <div v-if="results.posts.length > 0" class="py-2">
                <div class="px-4 py-1.5 text-xs font-semibold text-slate-400 uppercase tracking-wider">
                    News & Articles
                </div>
                <Link
                    v-for="(item, index) in results.posts"
                    :key="index"
                    :href="item.url"
                    class="flex items-center gap-3 px-4 py-2 hover:bg-slate-50 transition-colors"
                >
                    <div class="h-8 w-8 rounded-md bg-slate-100 overflow-hidden flex-shrink-0">
                        <img v-if="item.image" :src="item.image" class="h-full w-full object-cover" />
                        <FileText v-else class="h-4 w-4 m-2 text-slate-400" />
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="text-sm font-medium text-slate-900 truncate">{{ item.title }}</div>
                        <div class="text-xs text-slate-500 truncate">{{ item.subtitle }}</div>
                    </div>
                </Link>
            </div>

            <div v-if="results.doctors.length > 0" class="border-t border-slate-50 py-2">
                <div class="px-4 py-1.5 text-xs font-semibold text-slate-400 uppercase tracking-wider">
                    Doctors
                </div>
                <Link
                    v-for="(item, index) in results.doctors"
                    :key="index"
                    :href="item.url"
                    class="flex items-center gap-3 px-4 py-2 hover:bg-slate-50 transition-colors"
                >
                    <div class="h-8 w-8 rounded-full bg-slate-100 overflow-hidden flex-shrink-0">
                        <img v-if="item.image" :src="item.image" class="h-full w-full object-cover" />
                        <User v-else class="h-4 w-4 m-2 text-slate-400" />
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="text-sm font-medium text-slate-900 truncate">{{ item.title }}</div>
                        <div class="text-xs text-slate-500 truncate">{{ item.subtitle }}</div>
                    </div>
                </Link>
            </div>
        </div>
        
         <div
            v-else-if="showResults && query.length >= 2 && !loading"
             class="absolute top-full mt-2 w-full bg-white rounded-xl shadow-xl border border-slate-100 overflow-hidden z-50 p-4 text-center text-sm text-slate-500"
        >
            No results found.
        </div>
    </div>
</template>
