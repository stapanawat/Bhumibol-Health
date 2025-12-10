<script setup lang="ts">
import AppSidebarLayout from '@/layouts/app/AppSidebarLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { Plus, Edit, Trash, Play, Image as ImageIcon } from 'lucide-vue-next';
import { route } from 'ziggy-js';
import { Button } from '@/components/ui/button';
import { Badge } from '@/components/ui/badge';
import Swal from 'sweetalert2';

defineProps<{
    introPages: any[];
}>();

const deleteIntro = (id: number) => {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete(route('admin.intro-pages.destroy', id), {
                onSuccess: () => {
                   Swal.fire('Deleted!', 'Intro page has been deleted.', 'success');
                }
            });
        }
    });
};
</script>

<template>
    <Head title="Intro Pages" />
    <AppSidebarLayout>
        <div class="space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold tracking-tight">Intro Pages</h2>
                    <p class="text-muted-foreground">Manage splash screens and special announcements displayed on entry.</p>
                </div>
                <Button as-child>
                    <Link :href="route('admin.intro-pages.create')">
                        <Plus class="w-4 h-4 mr-2" />
                        Add Intro Page
                    </Link>
                </Button>
            </div>

            <div class="rounded-md border bg-card">
                <div class="relative w-full overflow-auto">
                    <table class="w-full caption-bottom text-sm text-left">
                        <thead class="[&_tr]:border-b">
                            <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                                <th class="h-12 px-4 align-middle font-medium text-muted-foreground">Preview</th>
                                <th class="h-12 px-4 align-middle font-medium text-muted-foreground">Title</th>
                                <th class="h-12 px-4 align-middle font-medium text-muted-foreground">Type</th>
                                <th class="h-12 px-4 align-middle font-medium text-muted-foreground">Schedule</th>
                                <th class="h-12 px-4 align-middle font-medium text-muted-foreground">Status</th>
                                <th class="h-12 px-4 align-middle font-medium text-muted-foreground text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="[&_tr:last-child]:border-0">
                            <tr v-for="intro in introPages" :key="intro.id" class="border-b transition-colors hover:bg-muted/50">
                                <td class="p-4 align-middle">
                                    <div class="w-16 h-10 rounded border bg-slate-100 overflow-hidden flex items-center justify-center">
                                         <img v-if="intro.type === 'image'" :src="intro.media_path" class="w-full h-full object-cover">
                                         <Play v-else class="w-6 h-6 text-slate-400" />
                                    </div>
                                </td>
                                <td class="p-4 align-middle font-medium">{{ intro.title }}</td>
                                <td class="p-4 align-middle capitalize">
                                    <div class="flex items-center gap-2">
                                        <component :is="intro.type === 'video' ? Play : ImageIcon" class="w-3 h-3 text-muted-foreground" />
                                        {{ intro.type }}
                                    </div>
                                </td>
                                <td class="p-4 align-middle">
                                    <div v-if="intro.start_date || intro.end_date" class="text-xs">
                                        <div>Start: {{ intro.start_date ? new Date(intro.start_date).toLocaleDateString() : 'Any' }}</div>
                                        <div>End: {{ intro.end_date ? new Date(intro.end_date).toLocaleDateString() : 'Any' }}</div>
                                    </div>
                                    <div v-else class="text-xs text-muted-foreground">Always Active</div>
                                </td>
                                <td class="p-4 align-middle">
                                    <Badge :variant="intro.status ? 'default' : 'secondary'">
                                        {{ intro.status ? 'Active' : 'Inactive' }}
                                    </Badge>
                                </td>
                                <td class="p-4 align-middle text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <Button variant="ghost" size="icon" as-child>
                                            <Link :href="route('admin.intro-pages.edit', intro.id)">
                                                <Edit class="w-4 h-4" />
                                            </Link>
                                        </Button>
                                        <Button variant="ghost" size="icon" class="text-destructive hover:text-destructive" @click="deleteIntro(intro.id)">
                                            <Trash class="w-4 h-4" />
                                        </Button>
                                    </div>
                                </td>
                            </tr>
                            <tr v-if="introPages.length === 0">
                                <td colspan="6" class="p-8 text-center text-muted-foreground">
                                    No intro pages created yet.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AppSidebarLayout>
</template>
