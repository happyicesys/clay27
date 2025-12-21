<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps<{
    settings: Record<string, string | null>
}>();

const form = useForm({
    instagram_url: props.settings.instagram_url || '',
    facebook_url: props.settings.facebook_url || '',
    xiaohongshu_url: props.settings.xiaohongshu_url || '',
});

const submit = () => {
    form.post(route('admin.settings.update'), {
        preserveScroll: true,
    });
};
</script>

<template>
    <Head title="Site Settings" />

    <AppLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Site Settings
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form @submit.prevent="submit" class="space-y-6">

                            <!-- Social Media Section -->
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4">Social Media</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="instagram_url" class="block text-sm font-medium text-gray-700">Instagram URL</label>
                                        <input
                                            id="instagram_url"
                                            v-model="form.instagram_url"
                                            type="url"
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                            placeholder="https://instagram.com/..."
                                        >
                                    </div>

                                    <div>
                                        <label for="facebook_url" class="block text-sm font-medium text-gray-700">Facebook URL</label>
                                        <input
                                            id="facebook_url"
                                            v-model="form.facebook_url"
                                            type="url"
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                            placeholder="https://facebook.com/..."
                                        >
                                    </div>

                                    <div>
                                        <label for="xiaohongshu_url" class="block text-sm font-medium text-gray-700">Xiaohongshu URL</label>
                                        <input
                                            id="xiaohongshu_url"
                                            v-model="form.xiaohongshu_url"
                                            type="text"
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                            placeholder="URL or Profile ID"
                                        >
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center gap-4">
                                <button
                                    type="submit"
                                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-150 ease-in-out"
                                    :disabled="form.processing"
                                >
                                    Save Settings
                                </button>

                                <transition
                                    enter-active-class="transition ease-in-out"
                                    enter-from-class="opacity-0"
                                    leave-active-class="transition ease-in-out"
                                    leave-to-class="opacity-0"
                                >
                                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Saved.</p>
                                </transition>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
