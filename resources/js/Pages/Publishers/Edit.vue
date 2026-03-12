<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import { useForm } from '@inertiajs/vue3'
import PageHeader from '@/Components/PageHeader.vue'

const props = defineProps({
    publisher: Object,
})

const form = useForm({
    name: props.publisher.name,
    logo: null
});

const submit = () => {
    form.put(`/publisher/${props.publisher.id}`)
}
</script>

<template>
    <AppLayout :title="`Editar: ${publisher.name}`">
        <template #header>
            <PageHeader :title="`Editar livro: ${publisher.name}`"/>
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

                <div v-if="publisher.logo">
                    <p class="text-sm text-gray-500 mb-2">Foto Atual</p>
                    <img :src="`/storage/${publisher.logo}`" class="w-32 rounded shadow">
                </div>

                <div>
                    <label class="block font-medium">Alterar Foto</label>
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
                        Atualizar Editora
                    </PrimaryButton>
                </div>

            </form>
        </div>
    </AppLayout>
</template>