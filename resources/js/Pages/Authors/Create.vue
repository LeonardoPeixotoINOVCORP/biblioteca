<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import PageHeader from '@/Components/PageHeader.vue'
import { useForm } from '@inertiajs/vue3'
import { ref } from 'vue'

const form = useForm({
    name: '',
    photo: null
})

const photoPreview = ref(null)

function onPhoto(e) {
    const file = e.target.files[0]
    if (!file) return
    form.photo = file
    const reader = new FileReader()
    reader.onload = (ev) => { photoPreview.value = ev.target.result }
    reader.readAsDataURL(file)
}

const submit = () => {
    form.post(route('authors.store'))
}
</script>

<template>
    <AppLayout title="Criar Autor">
        <template #header>
            <PageHeader title="Criar um Autor" />
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
                            placeholder="Nome do autor"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-300 transition"
                        />
                        <p v-if="form.errors.name" class="text-red-500 text-xs">{{ form.errors.name }}</p>
                    </div>

                    <!-- Foto -->
                    <div class="space-y-3">
                        <label class="text-xs font-semibold uppercase tracking-widest text-gray-400">Foto</label>
                        <div class="flex items-center gap-5">
                            <div class="w-16 h-16 rounded-full overflow-hidden bg-gray-100 shrink-0 flex items-center justify-center ring-1 ring-gray-200">
                                <img v-if="photoPreview" :src="photoPreview" class="w-full h-full object-cover" />
                                <svg v-else class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0" />
                                </svg>
                            </div>
                            <input
                                type="file"
                                accept="image/*"
                                @change="onPhoto"
                                class="text-sm text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 transition"
                            />
                        </div>
                        <p v-if="form.errors.photo" class="text-red-500 text-xs">{{ form.errors.photo }}</p>
                    </div>

                </div>

                <div class="flex justify-end">
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="px-6 py-2.5 bg-gray-800 text-white text-sm font-semibold rounded-lg hover:bg-gray-700 transition disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        {{ form.processing ? 'A criar...' : 'Criar Autor' }}
                    </button>
                </div>

            </form>
        </div>
    </AppLayout>
</template>