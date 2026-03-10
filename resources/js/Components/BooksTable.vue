<script setup>
import { Link } from '@inertiajs/vue3'

const props = defineProps({
    books: Array,
    sort: String,
})

const emit = defineEmits(['sort'])

// Devolve o ícone de ordenação para cada coluna
function sortIcon(field) {
    if (props.sort === `${field}_asc`) return '↑'
    if (props.sort === `${field}_desc`) return '↓'
    return '↕'
}

// Ao clicar num cabeçalho, alterna entre asc/desc
function toggleSort(field) {
    if (props.sort === `${field}_asc`) {
        emit('sort', `${field}_desc`)
    } else {
        emit('sort', `${field}_asc`)
    }
}
</script>

<template>
    <div class="rounded-xl shadow ">
        <table class="min-w-full divide-y divide-gray-200 bg-white text-sm table-fixed">
            <colgroup>
                <col class="w-16">
                <col class="w-36">
                <col class="w-56">
                <col class="w-auto">
                <col class="w-44">
                <col class="w-24">
            </colgroup>
            <thead class="bg-gray-50">
                <tr>
                    <!-- Capa -->
                    <th class="px-4 py-3 text-left font-semibold text-gray-600 uppercase tracking-wider w-16">
                        Capa
                    </th>

                    <!-- ISBN -->
                    <th class="px-4 py-3 text-left font-semibold text-gray-600 uppercase tracking-wider">
                        ISBN
                    </th>

                    <!-- Título ordenável -->
                    <th
                        class="px-4 py-3 text-left font-semibold text-gray-600 uppercase tracking-wider cursor-pointer select-none hover:text-gray-800 transition"
                        @click="toggleSort('title')"
                    >
                        Título
                        <span class="ml-1 text-gray-400">{{ sortIcon('title') }}</span>
                    </th>

                    <!-- Autores -->
                    <th class="px-4 py-3 text-left font-semibold text-gray-600 uppercase tracking-wider">
                        Autores
                    </th>

                    <!-- Editora -->
                    <th class="px-4 py-3 text-left font-semibold text-gray-600 uppercase tracking-wider">
                        Editora
                    </th>

                    <!-- Preço ordenável -->
                    <th
                        class="px-4 py-3 text-left font-semibold text-gray-600 uppercase tracking-wider cursor-pointer select-none hover:text-gray-800 transition"
                        @click="toggleSort('price')"
                    >
                        Preço
                        <span class="ml-1 text-gray-400">{{ sortIcon('price') }}</span>
                    </th>

                </tr>
            </thead>
            
            <tbody class="divide-y divide-gray-200">
                <tr
                    v-for="book in books"
                    :key="book.id"
                    class="hover:bg-gray-50 transition"
                >
                    <!-- Capa miniatura -->
                    <td class="px-4 py-3">
                        <img
                            :src="book.cover"
                            :alt="book.title"
                            class="h-14 w-10 object-cover rounded shadow"
                        />
                    </td>

                    <!-- ISBN -->
                    <td class="px-4 py-3 text-gray-500 font-mono text-xs">
                        {{ book.isbn ?? '—' }}
                    </td>

                    <!-- Título -->
                    <td class="px-4 py-3 font-medium text-gray-900">
                        {{ book.title }}
                    </td>

                    <!-- Autores -->
                    <td class="px-4 py-3 text-gray-600">
                        <span v-for="(author, index) in book.authors" :key="author.id">
                            {{ author.name }}<span v-if="index < book.authors.length - 1">, </span>
                        </span>
                    </td>

                    <!-- Editora -->
                    <td class="px-4 py-3 text-gray-600">
                        {{ book.publisher?.name ?? '—' }}
                    </td>

                    <!-- Preço -->
                    <td class="px-4 py-3 text-gray-800 font-semibold">
                        {{ book.price }}€
                    </td>

                </tr>

                <!-- Estado vazio -->
                <tr v-if="!books || books.length === 0">
                    <td colspan="7" class="px-4 py-10 text-center text-gray-400">
                        Nenhum livro encontrado.
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>