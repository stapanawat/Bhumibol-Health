<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import Swal from 'sweetalert2';

defineProps<{
    posts: {
        data: Array<{
            id: number;
            title_th: string;
            category: { name_th: string };
            user: { name: string };
            status: string;
            created_at: string;
        }>;
        links: Array<any>;
    };
}>();

const deletePost = (id: number) => {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete(route('admin.posts.destroy', id), {
                onSuccess: () => {
                    Swal.fire(
                        'Deleted!',
                        'Post has been deleted.',
                        'success'
                    )
                }
            });
        }
    })
};
</script>

<template>
    <Head title="Post Management" />

    <AppLayout title="Post Management">
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Post Management
                </h2>
                <Link :href="route('admin.posts.create')" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    + Create New Post
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Author</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="relative px-6 py-3"><span class="sr-only">Actions</span></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="post in posts.data" :key="post.id">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900 truncate max-w-xs">{{ post.title_th }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500">{{ post.category?.name_th }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500">{{ post.user?.name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span v-if="post.status === 'published'" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Published</span>
                                    <span v-else-if="post.status === 'draft'" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Draft</span>
                                    <span v-else class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">{{ post.status }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ new Date(post.created_at).toLocaleDateString() }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <Link :href="route('admin.posts.edit', post.id)" class="text-indigo-600 hover:text-indigo-900 mr-4">Edit</Link>
                                    <button @click="deletePost(post.id)" class="text-red-600 hover:text-red-900">Delete</button>
                                </td>
                            </tr>
                            <tr v-if="posts.data.length === 0">
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">No posts found.</td>
                            </tr>
                        </tbody>
                    </table>
                     <!-- Pagination Links could be added here -->
                </div>
            </div>
        </div>
    </AppLayout>
</template>
