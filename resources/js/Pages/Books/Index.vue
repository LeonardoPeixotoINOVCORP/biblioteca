<script setup>
import Pagination from '@/Components/Pagination.vue'
import BooksTable from '@/Components/BooksTable.vue'
import { Link, router } from '@inertiajs/vue3'
import { ref, watch } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import PageHeader from '@/Components/PageHeader.vue'

const props = defineProps({
    books: Object,
    filters: Object,
})

const search    = ref(props.filters?.search    ?? '')
const sort      = ref(props.filters?.sort      ?? 'latest')
const price_min = ref(props.filters?.price_min ?? '')
const price_max = ref(props.filters?.price_max ?? '')

// Debounce genérico
let debounce = null
function scheduleApply() {
    clearTimeout(debounce)
    debounce = setTimeout(applyFilters, 400)
}

watch(search,    scheduleApply)
watch(price_min, scheduleApply)
watch(price_max, scheduleApply)
watch(sort, applyFilters)          // ordenação aplica imediatamente

function applyFilters() {
    router.get(route('books'), {
        search:    search.value,
        sort:      sort.value,
        price_min: price_min.value,
        price_max: price_max.value,
    }, {
        preserveState: true,
        preserveScroll: true,
    })
}

// Recebe o evento de ordenação vindo do BooksTable
function handleSort(newSort) {
    sort.value = newSort
}
</script>

<template>
    <AppLayout title="Livros">
        <template #header>
            <PageHeader title="Livros">
                <template #actions>
                <Link
                    :href="route('books.create')"
                    class="flex items-center px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700 transition"
                >
                    Criar um livro
                </Link>
        </template>
      </PageHeader>
    </template>

        <div class="max-w-7xl mx-auto px-4 py-8 space-y-6">

            <!-- Barra de filtros -->
            <div class="flex flex-wrap items-center gap-3">

                <!-- Pesquisa -->
                <input
                    v-model="search"
                    type="text"
                    placeholder="Título, autor, editora..."
                    class="rounded-lg border-gray-300 shadow-sm text-sm flex-1 min-w-48"
                />

                <!-- Ordenação -->
                <select v-model="sort" class="rounded-lg border-gray-300 shadow-sm text-sm">
                    <option value="latest">Mais Recente</option>
                    <option value="oldest">Mais Antigo</option>
                    <option value="title_asc">Título (A→Z)</option>
                    <option value="title_desc">Título (Z→A)</option>
                    <option value="price_asc">Preço ↑</option>
                    <option value="price_desc">Preço ↓</option>
                </select>

                <!-- Filtro de preço -->
                <div class="flex items-center gap-2">
                    <input
                        v-model="price_min"
                        type="number"
                        min="0"
                        placeholder="Min €"
                        class="rounded-lg border-gray-300 shadow-sm text-sm w-24"
                    />
                    <span class="text-gray-400 text-sm">—</span>
                    <input
                        v-model="price_max"
                        type="number"
                        min="0"
                        placeholder="Max €"
                        class="rounded-lg border-gray-300 shadow-sm text-sm w-24"
                    />
                </div>
            </div>

            <!-- Tabela -->
            <BooksTable
                v-if="books?.data"
                :books="books.data"
                :sort="sort"
                @sort="handleSort"
            />

            <!-- Paginação -->
            <Pagination :books="books" />

        </div>
    </AppLayout>
</template>