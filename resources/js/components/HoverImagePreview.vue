<script setup lang="ts">
import { ref } from 'vue';

const props = defineProps<{
    src: string;
    alt?: string;
    imageClass?: string;
}>();

const showPreview = ref(false);

const openPreview = () => {
    showPreview.value = true;
};

const closePreview = () => {
    showPreview.value = false;
};
</script>

<template>
    <div class="relative inline-block cursor-pointer" @click="openPreview">
        <img :src="src" :alt="alt" :class="imageClass" />

        <Teleport to="body">
            <Transition
                enter-active-class="transition ease-out duration-300"
                enter-from-class="opacity-0"
                enter-to-class="opacity-100"
                leave-active-class="transition ease-in duration-200"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0"
            >
                <div
                    v-if="showPreview"
                    class="fixed inset-0 z-[100] flex items-center justify-center bg-black bg-opacity-50 p-4"
                    @click.stop="closePreview"
                >
                    <div class="bg-white p-2 rounded-lg shadow-2xl max-w-3xl max-h-[90vh] overflow-auto" @click.stop>
                        <img :src="src" class="max-w-full max-h-[85vh] rounded object-contain" />
                        <button
                            @click="closePreview"
                            class="absolute top-4 right-4 text-white bg-black bg-opacity-50 hover:bg-opacity-75 rounded-full p-2 focus:outline-none"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </Transition>
        </Teleport>
    </div>
</template>
