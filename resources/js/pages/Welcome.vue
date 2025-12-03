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

    <div class="min-h-screen bg-[#F9F5F1] text-[#4A2C2A] font-sans overflow-x-hidden">
        <!-- Header -->
        <header class="flex justify-between items-center px-20 py-12 bg-[#F9F5F1]">
            <!-- Logo -->
            <div class="text-2xl font-bold tracking-widest text-[#7A2021] origin-left scale-[1.15]">
                CLAY 27
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
                <ShoppingCart class="w-6 h-6 cursor-pointer" />
            </div>
        </header>

        <!-- Main Banner -->
        <div class="w-full h-[550px] relative mb-16">
            <div v-if="banners.length > 0" class="w-full h-full">
                <img :src="'/storage/' + banners[0].image_path" class="w-full h-full object-cover" :alt="banners[0].title">
                <!-- Overlay Button (Left Side) -->
                <div class="absolute inset-y-0 left-0 flex items-center pl-20">
                     <Link :href="banners[0].link_url || route('shop.index')" class="bg-white text-[#7A2021] px-10 py-4 border border-[#7A2021] hover:bg-[#7A2021] hover:text-white transition uppercase tracking-widest font-bold text-sm">
                        Shop Now
                     </Link>
                </div>
            </div>
            <div v-else class="w-full h-full bg-[#C4A4A4] flex items-center justify-center text-white">
                Main Cover
            </div>
        </div>

        <!-- Shop By Type -->
        <div class="w-full bg-white py-20 mb-16">
             <div class="w-full text-center px-8 md:px-0 pb-12">
                <h3 class="text-4xl font-serif mb-24 text-[#7A2021] uppercase tracking-widest">Shop By Type</h3>

                <div class="flex justify-center gap-12 flex-wrap px-8">
                    <!-- Mock Categories -->
                    <div class="flex flex-col items-center gap-6">
                        <div class="w-[300px] h-[300px] rounded-full bg-gray-200 overflow-hidden relative group cursor-pointer">
                             <img src="https://placehold.co/400" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        </div>
                        <span class="text-xl uppercase tracking-widest text-[#7A2021] font-bold">Earrings</span>
                    </div>
                    <div class="flex flex-col items-center gap-6">
                        <div class="w-[300px] h-[300px] rounded-full bg-gray-200 overflow-hidden relative group cursor-pointer">
                             <img src="https://placehold.co/400" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        </div>
                        <span class="text-xl uppercase tracking-widest text-[#7A2021] font-bold">Necklaces</span>
                    </div>
                    <div class="flex flex-col items-center gap-6">
                        <div class="w-[300px] h-[300px] rounded-full bg-gray-200 overflow-hidden relative group cursor-pointer">
                             <img src="https://placehold.co/400" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        </div>
                        <span class="text-xl uppercase tracking-widest text-[#7A2021] font-bold">Bracelets</span>
                    </div>
                     <div class="flex flex-col items-center gap-6">
                        <div class="w-[300px] h-[300px] rounded-full bg-gray-200 overflow-hidden relative group cursor-pointer">
                             <img src="https://placehold.co/400" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        </div>
                        <span class="text-xl uppercase tracking-widest text-[#7A2021] font-bold">Rings</span>
                    </div>
                </div>
             </div>
        </div>

        <!-- Best Sellers -->
        <div class="max-w-[1600px] mx-auto px-6 mb-24 mt-24">
            <h3 class="text-4xl font-serif mb-12 text-center text-[#7A2021] uppercase tracking-widest">Our Best Seller</h3>

            <div class="flex overflow-x-auto snap-x snap-mandatory gap-6 pb-8 no-scrollbar">
                <!-- Products (Limit to 6) -->
                <Link v-for="(product, index) in products.slice(0, 6)" :key="product.id" :href="route('shop.show', product.slug)" class="group relative block min-w-[300px] w-[300px] md:min-w-[calc(25%-1.125rem)] md:w-[calc(25%-1.125rem)] snap-center flex-shrink-0">
                    <!-- Image Container -->
                    <div class="aspect-square bg-gray-100 relative overflow-hidden">
                        <img v-if="product.image_path" :src="'/storage/' + product.image_path" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div v-else class="w-full h-full flex items-center justify-center text-gray-400">No Image</div>

                        <!-- Hover Add to Cart -->
                        <div class="absolute inset-0 bg-black/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                            <button class="bg-white text-[#7A2021] px-8 py-3 uppercase tracking-widest font-bold hover:bg-[#7A2021] hover:text-white transition shadow-lg">
                                Add to Cart
                            </button>
                        </div>

                        <!-- Top Left Label -->
                        <div class="absolute top-4 left-4 bg-white border border-[#7A2021] px-4 py-1 z-10">
                            <span class="text-xs font-bold text-[#7A2021] uppercase tracking-widest">{{ index % 2 === 0 ? 'New' : 'Best Seller' }}</span>
                        </div>

                        <!-- Bottom Left Info -->
                        <div class="absolute bottom-6 left-6 text-white drop-shadow-md z-10">
                             <h4 class="text-xl font-bold leading-tight mb-1">{{ product.name }}</h4>
                             <p class="text-lg font-medium">${{ product.price }}</p>
                        </div>

                        <!-- Gradient Overlay for text readability -->
                        <div class="absolute inset-x-0 bottom-0 h-1/3 bg-gradient-to-t from-black/50 to-transparent pointer-events-none"></div>
                    </div>
                </Link>

                <!-- 7th Item: View More -->
                <Link :href="route('shop.index')" class="group relative block min-w-[300px] w-[300px] md:min-w-[calc(25%-1.125rem)] md:w-[calc(25%-1.125rem)] snap-center flex-shrink-0">
                    <div class="aspect-square bg-transparent border border-[#7A2021] flex flex-col items-center justify-center text-[#7A2021] transition">
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
                     <img src="https://placehold.co/600x800" class="w-full h-full object-cover">
                </div>
            </div>

            <!-- Right Text -->
            <div class="w-full lg:w-1/2 h-full flex flex-col justify-center px-8 lg:px-12 text-[#7A2021] mt-8 lg:mt-0 text-center lg:text-left">
                <h4 class="text-2xl font-bold mb-6 uppercase tracking-widest">Our Studio in Johor Bahru</h4>
                <p class="mb-10 text-lg leading-relaxed max-w-xl mx-auto lg:mx-0">
                    Join us for an immersive clay-making experience. Learn the art of polymer clay and create your own unique jewelry pieces in our cozy studio.
                </p>
                <div>
                    <a href="#" class="inline-block bg-[#7A2021] text-white px-10 py-3 uppercase tracking-widest font-bold hover:bg-opacity-90 transition">
                        More Info
                    </a>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-[#7A2021] text-white py-12 text-center opacity-90">
            <p>&copy; 2025 Clay 27. All rights reserved.</p>
        </footer>
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
