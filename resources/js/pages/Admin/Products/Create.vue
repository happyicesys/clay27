<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps<{
    categories: Array<{
        id: number;
        name: string;
    }>;
    nextSequence: number;
}>();

const form = useForm({
    name: '',
    category_id: '',
    description: '',
    price: '',
    stock: '',
    sequence: props.nextSequence,
    is_bestseller: false,
    image: null as File | null,
    gallery_images: [] as File[],
    is_active: true,
});

const imagePreview = ref<string | null>(null);

const handleImageUpload = (event: Event) => {
    const files = (event.target as HTMLInputElement).files;
    if (files && files.length > 0) {
        form.image = files[0];
        imagePreview.value = URL.createObjectURL(files[0]);
    } else {
        form.image = null;
        imagePreview.value = null;
    }
};

const handleGalleryUpload = (event: Event) => {
    const files = (event.target as HTMLInputElement).files;
    if (files) {
        form.gallery_images = Array.from(files);
    }
};

const submit = () => {
    form.post(route('admin.products.store'));
};
</script>

<template>
    <Head title="Create Product" />

    <AppLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                 <div class="mb-6">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        Create Product
                    </h2>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form @submit.prevent="submit">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Name</label>
                                    <input v-model="form.name" id="name" type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    <div v-if="form.errors.name" class="text-red-500 text-xs italic">{{ form.errors.name }}</div>
                                </div>

                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="category_id">Category</label>
                                    <select v-model="form.category_id" id="category_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                        <option value="">Select Category</option>
                                        <option v-for="category in categories" :key="category.id" :value="category.id">
                                            {{ category.name }}
                                        </option>
                                    </select>
                                    <div v-if="form.errors.category_id" class="text-red-500 text-xs italic">{{ form.errors.category_id }}</div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="description">Description</label>
                                <textarea v-model="form.description" id="description" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                                <div v-if="form.errors.description" class="text-red-500 text-xs italic">{{ form.errors.description }}</div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="price">Price</label>
                                    <input v-model="form.price" id="price" type="number" step="0.01" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    <div v-if="form.errors.price" class="text-red-500 text-xs italic">{{ form.errors.price }}</div>
                                </div>

                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="stock">Stock</label>
                                    <input v-model="form.stock" id="stock" type="number" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    <div v-if="form.errors.stock" class="text-red-500 text-xs italic">{{ form.errors.stock }}</div>
                                </div>

                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="sequence">Sequence</label>
                                    <input v-model="form.sequence" id="sequence" type="number" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    <p class="text-xs text-gray-500 mt-1">Higher number = Lower priority (or custom sort order)</p>
                                    <div v-if="form.errors.sequence" class="text-red-500 text-xs italic">{{ form.errors.sequence }}</div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="image">Main Thumbnail Image</label>
                                <div v-if="imagePreview" class="mb-2">
                                    <img :src="imagePreview" class="h-32 w-32 object-cover rounded border border-gray-300">
                                </div>
                                <input @input="handleImageUpload" id="image" type="file" accept="image/*" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                <div v-if="form.errors.image" class="text-red-500 text-xs italic">{{ form.errors.image }}</div>
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="gallery_images">Gallery Images (Multiple)</label>
                                <input @input="handleGalleryUpload" id="gallery_images" type="file" multiple class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                <p class="text-xs text-gray-500 mt-1">You can select multiple files.</p>
                                <div v-if="form.errors['gallery_images']" class="text-red-500 text-xs italic">{{ form.errors['gallery_images'] }}</div>
                            </div>

                            <div class="mb-4 flex gap-6">
                                <label class="flex items-center">
                                    <input v-model="form.is_active" type="checkbox" class="form-checkbox h-5 w-5 text-blue-600">
                                    <span class="ml-2 text-gray-700">Active</span>
                                </label>

                                <label class="flex items-center">
                                    <input v-model="form.is_bestseller" type="checkbox" class="form-checkbox h-5 w-5 text-yellow-600">
                                    <span class="ml-2 text-gray-700">Best Seller</span>
                                </label>
                            </div>

                            <div class="flex items-center justify-between mt-8">
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" :disabled="form.processing">
                                    Create Product
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
