<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import PageHeader from '@/Components/PageHeader.vue';

// Stats recebidas do controller
defineProps({
    stats: Object
})

// Configuração dos cards
const cards = [
    {
        label: 'Total de Livros',
        key: 'total_books',
    },
    {
        label: 'Total de Autores',
        key: 'total_authors',
    },
    {
        label: 'Total de Editoras',
        key: 'total_publishers',
    },
]
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <PageHeader title="Dashboard"/>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    <div
                        v-for="card in cards"
                        :key="card.key"
                        :class="['border rounded-xl p-6 shadow-sm', card.color]"
                    >
                        <p class="text-sm text-gray-500 mb-1">{{ card.label }}</p>
                        <p :class="['text-4xl font-bold', card.textColor]">
                            {{ stats[card.key] }}
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </AppLayout>
</template>