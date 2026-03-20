<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import PageHeader from '@/Components/PageHeader.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import { useForm } from '@inertiajs/vue3'
import { ref } from 'vue'

const props = defineProps({
    publishers: Array,
    authors: Array
})

const form = useForm({
    title: '',
    price: '',
    author_ids: [],
    isbn: '',
    bibliography: '',
    publisher_id: '',
    cover: null,
    // novo autor inline
    new_author_name: '',
    new_author_photo: null,
})

const showNewAuthor = ref(false)
const newAuthorPhotoPreview = ref(null)

function toggleNewAuthor() {
    showNewAuthor.value = !showNewAuthor.value
    if (!showNewAuthor.value) {
        form.new_author_name = ''
        form.new_author_photo = null
        newAuthorPhotoPreview.value = null
    }
}

function onNewAuthorPhoto(e) {
    const file = e.target.files[0]
    if (!file) return
    form.new_author_photo = file
    const reader = new FileReader()
    reader.onload = (ev) => { newAuthorPhotoPreview.value = ev.target.result }
    reader.readAsDataURL(file)
}

function onCoverChange(e) {
    form.cover = e.target.files[0]
}

const submit = () => {
    form.post(route('books.store'))
}
</script>

<template>
    <AppLayout title="Criar Livro">
        <template #header>
            <PageHeader title="Criar um livro" />
        </template>

        <div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
            <form @submit.prevent="submit" enctype="multipart/form-data" class="space-y-6">

                <!-- Grid principal -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- Coluna esquerda -->
                    <div class="space-y-5">

                        <!-- Título -->
                        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-5 space-y-2">
                            <label class="text-xs font-semibold uppercase tracking-widest text-gray-400">Título</label>
                            <input
                                v-model="form.title"
                                type="text"
                                placeholder="Título do livro"
                                class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-300 transition"
                            />
                            <p v-if="form.errors.title" class="text-red-500 text-xs">{{ form.errors.title }}</p>
                        </div>

                        <!-- ISBN + Preço -->
                        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-5 space-y-4">
                            <div class="space-y-2">
                                <label class="text-xs font-semibold uppercase tracking-widest text-gray-400">ISBN</label>
                                <input
                                    v-model="form.isbn"
                                    type="text"
                                    placeholder="9783161484100"
                                    class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-gray-300 transition"
                                />
                                <p v-if="form.errors.isbn" class="text-red-500 text-xs">{{ form.errors.isbn }}</p>
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-semibold uppercase tracking-widest text-gray-400">Preço (€)</label>
                                <input
                                    v-model="form.price"
                                    type="number"
                                    step="0.01"
                                    min="0"
                                    placeholder="0.00"
                                    class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-300 transition"
                                />
                                <p v-if="form.errors.price" class="text-red-500 text-xs">{{ form.errors.price }}</p>
                            </div>
                        </div>

                        <!-- Editora -->
                        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-5 space-y-2">
                            <label class="text-xs font-semibold uppercase tracking-widest text-gray-400">Editora</label>
                            <select
                                v-model="form.publisher_id"
                                class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-300 transition bg-white"
                            >
                                <option value="">Selecione uma editora</option>
                                <option v-for="publisher in publishers" :key="publisher.id" :value="publisher.id">
                                    {{ publisher.name }}
                                </option>
                            </select>
                            <p v-if="form.errors.publisher_id" class="text-red-500 text-xs">{{ form.errors.publisher_id }}</p>
                        </div>

                        <!-- Bibliografia -->
                        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-5 space-y-2">
                            <label class="text-xs font-semibold uppercase tracking-widest text-gray-400">Bibliografia</label>
                            <textarea
                                v-model="form.bibliography"
                                rows="4"
                                placeholder="Descrição ou notas bibliográficas..."
                                class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-300 transition resize-none"
                            ></textarea>
                            <p v-if="form.errors.bibliography" class="text-red-500 text-xs">{{ form.errors.bibliography }}</p>
                        </div>

                    </div>

                    <!-- Coluna direita -->
                    <div class="space-y-5">

                        <!-- Capa -->
                        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-5 space-y-3">
                            <label class="text-xs font-semibold uppercase tracking-widest text-gray-400">Capa do Livro</label>
                            <input
                                type="file"
                                accept="image/*"
                                @change="onCoverChange"
                                class="w-full text-sm text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 transition"
                            />
                            <p v-if="form.errors.cover" class="text-red-500 text-xs">{{ form.errors.cover }}</p>
                        </div>

                        <!-- Autores -->
                        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-5 space-y-3">
                            <div class="flex items-center justify-between">
                                <label class="text-xs font-semibold uppercase tracking-widest text-gray-400">Autor(es)</label>
                                <PrimaryButton
                                    type="button"
                                    @click="toggleNewAuthor"
                                    :class="showNewAuthor
                                        ? 'bg-gray-200 text-gray-700'
                                        : 'bg-gray-800 text-white hover:bg-gray-700'"
                                >
                                    {{ showNewAuthor ? 'Cancelar' : '+ Novo autor' }}
                                </PrimaryButton>
                            </div>

                            <!-- Select de autores existentes -->
                            <select
                                v-model="form.author_ids"
                                multiple
                                class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-300 transition bg-white min-h-[120px]"
                            >
                                <option v-for="author in authors" :key="author.id" :value="author.id">
                                    {{ author.name }}
                                </option>
                            </select>
                            <p class="text-xs text-gray-400">Segura Ctrl (ou Cmd) para selecionar vários.</p>
                            <p v-if="form.errors.author_ids" class="text-red-500 text-xs">{{ form.errors.author_ids }}</p>

                            <!-- Novo autor inline -->
                            <div v-if="showNewAuthor" class="border border-dashed border-gray-200 rounded-xl p-4 space-y-3 bg-gray-50">
                                <p class="text-xs font-semibold uppercase tracking-widest text-gray-400">Novo Autor</p>

                                <div class="space-y-1">
                                    <label class="text-xs text-gray-500">Nome</label>
                                    <input
                                        v-model="form.new_author_name"
                                        type="text"
                                        placeholder="Nome do autor"
                                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-300 transition bg-white"
                                    />
                                    <p v-if="form.errors.new_author_name" class="text-red-500 text-xs">{{ form.errors.new_author_name }}</p>
                                </div>

                                <div class="space-y-2">
                                    <label class="text-xs text-gray-500">Foto do autor</label>
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 rounded-full overflow-hidden bg-gray-200 shrink-0 flex items-center justify-center">
                                            <img v-if="newAuthorPhotoPreview" :src="newAuthorPhotoPreview" class="w-full h-full object-cover" />
                                            <svg v-else class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0" />
                                            </svg>
                                        </div>
                                        <input
                                            type="file"
                                            accept="image/*"
                                            @change="onNewAuthorPhoto"
                                            class="text-sm text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 transition"
                                        />
                                    </div>
                                    <p v-if="form.errors.new_author_photo" class="text-red-500 text-xs">{{ form.errors.new_author_photo }}</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Botão submit -->
                <div class="flex justify-end">
                    <PrimaryButton
                        type="submit"
                        :disabled="form.processing"
                    >
                        {{ form.processing ? 'A publicar...' : 'Publicar Livro' }}
                    </PrimaryButton>
                </div>

            </form>
        </div>
    </AppLayout>
</template>