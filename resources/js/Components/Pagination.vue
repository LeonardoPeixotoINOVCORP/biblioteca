<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
    books: Object
})
</script>

<template>
<div class="flex items-center justify-between">
    <Link
        v-if="books.prev_page_url"
        :href="books.prev_page_url"
        preserve-scroll
            class="px-4 py-2 rounded-lg border bg-white text-sm text-gray-700 hover:font-medium hover:bg-gray-200 transition "
    >
        ← Anterior
    </Link>
    <span
        v-else
        class="px-4 py-2 rounded-lg bg-white/60 border text-sm text-gray-300 pointer-events-none"
    >
        ← Anterior
    </span>

    <span class="text-sm text-gray-500">Página {{ books.current_page }}</span>

    <Link
        v-if="books.next_page_url"
        :href="books.next_page_url"
        preserve-scroll
            class="px-4 py-2 rounded-lg border bg-white/80 text-sm text-gray-700 hover:bg-gray-100 hover:font-medium hover:bg-gray-200 transition"
    >
        Próxima →
    </Link>
    <span
        v-else
        class="px-4 py-2 rounded-lg border bg-white/60 text-sm text-gray-300 pointer-events-none"
    >
        Próxima →
    </span>
</div>
</template>
