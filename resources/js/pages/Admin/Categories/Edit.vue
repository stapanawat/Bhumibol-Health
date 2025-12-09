<script setup lang="ts">
import { route } from 'ziggy-js';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps<{
    category: {
        id: number;
        name_th: string;
        name_en: string;
        type: string;
        is_active: boolean; // Note: Ensure backend sends boolean or 0/1, Laravel might send 0/1
    };
}>();

const form = useForm({
    name_th: props.category.name_th,
    name_en: props.category.name_en,
    type: props.category.type,
    is_active: Boolean(props.category.is_active),
});

const submit = () => {
    form.put(route('admin.categories.update', props.category.id));
};
</script>

<template>
    <Head title="Edit Category" />

    <AppLayout title="Edit Category">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Category
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <form @submit.prevent="submit">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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
                                Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
