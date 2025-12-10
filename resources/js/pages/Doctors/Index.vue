<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import PublicLayout from '@/layouts/PublicLayout.vue';

defineProps<{
    doctors: Array<{
        id: number;
        name_th: string;
        name_en: string;
        specialty_th: string;
        specialty_en: string;
        image: string;
        education_th: string;
        education_en: string;
        department: string;
    }>;
}>();
</script>

<template>
    <Head title="Our Doctors" />

    <PublicLayout>
        <div class="bg-blue-600 py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-3xl font-extrabold text-white sm:text-4xl">Our Doctors</h1>
                <p class="mt-4 text-xl text-blue-100 max-w-2xl mx-auto">
                    Meet our team of dedicated medical specialists committed to your health and well-being.
                </p>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <div v-for="doctor in doctors" :key="doctor.id" class="bg-white rounded-2xl shadow-sm hover:shadow-md transition-shadow border border-slate-100 overflow-hidden flex flex-col items-center p-6 text-center group">
                    <div class="w-32 h-32 rounded-full overflow-hidden bg-slate-100 mb-4 ring-4 ring-blue-50 group-hover:ring-blue-100 transition-all">
                        <img v-if="doctor.image" :src="`/storage/${doctor.image}`" class="w-full h-full object-cover" :alt="doctor.name_th" />
                        <div v-else class="w-full h-full flex items-center justify-center text-slate-300">
                            <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 24 24"><path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                        </div>
                    </div>
                    
                    <h3 class="text-lg font-bold text-slate-900 mb-1">{{ doctor.name_th }}</h3>
                    <p class="text-blue-600 text-sm font-medium mb-3">{{ doctor.specialty_th }}</p>
                    
                    <div class="text-sm text-slate-500 mb-4 space-y-1 line-clamp-3">
                         <p v-if="doctor.department" class="font-medium text-slate-700">{{ doctor.department }}</p>
                         <p class="text-xs">{{ doctor.education_th }}</p>
                    </div>

                    <!-- Future: Link to doctor detail -->
                    <!-- <button class="mt-auto px-4 py-2 bg-blue-50 text-blue-600 rounded-full text-sm font-semibold hover:bg-blue-100 transition-colors">
                        View Profile
                    </button> -->
                </div>

                <div v-if="doctors.length === 0" class="col-span-full text-center py-12 text-slate-500">
                    No doctors found.
                </div>
            </div>
        </div>
    </PublicLayout>
</template>
