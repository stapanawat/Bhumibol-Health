<script setup lang="ts">
import AppSidebarLayout from '@/layouts/app/AppSidebarLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { Plus, Edit, Trash, Palette } from 'lucide-vue-next';
import { Button } from '@/components/ui/button';
import { Badge } from '@/components/ui/badge';
import Swal from 'sweetalert2';

defineProps<{
    themes: any[];
}>();

const deleteTheme = (id: number) => {
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
            router.delete(route('admin.themes.destroy', id), {
                onSuccess: () => {
                   Swal.fire('Deleted!', 'Theme has been deleted.', 'success');
                }
            });
        }
    });
};
</script>

<template>
    <Head title="Themes" />
    <AppSidebarLayout>
        <div class="space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold tracking-tight">Themes & Festivals</h2>
                    <p class="text-muted-foreground">Manage website themes and festival appearances.</p>
                </div>
                <Button as-child>
                    <Link :href="route('admin.themes.create')">
                        <Plus class="w-4 h-4 mr-2" />
                        Create Theme
                    </Link>
                </Button>
            </div>

            <div class="rounded-md border bg-card">
                <div class="relative w-full overflow-auto">
                    <table class="w-full caption-bottom text-sm text-left">
                        <thead class="[&_tr]:border-b">
                            <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                                <th class="h-12 px-4 align-middle font-medium text-muted-foreground">Name</th>
                                <th class="h-12 px-4 align-middle font-medium text-muted-foreground">Preview</th>
                                <th class="h-12 px-4 align-middle font-medium text-muted-foreground">Active Dates</th>
                                <th class="h-12 px-4 align-middle font-medium text-muted-foreground">Status</th>
                                <th class="h-12 px-4 align-middle font-medium text-muted-foreground text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="[&_tr:last-child]:border-0">
                            <tr v-for="theme in themes" :key="theme.id" class="border-b transition-colors hover:bg-muted/50">
                                <td class="p-4 align-middle font-medium">{{ theme.name }}</td>
                                <td class="p-4 align-middle">
                                    <div class="flex gap-2">
                                        <div class="w-6 h-6 rounded-full border shadow-sm" :style="{ backgroundColor: theme.colors?.primary || '#000' }"></div>
                                        <div class="w-6 h-6 rounded-full border shadow-sm" :style="{ backgroundColor: theme.colors?.background || '#fff' }"></div>
                                    </div>
                                </td>
                                <td class="p-4 align-middle">
                                    <div v-if="theme.start_date || theme.end_date" class="text-xs">
                                        <div>Start: {{ theme.start_date ? new Date(theme.start_date).toLocaleDateString() : 'Any' }}</div>
                                        <div>End: {{ theme.end_date ? new Date(theme.end_date).toLocaleDateString() : 'Any' }}</div>
                                    </div>
                                    <div v-else class="text-xs text-muted-foreground">Manual Activation</div>
                                </td>
                                <td class="p-4 align-middle">
                                    <Badge :variant="theme.status ? 'default' : 'secondary'">
                                        {{ theme.status ? 'Active' : 'Inactive' }}
                                    </Badge>
                                </td>
                                <td class="p-4 align-middle text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <Button variant="ghost" size="icon" as-child>
                                            <Link :href="route('admin.themes.edit', theme.id)">
                                                <Edit class="w-4 h-4" />
                                            </Link>
                                        </Button>
                                        <Button variant="ghost" size="icon" class="text-destructive hover:text-destructive" @click="deleteTheme(theme.id)">
                                            <Trash class="w-4 h-4" />
                                        </Button>
                                    </div>
                                </td>
                            </tr>
                            <tr v-if="themes.length === 0">
                                <td colspan="5" class="p-8 text-center text-muted-foreground">
                                    No themes found. Create one to get started.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AppSidebarLayout>
</template>
