<script setup lang="ts">
import AppSidebarLayout from '@/layouts/app/AppSidebarLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ArrowLeft, Save } from 'lucide-vue-next';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Switch } from '@/components/ui/switch';
import { Check, ChevronsUpDown } from 'lucide-vue-next';
import { ref } from 'vue';

import CategorySelector from './CategorySelector.vue';

const props = defineProps<{
    sitemap: any;
    categories: any[];
}>();

const form = useForm({
    _method: 'PUT',
    sitemap_category_id: String(props.sitemap.sitemap_category_id),
    title_th: props.sitemap.title_th,
    title_en: props.sitemap.title_en,
    link: props.sitemap.link,
    order: props.sitemap.order,
    status: Boolean(props.sitemap.status),
});

const submit = () => {
    form.post(route('admin.sitemaps.update', props.sitemap.id));
};

const openCombobox = ref(false);
const searchTerm = ref('');
const selectNewCategory = () => {
    if (!searchTerm.value) return;
    form.sitemap_category_id = searchTerm.value;
    openCombobox.value = false;
};
</script>

<template>
    <Head title="Edit Link" />
    <AppSidebarLayout>
        <div class="max-w-xl mx-auto space-y-6">
            <div class="flex items-center gap-4">
                <Button variant="ghost" size="icon" as-child>
                    <Link :href="route('admin.sitemaps.index')">
                        <ArrowLeft class="w-4 h-4" />
                    </Link>
                </Button>
                <div>
                    <h2 class="text-2xl font-bold tracking-tight">Edit Link</h2>
                    <p class="text-muted-foreground">Update sitemap link details.</p>
                </div>
            </div>

            <form @submit.prevent="submit" class="space-y-8">
                <div class="grid gap-6 p-6 border rounded-lg bg-card">
                    
                    <div class="space-y-2">
                        <CategorySelector
                            v-model="form.sitemap_category_id"
                            :categories="categories"
                        />
                        <div v-if="form.errors.sitemap_category_id" class="text-destructive text-sm">{{ form.errors.sitemap_category_id }}</div>
                    </div>

                    <div class="space-y-2">
                        <Label for="title_th">Title (Thai)</Label>
                        <Input id="title_th" v-model="form.title_th" required />
                        <div v-if="form.errors.title_th" class="text-destructive text-sm">{{ form.errors.title_th }}</div>
                    </div>

                    <div class="space-y-2">
                        <Label for="title_en">Title (English)</Label>
                        <Input id="title_en" v-model="form.title_en" />
                        <div v-if="form.errors.title_en" class="text-destructive text-sm">{{ form.errors.title_en }}</div>
                    </div>

                    <div class="space-y-2">
                        <Label for="link">URL / Link</Label>
                        <Input id="link" v-model="form.link" required />
                        <div v-if="form.errors.link" class="text-destructive text-sm">{{ form.errors.link }}</div>
                    </div>

                    <div class="space-y-2">
                        <Label for="order">Display Order</Label>
                        <Input id="order" type="number" v-model="form.order" />
                    </div>

                    <div class="flex items-center gap-4">
                        <Switch id="status" :checked="!!form.status" @update:checked="(v) => form.status = v" />
                        <Label for="status">Active Status</Label>
                    </div>
                </div>

                <div class="flex justify-end gap-4">
                    <Button variant="outline" type="button" as-child>
                        <Link :href="route('admin.sitemaps.index')">Cancel</Link>
                    </Button>
                    <Button type="submit" :disabled="form.processing">
                        <Save class="w-4 h-4 mr-2" />
                        {{ form.processing ? 'Saving...' : 'Update Link' }}
                    </Button>
                </div>
            </form>
        </div>
    </AppSidebarLayout>
</template>
