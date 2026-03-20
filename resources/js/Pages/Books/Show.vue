<script setup>
import { Link } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import PageHeader from '@/Components/PageHeader.vue'
import ActionLinks from '@/Components/ActionLinks.vue'

const props = defineProps({
    book: Object,
    requests: Array,
})

const statusColor = (status) => ({
    pendente:  'bg-yellow-100 text-yellow-800',
    aprovada:  'bg-green-100 text-green-800',
    devolvida: 'bg-blue-100 text-blue-800',
    rejeitada: 'bg-red-100 text-red-800',
}[status] ?? '')
</script>

<template>
    <AppLayout :title="book.title">
        <template #header>
            <PageHeader :title="book.title">
                <template #actions>
                    <div class="flex items-center gap-3">
                        <Link
                            v-if="book.available"
                            :href="route('book-requests.store')"
                            method="post"
                            :data="{ book_id: book.id }"
                            as="button"
                            class="px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700 transition font-semibold"
                        >
                            Requisitar
                        </Link>
                        <ActionLinks
                            v-if="$page.props.auth.roles.includes('admin')"
                            :edit-route="route('books.edit', book.id)"
                            :delete-route="route('books.destroy', book.id)"
                        />
                    </div>
                </template>
            </PageHeader>
        </template>

        <div class="max-w-5xl mx-auto py-10 px-4 sm:px-6 lg:px-8 space-y-10">

            
            <div class="bg-white border border-gray-100 rounded-2xl shadow-md overflow-hidden">
                <div class="flex flex-col md:flex-row">

                    <!-- Capa -->
                    <div class="md:w-64 shrink-0 bg-gray-50 flex items-center justify-center border-b md:border-b-0 md:border-r border-gray-100">
                        <img
                            v-if="book.cover"
                            :src="`/storage/${book.cover}`"
                            :alt="book.title"
                            class="w-full max-w-[250px] max-h-[230px] rounded-xl shadow-md object-cover"
                        />
                        <div v-else class="w-40 h-56 bg-gray-200 rounded-xl flex items-center justify-center text-sm text-gray-400">
                            Sem capa
                        </div>
                    </div>

                    <!-- Informações -->
                    <div class="flex-1 p-8 flex flex-col gap-5">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900 leading-tight mb-1">{{ book.title }}</h1>

                            <!-- Autores -->
                            <div class="flex flex-wrap items-center gap-2 mt-3">
                                <template v-for="(author, index) in book.authors" :key="author.id">
                                    <div class="flex items-center gap-1.5">
                                        <img
                                            v-if="author.photo"
                                            :src="`/storage/${author.photo}`"
                                            :alt="author.name"
                                            class="w-6 h-6 rounded-full object-cover ring-1 ring-gray-200"
                                        />
                                        <Link
                                            :href="route('authors.show', author.id)"
                                            class="text-sm text-gray-600 hover:text-amber-700 hover:underline transition-colors"
                                        >
                                            {{ author.name }}
                                        </Link>
                                        <span v-if="index < book.authors.length - 1" class="text-gray-300">·</span>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- Divider -->
                        <div class="border-t border-gray-100"></div>

                        <!-- Metadados em grid -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                            <!-- Editora -->
                            <div class="flex flex-col gap-1">
                                <span class="text-xs font-semibold uppercase tracking-widest text-gray-400">Editora</span>
                                <template v-if="book.publisher">
                                    <div class="flex items-center gap-2">
                                        <img
                                            v-if="book.publisher.logo"
                                            :src="`/storage/${book.publisher.logo}`"
                                            :alt="book.publisher.name"
                                            class="w-6 h-6 rounded-full object-cover ring-1 ring-gray-200"
                                        />
                                        <Link
                                            :href="route('publishers.show', book.publisher.id)"
                                            class="text-sm text-gray-700 hover:text-amber-700 hover:underline transition-colors"
                                        >
                                            {{ book.publisher.name }}
                                        </Link>
                                    </div>
                                </template>
                                <span v-else class="text-sm text-gray-400">—</span>
                            </div>

                            <!-- ISBN -->
                            <div class="flex flex-col gap-1">
                                <span class="text-xs font-semibold uppercase tracking-widest text-gray-400">ISBN</span>
                                <span class="text-sm text-gray-700 font-mono">{{ book.isbn }}</span>
                            </div>

                            <!-- Preço -->
                            <div class="flex flex-col gap-1">
                                <span class="text-xs font-semibold uppercase tracking-widest text-gray-400">Preço</span>
                                <span class="text-sm text-gray-800 font-semibold">{{ Number(book.price).toFixed(2) }}€</span>
                            </div>

                            <!-- Disponibilidade -->
                            <div class="flex flex-col gap-1">
                                <span class="text-xs font-semibold uppercase tracking-widest text-gray-400">Disponibilidade</span>
                                <span
                                    :class="book.available
                                        ? 'bg-green-100 text-green-800'
                                        : 'bg-red-100 text-red-800'"
                                    class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-semibold w-fit"
                                >
                                    <span
                                        :class="book.available ? 'bg-green-500' : 'bg-red-500'"
                                        class="w-1.5 h-1.5 rounded-full"
                                    ></span>
                                    {{ book.available ? 'Disponível' : 'Indisponível' }}
                                </span>
                            </div>
                        </div>

                        <!-- Bibliografia -->
                        <div v-if="book.bibliography" class="flex flex-col gap-1">
                            <span class="text-xs font-semibold uppercase tracking-widest text-gray-400">Bibliografia</span>
                            <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-line">{{ book.bibliography }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Histórico de Requisições -->
            <div v-if="$page.props.auth.roles.includes('admin')">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-7 h-7 rounded-lg bg-gray-100 flex items-center justify-center">
                        <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                        </svg>
                    </div>
                    <h2 class="text-xs font-semibold text-gray-400 uppercase tracking-widest">Histórico de Requisições</h2>
                </div>

                <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">
                    <table class="min-w-full text-sm divide-y divide-gray-100">
                        <thead class="bg-gray-50 text-left text-gray-500 uppercase text-xs">
                            <tr>
                                <th class="px-5 py-3 font-semibold tracking-wider">Utilizador</th>
                                <th class="px-5 py-3 font-semibold tracking-wider">Data Requisição</th>
                                <th class="px-5 py-3 font-semibold tracking-wider">Data Limite</th>
                                <th class="px-5 py-3 font-semibold tracking-wider">Data Devolução</th>
                                <th class="px-5 py-3 font-semibold tracking-wider">Estado</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            <tr v-for="req in requests" :key="req.id" class="hover:bg-amber-50 transition-colors">
                                <td class="px-5 py-3 font-medium">
                                    <Link :href="route('users.show', req.user.id)" class="hover:text-amber-700 transition-colors">
                                        {{ req.user.name }}
                                    </Link>
                                </td>
                                <td class="px-5 py-3 text-gray-600">{{ req.requested_at }}</td>
                                <td class="px-5 py-3 text-gray-600">{{ req.due_date ?? '—' }}</td>
                                <td class="px-5 py-3 text-gray-600">{{ req.returned_at ?? '—' }}</td>
                                <td class="px-5 py-3">
                                    <span class="px-2.5 py-1 rounded-md text-xs font-semibold capitalize"
                                        :class="statusColor(req.status)">
                                        {{ req.status }}
                                    </span>
                                </td>
                            </tr>
                            <tr v-if="!requests.length">
                                <td colspan="5" class="px-5 py-8 text-center text-gray-400 text-sm italic">
                                    Sem requisições para este livro.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </AppLayout>
</template>