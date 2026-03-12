<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import PageHeader from '@/Components/PageHeader.vue'

import ImageCard from '@/Components/ImageCard.vue';
import ActionLinks from '@/Components/ActionLinks.vue';

const props = defineProps({
    publisher: Object
})
</script>

<template>
    <AppLayout :title="publisher.name">
        <template #header>
            <PageHeader :title="publisher.name"/>
        </template>

        <!-- Conteúdo da editora -->
        <div class="max-w-5xl mx-auto py-8">
            <div class="flex flex-col md:flex-row gap-6">

                <!-- Foto da editora -->
                <ImageCard :src="publisher.logo" :alt="publisher.name" fallback-text="Sem capa"/>


                <!-- Informações -->
                <div class="md:w-2/3 flex flex-col gap-4">  
                    <h1 class="text-4xl font-bold">{{ publisher.name }}</h1>
                    <ActionLinks :edit-route="route('publishers.edit', publisher.id)" :delete-route="route('publishers.destroy', publisher.id)"/>
                </div>

            </div>
        </div>
    </AppLayout>
</template>