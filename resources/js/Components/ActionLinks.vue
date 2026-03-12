<script setup>
import { Link } from '@inertiajs/vue3'

const props = defineProps({
    editRoute: String,
    deleteRoute: String,
    deleteText: { type: String, default: 'Remover' },
    editText: { type: String, default: 'Editar' }
})
</script>

<template>
    <div class="flex gap-3 font-semibold text-lg">
        <Link :href="editRoute" class="rounded-xl px-5 py-3 bg-gray-800 text-gray-100 hover:bg-gray-600 transition">
            {{ editText }}
        </Link>
        
        <Link 
        v-if="deleteRoute"
        :href="deleteRoute" 
        method="delete"
        class="rounded-xl px-5 py-3 text-red-800 bg-gray-100 border border-gray-300 hover:bg-gray-300 transition"
        >
        {{ deleteText }}
        </Link>
    </div>
</template>