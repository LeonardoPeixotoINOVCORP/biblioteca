<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import PageHeader from '@/Components/PageHeader.vue'
import ImageCard from '@/Components/ImageCard.vue'
import BookList from '@/Components/BookList.vue'
import ActionLinks from '@/Components/ActionLinks.vue'

const props = defineProps({
    publisher: Object,
})
</script>

<template>
    <AppLayout :title="publisher.name">
        <template #header>
            <PageHeader :title="publisher.name">
                <template #actions>
                    <ActionLinks
                        v-if="$page.props.auth.roles.includes('admin')"
                        :edit-route="route('publishers.edit', publisher.id)"
                        :delete-route="route('publishers.destroy', publisher.id)"
                    />
                </template>
            </PageHeader>
        </template>

        <div class="max-w-5xl mx-auto py-10 px-4 sm:px-6 lg:px-8 space-y-8">

            <!-- Bloco principal -->
            <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">
                <div class="flex flex-col md:flex-row">

                    <!-- Logo -->
                    <div class="md:w-56 shrink-0 bg-gray-50 border-b md:border-b-0 md:border-r border-gray-100 min-h-[220px]">
                        <ImageCard
                            :src="publisher.logo"
                            :alt="publisher.name"
                            fallback-text="Sem logo"
                        />
                    </div>

                    <!-- Informações -->
                    <div class="flex-1 p-8 flex flex-col justify-center gap-4">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-widest text-gray-400 mb-1">Editora</p>
                            <h1 class="text-3xl font-bold text-gray-900 leading-tight">{{ publisher.name }}</h1>
                        </div>

                        <div class="border-t border-gray-100"></div>

                        <div class="flex flex-col gap-1">
                            <span class="text-xs font-semibold uppercase tracking-widest text-gray-400">Livros publicados</span>
                            <span class="text-sm text-gray-700">
                                {{ publisher.books?.length ?? 0 }} {{ publisher.books?.length === 1 ? 'livro' : 'livros' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Lista de livros -->
            <div v-if="publisher.books?.length">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-7 h-7 rounded-lg bg-gray-100 flex items-center justify-center">
                        <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <h2 class="text-xs font-semibold text-gray-400 uppercase tracking-widest">Livros</h2>
                </div>

                <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">
                    <BookList :books="publisher.books" />
                </div>
            </div>

            <div v-else class="bg-white border border-gray-100 rounded-2xl shadow-sm px-6 py-10 text-center text-sm text-gray-400 italic">
                Nenhum livro associado a esta editora.
            </div>

        </div>
    </AppLayout>
</template>