<script setup>
const props = defineProps({
    src: String,
    alt: String,
    fallbackText: String
})
</script>

<template>
    <div class="w-full h-full overflow-hidden">
        <img
            v-if="src"
            :src="`/storage/${src}`"
            :alt="alt"
            class="w-full h-full object-cover"
        />
        <div v-else class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-400 font-semibold">
            {{ fallbackText || 'Sem imagem' }}
        </div>
    </div>
</template>