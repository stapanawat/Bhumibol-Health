<script setup lang="ts">
import AppSidebarLayout from '@/layouts/app/AppSidebarLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { Plus, Edit, Trash, ExternalLink, Link as LinkIcon, Folder } from 'lucide-vue-next';
import { Button } from '@/components/ui/button';
import { Badge } from '@/components/ui/badge';
import Swal from 'sweetalert2';

defineProps<{
    sitemaps: any[];
}>();

const deleteSitemap = (id: number) => {
    Swal.fire({
        title: 'Are you sure?',
        text: "This will delete the sitemap link!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete(route('admin.sitemaps.destroy', id), {
                onSuccess: () => {
                   Swal.fire('Deleted!', 'Link has been deleted.', 'success');
                }
            });
        }
    });
};
</script>

<template>
    <Head title="Sitemap Links" />
    <AppSidebarLayout>
        <div class="space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold tracking-tight">Sitemap Links</h2>
                    <p class="text-muted-foreground">Manage links for the public sitemap.</p>
                </div>
                <div class="flex gap-2">
                     <Button variant="outline" as-child>
                        <Link :href="route('admin.sitemap-categories.index')">
                            <Folder class="w-4 h-4 mr-2" />
                            Manage Categories
                        </Link>
                    </Button>
                    <Button as-child>
                        <Link :href="route('admin.sitemaps.create')">
                            <Plus class="w-4 h-4 mr-2" />
                            Create Link
                        </Link>
                    </Button>
                </div>
            </div>

            <div class="rounded-md border bg-card">
                <div class="relative w-full overflow-auto">
                    <table class="w-full caption-bottom text-sm text-left">
                        <thead class="[&_tr]:border-b">
                            <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                                <th class="h-12 px-4 align-middle font-medium text-muted-foreground">Order</th>
                                <th class="h-12 px-4 align-middle font-medium text-muted-foreground">Category</th>
                                <th class="h-12 px-4 align-middle font-medium text-muted-foreground">Title (TH)</th>
                                <th class="h-12 px-4 align-middle font-medium text-muted-foreground">Link</th>
                                <th class="h-12 px-4 align-middle font-medium text-muted-foreground">Status</th>
                                <th class="h-12 px-4 align-middle font-medium text-muted-foreground text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="[&_tr:last-child]:border-0">
                            <tr v-for="sitemap in sitemaps" :key="sitemap.id" class="border-b transition-colors hover:bg-muted/50">
                                <td class="p-4 align-middle font-medium">{{ sitemap.order }}</td>
                                <td class="p-4 align-middle">
                                    <Badge variant="outline" v-if="sitemap.category">
                                        {{ sitemap.category.name_th }}
                                    </Badge>
                                    <span v-else class="text-muted-foreground">-</span>
                                </td>
                                <td class="p-4 align-middle">{{ sitemap.title_th }}</td>
                                <td class="p-4 align-middle">
                                    <a :href="sitemap.link" target="_blank" class="flex items-center text-primary hover:underline">
                                        <LinkIcon class="w-3 h-3 mr-1" />
                                        {{ sitemap.link }}
                                    </a>
                                </td>
                                <td class="p-4 align-middle">
                                    <Badge :variant="sitemap.status ? 'default' : 'secondary'">
                                        {{ sitemap.status ? 'Active' : 'Inactive' }}
                                    </Badge>
                                </td>
                                <td class="p-4 align-middle text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <Button variant="ghost" size="icon" as-child>
                                            <Link :href="route('admin.sitemaps.edit', sitemap.id)">
                                                <Edit class="w-4 h-4" />
                                            </Link>
                                        </Button>
                                        <Button variant="ghost" size="icon" class="text-destructive hover:text-destructive" @click="deleteSitemap(sitemap.id)">
                                            <Trash class="w-4 h-4" />
                                        </Button>
                                    </div>
                                </td>
                            </tr>
                            <tr v-if="sitemaps.length === 0">
                                <td colspan="6" class="p-8 text-center text-muted-foreground">
                                    No links found. Create one to get started.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AppSidebarLayout>
</template>
