<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import { useForm } from '@inertiajs/vue3'
import PageHeader from '@/Components/PageHeader.vue'

const props = defineProps({
    publishers: Array,
    authors: Array
})

// Inicializa o formulário vazio
const form = useForm({
    title: '',
    price: '',
    author_ids: [], // array vazio
    isbn: '',
    bibliography: '',
    publisher_id: '',
    cover: null
});

// Função para enviar o formulário
const submit = () => {
    form.post(route('books.store')) // usa a rota do store
}
</script>

<template>
    <AppLayout :title="'Criar Livro'">
        <template #header>
            <PageHeader title="Criar um livro"/>
        </template>

        <div class="py-6 max-w-4xl mx-auto">
            <form @submit.prevent="submit" class="space-y-4" enctype="multipart/form-data">

                <div>
                    <label class="block font-medium">Título</label>
                    <input v-model="form.title" type="text" class="border rounded w-full p-2">
                    <p v-if="form.errors.title" class="text-red-600 text-sm mt-1">
                        {{ form.errors.title }}
                    </p>
                </div>

                <div>
                    <label class="block font-medium">Preço</label>
                    <input v-model="form.price" type="number" step="0.01" class="border rounded w-full p-2">
                    <p v-if="form.errors.price" class="text-red-600 text-sm mt-1">
                        {{ form.errors.price }}
                    </p>
                </div>

                <div>
                    <label class="block font-medium">Autor(es)</label>
                    <select v-model="form.author_ids" multiple class="border rounded w-full p-2">
                        <option 
                        v-for="author in authors" 
                        :key="author.id" 
                        :value="author.id"
                        >
                            {{ author.name }}
                        </option>
                    </select>
                    <p v-if="form.errors.author_ids" class="text-red-600 text-sm mt-1">
                        {{ form.errors.author_ids }}
                    </p>
                </div>

                <div>
                    <label class="block font-medium">ISBN</label>
                    <input v-model="form.isbn" type="text" class="border rounded w-full p-2">
                    <p v-if="form.errors.isbn" class="text-red-600 text-sm mt-1">
                        {{ form.errors.isbn }}
                    </p>
                </div>

                <div>
                    <label class="block font-medium">Bibliografia</label>
                    <textarea v-model="form.bibliography" class="border rounded w-full p-2"></textarea>
                    <p v-if="form.errors.bibliography" class="text-red-600 text-sm mt-1">
                        {{ form.errors.bibliography }}
                    </p>
                </div>

                <div>
                    <label class="block font-medium">Editora</label>
                    <select v-model="form.publisher_id" class="border rounded w-full p-2">
                        <option value="">Selecione uma editora</option>
                        <option 
                        v-for="publisher in publishers"
                        :key="publisher.id"
                        :value="publisher.id"
                        >
                        {{ publisher.name }}
                        </option>
                    </select>
                    <p v-if="form.errors.publisher_id" class="text-red-600 text-sm mt-1">
                        {{ form.errors.publisher_id }}
                    </p>
                </div>

                <div>
                    <label class="block font-medium">Capa do Livro</label>
                    <input 
                    type="file"
                    @change="form.cover = $event.target.files[0]"
                    class="border rounded w-full p-2" 
                    >
                    <p v-if="form.errors.cover" class="text-red-600 text-sm mt-1">
                        {{ form.errors.cover }}
                    </p>
                </div>

                <div class="pt-4">
                    <PrimaryButton 
                        type="submit"
                        :disabled="form.processing"
                    >
                        Publicar Livro
                    </PrimaryButton>
                </div>

            </form>
        </div>
    </AppLayout>
</template>