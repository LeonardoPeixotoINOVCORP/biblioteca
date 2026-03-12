<script setup>
import { ref, computed } from 'vue'
import { Link } from '@inertiajs/vue3'

const props = defineProps({
    items: Array, // livros ou autores
    type: String // 'book' ou 'author'
})

const visibleCount = 3
const startIndex = ref(0)

const visibleItems = computed(() => props.items.slice(startIndex.value, startIndex.value + visibleCount))

const prev = () => {
    startIndex.value = Math.max(startIndex.value - visibleCount, 0)
}

const next = () => {
    startIndex.value = Math.min(startIndex.value + visibleCount, props.items.length - visibleCount)
}
</script>

<template>
    <div class="relative w-full">
        <div class="flex space-x-4 overflow-hidden">
            <div v-for="item in visibleItems" :key="item.id" class="flex-1 border rounded p-4 text-center bg-gray-50 shadow-sm">
                <Link v-if="type === 'book'" :href="route('books.show', item.id)" class="font-medium hover:underline">
                    {{ item.title }}
                </Link>
                <Link v-else-if="type === 'author'" :href="route('authors.show', item.id)" class="font-medium hover:underline">
                    {{ item.name }}
                </Link>
            </div>
        </div>

        <!-- Setas -->
        <button
            @click="prev"
            class="absolute left-0 top-1/2 -translate-y-1/2 bg-gray-200 rounded-full p-2 hover:bg-gray-300 transition"
            :disabled="startIndex === 0"
        >
            ‹
        </button>
        <button
            @click="next"
            class="absolute right-0 top-1/2 -translate-y-1/2 bg-gray-200 rounded-full p-2 hover:bg-gray-300 transition"
            :disabled="startIndex + visibleCount >= items.length"
        >
            ›
        </button>
    </div>
</template>