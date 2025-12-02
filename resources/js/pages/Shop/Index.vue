<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { ShoppingCart, Menu } from 'lucide-vue-next';

defineProps<{
    products: Array<{
        id: number;
        name: string;
        slug: string;
        price: number;
        image_path: string;
    }>;
}>();
</script>

<template>
    <Head title="Shop" />

    <div class="min-h-screen bg-[#F9F5F1] text-[#4A2C2A]">
        <header class="flex justify-between items-center p-6">
            <Link :href="route('home')" class="text-2xl font-bold tracking-widest">CLAY 27</Link>
            <div class="flex gap-4">
                <Menu class="w-6 h-6 cursor-pointer" />
                <ShoppingCart class="w-6 h-6 cursor-pointer" />
            </div>
        </header>

        <div class="px-6 py-8">
            <h1 class="text-2xl font-serif mb-6">All Products</h1>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <Link v-for="product in products" :key="product.id" :href="route('shop.show', product.slug)" class="group">
                    <div class="aspect-square bg-white rounded-lg overflow-hidden mb-2">
                        <img v-if="product.image_path" :src="'/storage/' + product.image_path" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        <div v-else class="w-full h-full bg-gray-100 flex items-center justify-center text-gray-400">No Image</div>
                    </div>
                    <h4 class="text-sm font-medium">{{ product.name }}</h4>
                    <p class="text-sm text-gray-500">${{ product.price }}</p>
                </Link>
            </div>
        </div>
    </div>
</template>
