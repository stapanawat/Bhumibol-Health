<script setup lang="ts">
import AppSidebarLayout from '@/layouts/app/AppSidebarLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ArrowLeft, Save } from 'lucide-vue-next';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Switch } from '@/components/ui/switch';

const props = defineProps<{
    category: any;
}>();

const form = useForm({
    _method: 'PUT',
    name_th: props.category.name_th,
    name_en: props.category.name_en,
    order: props.category.order,
    status: Boolean(props.category.status),
});

const submit = () => {
    form.post(route('admin.sitemap-categories.update', props.category.id));
};
</script>

<template>
    <Head title="Edit Category" />
    <AppSidebarLayout>
        <div class="max-w-xl mx-auto space-y-6">
            <div class="flex items-center gap-4">
                <Button variant="ghost" size="icon" as-child>
                    <Link :href="route('admin.sitemap-categories.index')">
                        <ArrowLeft class="w-4 h-4" />
                    </Link>
                </Button>
                <div>
                    <h2 class="text-2xl font-bold tracking-tight">Edit Category</h2>
                    <p class="text-muted-foreground">Update sitemap category details.</p>
                </div>
            </div>

            <form @submit.prevent="submit" class="space-y-8">
                <div class="grid gap-6 p-6 border rounded-lg bg-card">
                    <div class="space-y-2">
                        <Label for="name_th">Name (Thai)</Label>
                        <Input id="name_th" v-model="form.name_th" required />
                        <div v-if="form.errors.name_th" class="text-destructive text-sm">{{ form.errors.name_th }}</div>
                    </div>

                    <div class="space-y-2">
                        <Label for="name_en">Name (English)</Label>
                        <Input id="name_en" v-model="form.name_en" />
                        <div v-if="form.errors.name_en" class="text-destructive text-sm">{{ form.errors.name_en }}</div>
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
                        <Link :href="route('admin.sitemap-categories.index')">Cancel</Link>
                    </Button>
                    <Button type="submit" :disabled="form.processing">
                        <Save class="w-4 h-4 mr-2" />
                        {{ form.processing ? 'Saving...' : 'Update Category' }}
                    </Button>
                </div>
            </form>
        </div>
    </AppSidebarLayout>
</template>
