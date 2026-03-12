<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import { useForm } from '@inertiajs/vue3'
import PageHeader from '@/Components/PageHeader.vue'

// Inicializa o formulário vazio
const form = useForm({
    name: '',
    logo: null
});

// Função para enviar o formulário
const submit = () => {
    form.post(route('publishers.store')) // usa a rota do store
}
</script>

<template>
    <AppLayout :title="'Criar Editora'">
        <template #header>
            <PageHeader title="Criar uma Editora"/>
        </template>

        <div class="py-6 max-w-4xl mx-auto">
            <form @submit.prevent="submit" class="space-y-4" enctype="multipart/form-data">

                <div>
                    <label class="block font-medium">Nome</label>
                    <input v-model="form.name" type="text" class="border rounded w-full p-2">
                    <p v-if="form.errors.name" class="text-red-600 text-sm mt-1">
                        {{ form.errors.name }}
                    </p>
                </div>

                <div>
                    <label class="block font-medium">Foto</label>
                    <input 
                    type="file"
                    @change="form.logo = $event.target.files[0]"
                    class="border rounded w-full p-2" 
                    >
                    <p v-if="form.errors.logo" class="text-red-600 text-sm mt-1">
                        {{ form.errors.logo }}
                    </p>
                </div>

                <div class="pt-4">
                    <PrimaryButton 
                        type="submit"
                        :disabled="form.processing"
                    >
                        Criar Editora
                    </PrimaryButton>
                </div>

            </form>
        </div>
    </AppLayout>
</template>