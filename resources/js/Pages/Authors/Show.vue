<script setup>
import { Link } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import PageHeader from '@/Components/PageHeader.vue'

const props = defineProps({
    author: Object
})
</script>

<template>
    <AppLayout :title="author.name">
        <template #header>
            <PageHeader :title="author.name"/>
        </template>

        <!-- Conteúdo do autor -->
        <div class="max-w-5xl mx-auto py-8">
            <div class="flex flex-col md:flex-row gap-6">

                <!-- Foto do autor -->
                <div class="md:w-1/3">
                    <img 
                        v-if="author.photo"
                        :src="`/storage/${author.photo}`"
                        :alt="author.name"
                        class="w-64 h-64 rounded shadow-lg object-cover"
                    />
                    <div v-else class="w-full h-64 bg-gray-200 flex items-center justify-center rounded">
                        Sem capa
                    </div>
                </div>

                <!-- Informações -->
                <div class="md:w-2/3 flex flex-col gap-4">
                    <h1 class="text-3xl font-bold text-gray-900">{{ author.name }}</h1>

                    <!-- <div class="flex gap-2 font-semibold">
                        <Link :href="route('authors.edit', author.id)"  class="rounded-xl px-4 py-2 bg-gray-800 text-gray-100 hover:bg-gray-600 transition duration-150">
                            Editar
                        </Link>
                        <Link 
                        :href="route('authors.destroy', author.id)"
                        method="delete"
                        class="rounded-xl px-4 py-2 text-red-800 bg-gray-100 border border-gray-300 hover:bg-gray-300 transition duration-150">
                            Remover
                        </Link>
                    </div>
                 -->
                </div>

            </div>
        </div>
    </AppLayout>
</template>