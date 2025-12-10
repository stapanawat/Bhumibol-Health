<script setup lang="ts">
import AppSidebarLayout from '@/layouts/app/AppSidebarLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { Plus, Edit, Trash, Image as ImageIcon } from 'lucide-vue-next';
import { route } from 'ziggy-js'; 
import { Button } from '@/components/ui/button';
import { Badge } from '@/components/ui/badge';
import Swal from 'sweetalert2';

defineProps<{
    popups: any[];
}>();

const deletePopup = (id: number) => {
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
            router.delete(route('admin.popups.destroy', id), {
                onSuccess: () => {
                   Swal.fire('Deleted!', 'Popup has been deleted.', 'success');
                }
            });
        }
    });
};
</script>

<template>
    <Head title="Popups" />
    <AppSidebarLayout>
        <div class="space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold tracking-tight">Popups</h2>
                    <p class="text-muted-foreground">Manage active popups and banners.</p>
                </div>
                <Button as-child>
                    <Link :href="route('admin.popups.create')">
                        <Plus class="w-4 h-4 mr-2" />
                        Add Popup
                    </Link>
                </Button>
            </div>

            <div class="rounded-md border bg-card">
                <div class="relative w-full overflow-auto">
                    <table class="w-full caption-bottom text-sm text-left">
                        <thead class="[&_tr]:border-b">
                            <tr class="border-b transition-colors hover:bg-muted/50">
                                <th class="h-12 px-4 align-middle font-medium text-muted-foreground">Preview</th>
                                <th class="h-12 px-4 align-middle font-medium text-muted-foreground">Title</th>
                                <th class="h-12 px-4 align-middle font-medium text-muted-foreground">Frequency</th>
                                <th class="h-12 px-4 align-middle font-medium text-muted-foreground">Schedule</th>
                                <th class="h-12 px-4 align-middle font-medium text-muted-foreground">Status</th>
                                <th class="h-12 px-4 align-middle font-medium text-muted-foreground text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="[&_tr:last-child]:border-0">
                            <tr v-for="popup in popups" :key="popup.id" class="border-b transition-colors hover:bg-muted/50">
                                <td class="p-4 align-middle">
                                    <div class="w-16 h-10 rounded border bg-slate-100 overflow-hidden flex items-center justify-center">
                                         <img :src="popup.image_path" class="w-full h-full object-cover">
                                    </div>
                                </td>
                                <td class="p-4 align-middle font-medium">{{ popup.title }}</td>
                                <td class="p-4 align-middle capitalize">
                                    {{ popup.frequency.replace(/_/g, ' ') }}
                                </td>
                                <td class="p-4 align-middle">
                                    <div v-if="popup.start_date || popup.end_date" class="text-xs">
                                        <div>Start: {{ popup.start_date ? new Date(popup.start_date).toLocaleDateString() : 'Any' }}</div>
                                        <div>End: {{ popup.end_date ? new Date(popup.end_date).toLocaleDateString() : 'Any' }}</div>
                                    </div>
                                    <div v-else class="text-xs text-muted-foreground">Always Active</div>
                                </td>
                                <td class="p-4 align-middle">
                                    <Badge :variant="popup.status ? 'default' : 'secondary'">
                                        {{ popup.status ? 'Active' : 'Inactive' }}
                                    </Badge>
                                </td>
                                <td class="p-4 align-middle text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <Button variant="ghost" size="icon" as-child>
                                            <Link :href="route('admin.popups.edit', popup.id)">
                                                <Edit class="w-4 h-4" />
                                            </Link>
                                        </Button>
                                        <Button variant="ghost" size="icon" class="text-destructive hover:text-destructive" @click="deletePopup(popup.id)">
                                            <Trash class="w-4 h-4" />
                                        </Button>
                                    </div>
                                </td>
                            </tr>
                            <tr v-if="popups.length === 0">
                                <td colspan="6" class="p-8 text-center text-muted-foreground">
                                    No popups created yet.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AppSidebarLayout>
</template>
