<script setup lang="ts">
import AppSidebarLayout from '@/layouts/app/AppSidebarLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { Plus, Edit, Trash, Folder } from 'lucide-vue-next';
import { Button } from '@/components/ui/button';
import { Badge } from '@/components/ui/badge';
import Swal from 'sweetalert2';

defineProps<{
    categories: any[];
}>();

const deleteCategory = (id: number) => {
    Swal.fire({
        title: 'Are you sure?',
        text: "This will delete the category and all its links!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete(route('admin.sitemap-categories.destroy', id), {
                onSuccess: () => {
                   Swal.fire('Deleted!', 'Category has been deleted.', 'success');
                }
            });
        }
    });
};
</script>

<template>
    <Head title="Sitemap Categories" />
    <AppSidebarLayout>
        <div class="space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold tracking-tight">Sitemap Categories</h2>
                    <p class="text-muted-foreground">Manage categories for the site map.</p>
                </div>
                <Button as-child>
                    <Link :href="route('admin.sitemap-categories.create')">
                        <Plus class="w-4 h-4 mr-2" />
                        Create Category
                    </Link>
                </Button>
            </div>

            <div class="rounded-md border bg-card">
                <div class="relative w-full overflow-auto">
                    <table class="w-full caption-bottom text-sm text-left">
                        <thead class="[&_tr]:border-b">
                            <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                                <th class="h-12 px-4 align-middle font-medium text-muted-foreground">Order</th>
                                <th class="h-12 px-4 align-middle font-medium text-muted-foreground">Name (TH)</th>
                                <th class="h-12 px-4 align-middle font-medium text-muted-foreground">Name (EN)</th>
                                <th class="h-12 px-4 align-middle font-medium text-muted-foreground">Status</th>
                                <th class="h-12 px-4 align-middle font-medium text-muted-foreground text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="[&_tr:last-child]:border-0">
                            <tr v-for="category in categories" :key="category.id" class="border-b transition-colors hover:bg-muted/50">
                                <td class="p-4 align-middle font-medium">{{ category.order }}</td>
                                <td class="p-4 align-middle">{{ category.name_th }}</td>
                                <td class="p-4 align-middle text-muted-foreground">{{ category.name_en || '-' }}</td>
                                <td class="p-4 align-middle">
                                    <Badge :variant="category.status ? 'default' : 'secondary'">
                                        {{ category.status ? 'Active' : 'Inactive' }}
                                    </Badge>
                                </td>
                                <td class="p-4 align-middle text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <Button variant="ghost" size="icon" as-child>
                                            <Link :href="route('admin.sitemap-categories.edit', category.id)">
                                                <Edit class="w-4 h-4" />
                                            </Link>
                                        </Button>
                                        <Button variant="ghost" size="icon" class="text-destructive hover:text-destructive" @click="deleteCategory(category.id)">
                                            <Trash class="w-4 h-4" />
                                        </Button>
                                    </div>
                                </td>
                            </tr>
                            <tr v-if="categories.length === 0">
                                <td colspan="5" class="p-8 text-center text-muted-foreground">
                                    No categories found.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AppSidebarLayout>
</template>
