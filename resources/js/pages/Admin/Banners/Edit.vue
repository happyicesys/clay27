<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps<{
    banner: {
        id: number;
        title: string;
        image_path: string;
        link_url: string;
        position: string;
        is_active: boolean;
        image_url: string;
    };
    existingPositions: string[];
}>();

const form = useForm({
    _method: 'PUT',
    title: props.banner.title,
    image: null as File | null,
    link_url: props.banner.link_url,
    position: props.banner.position,
    is_active: Boolean(props.banner.is_active),
});

const submit = () => {
    form.post(route('admin.banners.update', props.banner.id));
};
</script>

<template>
    <Head title="Edit Banner" />

    <AppLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="mb-6">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        Edit Banner
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
                                <div v-if="banner.image_path" class="mb-2">
                                    <img :src="banner.image_url" class="h-20 w-20 object-cover">
                                </div>
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
                                    <option value="main" :disabled="props.existingPositions.includes('main') && props.banner.position !== 'main'">
                                        Main {{ (props.existingPositions.includes('main') && props.banner.position !== 'main') ? '(Already Exists)' : '' }}
                                    </option>
                                    <option value="footer" :disabled="props.existingPositions.includes('footer') && props.banner.position !== 'footer'">
                                        Footer {{ (props.existingPositions.includes('footer') && props.banner.position !== 'footer') ? '(Already Exists)' : '' }}
                                    </option>
                                    <option value="workshop" :disabled="props.existingPositions.includes('workshop') && props.banner.position !== 'workshop'">
                                        Workshop {{ (props.existingPositions.includes('workshop') && props.banner.position !== 'workshop') ? '(Already Exists)' : '' }}
                                    </option>
                                </select>
                                <div v-if="form.errors.position" class="text-red-500 text-xs italic">{{ form.errors.position }}</div>
                            </div>

                            <div class="mb-4">
                                <label class="flex items-center">
                                    <input v-model="form.is_active" type="checkbox" class="form-checkbox">
                                    <span class="ml-2">Active</span>
                                </label>
                            </div>

                            <div class="flex items-center justify-between">
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" :disabled="form.processing">
                                    Update Banner
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
