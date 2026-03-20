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
        <table class="min-w-full w-full divide-y divide-gray-200 bg-white text-sm table-fixed">
            <colgroup>
                <col class="w-[100px]">
                <col class="w-[160px]">
                <col class="w-[250px]">
                <col class="w-[250px]">
                <col class="w-[160px]">
                <col class="w-[100px]">
                <col class="w-[160px]">
                <col v-if="$page.props.auth.roles.includes('admin')" class="w-[200px]">
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

                    <!-- Disponibilidade -->
                    <th class="px-4 py-3 text-center font-semibold text-gray-600 uppercase tracking-wider">
                        Disponibilidade
                    </th>

                    <!-- Ações -->
                    <th v-if="$page.props.auth.roles.includes('admin')" class="px-4 py-3 text-center font-semibold text-gray-600 uppercase tracking-wider">
                        Ações
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
                        <Link :href="route('books.show', book.id)">
                            <img
                            :src="book.cover"
                            :alt="book.title"
                            class="h-20 w-30 object-cover rounded shadow"
                        />
                        </Link>
                    </td>

                    <!-- ISBN -->
                    <td class="px-4 py-3 text-gray-500 font-mono text-xs">
                        {{ book.isbn ?? '—' }}
                    </td>

                    <!-- Título -->
                    <td class="px-4 py-3 font-medium text-gray-900 truncate max-w-0 hover:text-blue-900">
                        <Link :href="route('books.show', book.id)">
                            {{ book.title }}
                        </Link>
                    </td>

                    <!-- Autores -->
                    <td class="px-4 py-3 text-gray-600 truncate max-w-0">
                        <span v-for="(author, index) in book.authors" :key="author.id">
                            <Link :href="route('authors.show', author.id)">
                            {{ author.name }}<span v-if="index < book.authors.length - 1">, </span>
                            </Link>
                        </span>
                    </td>

                    <!-- Editora -->
                    <td class="px-4 py-3 text-gray-600">
                        <Link 
                            v-if="book.publisher"
                            :href="route('publishers.show', book.publisher.id)"
                        >
                            {{ book.publisher.name }}
                        </Link>

                        <span v-else>—</span>
                    </td>

                    <!-- Preço -->
                    <td class="px-4 py-3 text-gray-800 font-semibold">
                        {{ Number(book.price).toFixed(2) }}€
                    </td>

                    <!-- Preço -->
                    <td class="px-4 py-3 text-gray-800 font-semibold text-center">
                        {{ book.available ? "Disponivel" : "Indisponível"}}
                    </td>
                    
                    <!-- Ações -->
                    <td v-if="$page.props.auth.roles.includes('admin')" class="px-4 py-3 font-semibold">
                        <div class="flex gap-2 justify-center">
                            <Link :href="route('books.edit', book.id)"  class="rounded-md px-3 py-1 bg-gray-800 text-gray-100 hover:bg-gray-600 transition duration-150">
                                Editar
                            </Link>
                            <Link 
                            :href="route('books.destroy', book.id)"
                            method="delete"
                            class="rounded-md px-3 py-1 text-red-800 bg-gray-100 border border-gray-300 hover:bg-gray-300 transition duration-150">
                                Remover
                                
                            </Link>
                        </div>
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