<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import PageHeader from '@/Components/PageHeader.vue'
import { useForm } from '@inertiajs/vue3'

const props = defineProps({
    books: Array,
})

const form = useForm({
    book_id: '',
})

const submit = () => {
    form.post(route('book-requests.store'))
}
</script>

<template>
    <AppLayout title="Requisitar Livro">
        <template #header>
            <PageHeader title="Requisitar um livro" />
        </template>

        <div class="max-w-xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
            <form @submit.prevent="submit" class="space-y-5">

                <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6 space-y-4">

                    <div class="space-y-2">
                        <label class="text-xs font-semibold uppercase tracking-widest text-gray-400">Livro</label>
                        <select
                            v-model="form.book_id"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-300 transition bg-white"
                        >
                            <option value="">Selecione um livro</option>
                            <option v-for="book in books" :key="book.id" :value="book.id">
                                {{ book.title }}
                            </option>
                        </select>
                        <p v-if="form.errors.book_id" class="text-red-500 text-xs">{{ form.errors.book_id }}</p>
                    </div>

                    <p class="text-xs text-gray-400">
                        Só são apresentados livros disponíveis para requisição. O prazo de devolução é de 5 dias após a aprovação.
                    </p>
                </div>

                <div class="flex justify-end">
                    <button
                        type="submit"
                        :disabled="form.processing || !form.book_id"
                        class="px-6 py-2.5 bg-gray-800 text-white text-sm font-semibold rounded-lg hover:bg-gray-700 transition disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        {{ form.processing ? 'A requisitar...' : 'Requisitar Livro' }}
                    </button>
                </div>

            </form>
        </div>
    </AppLayout>
</template>