<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import HoverImagePreview from '@/components/HoverImagePreview.vue';

defineProps<{
    banners: Array<{
        id: number;
        title: string;
        image_path: string;
        image_url: string;
        position: string;
        is_active: boolean;
    }>;
}>();

const deleteBanner = (id: number) => {
    if (confirm('Are you sure?')) {
        router.delete(route('admin.banners.destroy', id));
    }
};
</script>

<template>
    <Head title="Banners" />

    <AppLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight text-white">
                        Banners ({{ banners.length }})
                    </h2>
                    <Link :href="route('admin.banners.create')" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Create Banner
                    </Link>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Position</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 bg-gray-50 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="banner in banners" :key="banner.id">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <HoverImagePreview
                                            :src="banner.image_url"
                                            image-class="h-10 w-20 object-cover rounded cursor-zoom-in"
                                        />
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ banner.title }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ banner.position }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span :class="banner.is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full">
                                            {{ banner.is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <Link :href="route('admin.banners.edit', banner.id)" class="text-indigo-600 hover:text-indigo-900 mr-4">Edit</Link>
                                        <button @click="deleteBanner(banner.id)" class="text-red-600 hover:text-red-900">Delete</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
