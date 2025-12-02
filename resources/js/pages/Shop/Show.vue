<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { ShoppingCart, Menu, ArrowLeft } from 'lucide-vue-next';

defineProps<{
    product: {
        id: number;
        name: string;
        description: string;
        price: number;
        stock: number;
        image_path: string;
    };
}>();
</script>

<template>
    <Head :title="product.name" />

    <div class="min-h-screen bg-[#F9F5F1] text-[#4A2C2A]">
        <header class="flex justify-between items-center p-6">
            <Link :href="route('home')" class="text-2xl font-bold tracking-widest">CLAY 27</Link>
            <div class="flex gap-4">
                <Menu class="w-6 h-6 cursor-pointer" />
                <ShoppingCart class="w-6 h-6 cursor-pointer" />
            </div>
        </header>

        <div class="px-6 py-8 max-w-4xl mx-auto">
            <Link :href="route('shop.index')" class="inline-flex items-center text-sm mb-6 opacity-60 hover:opacity-100">
                <ArrowLeft class="w-4 h-4 mr-1" /> Back to Shop
            </Link>

            <div class="grid md:grid-cols-2 gap-8">
                <div class="aspect-square bg-white rounded-lg overflow-hidden">
                    <img v-if="product.image_path" :src="'/storage/' + product.image_path" class="w-full h-full object-cover">
                    <div v-else class="w-full h-full bg-gray-100 flex items-center justify-center text-gray-400">No Image</div>
                </div>

                <div>
                    <h1 class="text-3xl font-serif mb-2">{{ product.name }}</h1>
                    <p class="text-xl font-medium mb-4">${{ product.price }}</p>
                    <p class="text-sm opacity-80 mb-6 leading-relaxed">{{ product.description }}</p>

                    <button class="w-full bg-[#4A2C2A] text-white py-3 rounded font-bold hover:bg-opacity-90 transition">
                        Add to Cart
                    </button>
                    <p class="text-xs text-center mt-2 opacity-60" v-if="product.stock > 0">{{ product.stock }} in stock</p>
                    <p class="text-xs text-center mt-2 text-red-500" v-else>Out of Stock</p>
                </div>
            </div>
        </div>
    </div>
</template>
