<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';

// Props recebidas do controller
const props = defineProps({
    authors: Object
})

</script>

<template>
    <AppLayout title="Autores">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Autores
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex gap-x-6">
                <div 
                v-for="author in authors" 
                :key="author.id"
                class="bg-white shadow-md rounded-xl p-6 hover:shadow-lg transition"
                >
                    <div>
                        <p>
                            {{ author.name }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
