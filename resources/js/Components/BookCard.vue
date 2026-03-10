<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
    book: Object
})
</script>

<template>
    <div class="bg-white shadow-md rounded-xl p-6 hover:-translate-y-1 hover:shadow-lg transition duration-150">
        <Link :href="route('books.show', book.id)">
            <img :src="book.cover" :alt="book.title" class="w-full h-48 object-fill rounded-lg mb-4">
        </Link>
        <h2 class="text-lg font-bold text-gray-900 mb-2">{{ book.title }}</h2>
        <p class="text-sm text-gray-600 mb-4 pb-4 border-b border-black/10">
            <span v-for="(author, index) in book.authors" :key="author.id">
                {{ author.name }}<span v-if="index < book.authors.length - 1">, </span>
            </span>
        </p>
        <div class="flex justify-between items-center">
            <p class="text-sm text-gray-600">Preço: {{ book.price }}€</p>
            <p class="text-sm text-gray-600">{{ book.publisher.name }}</p>
        </div>
    </div>
</template>