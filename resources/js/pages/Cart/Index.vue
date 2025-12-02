<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { ShoppingCart, Menu, Trash2 } from 'lucide-vue-next';

defineProps<{
    cart: {
        items: Array<{
            id: number;
            quantity: number;
            product: {
                name: string;
                price: number;
                image_path: string;
            };
        }>;
    };
}>();

const updateQuantity = (itemId: number, quantity: number) => {
    router.put(route('cart.update', itemId), { quantity });
};

const removeItem = (itemId: number) => {
    router.delete(route('cart.destroy', itemId));
};

const total = (items: any[]) => {
    return items.reduce((acc, item) => acc + item.quantity * item.product.price, 0).toFixed(2);
};
</script>

<template>
    <Head title="Shopping Cart" />

    <div class="min-h-screen bg-[#F9F5F1] text-[#4A2C2A]">
        <header class="flex justify-between items-center p-6">
            <Link :href="route('home')" class="text-2xl font-bold tracking-widest">CLAY 27</Link>
            <div class="flex gap-4">
                <Menu class="w-6 h-6 cursor-pointer" />
                <ShoppingCart class="w-6 h-6 cursor-pointer" />
            </div>
        </header>

        <div class="px-6 py-8 max-w-4xl mx-auto">
            <h1 class="text-3xl font-serif mb-8">Shopping Cart</h1>

            <div v-if="cart && cart.items && cart.items.length > 0">
                <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
                    <div v-for="item in cart.items" :key="item.id" class="flex items-center p-4 border-b last:border-b-0">
                        <div class="w-20 h-20 bg-gray-100 rounded overflow-hidden flex-shrink-0">
                            <img v-if="item.product.image_path" :src="'/storage/' + item.product.image_path" class="w-full h-full object-cover">
                        </div>
                        <div class="ml-4 flex-1">
                            <h3 class="font-medium">{{ item.product.name }}</h3>
                            <p class="text-sm text-gray-500">${{ item.product.price }}</p>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="flex items-center border rounded">
                                <button @click="updateQuantity(item.id, item.quantity - 1)" class="px-2 py-1 hover:bg-gray-100">-</button>
                                <span class="px-2">{{ item.quantity }}</span>
                                <button @click="updateQuantity(item.id, item.quantity + 1)" class="px-2 py-1 hover:bg-gray-100">+</button>
                            </div>
                            <button @click="removeItem(item.id)" class="text-red-500 hover:text-red-700">
                                <Trash2 class="w-5 h-5" />
                            </button>
                        </div>
                    </div>
                </div>

                <div class="flex justify-between items-center mb-8">
                    <span class="text-xl font-bold">Total:</span>
                    <span class="text-xl font-bold">${{ total(cart.items) }}</span>
                </div>

                <div class="flex justify-end">
                    <Link :href="route('checkout.index')" class="bg-[#4A2C2A] text-white px-8 py-3 rounded font-bold hover:bg-opacity-90 transition">
                        Proceed to Checkout
                    </Link>
                </div>
            </div>
            <div v-else class="text-center py-12">
                <p class="text-lg opacity-60 mb-4">Your cart is empty.</p>
                <Link :href="route('shop.index')" class="text-[#4A2C2A] font-bold hover:underline">Continue Shopping</Link>
            </div>
        </div>
    </div>
</template>
