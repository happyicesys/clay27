<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps<{
    product: {
        id: number;
        name: string;
        category_id: number | null;
        description: string;
        price: number;
        stock: number;
        sequence: number;
        is_bestseller: boolean;
        image_path: string;
        is_active: boolean;
        images: Array<{ id: number; image_path: string }>;
    };
    categories: Array<{
        id: number;
        name: string;
    }>;
}>();

const form = useForm({
    _method: 'PUT',
    name: props.product.name,
    category_id: props.product.category_id,
    description: props.product.description,
    price: props.product.price,
    stock: props.product.stock,
    sequence: props.product.sequence,
    is_bestseller: Boolean(props.product.is_bestseller),
    image: null as File | null,
    gallery_images: [] as File[],
    deleted_images: [] as number[],
    is_active: Boolean(props.product.is_active),
});

const handleGalleryUpload = (event: Event) => {
    const files = (event.target as HTMLInputElement).files;
    if (files) {
        form.gallery_images = Array.from(files);
    }
};

const markImageForDeletion = (imageId: number) => {
    if (!form.deleted_images.includes(imageId)) {
        form.deleted_images.push(imageId);
    }
};

const undoDeletion = (imageId: number) => {
    const index = form.deleted_images.indexOf(imageId);
    if (index > -1) {
        form.deleted_images.splice(index, 1);
    }
};

const submit = () => {
    form.post(route('admin.products.update', props.product.id));
};
</script>

<template>
    <Head title="Edit Product" />

    <AppLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                 <div class="mb-6">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        Edit Product
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
                                <div v-if="product.image_path" class="mb-2">
                                    <img :src="product.image_url" class="h-20 w-20 object-cover rounded">
                                </div>
                                <input @input="form.image = ($event.target as HTMLInputElement).files?.[0] || null" id="image" type="file" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                <div v-if="form.errors.image" class="text-red-500 text-xs italic">{{ form.errors.image }}</div>
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Gallery Images</label>

                                <div v-if="product.images.length > 0" class="flex flex-wrap gap-4 mb-4">
                                    <div v-for="img in product.images" :key="img.id" class="relative group">
                                        <img :src="img.image_url" class="h-24 w-24 object-cover rounded border" :class="{'opacity-50': form.deleted_images.includes(img.id)}">
                                        <button v-if="!form.deleted_images.includes(img.id)" @click.prevent="markImageForDeletion(img.id)" class="absolute top-0 right-0 bg-red-600 text-white rounded-full p-1 m-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                        <button v-else @click.prevent="undoDeletion(img.id)" class="absolute top-0 right-0 bg-green-600 text-white rounded-full p-1 m-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 12.6111L8.92308 17.5L20 6.5" />
                                            </svg>
                                        </button>
                                        <span v-if="form.deleted_images.includes(img.id)" class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-red-700 font-bold bg-white/80 px-1 rounded">DELETED</span>
                                    </div>
                                </div>
                                <div v-else class="text-gray-500 text-sm italic mb-2">No gallery images uploaded.</div>

                                <input @input="handleGalleryUpload" id="gallery_images" type="file" multiple class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                <p class="text-xs text-gray-500 mt-1">Upload additional images.</p>
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
                                    Update Product
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
