<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
    book: Object
})
</script>

<template>
    <AppLayout :title="book.title">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ book.title }}
            </h2>
        </template>
    </AppLayout>
</template>