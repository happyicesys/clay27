<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { ShoppingCart, Menu, ArrowRight } from 'lucide-vue-next';
import SiteFooter from '@/components/SiteFooter.vue';
import { formatCurrency } from '@/lib/utils';

const props = defineProps<{
    banners: Array<{
        id: number;
        image_path: string;
        title: string;
        link_url: string;
        position: string;
        image_url: string;
    }>;
    categories: Array<{
        id: number;
        name: string;
        slug: string;
        image_path: string | null;
        image_url: string | null; // Added image_url type
    }>;
    products: Array<{
        id: number;
        name: string;
        slug: string;
        price: number;
        image_path: string;
        is_bestseller: boolean;
        image_url: string; // Added image_url type
    }>;
}>();

import { computed } from 'vue';

const mainBanner = computed(() => props.banners.find(b => b.position === 'main'));
const workshopBanner = computed(() => props.banners.find(b => b.position === 'workshop'));
</script>

<template>
    <Head title="Welcome" />

    <div class="min-h-screen bg-[#F9F5F1] text-[#4A2C2A] font-sans overflow-x-hidden">
        <!-- Header -->
        <header class="flex justify-between items-center px-20 py-12 bg-[#F9F5F1]">
            <!-- Logo -->
            <div class="text-2xl font-bold tracking-widest text-[#7A2021] origin-left scale-[1.15]">
                CLAY27
            </div>

            <!-- Center Nav -->
            <nav class="hidden md:flex gap-12 text-[#7A2021] font-bold tracking-widest text-lg">
                <Link href="/" class="hover:opacity-70">HOME</Link>
                <Link :href="route('shop.index')" class="hover:opacity-70">SHOP</Link>
                <a href="#workshop" class="hover:opacity-70">WORKSHOP</a>
                <a href="#about" class="hover:opacity-70">ABOUT US</a>
            </nav>

            <!-- Right Icons -->
            <div class="flex gap-6 text-[#7A2021]">
                <Menu class="w-6 h-6 cursor-pointer md:hidden" />
                <Link :href="route('cart.index')">
                    <ShoppingCart class="w-6 h-6 cursor-pointer" />
                </Link>
            </div>
        </header>

        <!-- Main Banner -->
        <div class="w-full h-[550px] relative mb-16">
            <div v-if="mainBanner" class="w-full h-full">
                <img :src="mainBanner.image_url" class="w-full h-full object-cover" :alt="mainBanner.title">
                <!-- Overlay Button (Left Side) -->
                <div class="absolute inset-y-0 left-0 flex items-center pl-20">
                     <Link :href="mainBanner.link_url || route('shop.index')" class="bg-white text-[#7A2021] px-10 py-4 border border-[#7A2021] hover:bg-[#7A2021] hover:text-white transition uppercase tracking-widest font-bold text-sm rounded-md">
                        Shop Now
                     </Link>
                </div>
            </div>
            <div v-else class="w-full h-full bg-[#C4A4A4] flex items-center justify-center text-white">
                Main Cover
            </div>
        </div>

        <!-- Shop By Category -->
        <div class="w-full bg-white py-20 mb-16" v-if="categories.length > 0">
             <div class="w-full text-center px-8 md:px-0 pb-12">
                <h3 class="text-4xl font-serif mb-24 text-[#7A2021] uppercase tracking-widest">Shop By Category</h3>

                <div class="flex justify-center gap-12 flex-wrap px-8">
                    <Link v-for="category in categories" :key="category.id" :href="route('shop.index', { category: category.slug })" class="flex flex-col items-center gap-6 group">
                        <div class="w-[300px] h-[300px] rounded-full bg-gray-200 overflow-hidden relative border-4 border-transparent group-hover:border-[#7A2021] transition duration-500">
                             <img v-if="category.image_url" :src="category.image_url" class="w-full h-full object-cover group-hover:scale-125 transition-transform duration-500 ease-in-out">
                             <div v-if="category.image_path" class="absolute inset-0 bg-white opacity-20 group-hover:opacity-0 transition-opacity duration-500 pointer-events-none"></div>

                             <div v-if="!category.image_path" class="w-full h-full bg-[#E5E0DC] flex items-center justify-center text-gray-400">
                                 <span class="text-4xl">{{ category.name.substring(0, 2) }}</span>
                             </div>
                        </div>
                        <span class="text-xl uppercase tracking-widest text-[#7A2021] font-bold">{{ category.name }}</span>
                    </Link>
                </div>
             </div>
        </div>

        <!-- Best Sellers -->
        <div class="max-w-[1600px] mx-auto px-6 mb-24 mt-24">
            <h3 class="text-4xl font-serif mb-12 text-center text-[#7A2021] uppercase tracking-widest">Our Best Seller</h3>

            <div class="flex overflow-x-auto snap-x snap-mandatory gap-6 pb-8 no-scrollbar">
                <!-- First 7 Products -->
                <Link v-for="(product, index) in products.slice(0, 7)" :key="product.id" :href="route('shop.show', product.slug)" class="group relative block min-w-[300px] w-[300px] snap-center flex-shrink-0">
                    <!-- Image Container -->
                    <div class="aspect-square bg-gray-100 relative overflow-hidden rounded-xl">
                        <img v-if="product.image_url" :src="product.image_url" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div v-else class="w-full h-full flex items-center justify-center text-gray-400 bg-gradient-to-br from-gray-200 to-gray-300">
                            <span class="text-sm text-gray-500">{{ product.name }}</span>
                        </div>

                        <!-- Hover Add to Cart -->
                        <div class="absolute inset-0 bg-black/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                            <button class="bg-white text-[#7A2021] px-8 py-3 uppercase tracking-widest font-bold hover:bg-[#7A2021] hover:text-white transition shadow-lg rounded-md">
                                Add to Cart
                            </button>
                        </div>

                        <!-- Top Left Label -->
                        <div class="absolute top-4 left-4 bg-white border border-[#7A2021] px-4 py-1 z-10" v-if="product.is_bestseller || index < 2">
                            <span class="text-xs font-bold text-[#7A2021] uppercase tracking-widest">{{ product.is_bestseller ? 'Best Seller' : 'New' }}</span>
                        </div>

                        <!-- Bottom Left Info -->
                        <div class="absolute bottom-6 left-6 text-white drop-shadow-md z-10">
                             <h4 class="text-xl font-bold leading-tight mb-1">{{ product.name }}</h4>
                             <p class="text-lg font-medium">{{ formatCurrency(product.price) }}</p>
                        </div>

                        <!-- Gradient Overlay for text readability -->
                        <div class="absolute inset-x-0 bottom-0 h-1/3 bg-gradient-to-t from-black/50 to-transparent pointer-events-none"></div>
                    </div>
                </Link>

                <!-- 8th Item: View More (after 7 products) -->
                <Link :href="route('shop.index')" class="group relative block min-w-[300px] w-[300px] snap-center flex-shrink-0">
                    <div class="aspect-square bg-transparent border border-[#7A2021] flex flex-col items-center justify-center text-[#7A2021] transition rounded-xl">
                        <span class="text-lg font-bold uppercase tracking-widest mb-4 group-hover:text-gray-500 transition-colors duration-300">View More</span>
                        <ArrowRight class="w-10 h-10 group-hover:scale-125 group-hover:text-gray-500 transition-all duration-300" />
                    </div>
                </Link>
            </div>
        </div>

        <!-- Workshop -->
        <div id="workshop" class="max-w-[1600px] mx-auto h-auto lg:h-[550px] mb-24 flex flex-col lg:flex-row">
            <!-- Left Image (Arch) -->
            <div class="w-full lg:w-1/2 h-[400px] lg:h-full relative px-8 lg:px-0 lg:pr-12 flex justify-center lg:justify-end">
                <div class="w-full max-w-[500px] h-full rounded-t-[250px] overflow-hidden bg-gray-300 relative">
                     <img v-if="workshopBanner" :src="workshopBanner.image_url" class="w-full h-full object-cover">
                     <img v-else src="https://placehold.co/600x800" class="w-full h-full object-cover">
                </div>
            </div>

            <!-- Right Text -->
            <div class="w-full lg:w-1/2 h-full flex flex-col justify-center px-8 lg:px-12 text-[#7A2021] mt-8 lg:mt-0 text-center lg:text-left">
                <h4 class="text-2xl font-bold mb-6 uppercase tracking-widest">Workshop Available in Johor Bahru (by appointment)</h4>
                <p class="mb-10 text-lg leading-relaxed max-w-xl mx-auto lg:mx-0">
                    Join us for an immersive clay-making experience. Learn the art of polymer clay and create your own unique jewelry pieces in our cozy studio.
                </p>
                <div>
                    <a href="#" class="inline-block bg-[#7A2021] text-white px-10 py-3 uppercase tracking-widest font-bold hover:bg-opacity-90 transition rounded-md">
                        More Info
                    </a>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <SiteFooter />
    </div>
</template>

<style scoped>
/* Custom Scrollbar Hide */
.no-scrollbar::-webkit-scrollbar {
    display: none;
}
.no-scrollbar {
    -ms-overflow-style: none;
    scrollbar-width: none;
}
</style>
