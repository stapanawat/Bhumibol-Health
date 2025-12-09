<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link, useForm, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps<{
    post: any;
    categories: Array<{ id: number; name_th: string }>;
}>();

const form = useForm({
    _method: 'PUT', // For handling file upload in PUT request (Laravel quirks)
    title_th: props.post.title_th,
    title_en: props.post.title_en,
    category_id: props.post.category_id,
    content_th: props.post.content_th,
    content_en: props.post.content_en,
    excerpt_th: props.post.excerpt_th,
    excerpt_en: props.post.excerpt_en,
    status: props.post.status,
    is_pinned: Boolean(props.post.is_pinned),
    image: null as File | null,
});

const imagePreview = ref<string | null>(props.post.image ? `/storage/${props.post.image}` : null);

const handleImageUpload = (event: Event) => {
    const target = event.target as HTMLInputElement;
    if (target.files && target.files[0]) {
        form.image = target.files[0];
        imagePreview.value = URL.createObjectURL(target.files[0]);
    }
};

const submit = () => {
    // We use router.post with _method: PUT because Inertia/Laravel has issues with PUT + FormData (Files)
    router.post(route('admin.posts.update', props.post.id), form);
};
</script>

<template>
    <Head title="Edit Post" />

    <AppLayout title="Edit Post">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Post
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <form @submit.prevent="submit" enctype="multipart/form-data">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <!-- Image Upload -->
                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Cover Image</label>
                                <div class="mt-1 flex items-center gap-4">
                                    <div v-if="imagePreview" class="w-32 h-32 bg-gray-100 rounded-lg overflow-hidden">
                                        <img :src="imagePreview" class="w-full h-full object-cover" />
                                    </div>
                                    <input type="file" @change="handleImageUpload" accept="image/*" class="block w-full text-sm text-gray-500
                                        file:mr-4 file:py-2 file:px-4
                                        file:rounded-full file:border-0
                                        file:text-sm file:font-semibold
                                        file:bg-blue-50 file:text-blue-700
                                        hover:file:bg-blue-100
                                    "/>
                                </div>
                                <div v-if="form.errors.image" class="text-red-500 text-xs mt-1">{{ form.errors.image }}</div>
                            </div>

                            <!-- Basic Info -->
                            <div class="col-span-2 md:col-span-1">
                                <label class="block text-sm font-medium text-gray-700">Category</label>
                                <select v-model="form.category_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                                    <option value="" disabled>Select Category</option>
                                    <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.name_th }}</option>
                                </select>
                                <div v-if="form.errors.category_id" class="text-red-500 text-xs mt-1">{{ form.errors.category_id }}</div>
                            </div>

                            <div class="col-span-2 md:col-span-1">
                                <label class="block text-sm font-medium text-gray-700">Status</label>
                                <select v-model="form.status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    <option value="draft">Draft (ฉบับร่าง)</option>
                                    <option value="published">Published (เผยแพร่)</option>
                                    <option value="archived">Archived (เก็บเข้ากรุ)</option>
                                </select>
                                <div v-if="form.errors.status" class="text-red-500 text-xs mt-1">{{ form.errors.status }}</div>
                            </div>

                            <!-- Thai Content -->
                            <div class="col-span-2 border-t pt-4">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Content (Thai)</h3>
                                <div class="grid grid-cols-1 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Title (TH)</label>
                                        <input v-model="form.title_th" type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                                        <div v-if="form.errors.title_th" class="text-red-500 text-xs mt-1">{{ form.errors.title_th }}</div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Excerpt (TH)</label>
                                        <textarea v-model="form.excerpt_th" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"></textarea>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Content (TH)</label>
                                        <textarea v-model="form.content_th" rows="10" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- English Content -->
                            <div class="col-span-2 border-t pt-4 bg-gray-50 p-4 rounded-lg">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Content (English) - Optional</h3>
                                <div class="grid grid-cols-1 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Title (EN)</label>
                                        <input v-model="form.title_en" type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Excerpt (EN)</label>
                                        <textarea v-model="form.excerpt_en" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"></textarea>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Content (EN)</label>
                                        <textarea v-model="form.content_en" rows="10" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"></textarea>
                                    </div>
                                </div>
                            </div>
                            
                             <div class="col-span-2 md:col-span-1 pt-4">
                                <label class="flex items-center space-x-3">
                                    <input v-model="form.is_pinned" type="checkbox" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                    <span class="text-gray-900 font-medium">Pin to Highlight (ปักหมุดข่าวสำคัญ)</span>
                                </label>
                            </div>

                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <Link :href="route('admin.posts.index')" class="text-gray-600 hover:text-gray-900 mr-4">Cancel</Link>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" :disabled="form.processing">
                                Update Post
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
