<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { CheckCircle } from 'lucide-vue-next';
import { formatCurrency } from '@/lib/utils';

defineProps<{
    order: {
        id: number;
        total_amount: number;
        items: Array<{
            id: number;
            product_name: string;
            quantity: number;
            price: number;
        }>;
    };
}>();
</script>

<template>
    <Head title="Order Confirmed" />

    <div class="min-h-screen bg-[#F9F5F1] text-[#4A2C2A] flex items-center justify-center p-6">
        <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full text-center">
            <div class="flex justify-center mb-6">
                <CheckCircle class="w-16 h-16 text-green-500" />
            </div>
            <h1 class="text-3xl font-serif mb-2">Thank You!</h1>
            <p class="text-gray-600 mb-8">Your order #{{ order.id }} has been placed successfully.</p>

            <div class="text-left bg-gray-50 p-4 rounded mb-8">
                <h3 class="font-bold mb-2">Order Details</h3>
                <div v-for="item in order.items" :key="item.id" class="flex justify-between text-sm mb-1">
                    <span>{{ item.product_name }} x {{ item.quantity }}</span>
                    <span>{{ formatCurrency(item.price) }}</span>
                </div>
                <div class="border-t mt-2 pt-2 flex justify-between font-bold">
                    <span>Total</span>
                    <span>{{ formatCurrency(order.total_amount) }}</span>
                </div>
            </div>

            <Link :href="route('shop.index')" class="inline-block bg-[#4A2C2A] text-white px-8 py-3 rounded font-bold hover:bg-opacity-90 transition">
                Continue Shopping
            </Link>
        </div>
    </div>
</template>
