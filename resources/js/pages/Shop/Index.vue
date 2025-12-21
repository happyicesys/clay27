<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { ShoppingCart, Menu } from 'lucide-vue-next';
import SiteFooter from '@/components/SiteFooter.vue';
import { formatCurrency } from '@/lib/utils';

const props = defineProps<{
    products: Array<{
        id: number;
        name: string;
        slug: string;
        price: number;
        image_path: string;
    }>;
    categories: Array<{
        id: number;
        name: string;
        slug: string;
        image_path: string | null;
    }>;
    currentCategory: string | null;
}>();
</script>

<template>
    <Head title="Shop" />

    <div class="min-h-screen bg-[#F9F5F1] text-[#4A2C2A]">
        <header class="flex justify-between items-center p-6 bg-[#F9F5F1]">
            <Link :href="route('home')" class="text-2xl font-bold tracking-widest">CLAY27</Link>
            <div class="flex gap-4">
                <Link :href="route('cart.index')" class="relative">
                    <ShoppingCart class="w-6 h-6 cursor-pointer" />
                </Link>
            </div>
        </header>

        <!-- Shop By Category Section -->
        <div class="px-6 py-12 text-center" v-if="categories.length > 0">
            <h2 class="text-2xl font-serif text-[#784421] mb-8 tracking-wide">SHOP BY CATEGORY</h2>
            <div class="flex flex-wrap justify-center gap-8 md:gap-12">
                <Link :href="route('shop.index')" class="group flex flex-col items-center">
                    <div class="w-32 h-32 md:w-36 md:h-36 rounded-full bg-gray-200 overflow-hidden mb-4 border-2 transition-all duration-300 flex items-center justify-center"
                         :class="!currentCategory ? 'border-[#784421] shadow-lg scale-105' : 'border-transparent group-hover:border-[#784421]'">
                         <span class="text-gray-500">All</span>
                    </div>
                    <span class="text-sm font-bold tracking-widest uppercase text-[#5A3A31]" :class="!currentCategory ? 'underline decoration-2 underline-offset-4' : ''">ALL</span>
                </Link>

                <Link v-for="category in categories" :key="category.id" :href="route('shop.index', { category: category.slug })" class="group flex flex-col items-center">
                    <div class="w-32 h-32 md:w-36 md:h-36 rounded-full bg-gray-200 overflow-hidden mb-4 border-2 transition-all duration-300"
                         :class="currentCategory === category.slug ? 'border-[#784421] shadow-lg scale-105' : 'border-transparent group-hover:border-[#784421]'">
                        <img v-if="category.image_url" :src="category.image_url" class="w-full h-full object-cover">
                        <div v-else class="w-full h-full bg-[#E5E0DC] flex items-center justify-center text-gray-400">
                             <!-- Placeholder if no image -->
                             <span class="text-xs">{{ category.name.substring(0, 2) }}</span>
                        </div>
                    </div>
                    <span class="text-sm font-bold tracking-widest uppercase text-[#5A3A31]" :class="currentCategory === category.slug ? 'underline decoration-2 underline-offset-4' : ''">{{ category.name }}</span>
                </Link>
            </div>
        </div>

        <div class="px-6 py-8 md:px-12">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-x-6 gap-y-10">
                <Link v-for="product in products" :key="product.id" :href="route('shop.show', product.slug)" class="group block">
                    <div class="aspect-square bg-white rounded-lg overflow-hidden mb-3 relative shadow-sm group-hover:shadow-md transition-shadow">
                        <img v-if="product.image_url" :src="product.image_url" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div v-else class="w-full h-full bg-gray-100 flex items-center justify-center text-gray-400">No Image</div>
                    </div>
                    <h4 class="text-base font-serif text-[#2C1810] group-hover:text-[#784421] transition-colors">{{ product.name }}</h4>
                    <p class="text-sm text-gray-500 mt-1 font-sans">{{ formatCurrency(product.price) }}</p>
                </Link>
            </div>
            <div v-if="products.length === 0" class="text-center py-12 text-gray-500 italic">
                No products found in this category.
            </div>
        </div>
        <SiteFooter />
    </div>
</template>
