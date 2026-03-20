<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import PageHeader from '@/Components/PageHeader.vue'
import { useForm } from '@inertiajs/vue3'
import { ref } from 'vue'

const form = useForm({
    name: '',
    logo: null
})

const logoPreview = ref(null)

function onLogo(e) {
    const file = e.target.files[0]
    if (!file) return
    form.logo = file
    const reader = new FileReader()
    reader.onload = (ev) => { logoPreview.value = ev.target.result }
    reader.readAsDataURL(file)
}

const submit = () => {
    form.post(route('publishers.store'))
}
</script>

<template>
    <AppLayout title="Criar Editora">
        <template #header>
            <PageHeader title="Criar uma Editora" />
        </template>

        <div class="max-w-xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
            <form @submit.prevent="submit" enctype="multipart/form-data" class="space-y-5">

                <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6 space-y-5">

                    <!-- Nome -->
                    <div class="space-y-2">
                        <label class="text-xs font-semibold uppercase tracking-widest text-gray-400">Nome</label>
                        <input
                            v-model="form.name"
                            type="text"
                            placeholder="Nome da editora"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-300 transition"
                        />
                        <p v-if="form.errors.name" class="text-red-500 text-xs">{{ form.errors.name }}</p>
                    </div>

                    <!-- Logo -->
                    <div class="space-y-3">
                        <label class="text-xs font-semibold uppercase tracking-widest text-gray-400">Logo</label>
                        <div class="flex items-center gap-5">
                            <div class="w-16 h-16 rounded-full overflow-hidden bg-gray-100 shrink-0 flex items-center justify-center ring-1 ring-gray-200">
                                <img v-if="logoPreview" :src="logoPreview" class="w-full h-full object-cover" />
                                <svg v-else class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                                </svg>
                            </div>
                            <input
                                type="file"
                                accept="image/*"
                                @change="onLogo"
                                class="text-sm text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 transition"
                            />
                        </div>
                        <p v-if="form.errors.logo" class="text-red-500 text-xs">{{ form.errors.logo }}</p>
                    </div>

                </div>

                <div class="flex justify-end">
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="px-6 py-2.5 bg-gray-800 text-white text-sm font-semibold rounded-lg hover:bg-gray-700 transition disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        {{ form.processing ? 'A criar...' : 'Criar Editora' }}
                    </button>
                </div>

            </form>
        </div>
    </AppLayout>
</template>