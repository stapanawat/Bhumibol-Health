<script setup lang="ts">
import { route } from 'ziggy-js';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name_th: '',
    name_en: '',
    type: 'news',
    is_active: true,
});

const submit = () => {
    form.post(route('admin.categories.store'), {
        onSuccess: () => form.reset(),
    });
};
</script>

<template>
    <Head title="Create Category" />

    <AppLayout title="Create Category">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create Category
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <form @submit.prevent="submit">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Helper for cleaner code, normally would be components -->
                            <div class="col-span-2 md:col-span-1">
                                <label class="block text-sm font-medium text-gray-700">Name (Thai)</label>
                                <input v-model="form.name_th" type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                                <div v-if="form.errors.name_th" class="text-red-500 text-xs mt-1">{{ form.errors.name_th }}</div>
                            </div>

                            <div class="col-span-2 md:col-span-1">
                                <label class="block text-sm font-medium text-gray-700">Name (English)</label>
                                <input v-model="form.name_en" type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <div v-if="form.errors.name_en" class="text-red-500 text-xs mt-1">{{ form.errors.name_en }}</div>
                            </div>

                            <div class="col-span-2 md:col-span-1">
                                <label class="block text-sm font-medium text-gray-700">Type</label>
                                <select v-model="form.type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    <option value="news">News (ข่าวประชาสัมพันธ์)</option>
                                    <option value="article">Article (บทความสุขภาพ)</option>
                                    <option value="activity">Activity (กิจกรรม)</option>
                                    <option value="procurement">Procurement (จัดซื้อจัดจ้าง)</option>
                                </select>
                                <div v-if="form.errors.type" class="text-red-500 text-xs mt-1">{{ form.errors.type }}</div>
                            </div>

                            <div class="col-span-2 md:col-span-1 flex items-center pt-6">
                                <label class="flex items-center space-x-3">
                                    <input v-model="form.is_active" type="checkbox" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                    <span class="text-gray-900 font-medium">Active (ใช้งาน)</span>
                                </label>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <Link :href="route('admin.categories.index')" class="text-gray-600 hover:text-gray-900 mr-4">Cancel</Link>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" :disabled="form.processing">
                                Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
