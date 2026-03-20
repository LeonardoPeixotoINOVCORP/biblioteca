<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import PageHeader from '@/Components/PageHeader.vue';
import { Link } from '@inertiajs/vue3';

// Props recebidas do controller
const props = defineProps({
    publishers: Object
})

</script>

<template>
    <AppLayout title="Editoras">
        <template #header>
            <PageHeader title="Editoras">
                <template #actions>
                    <Link
                        v-if="$page.props.auth.roles.includes('admin')"
                        :href="route('publishers.create')"
                        class="flex items-center px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700 transition"
                    >
                        Criar uma editora
                    </Link>
                </template>
            </PageHeader>
        </template>
        
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5">
                    <div 
                        v-for="publisher in publishers.data" 
                        :key="publisher.id"
                        class="flex flex-col items-center text-center group text-white rounded-2xl py-5"
                    >
                        <!-- <Link :href="route('publishers.show', publisher.id)"> -->
                        <div class="w-48 h-48  overflow-hidden bg-gray-100 shadow mb-3 ring-2 ring-transparent group-hover:ring-amber-400 transition">
                            <Link :href="route('publishers.show', publisher.id)">
                            <img
                                v-if="publisher.logo"
                                :src="publisher.logo"
                                :alt="publisher.name"
                                class="w-full h-full object-fill"
                            />
                            <div v-else class="w-full h-full flex items-center justify-center text-2xl font-semibold text-gray-400">
                                {{ publisher.name }}
                            </div>
                            </Link>
                        </div>
                        
                        <p class="font-bold text-sm  text-gray-800 group-hover:text-gray-600">{{ publisher.name }}</p>
                    </div>
                    
                </div>

                <!-- Paginação
                <Pagination :page="publishers" /> -->

            </div>
        </div>
    </AppLayout>
</template>
