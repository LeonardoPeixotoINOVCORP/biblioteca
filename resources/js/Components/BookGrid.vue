<script setup>
import BookCard from '@/Components/BookCard.vue'

defineProps({
    books: Array
})
</script>

<template>
    <div class="max-w-5xl mx-auto py-8 px-4 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
        <BookCard v-for="book in books" :key="book.id" :book="book" />
    </div>
</template>