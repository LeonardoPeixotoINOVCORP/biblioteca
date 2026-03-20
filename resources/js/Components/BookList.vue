<script setup>
import { Link } from '@inertiajs/vue3'
defineProps({
    books: Array
})
</script>

<template>
    <div v-if="books?.length" class="divide-y divide-gray-50">
        <Link
            v-for="book in books"
            :key="book.id"
            :href="route('books.show', book.id)"
            class="flex items-center gap-4 px-5 py-3 hover:bg-amber-50 transition-colors group"
        >
            <!-- Capa -->
            <div class="shrink-0">
                <img
                    v-if="book.cover"
                    :src="`/storage/${book.cover}`"
                    :alt="book.title"
                    class="w-12 h-16 object-cover rounded shadow-sm"
                />
                <div
                    v-else
                    class="w-12 h-16 bg-gray-200 rounded shadow-sm flex items-center justify-center"
                >
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
            </div>

            <!-- Título -->
            <span class="text-sm text-gray-700 group-hover:text-amber-700 transition-colors truncate">
                {{ book.title }}
            </span>

            <!-- Seta -->
            <svg class="w-4 h-4 text-gray-300 group-hover:text-amber-400 transition-colors ml-auto shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
            </svg>
        </Link>
    </div>

    <div v-else class="px-5 py-8 text-center text-sm text-gray-400 italic">
        Nenhum livro associado.
    </div>
</template>