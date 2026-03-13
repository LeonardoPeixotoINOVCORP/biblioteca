<script setup>
import { Link } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import PageHeader from '@/Components/PageHeader.vue'

defineProps({
    stats: Object
})

const cards = [
{
    label: 'Total de Livros',
    key: 'total_books',
    icon: 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253',
    bg: 'bg-gray-50',
    border: 'border-gray-200',
    text: 'text-gray-800',
    icon_bg: 'bg-gray-200',
    icon_color: 'text-gray-700',
},
{
    label: 'Total de Autores',
    key: 'total_authors',
    icon: 'M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z',
    bg: 'bg-gray-50',
    border: 'border-gray-200',
    text: 'text-gray-800',
    icon_bg: 'bg-gray-200',
    icon_color: 'text-gray-700',
},
{
    label: 'Total de Editoras',
    key: 'total_publishers',
    icon: 'M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21',
    bg: 'bg-gray-50',
    border: 'border-gray-200',
    text: 'text-gray-800',
    icon_bg: 'bg-gray-200',
    icon_color: 'text-gray-700',
}
]

const actions = [
    {
        label: 'Adicionar Autor',
        href: '/author/create',
        desc: 'Cadastrar novo autor',
        icon: 'M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM3 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 019.374 21c-2.331 0-4.512-.645-6.374-1.766z',
        bg: 'bg-gray-800 hover:bg-gray-900',
    },
    {
        label: 'Adicionar Livro',
        href: '/book/create',
        desc: 'Registrar novo livro',
        icon: 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253',
        bg: 'bg-gray-800 hover:bg-gray-900',
    },
    {
        label: 'Adicionar Editora',
        href: '/publisher/create',
        desc: 'Cadastrar nova editora',
        icon: 'M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21',
        bg: 'bg-gray-800 hover:bg-gray-900',
    },
]
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <PageHeader title="Dashboard" />
        </template>

        <div class="py-10 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-10">

            <!-- Metric Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                <div
                    v-for="card in cards"
                    :key="card.key"
                    :class="['rounded-2xl border p-6 flex items-center gap-5 transition-shadow hover:border-amber-400', card.bg, card.border]"
                >
                    <div :class="['w-12 h-12 rounded-xl flex items-center justify-center shrink-0', card.icon_bg]">
                        <svg :class="['w-6 h-6', card.icon_color]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" :d="card.icon" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-widest mb-1">{{ card.label }}</p>
                        <p :class="['text-3xl font-bold leading-none', card.text]">{{ stats[card.key] }}</p>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div>
                <h2 class="text-xs font-semibold text-gray-400 uppercase tracking-widest mb-4">Ações Rápidas</h2>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <Link
                        v-for="action in actions"
                        :key="action.href"
                        :href="action.href"
                        :class="['flex items-center gap-4 rounded-2xl px-5 py-4 text-white transition-all shadow-sm hover:shadow-md active:scale-95', action.bg]"
                    >
                        <div class="w-9 h-9 rounded-lg bg-white/20 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" :d="action.icon" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-sm leading-tight">{{ action.label }}</p>
                            <p class="text-xs text-white/70 mt-0.5">{{ action.desc }}</p>
                        </div>
                    </Link>
                </div>
            </div>

            <!-- Recent Activity -->
            <div>
                <h2 class="text-xs font-semibold text-gray-400 uppercase tracking-widest mb-4">Atividade Recente</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

                    <!-- Últimos Livros -->
                    <div class="bg-white border border-gray-100 rounded-2xl overflow-hidden shadow-sm">
                        <div class="flex items-center gap-3 px-5 py-4 border-b border-gray-100">
                            <div class="w-7 h-7 rounded-lg bg-gray-100 flex items-center justify-center">
                                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                            <h3 class="font-semibold text-sm text-gray-700">Últimos Livros</h3>
                        </div>
                        <ul class="divide-y divide-gray-50">
                            <li v-for="book in stats.latest_books" :key="book.id">
                                <Link
                                    :href="route('books.show', book.id)"
                                    class="flex items-center justify-between px-5 py-3 hover:bg-amber-50 transition-colors group"
                                >
                                <span class="text-sm text-gray-700 group-hover:text-amber-700 truncate transition-colors">{{ book.title }}</span>
                                <img 
                                  v-if="book.cover"
                                  :src="`/storage/${book.cover}`"
                                  :alt="book.title"
                                  class="w-8 h-8 rounded-full shadow-lg object-cover"
                                />
                                </Link>
                            </li>
                            <li v-if="!stats.latest_books?.length" class="px-5 py-4 text-sm text-gray-400 italic">Nenhum livro cadastrado</li>
                        </ul>
                    </div>

                    <!-- Últimos Autores -->
                    <div class="bg-white border border-gray-100 rounded-2xl overflow-hidden shadow-sm">
                        <div class="flex items-center gap-3 px-5 py-4 border-b border-gray-100">
                            <div class="w-7 h-7 rounded-lg bg-gray-100 flex items-center justify-center">
                                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                </svg>
                            </div>
                            <h3 class="font-semibold text-sm text-gray-700">Últimos Autores</h3>
                        </div>
                        <ul class="divide-y divide-gray-50">
                            <li v-for="author in stats.latest_authors" :key="author.id">
                                <Link
                                    :href="route('authors.show', author.id)"
                                    class="flex items-center justify-between px-5 py-3 hover:bg-amber-50 transition-colors group"
                                >
                                    <div class="flex items-center gap-3 min-w-0">
                                        <span class="text-sm text-gray-700 group-hover:text-amber-700 truncate transition-colors">{{ author.name }}</span>     
                                    </div>
                                    <img 
                                  v-if="author.photo"
                                  :src="`/storage/${author.photo}`"
                                  :alt="author.title"
                                  class="w-8 h-8 rounded-full shadow-lg object-cover"
                                />
                                </Link>
                            </li>
                            <li v-if="!stats.latest_authors?.length" class="px-5 py-4 text-sm text-gray-400 italic">Nenhum autor cadastrado</li>
                        </ul>
                    </div>

                    <!-- Últimas Editoras -->
                    <div class="bg-white border border-gray-100 rounded-2xl overflow-hidden shadow-sm">
                        <div class="flex items-center gap-3 px-5 py-4 border-b border-gray-100">
                            <div class="w-7 h-7 rounded-lg bg-gray-100 flex items-center justify-center">
                                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                                </svg>
                            </div>
                            <h3 class="font-semibold text-sm text-gray-700">Últimas Editoras</h3>
                        </div>
                        <ul class="divide-y divide-gray-50">
                            <li v-for="publisher in stats.latest_publishers" :key="publisher.id">
                                <Link
                                    :href="route('publishers.show', publisher.id)"
                                    class="flex items-center justify-between px-5 py-3 hover:bg-amber-50 transition-colors group"
                                >
                                    <div class="flex items-center gap-3 min-w-0">
                                        <span class="text-sm text-gray-700 group-hover:text-amber-700 truncate transition-colors">{{ publisher.name }}</span>     
                                    </div>
                                    <img 
                                  v-if="publisher.logo"
                                  :src="`/storage/${publisher.logo}`"
                                  :alt="publisher.title"
                                  class="w-8 h-8 rounded-full shadow-lg object-cover"
                                />
                                </Link>
                            </li>
                            <li v-if="!stats.latest_publishers?.length" class="px-5 py-4 text-sm text-gray-400 italic">Nenhuma editora cadastrado</li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </AppLayout>
</template>