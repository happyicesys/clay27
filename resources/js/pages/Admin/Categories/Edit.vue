<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps<{
    category: {
        id: number;
        name: string;
        slug: string;
        sequence: number;
        image_path: string | null;
        is_active: boolean;
    };
}>();

const form = useForm({
    _method: 'PUT',
    name: props.category.name,
    slug: props.category.slug,
    sequence: props.category.sequence,
    image: null as File | null,
    is_active: Boolean(props.category.is_active),
});

const submit = () => {
    form.post(route('admin.categories.update', props.category.id));
};
</script>

<template>
    <Head title="Edit Category" />

    <AppLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="mb-6">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        Edit Category
                    </h2>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form @submit.prevent="submit">
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Name</label>
                                <input v-model="form.name" id="name" type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                <div v-if="form.errors.name" class="text-red-500 text-xs italic">{{ form.errors.name }}</div>
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="slug">Slug</label>
                                <input v-model="form.slug" id="slug" type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                <div v-if="form.errors.slug" class="text-red-500 text-xs italic">{{ form.errors.slug }}</div>
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="sequence">Sequence</label>
                                <input v-model="form.sequence" id="sequence" type="number" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                <p class="text-xs text-gray-500 mt-1">Order in which categories appear (Ascending).</p>
                                <div v-if="form.errors.sequence" class="text-red-500 text-xs italic">{{ form.errors.sequence }}</div>
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="image">Thumbnail Image</label>
                                <div v-if="category.image_path" class="mb-2">
                                    <img :src="category.image_url" class="h-20 w-20 object-cover rounded">
                                </div>
                                <input @input="form.image = ($event.target as HTMLInputElement).files?.[0] || null" id="image" type="file" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                <p class="text-xs text-gray-500 mt-1">Recommended size: 400 x 400 pixels (Square).</p>
                                <div v-if="form.errors.image" class="text-red-500 text-xs italic">{{ form.errors.image }}</div>
                            </div>

                            <div class="mb-4">
                                <label class="flex items-center">
                                    <input v-model="form.is_active" type="checkbox" class="form-checkbox">
                                    <span class="ml-2">Active</span>
                                </label>
                            </div>

                            <div class="flex items-center justify-between">
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" :disabled="form.processing">
                                    Update Category
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
