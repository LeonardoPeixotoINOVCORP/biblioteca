<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import PageHeader from '@/Components/PageHeader.vue'

import ImageCard from '@/Components/ImageCard.vue'
import BookList from '@/Components/BookList.vue'
import ActionLinks from '@/Components/ActionLinks.vue'

const props = defineProps({
    author: Object,
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

                <!-- Foto da editora -->
                <ImageCard 
                :src="author.photo" 
                :alt="author.name" 
                fallback-text="Sem foto"/>


                <!-- Informações -->
                <div class="md:w-2/3 flex flex-col gap-6">
                    <h1 class="text-4xl font-bold">{{ author.name }}</h1>
                    <BookList :books="author.books"/>
                    <ActionLinks :edit-route="route('authors.edit', author.id)" :delete-route="route('authors.destroy', author.id)"/>
                </div>
                
            </div>
        </div>
    </AppLayout>
</template>