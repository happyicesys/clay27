<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ShoppingCart, Menu } from 'lucide-vue-next';
import { formatCurrency } from '@/lib/utils';

const props = defineProps<{
    cart: {
        items: Array<{
            id: number;
            quantity: number;
            product: {
                name: string;
                price: number;
            };
        }>;
    };
}>();

const form = useForm({
    email: '',
    name: '',
    address: '',
    city: '',
    zip: '',
});

const submit = () => {
    form.post(route('checkout.store'));
};

const total = (items: any[]) => {
    return items.reduce((acc, item) => acc + item.quantity * item.product.price, 0).toFixed(2);
};
</script>

<template>
    <Head title="Checkout" />

    <div class="min-h-screen bg-[#F9F5F1] text-[#4A2C2A]">
        <header class="flex justify-between items-center p-6">
            <Link :href="route('home')" class="text-2xl font-bold tracking-widest">CLAY27</Link>
            <div class="flex gap-4">
                <Menu class="w-6 h-6 cursor-pointer" />
                <ShoppingCart class="w-6 h-6 cursor-pointer" />
            </div>
        </header>

        <div class="px-6 py-8 max-w-4xl mx-auto">
            <h1 class="text-3xl font-serif mb-8">Checkout</h1>

            <div class="grid md:grid-cols-2 gap-8">
                <!-- Order Summary -->
                <div class="bg-white p-6 rounded-lg shadow h-fit">
                    <h2 class="text-xl font-bold mb-4">Order Summary</h2>
                    <div v-for="item in cart.items" :key="item.id" class="flex justify-between mb-2 text-sm">
                        <span>{{ item.product.name }} x {{ item.quantity }}</span>
                        <span>{{ formatCurrency(item.product.price * item.quantity) }}</span>
                    </div>
                    <div class="border-t mt-4 pt-4 flex justify-between font-bold text-lg">
                        <span>Total</span>
                        <span>{{ formatCurrency(total(cart.items)) }}</span>
                    </div>
                </div>

                <!-- Customer Details Form -->
                <div class="bg-white p-6 rounded-lg shadow">
                    <h2 class="text-xl font-bold mb-4">Shipping Details</h2>
                    <form @submit.prevent="submit">
                        <div class="mb-4">
                            <label class="block text-sm font-bold mb-2" for="email">Email</label>
                            <input v-model="form.email" id="email" type="email" class="w-full border rounded px-3 py-2" required>
                            <div v-if="form.errors.email" class="text-red-500 text-xs mt-1">{{ form.errors.email }}</div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-bold mb-2" for="name">Full Name</label>
                            <input v-model="form.name" id="name" type="text" class="w-full border rounded px-3 py-2" required>
                            <div v-if="form.errors.name" class="text-red-500 text-xs mt-1">{{ form.errors.name }}</div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-bold mb-2" for="address">Address</label>
                            <input v-model="form.address" id="address" type="text" class="w-full border rounded px-3 py-2" required>
                            <div v-if="form.errors.address" class="text-red-500 text-xs mt-1">{{ form.errors.address }}</div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-bold mb-2" for="city">City</label>
                                <input v-model="form.city" id="city" type="text" class="w-full border rounded px-3 py-2" required>
                                <div v-if="form.errors.city" class="text-red-500 text-xs mt-1">{{ form.errors.city }}</div>
                            </div>
                            <div>
                                <label class="block text-sm font-bold mb-2" for="zip">Zip Code</label>
                                <input v-model="form.zip" id="zip" type="text" class="w-full border rounded px-3 py-2" required>
                                <div v-if="form.errors.zip" class="text-red-500 text-xs mt-1">{{ form.errors.zip }}</div>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-[#4A2C2A] text-white py-3 rounded font-bold hover:bg-opacity-90 transition" :disabled="form.processing">
                            Pay Now
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
