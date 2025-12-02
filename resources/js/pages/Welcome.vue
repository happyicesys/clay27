<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { ShoppingCart, Menu, ArrowRight } from 'lucide-vue-next';

defineProps<{
    banners: Array<{
        id: number;
        image_path: string;
        title: string;
        link_url: string;
    }>;
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
    <Head title="Welcome" />

    <div class="min-h-screen bg-[#F9F5F1] text-[#4A2C2A]">
        <!-- Header -->
        <header class="flex justify-between items-center p-6">
            <div class="w-8">
                <!-- Spacer or Menu if left aligned -->
            </div>
            <div class="text-2xl font-bold tracking-widest">
                CLAY 27
            </div>
            <div class="flex gap-4">
                <Menu class="w-6 h-6 cursor-pointer" />
                <ShoppingCart class="w-6 h-6 cursor-pointer" />
            </div>
        </header>

        <!-- Main Banner -->
        <div class="px-6 mb-12">
            <div v-if="banners.length > 0" class="relative w-full aspect-[4/3] md:aspect-[2/1] bg-[#C4A4A4] rounded-lg overflow-hidden">
                <img :src="'/storage/' + banners[0].image_path" class="w-full h-full object-cover" :alt="banners[0].title">
                <div class="absolute inset-0 flex items-center justify-center">
                    <h2 class="text-white text-4xl font-serif">{{ banners[0].title }}</h2>
                </div>
            </div>
            <div v-else class="w-full aspect-[4/3] bg-[#C4A4A4] rounded-lg flex items-center justify-center text-white">
                Main Cover
            </div>
        </div>

        <!-- Categories / Horizontal Scroll -->
        <div class="px-6 mb-12">
            <h3 class="text-lg font-serif mb-4">Our Polymer Clay Jewellery</h3>
            <div class="flex gap-4 overflow-x-auto pb-4 no-scrollbar">
                <!-- Mock Categories -->
                <div class="flex-shrink-0 flex flex-col items-center gap-2">
                    <div class="w-20 h-20 rounded-full bg-gray-200 overflow-hidden">
                         <img src="https://placehold.co/100" class="w-full h-full object-cover">
                    </div>
                    <span class="text-xs uppercase tracking-wide">Shoes</span>
                </div>
                <div class="flex-shrink-0 flex flex-col items-center gap-2">
                    <div class="w-20 h-20 rounded-full bg-gray-200 overflow-hidden">
                         <img src="https://placehold.co/100" class="w-full h-full object-cover">
                    </div>
                    <span class="text-xs uppercase tracking-wide">Roller Skates</span>
                </div>
                <div class="flex-shrink-0 flex flex-col items-center gap-2">
                    <div class="w-20 h-20 rounded-full bg-gray-200 overflow-hidden">
                         <img src="https://placehold.co/100" class="w-full h-full object-cover">
                    </div>
                    <span class="text-xs uppercase tracking-wide">Bags</span>
                </div>
                 <div class="flex-shrink-0 flex flex-col items-center gap-2">
                    <div class="w-20 h-20 rounded-full bg-gray-200 overflow-hidden">
                         <img src="https://placehold.co/100" class="w-full h-full object-cover">
                    </div>
                    <span class="text-xs uppercase tracking-wide">Travel</span>
                </div>
            </div>
        </div>

        <!-- Best Sellers -->
        <div class="px-6 mb-12">
            <div class="flex justify-between items-end mb-4">
                <h3 class="text-lg font-serif">Our Best Sellers</h3>
                <Link :href="route('shop.index')" class="flex items-center gap-1 text-sm font-medium">
                    View All <ArrowRight class="w-4 h-4" />
                </Link>
            </div>

            <div class="grid grid-cols-2 gap-4">
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

        <!-- Workshop Promo -->
        <div class="bg-[#7A2021] text-white p-8 mx-6 rounded-lg mb-12 relative overflow-hidden">
             <div class="relative z-10">
                <h3 class="text-2xl font-serif mb-2">Workshop</h3>
                <p class="text-sm opacity-90 mb-4">Join our clay making workshop!</p>
                <button class="bg-white text-[#7A2021] px-4 py-2 rounded text-sm font-bold">Book Now</button>
             </div>
        </div>

        <!-- Footer -->
        <footer class="px-6 py-8 text-center text-sm opacity-60">
            <p>&copy; 2025 Clay 27. All rights reserved.</p>
        </footer>
    </div>
</template>

<style scoped>
.no-scrollbar::-webkit-scrollbar {
    display: none;
}
.no-scrollbar {
    -ms-overflow-style: none;
    scrollbar-width: none;
}
</style>
