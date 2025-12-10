<script setup lang="ts">
import { route } from 'ziggy-js';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import TranslationButton from '@/components/TranslationButton.vue';
import { debounce } from 'lodash';
import axios from 'axios';

const form = useForm({
    name_th: '', name_en: '', specialty_th: '', specialty_en: '',
    education_th: '', education_en: '', department: '', order: 0,
    image: null as File | null,
});

const translateText = async (text: string, onSuccess: (res: string) => void) => {
     if (!text) return;
     try {
        const response = await axios.post(route('admin.translate'), {
            text,
            target_lang: 'en',
            source_lang: 'th'
        });
        onSuccess(response.data.translation);
     } catch (e) {
         console.error('Auto-translation failed:', e);
     }
}

const debouncedTranslate = debounce(translateText, 1000);

watch(() => form.name_th, (newVal) => {
    if (!form.name_en) debouncedTranslate(newVal, (res) => form.name_en = res);
});

watch(() => form.specialty_th, (newVal) => {
    if (!form.specialty_en) debouncedTranslate(newVal, (res) => form.specialty_en = res);
});

watch(() => form.education_th, (newVal) => {
    if (!form.education_en) debouncedTranslate(newVal, (res) => form.education_en = res);
});

const photoPreview = ref<string | null>(null);

const updatePhotoPreview = (event: Event) => {
    const target = event.target as HTMLInputElement;
    if (target.files && target.files[0]) {
        const file = target.files[0];
        form.image = file;
        const reader = new FileReader();
        reader.onload = (e) => {
            photoPreview.value = e.target?.result as string;
        };
        reader.readAsDataURL(file);
    }
};

const submit = () => {
    form.post(route('admin.doctors.store'), {
        onSuccess: () => form.reset(),
    });
};
</script>

<template>
    <Head title="Add New Doctor" />

    <AppLayout title="Add New Doctor">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Add New Doctor
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <form @submit.prevent="submit">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <!-- Profile Photo -->
                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Profile Photo</label>
                                <div class="mt-2 flex items-center space-x-6">
                                    <div class="shrink-0">
                                        <div v-if="photoPreview" class="h-24 w-24 rounded-full object-cover overflow-hidden ring-4 ring-white shadow-lg">
                                            <img :src="photoPreview" class="h-full w-full object-cover">
                                        </div>
                                        <div v-else class="h-24 w-24 rounded-full bg-gray-200 flex items-center justify-center text-gray-400">
                                            <svg class="h-12 w-12" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </div>
                                    </div>
                                    <label class="block">
                                        <span class="sr-only">Choose profile photo</span>
                                        <input type="file" @change="updatePhotoPreview" class="block w-full text-sm text-slate-500
                                          file:mr-4 file:py-2 file:px-4
                                          file:rounded-full file:border-0
                                          file:text-sm file:font-semibold
                                          file:bg-blue-50 file:text-blue-700
                                          hover:file:bg-blue-100
                                        "/>
                                    </label>
                                </div>
                                <div v-if="form.errors.image" class="text-red-500 text-xs mt-1">{{ form.errors.image }}</div>
                            </div>

                            <div class="col-span-2 md:col-span-1">
                                <label class="block text-sm font-medium text-gray-700">Name (Thai)</label>
                                <input v-model="form.name_th" type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required placeholder="e.g. นพ. สมชาย ใจดี">
                                <div v-if="form.errors.name_th" class="text-red-500 text-xs mt-1">{{ form.errors.name_th }}</div>
                            </div>

                            <div class="col-span-2 md:col-span-1">
                                <label class="block text-sm font-medium text-gray-700">Name (English)</label>
                                <div class="flex justify-between items-center mb-1">
                                    <div class="h-4"></div>
                                    <TranslationButton :text="form.name_th" to="en" @translated="form.name_en = $event" />
                                </div>
                                <input v-model="form.name_en" type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="e.g. Dr. Somchai Jaidee">
                                <div v-if="form.errors.name_en" class="text-red-500 text-xs mt-1">{{ form.errors.name_en }}</div>
                            </div>

                            <div class="col-span-2 md:col-span-1">
                                <label class="block text-sm font-medium text-gray-700">Specialty (Thai)</label>
                                <input v-model="form.specialty_th" type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required placeholder="e.g. อายุรแพทย์หัวใจ">
                                <div v-if="form.errors.specialty_th" class="text-red-500 text-xs mt-1">{{ form.errors.specialty_th }}</div>
                            </div>

                            <div class="col-span-2 md:col-span-1">
                                <label class="block text-sm font-medium text-gray-700">Specialty (English)</label>
                                <div class="flex justify-between items-center mb-1">
                                    <div class="h-4"></div>
                                    <TranslationButton :text="form.specialty_th" to="en" @translated="form.specialty_en = $event" />
                                </div>
                                <input v-model="form.specialty_en" type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="e.g. Cardiologist">
                                <div v-if="form.errors.specialty_en" class="text-red-500 text-xs mt-1">{{ form.errors.specialty_en }}</div>
                            </div>
                            
                            <div class="col-span-2 md:col-span-1">
                                <label class="block text-sm font-medium text-gray-700">Department</label>
                                <input v-model="form.department" type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="e.g. แผนกอายุรกรรม">
                                <div v-if="form.errors.department" class="text-red-500 text-xs mt-1">{{ form.errors.department }}</div>
                            </div>

                            <div class="col-span-2 md:col-span-1">
                                <label class="block text-sm font-medium text-gray-700">Sort Order</label>
                                <input v-model="form.order" type="number" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <div v-if="form.errors.order" class="text-red-500 text-xs mt-1">{{ form.errors.order }}</div>
                            </div>

                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Education / Qualifications (Thai)</label>
                                <textarea v-model="form.education_th" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"></textarea>
                                <div v-if="form.errors.education_th" class="text-red-500 text-xs mt-1">{{ form.errors.education_th }}</div>
                            </div>

                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Education / Qualifications (English)</label>
                                <div class="flex justify-between items-center mb-1">
                                    <div class="h-4"></div>
                                    <TranslationButton :text="form.education_th" to="en" @translated="form.education_en = $event" />
                                </div>
                                <textarea v-model="form.education_en" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"></textarea>
                                <div v-if="form.errors.education_en" class="text-red-500 text-xs mt-1">{{ form.errors.education_en }}</div>
                            </div>

                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <Link :href="route('admin.doctors.index')" class="text-gray-600 hover:text-gray-900 mr-4">Cancel</Link>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" :disabled="form.processing">
                                Save Doctor
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
