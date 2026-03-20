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
    <div class="flex gap-3 font-semibold">
        <Link 
        :href="editRoute" 
        class="px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700 transition"
        >
            {{ editText }}
        </Link>
        
        <Link 
        v-if="deleteRoute"
        :href="deleteRoute" 
        method="delete"
        class="px-4 py-2 text-red-800 bg-gray-100 rounded-md border border-gray-300 hover:bg-gray-300 transition"
        >
        {{ deleteText }}
        </Link>
    </div>
</template>