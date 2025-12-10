<script setup lang="ts">
import AppSidebarLayout from '@/layouts/app/AppSidebarLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ArrowLeft, Save } from 'lucide-vue-next';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Switch } from '@/components/ui/switch';
import { Textarea } from '@/components/ui/textarea';

const form = useForm({
    name: '',
    colors: {
        primary: '#0f172a',
        secondary: '#64748b',
        background: '#ffffff',
        text: '#0f172a',
        accent: '#3b82f6',
        muted: '#f1f5f9',
    },
    font_family: '',
    background_image: null as File | null,
    start_date: '',
    end_date: '',
    status: true,
    css_overrides: '',
});

const submit = () => {
    form.post(route('admin.themes.store'));
};

const onFileChange = (e: Event) => {
    const target = e.target as HTMLInputElement;
    if (target.files && target.files[0]) {
        form.background_image = target.files[0];
    }
};
</script>

<template>
    <Head title="Create Theme" />
    <AppSidebarLayout>
        <div class="max-w-4xl mx-auto space-y-6">
            <div class="flex items-center gap-4">
                <Button variant="ghost" size="icon" as-child>
                    <Link :href="route('admin.themes.index')">
                        <ArrowLeft class="w-4 h-4" />
                    </Link>
                </Button>
                <div>
                    <h2 class="text-2xl font-bold tracking-tight">Create Theme</h2>
                    <p class="text-muted-foreground">Design a new festival or seasonal theme.</p>
                </div>
            </div>

            <form @submit.prevent="submit" class="space-y-8">
                <!-- Basic Info -->
                <div class="grid gap-6 p-6 border rounded-lg bg-card">
                    <h3 class="text-lg font-semibold">Basic Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <Label for="name">Theme Name</Label>
                            <Input id="name" v-model="form.name" placeholder="e.g. Songkran Festival" required />
                            <div v-if="form.errors.name" class="text-destructive text-sm">{{ form.errors.name }}</div>
                        </div>
                        <div class="space-y-2">
                            <Label for="font_family">Font Family (Optional)</Label>
                            <Input id="font_family" v-model="form.font_family" placeholder="e.g. 'Sarabun', sans-serif" />
                            <div v-if="form.errors.font_family" class="text-destructive text-sm">{{ form.errors.font_family }}</div>
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <Switch id="status" :checked="!!form.status" @update:checked="(v) => form.status = v" />
                        <Label for="status">Active Status</Label>
                    </div>
                </div>

                <!-- Colors -->
                <div class="grid gap-6 p-6 border rounded-lg bg-card">
                    <h3 class="text-lg font-semibold">Color Palette</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                        <div class="space-y-2">
                            <Label>Primary Color</Label>
                            <div class="flex gap-2">
                                <Input type="color" v-model="form.colors.primary" class="w-12 h-10 p-1" />
                                <Input v-model="form.colors.primary" class="font-mono uppercase" maxlength="7" />
                            </div>
                        </div>
                        <div class="space-y-2">
                            <Label>Secondary Color</Label>
                            <div class="flex gap-2">
                                <Input type="color" v-model="form.colors.secondary" class="w-12 h-10 p-1" />
                                <Input v-model="form.colors.secondary" class="font-mono uppercase" maxlength="7" />
                            </div>
                        </div>
                        <div class="space-y-2">
                            <Label>Accent Color</Label>
                            <div class="flex gap-2">
                                <Input type="color" v-model="form.colors.accent" class="w-12 h-10 p-1" />
                                <Input v-model="form.colors.accent" class="font-mono uppercase" maxlength="7" />
                            </div>
                        </div>
                        <div class="space-y-2">
                            <Label>Background Color</Label>
                            <div class="flex gap-2">
                                <Input type="color" v-model="form.colors.background" class="w-12 h-10 p-1" />
                                <Input v-model="form.colors.background" class="font-mono uppercase" maxlength="7" />
                            </div>
                        </div>
                        <div class="space-y-2">
                            <Label>Text Color</Label>
                            <div class="flex gap-2">
                                <Input type="color" v-model="form.colors.text" class="w-12 h-10 p-1" />
                                <Input v-model="form.colors.text" class="font-mono uppercase" maxlength="7" />
                            </div>
                        </div>
                        <div class="space-y-2">
                            <Label>Muted Color (Backgrounds)</Label>
                            <div class="flex gap-2">
                                <Input type="color" v-model="form.colors.muted" class="w-12 h-10 p-1" />
                                <Input v-model="form.colors.muted" class="font-mono uppercase" maxlength="7" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Scheduling & Background -->
                <div class="grid gap-6 p-6 border rounded-lg bg-card">
                    <h3 class="text-lg font-semibold">Appearance & Schedule</h3>
                    
                    <div class="space-y-2">
                        <Label for="bg_image">Background Image (Optional)</Label>
                        <Input id="bg_image" type="file" accept="image/*" @change="onFileChange" />
                        <p class="text-xs text-muted-foreground">Overrides the background color if set. Max 10MB.</p>
                        <div v-if="form.errors.background_image" class="text-destructive text-sm">{{ form.errors.background_image }}</div>
                    </div>

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

                <!-- Advanced CSS -->
                <div class="grid gap-6 p-6 border rounded-lg bg-card">
                    <h3 class="text-lg font-semibold">Advanced</h3>
                    <div class="space-y-2">
                        <Label for="css_overrides">Custom CSS Overrides</Label>
                        <Textarea id="css_overrides" v-model="form.css_overrides" rows="5" class="font-mono text-sm" placeholder=":root { --radius: 1rem; }" />
                        <p class="text-xs text-muted-foreground">Directly inject CSS. Use with caution.</p>
                    </div>
                </div>

                <div class="flex justify-end gap-4">
                    <Button variant="outline" type="button" as-child>
                        <Link :href="route('admin.themes.index')">Cancel</Link>
                    </Button>
                    <Button type="submit" :disabled="form.processing">
                        <Save class="w-4 h-4 mr-2" />
                        {{ form.processing ? 'Saving...' : 'Save Theme' }}
                    </Button>
                </div>
            </form>
        </div>
    </AppSidebarLayout>
</template>
