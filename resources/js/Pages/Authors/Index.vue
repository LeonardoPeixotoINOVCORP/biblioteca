<script setup>
import Pagination from '@/Components/Pagination.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import PageHeader from '@/Components/PageHeader.vue';
import { Link } from '@inertiajs/vue3';

// Props recebidas do controller
const props = defineProps({
    authors: Object
})

</script>

<template>
    <AppLayout title="Autores">
        <template #header>
            <PageHeader title="Autores">
                <template #actions>
                <Link
                    :href="route('authors.create')"
                    class="flex items-center px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700 transition"
                >
                    Criar um autor
                </Link>
                </template>
            </PageHeader>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
                    <div 
                        v-for="author in authors.data" 
                        :key="author.id"
                        class="flex flex-col items-center text-center group text-white rounded-2xl py-5"
                    >
                        <Link :href="route('authors.show', author.id)">
                        <div class="w-48 h-48 rounded-full overflow-hidden bg-gray-100 shadow mb-3 ring-2 ring-transparent group-hover:ring-amber-400 transition">
                            <img
                                v-if="author.photo"
                                :src="author.photo"
                                :alt="author.name"
                                class="w-full h-full object-cover"
                            />
                            <div v-else class="w-full h-full flex items-center justify-center text-2xl font-semibold text-gray-400">
                                {{ author.name }}
                            </div>
                        </div>
                        
                        <p class="font-bold text-sm  text-gray-800 group-hover:text-gray-600">{{ author.name }}</p>
                        </Link>
                    </div>
                    
                </div>
                <!-- Paginação -->
                 <div class="mt-auto pt-12">
                     <Pagination :page="authors" />
                 </div>
            </div>
        </div>
    </AppLayout>
</template>
