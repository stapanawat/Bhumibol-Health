<script setup lang="ts">
import AppSidebarLayout from '@/layouts/app/AppSidebarLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ArrowLeft, Save } from 'lucide-vue-next';
import { route } from 'ziggy-js';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Switch } from '@/components/ui/switch';
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from '@/components/ui/select';

const props = defineProps<{
    popup: any;
}>();

const form = useForm({
    _method: 'PUT',
    title: props.popup.title,
    image_file: null as File | null,
    link: props.popup.link || '',
    frequency: props.popup.frequency,
    start_date: props.popup.start_date ? new Date(props.popup.start_date).toISOString().slice(0, 16) : '',
    end_date: props.popup.end_date ? new Date(props.popup.end_date).toISOString().slice(0, 16) : '',
    status: Boolean(props.popup.status),
});

const submit = () => {
    form.post(route('admin.popups.update', props.popup.id));
};

const onFileChange = (e: Event) => {
    const target = e.target as HTMLInputElement;
    if (target.files && target.files[0]) {
        form.image_file = target.files[0];
    }
};
</script>

<template>
    <Head title="Edit Popup" />
    <AppSidebarLayout>
        <div class="max-w-4xl mx-auto space-y-6">
            <div class="flex items-center gap-4">
                <Button variant="ghost" size="icon" as-child>
                    <Link :href="route('admin.popups.index')">
                        <ArrowLeft class="w-4 h-4" />
                    </Link>
                </Button>
                <div>
                    <h2 class="text-2xl font-bold tracking-tight">Edit Popup</h2>
                    <p class="text-muted-foreground">Update popup details.</p>
                </div>
            </div>

            <form @submit.prevent="submit" class="space-y-8">
                <!-- Info -->
                <div class="grid gap-6 p-6 border rounded-lg bg-card">
                    <h3 class="text-lg font-semibold">Popup Content</h3>
                    
                    <div class="space-y-2">
                        <Label for="title">Title</Label>
                        <Input id="title" v-model="form.title" required />
                        <div v-if="form.errors.title" class="text-destructive text-sm">{{ form.errors.title }}</div>
                    </div>

                    <div class="space-y-2">
                        <Label for="frequency">Display Frequency</Label>
                        <Select v-model="form.frequency">
                            <SelectTrigger>
                                <SelectValue placeholder="Select frequency" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem value="once_per_session">Once Per Session</SelectItem>
                                <SelectItem value="once_per_day">Once Per Day</SelectItem>
                                <SelectItem value="always">Always (Every Load)</SelectItem>
                            </SelectContent>
                        </Select>
                    </div>
                    
                    <div class="space-y-2">
                         <Label for="image_file">Popup Image</Label>
                         <div v-if="popup.image_path" class="mb-2">
                             <img :src="popup.image_path" class="h-20 w-auto rounded border" />
                         </div>
                         <Input id="image_file" type="file" accept="image/*" @change="onFileChange" />
                         <p class="text-xs text-muted-foreground">Max 10MB. Upload new file to replace.</p>
                    </div>
                    
                    <div class="space-y-2">
                        <Label for="link">Redirect Link</Label>
                        <Input id="link" v-model="form.link" />
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
                        <Link :href="route('admin.popups.index')">Cancel</Link>
                    </Button>
                    <Button type="submit" :disabled="form.processing">
                        <Save class="w-4 h-4 mr-2" />
                        {{ form.processing ? 'Saving...' : 'Update Popup' }}
                    </Button>
                </div>
            </form>
        </div>
    </AppSidebarLayout>
</template>
