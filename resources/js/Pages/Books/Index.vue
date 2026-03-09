<script setup>
defineProps({
    books: Array
})
import AppLayout from '@/Layouts/AppLayout.vue';
</script>

<template>
    <AppLayout title="Livros">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Livros
            </h2>
        </template>

        <div class="max-w-7xl max-h-7xl mx-auto py-8 px-4 grid gap-6 md:grid-cols-2 lg:grid-cols-3 ">
            <div 
            v-for="book in books" 
            :key="book.id"
            class="bg-white shadow-md rounded-xl p-6 hover:shadow-lg transition "
            >

            <div>
                <img :src="book.cover" :alt="book.title" class="w-full h-96 object-cover rounded-lg mb-4">

                <h2 class="text-lg font-bold text-gray-900 mb-2">
                    {{ book.title }}
                </h2>
                
                <p class="text-sm text-gray-600 mb-4 pb-4 border-b border-black/10">
                    <span 
                    v-for="(author, index) in book.authors"
                    :key="author.id"
                    >
                        {{ author.name }}<span v-if="index < book.authors.length - 1">, </span>
                    </span>
                </p>

                <div class="justify-between flex">
                    <p class="text-gray-600">
                        Preço: {{ book.price }}€
                    </p>
                    
                    <p class="text-sm text-gray-600">
                        Editora: {{ book.publisher.name }}
                    </p>
                </div>
    
                <!-- <p class="text-sm text-gray-600 mt-2 line-clamp-1 hover:line-clamp-5 transition duration-300">
                    Bibliografia: {{ book.bibliography }}
                </p>

                <p class="text-sm text-gray-600">
                    ISBN: {{ book.isbn }}
                </p>
     -->
            </div>

        </div>
    </div>
</AppLayout>
</template>
