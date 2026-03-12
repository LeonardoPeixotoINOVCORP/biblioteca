<script setup>
import { Link } from '@inertiajs/vue3'
const props = defineProps({
    books: Array
})
</script>

<template>
    <p v-if="books.length" class="text-xl text-gray-700">
        <strong class="text-gray-900">Livros: </strong>
        <span v-for="book in books" :key="book.id">
            <Link :href="route('books.show', book.id)" class="text-gray-700 hover:underline font-medium">
                {{ book.title }}
            </Link><span v-if="book !== books.at(-1)">, </span>
        </span>
    </p>
</template>