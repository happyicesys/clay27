<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { ShoppingCart, Menu, ArrowLeft } from 'lucide-vue-next';
import SiteFooter from '@/components/SiteFooter.vue';
import { ref, computed } from 'vue';
import { formatCurrency } from '@/lib/utils';

const props = defineProps<{
    product: {
        id: number;
        name: string;
        description: string;
        price: number;
        stock: number;
        image_path: string;
        images: Array<{ id: number; image_path: string }>;
    };
    relatedProducts: Array<{
        id: number;
        name: string;
        slug: string;
        price: number;
        image_path: string;
    }>;
}>();

const allImages = computed(() => {
    const imgs = [];
    if (props.product.image_url) imgs.push(props.product.image_url);
    if (props.product.images) {
        props.product.images.forEach(img => imgs.push(img.image_url));
    }
    return imgs;
});

const activeImage = ref(props.product.image_url);

const setActiveImage = (path: string) => {
    activeImage.value = path;
};

const addToCart = () => {
    router.post(route('cart.store'), {
        product_id: props.product.id,
        quantity: 1
    });
};
</script>

<template>
    <Head :title="product.name" />

    <div class="min-h-screen bg-[#F9F5F1] text-[#4A2C2A]">
        <header class="flex justify-between items-center p-6 bg-[#F9F5F1]">
            <Link :href="route('home')" class="text-2xl font-bold tracking-widest">CLAY27</Link>
            <div class="flex gap-4">
                <Link :href="route('cart.index')" class="relative">
                    <ShoppingCart class="w-6 h-6 cursor-pointer" />
                </Link>
            </div>
        </header>

        <div class="px-6 py-8 max-w-6xl mx-auto">
            <Link :href="route('shop.index')" class="inline-flex items-center text-sm mb-6 opacity-60 hover:opacity-100">
                <ArrowLeft class="w-4 h-4 mr-1" /> Back to Shop
            </Link>

            <div class="grid md:grid-cols-2 gap-12">
                <!-- Gallery Section -->
                <div>
                    <div class="aspect-square bg-white rounded-lg overflow-hidden mb-4 shadow-sm">
                        <img v-if="activeImage" :src="activeImage" class="w-full h-full object-cover">
                        <div v-else class="w-full h-full bg-gray-100 flex items-center justify-center text-gray-400">No Image</div>
                    </div>

                    <div v-if="allImages.length > 1" class="flex gap-4 overflow-x-auto pb-2">
                        <button v-for="(img, index) in allImages" :key="index"
                            @click="setActiveImage(img)"
                            class="w-20 h-20 flex-shrink-0 rounded-md overflow-hidden border-2 transition-all"
                            :class="activeImage === img ? 'border-[#784421]' : 'border-transparent opacity-70 hover:opacity-100'">
                            <img :src="img" class="w-full h-full object-cover">
                        </button>
                    </div>
                </div>

                <!-- Product Details -->
                <div class="flex flex-col justify-center">
                    <h1 class="text-3xl md:text-4xl font-serif mb-2 text-[#2C1810]">{{ product.name }}</h1>
                    <p class="text-2xl font-medium mb-6 text-[#784421]">{{ formatCurrency(product.price) }}</p>

                    <div class="prose prose-sm text-[#4A2C2A]/80 mb-8 leading-relaxed whitespace-pre-line">
                        {{ product.description }}
                    </div>

                    <button @click="addToCart"
                        class="w-full bg-[#4A2C2A] text-white py-4 rounded font-bold hover:bg-[#2C1810] transition-colors shadow-lg uppercase tracking-wide disabled:opacity-50 disabled:cursor-not-allowed"
                        :disabled="product.stock <= 0">
                        {{ product.stock > 0 ? 'Add to Cart' : 'Out of Stock' }}
                    </button>

                    <p class="text-xs text-center mt-3 opacity-60" v-if="product.stock > 0">{{ product.stock }} items in stock</p>
                </div>
            </div>

            <!-- Related Products -->
            <div v-if="relatedProducts.length > 0" class="mt-24 border-t border-[#E5E0DC] pt-12">
                <h3 class="text-2xl font-serif mb-8 text-center text-[#2C1810]">You May Also Like</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    <Link v-for="related in relatedProducts" :key="related.id" :href="route('shop.show', related.slug)" class="group block">
                        <div class="aspect-square bg-white rounded-lg overflow-hidden mb-3 relative shadow-sm group-hover:shadow-md transition-shadow">
                            <img v-if="related.image_url" :src="related.image_url" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <div v-else class="w-full h-full bg-gray-100 flex items-center justify-center text-gray-400">No Image</div>
                        </div>
                        <h4 class="text-base font-serif text-[#2C1810] group-hover:text-[#784421] transition-colors">{{ related.name }}</h4>
                        <p class="text-sm text-gray-500 mt-1 font-sans">{{ formatCurrency(related.price) }}</p>
                    </Link>
                </div>
            </div>
        </div>
        <SiteFooter />
    </div>
</template>
