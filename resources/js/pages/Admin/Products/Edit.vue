<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps<{
    product: {
        id: number;
        name: string;
        description: string;
        price: number;
        stock: number;
        image_path: string;
        is_active: boolean;
    };
}>();

const form = useForm({
    _method: 'PUT',
    name: props.product.name,
    description: props.product.description,
    price: props.product.price,
    stock: props.product.stock,
    image: null as File | null,
    is_active: Boolean(props.product.is_active),
});

const submit = () => {
    form.post(route('admin.products.update', props.product.id));
};
</script>

<template>
    <Head title="Edit Product" />

    <AppLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Product
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form @submit.prevent="submit">
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Name</label>
                                <input v-model="form.name" id="name" type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                <div v-if="form.errors.name" class="text-red-500 text-xs italic">{{ form.errors.name }}</div>
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="description">Description</label>
                                <textarea v-model="form.description" id="description" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                                <div v-if="form.errors.description" class="text-red-500 text-xs italic">{{ form.errors.description }}</div>
                            </div>

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
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="image">Image</label>
                                <div v-if="product.image_path" class="mb-2">
                                    <img :src="'/storage/' + product.image_path" class="h-20 w-20 object-cover">
                                </div>
                                <input @input="form.image = $event.target.files[0]" id="image" type="file" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
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
