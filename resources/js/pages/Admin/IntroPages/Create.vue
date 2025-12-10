<script setup lang="ts">
import AppSidebarLayout from '@/layouts/app/AppSidebarLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ArrowLeft, Save } from 'lucide-vue-next';
import { route } from 'ziggy-js';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Switch } from '@/components/ui/switch';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';

const form = useForm({
    title: '',
    type: 'image',
    media_file: null as File | null,
    link: '',
    display_duration: 5,
    start_date: '',
    end_date: '',
    status: true,
});

const submit = () => {
    form.post(route('admin.intro-pages.store'));
};

const onFileChange = (e: Event) => {
    const target = e.target as HTMLInputElement;
    if (target.files && target.files[0]) {
        form.media_file = target.files[0];
    }
};
</script>

<template>
    <Head title="Create Intro Page" />
    <AppSidebarLayout>
        <div class="max-w-4xl mx-auto space-y-6">
            <div class="flex items-center gap-4">
                <Button variant="ghost" size="icon" as-child>
                    <Link :href="route('admin.intro-pages.index')">
                        <ArrowLeft class="w-4 h-4" />
                    </Link>
                </Button>
                <div>
                    <h2 class="text-2xl font-bold tracking-tight">Create Intro Page</h2>
                    <p class="text-muted-foreground">Add a new splash screen.</p>
                </div>
            </div>

            <form @submit.prevent="submit" class="space-y-8">
                <!-- Info -->
                <div class="grid gap-6 p-6 border rounded-lg bg-card">
                    <h3 class="text-lg font-semibold">Intro Content</h3>
                    
                    <div class="space-y-2">
                        <Label for="title">Title (Internal Use)</Label>
                        <Input id="title" v-model="form.title" placeholder="e.g. King's Birthday 2025" required />
                        <div v-if="form.errors.title" class="text-destructive text-sm">{{ form.errors.title }}</div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                         <div class="space-y-2">
                            <Label for="type">Content Type</Label>
                            <Select v-model="form.type">
                                <SelectTrigger>
                                    <SelectValue placeholder="Select type" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem value="image">Image</SelectItem>
                                    <SelectItem value="video">Video</SelectItem>
                                </SelectContent>
                            </Select>
                        </div>
                         <div class="space-y-2">
                            <Label for="display_duration">Duration (Seconds)</Label>
                            <Input id="display_duration" type="number" min="1" v-model="form.display_duration" />
                        </div>
                    </div>
                    
                    <div class="space-y-2">
                         <Label for="media_file">Media File</Label>
                         <Input id="media_file" type="file" :accept="form.type === 'video' ? 'video/*' : 'image/*'" @change="onFileChange" required />
                         <p class="text-xs text-muted-foreground">Max 20MB.</p>
                         <div v-if="form.errors.media_file" class="text-destructive text-sm">{{ form.errors.media_file }}</div>
                    </div>
                    
                    <div class="space-y-2">
                        <Label for="link">Redirect Link (Optional)</Label>
                        <Input id="link" v-model="form.link" placeholder="https://..." />
                        <p class="text-xs text-muted-foreground">If set, clicking the intro page will redirect here.</p>
                    </div>

                     <div class="flex items-center gap-4 py-4">
                        <Switch id="status" :checked="form.status" @update:checked="form.status = $event" />
                        <Label for="status">Active Status</Label>
                    </div>
                </div>

                <!-- Scheduling -->
                <div class="grid gap-6 p-6 border rounded-lg bg-card">
                    <h3 class="text-lg font-semibold">Schedule</h3>
                     <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <Label for="start_date">Start Date & Time</Label>
                            <Input id="start_date" type="datetime-local" v-model="form.start_date" />
                        </div>
                        <div class="space-y-2">
                            <Label for="end_date">End Date & Time</Label>
                            <Input id="end_date" type="datetime-local" v-model="form.end_date" />
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-4">
                    <Button variant="outline" type="button" as-child>
                        <Link :href="route('admin.intro-pages.index')">Cancel</Link>
                    </Button>
                    <Button type="submit" :disabled="form.processing">
                        <Save class="w-4 h-4 mr-2" />
                        {{ form.processing ? 'Saving...' : 'Create Intro' }}
                    </Button>
                </div>
            </form>
        </div>
    </AppSidebarLayout>
</template>
