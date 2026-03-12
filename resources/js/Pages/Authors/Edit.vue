<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import { useForm } from '@inertiajs/vue3'
import PageHeader from '@/Components/PageHeader.vue'

const props = defineProps({
    author: Object,
})

const form = useForm({
    name: props.author.name,
    photo: null
});

const submit = () => {
    form.put(`/author/${props.author.id}`)
}
</script>

<template>
    <AppLayout :title="`Editar: ${author.name}`">
        <template #header>
            <PageHeader :title="`Editar livro: ${author.name}`"/>
        </template>
    
        <div class="py-6 max-w-4xl mx-auto">
            <form @submit.prevent="submit" class="space-y-4" enctype="multipart/form-data">

                <div>
                    <label class="block font-medium">Título</label>
                    <input v-model="form.name" type="text" class="border rounded w-full p-2">
                    <p v-if="form.errors.name" class="text-red-600 text-sm mt-1">
                        {{ form.errors.name }}
                    </p>
                </div>

                <div v-if="author.photo">
                    <p class="text-sm text-gray-500 mb-2">Foto Atual</p>
                    <img :src="`/storage/${author.photo}`" class="w-32 rounded shadow">
                </div>

                <div>
                    <label class="block font-medium">Alterar Foto</label>
                    <input 
                    type="file"
                    @change="form.photo = $event.target.files[0]"
                    class="border rounded w-full p-2" 
                    >
                     <p v-if="form.errors.photo" class="text-red-600 text-sm mt-1">
                        {{ form.errors.photo }}
                    </p>
                </div>

                <div class="pt-4">
                    <PrimaryButton 
                        type="submit"
                        
                        :disabled="form.processing"
                    >
                        Atualizar Autor
                    </PrimaryButton>
                </div>

            </form>
        </div>
    </AppLayout>
</template>