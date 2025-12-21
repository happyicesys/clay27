<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import HoverImagePreview from '@/components/HoverImagePreview.vue';
import { ref, watch } from 'vue';
import { ChevronUp, ChevronDown } from 'lucide-vue-next';
import { formatCurrency } from '@/lib/utils';

const props = defineProps<{
    products: Array<{
        id: number;
        name: string;
        price: number;
        stock: number;
        is_active: boolean;
        image_path: string | null;
        image_url: string | null;
        category?: {
            id: number;
            name: string;
        };
    }>;
    categories: Array<{ id: number; name: string }>;
    filters: {
        search?: string;
        category?: string;
        sort_field?: string;
        sort_direction?: string;
    };
}>();

const search = ref(props.filters.search || '');
const selectedCategory = ref(props.filters.category || '');
const sortField = ref(props.filters.sort_field || 'sequence');
const sortDirection = ref(props.filters.sort_direction || 'asc');

const deleteProduct = (id: number) => {
    if (confirm('Are you sure?')) {
        router.delete(route('admin.products.destroy', id));
    }
};

const handleSort = (field: string) => {
    if (sortField.value === field) {
        sortDirection.value = sortDirection.value === 'asc' ? 'desc' : 'asc';
    } else {
        sortField.value = field;
        sortDirection.value = 'asc';
    }
    applyFilters();
};

const applyFilters = () => {
    router.get(route('admin.products.index'), {
        search: search.value,
        category: selectedCategory.value,
        sort_field: sortField.value,
        sort_direction: sortDirection.value,
    }, { preserveState: true, replace: true });
};

const clearFilters = () => {
    router.get(route('admin.products.index'));
};

// Debounce search
let timeout: ReturnType<typeof setTimeout>;
watch(search, (newVal) => {
    clearTimeout(timeout);
    timeout = setTimeout(() => {
        applyFilters();
    }, 300);
});

watch(selectedCategory, () => {
    applyFilters();
});
</script>

<template>
    <Head title="Products" />

    <AppLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        Products ({{ products.length }})
                    </h2>
                    <Link :href="route('admin.products.create')" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Create Product
                    </Link>
                </div>

                <!-- Filters -->
                <div class="bg-white p-4 mb-6 rounded-lg shadow flex gap-4 items-center">
                    <input
                        v-model="search"
                        type="text"
                        placeholder="Search products..."
                        class="border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 flex-1"
                    >
                    <select
                        v-model="selectedCategory"
                        class="border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 w-1/4"
                    >
                        <option value="">All Categories</option>
                        <option v-for="category in categories" :key="category.id" :value="category.id">
                            {{ category.name }}
                        </option>
                    </select>

                    <button
                        @click="clearFilters"
                        class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-2 px-4 rounded whitespace-nowrap"
                    >
                        Clear Filter
                    </button>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>

                                    <th @click="handleSort('name')" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100">
                                        <div class="flex items-center gap-1">
                                            Name
                                            <div v-if="sortField === 'name'" class="flex flex-col">
                                                <ChevronUp v-if="sortDirection === 'asc'" class="w-3 h-3" />
                                                <ChevronDown v-else class="w-3 h-3" />
                                            </div>
                                        </div>
                                    </th>

                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>

                                    <th @click="handleSort('price')" class="px-6 py-3 bg-gray-50 text-right text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100">
                                        <div class="flex items-center justify-end gap-1">
                                            Price
                                            <div v-if="sortField === 'price'" class="flex flex-col">
                                                <ChevronUp v-if="sortDirection === 'asc'" class="w-3 h-3" />
                                                <ChevronDown v-else class="w-3 h-3" />
                                            </div>
                                        </div>
                                    </th>

                                    <th @click="handleSort('stock')" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100">
                                        <div class="flex items-center gap-1">
                                            Stock
                                            <div v-if="sortField === 'stock'" class="flex flex-col">
                                                <ChevronUp v-if="sortDirection === 'asc'" class="w-3 h-3" />
                                                <ChevronDown v-else class="w-3 h-3" />
                                            </div>
                                        </div>
                                    </th>

                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 bg-gray-50 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="product in products" :key="product.id">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <HoverImagePreview
                                            v-if="product.image_url"
                                            :src="product.image_url"
                                            alt="Product Image"
                                            image-class="h-12 w-12 object-cover rounded cursor-zoom-in"
                                        />
                                        <div v-else class="h-12 w-12 bg-gray-200 rounded flex items-center justify-center text-gray-400 text-xs">No Img</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ product.name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-500">{{ product.category?.name || '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">{{ formatCurrency(product.price) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ product.stock }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span :class="product.is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full">
                                            {{ product.is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <Link :href="route('admin.products.edit', product.id)" class="text-indigo-600 hover:text-indigo-900 mr-4">Edit</Link>
                                        <button @click="deleteProduct(product.id)" class="text-red-600 hover:text-red-900">Delete</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
