<script setup>
const props = defineProps({
    src: String,
    alt: String,
    size: { type: String, default: '64' }, // tamanho em w/h
    fallbackText: String
})
</script>

<template>
    <div class="w-64 h-64 rounded shadow-lg overflow-hidden">
        <img 
            v-if="src" 
            :src="`/storage/${src}`" 
            :alt="alt" 
            class="w-full h-full object-fill"
        />
        <div v-else class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-400 font-semibold">
            {{ fallbackText || 'Sem imagem' }}
        </div>
    </div>
</template>