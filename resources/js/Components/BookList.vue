<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
    books: Array
})
</script>

<template>
<div v-if="books?.length">

    <p class="text-xl font-semibold text-gray-900 mb-2">
        Livros
    </p>

    <div class="flex flex-col gap-2">
        <Link
            v-for="book in books"
            :key="book.id"
            :href="route('books.show', book.id)"
            class="flex items-center gap-3 px-3 py-2 bg-gray-100 text-gray-700 text-lg hover:underline hover:text-gray-500"
        >

            <img
                v-if="book.cover"
                :src="`/storage/${book.cover}`"
                class="w-10 h-14 object-cover rounded shadow-sm flex-shrink-0"
            />

            <div
                v-else
                class="w-10 h-14 bg-gray-300 rounded shadow-sm flex-shrink-0"
            />

            <span>{{ book.title }}</span>

        </Link>
    </div>

</div>
</template>
