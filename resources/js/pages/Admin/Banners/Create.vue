<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps<{
    existingPositions: string[];
}>();

const form = useForm({
    title: '',
    image: null as File | null,
    link_url: '',
    position: props.existingPositions.includes('main') ? (props.existingPositions.includes('footer') ? '' : 'footer') : 'main',
    is_active: true,
});

const submit = () => {
    form.post(route('admin.banners.store'));
};
</script>

<template>
    <Head title="Create Banner" />

    <AppLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="mb-6">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        Create Banner
                    </h2>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form @submit.prevent="submit">
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="title">Title</label>
                                <input v-model="form.title" id="title" type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                <div v-if="form.errors.title" class="text-red-500 text-xs italic">{{ form.errors.title }}</div>
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="image">Image</label>
                                <input @input="form.image = ($event.target as HTMLInputElement).files?.[0] || null" id="image" type="file" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                <p class="text-xs text-gray-500 mt-1">Recommended size: 1920 x 550 pixels.</p>
                                <div v-if="form.errors.image" class="text-red-500 text-xs italic">{{ form.errors.image }}</div>
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="link_url">Link URL</label>
                                <input v-model="form.link_url" id="link_url" type="url" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                <div v-if="form.errors.link_url" class="text-red-500 text-xs italic">{{ form.errors.link_url }}</div>
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="position">Position</label>
                                <select v-model="form.position" id="position" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    <option value="main" :disabled="props.existingPositions.includes('main')">
                                        Main {{ props.existingPositions.includes('main') ? '(Already Exists)' : '' }}
                                    </option>
                                    <option value="footer" :disabled="props.existingPositions.includes('footer')">
                                        Footer {{ props.existingPositions.includes('footer') ? '(Already Exists)' : '' }}
                                    </option>
                                    <option value="workshop" :disabled="props.existingPositions.includes('workshop')">
                                        Workshop {{ props.existingPositions.includes('workshop') ? '(Already Exists)' : '' }}
                                    </option>
                                </select>
                                <div v-if="form.errors.position" class="text-red-500 text-xs italic">{{ form.errors.position }}</div>
                                <div v-if="props.existingPositions.includes('main') && props.existingPositions.includes('footer')" class="text-red-500 text-xs italic mt-2">
                                    Both Main and Footer banners already exist. You cannot create a new banner.
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="flex items-center">
                                    <input v-model="form.is_active" type="checkbox" class="form-checkbox">
                                    <span class="ml-2">Active</span>
                                </label>
                            </div>

                            <div class="flex items-center justify-between">
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" :disabled="form.processing">
                                    Create Banner
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
