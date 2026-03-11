<script setup>
import { Link } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import PageHeader from '@/Components/PageHeader.vue'

const props = defineProps({
    book: Object
})
</script>

<template>
    <AppLayout :title="book.title">
        <template #header>
            <PageHeader :title="book.title"/>
        </template>

        <!-- Conteúdo do livro -->
        <div class="max-w-5xl mx-auto py-8">
            <div class="flex flex-col md:flex-row gap-6">

                <!-- Capa do livro -->
                <div class="md:w-1/3">
                    <img 
                        v-if="book.cover"
                        :src="`/storage/${book.cover}`"
                        :alt="book.title"
                        class="w-full rounded shadow-lg object-cover"
                    />
                    <div v-else class="w-full h-64 bg-gray-200 flex items-center justify-center rounded">
                        Sem capa
                    </div>
                </div>

                <!-- Informações -->
                <div class="md:w-2/3 flex flex-col gap-4">
                    <h1 class="text-3xl font-bold text-gray-900">{{ book.title }}</h1>

                    <p class="text-gray-700">
                        <span><strong>{{ book.authors.length > 1 ? 'Autores' : 'Autor' }}: </strong> </span>
                        <span 
                        v-for="(author, index) in book.authors" 
                        :key="author.id">
                            {{ author.name }}<span 
                            v-if="index < book.authors.length - 1"
                            >, 
                        </span>
                        </span>
                    </p>

                    <p class="text-gray-700"><strong>Editora:</strong> {{ book.publisher?.name ?? '—' }}</p>
                    <p class="text-gray-700"><strong>ISBN:</strong> {{ book.isbn }}</p>
                    <p class="text-gray-800 font-semibold"><strong>Preço:</strong> {{ Number(book.price).toFixed(2) }}€</p>

                    <div>
                        <h2 class="text-xl font-semibold mt-4 mb-2">Bibliografia</h2>
                        <p class="text-gray-700whitespace-pre-line break-words">{{ book.bibliography }}</p>
                    </div>

                    <div class="flex gap-2 font-semibold">
                        <Link :href="route('books.edit', book.id)"  class="rounded-xl px-4 py-2 bg-gray-800 text-gray-100 hover:bg-gray-600 transition duration-150">
                            Editar
                        </Link>
                        <Link 
                        :href="route('books.destroy', book.id)"
                        method="delete"
                        class="rounded-xl px-4 py-2 text-red-800 bg-gray-100 border border-gray-300 hover:bg-gray-300 transition duration-150">
                            Remover
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>