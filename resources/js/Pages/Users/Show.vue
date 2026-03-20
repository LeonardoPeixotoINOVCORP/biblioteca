<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import PageHeader from '@/Components/PageHeader.vue'
import ImageCard from '@/Components/ImageCard.vue'

const props = defineProps({
    user: Object,
    requests: Array,
})

const statusColor = (status) => ({
    pendente:  'bg-yellow-100 text-yellow-800',
    aprovada:  'bg-green-100 text-green-800',
    devolvida: 'bg-blue-100 text-blue-800',
    rejeitada: 'bg-red-100 text-red-800',
}[status] ?? '')
</script>

<template>
    <AppLayout title="Utilizadores">
        <template #header>
            <PageHeader :title="user.name" />
        </template>

        <div class="max-w-5xl mx-auto py-10 px-4 sm:px-6 lg:px-8 space-y-8">

            <!-- Bloco principal -->
            <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">
                <div class="flex flex-col md:flex-row">

                    <!-- Foto -->
                    <div class="md:w-56 shrink-0 bg-gray-50 border-b md:border-b-0 md:border-r border-gray-100 min-h-[220px]">
                        <ImageCard
                            :src="user.profile_photo_path"
                            :alt="user.name"
                            fallback-text="Sem foto"
                        />
                    </div>

                    <!-- Informações -->
                    <div class="flex-1 p-8 flex flex-col justify-center gap-4">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-widest text-gray-400 mb-1">Utilizador</p>
                            <h1 class="text-3xl font-bold text-gray-900 leading-tight">{{ user.name }}</h1>
                        </div>

                        <div class="border-t border-gray-100"></div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="flex flex-col gap-1">
                                <span class="text-xs font-semibold uppercase tracking-widest text-gray-400">Email</span>
                                <span class="text-sm text-gray-700">{{ user.email }}</span>
                            </div>
                            <div class="flex flex-col gap-1">
                                <span class="text-xs font-semibold uppercase tracking-widest text-gray-400">Requisições</span>
                                <span class="text-sm text-gray-700">
                                    {{ requests.length }} {{ requests.length === 1 ? 'requisição' : 'requisições' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Histórico de Requisições -->
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-7 h-7 rounded-lg bg-gray-100 flex items-center justify-center">
                        <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z" />
                        </svg>
                    </div>
                    <h2 class="text-xs font-semibold text-gray-400 uppercase tracking-widest">Histórico de Requisições</h2>
                </div>

                <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">
                    <table class="min-w-full text-sm divide-y divide-gray-100">
                        <thead class="bg-gray-50 text-left text-gray-500 uppercase text-xs">
                            <tr>
                                <th class="px-5 py-3 font-semibold tracking-wider">Data Requisição</th>
                                <th class="px-5 py-3 font-semibold tracking-wider">Data Limite</th>
                                <th class="px-5 py-3 font-semibold tracking-wider">Data Devolução</th>
                                <th class="px-5 py-3 font-semibold tracking-wider">Estado</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            <tr v-for="req in requests" :key="req.id" class="hover:bg-amber-50 transition-colors">
                                <td class="px-5 py-3 text-gray-600">{{ req.requested_at }}</td>
                                <td class="px-5 py-3 text-gray-600">{{ req.due_date ?? '—' }}</td>
                                <td class="px-5 py-3 text-gray-600">{{ req.returned_at ?? '—' }}</td>
                                <td class="px-5 py-3">
                                    <span class="px-2.5 py-1 rounded-md text-xs font-semibold capitalize"
                                        :class="statusColor(req.status)">
                                        {{ req.status }}
                                    </span>
                                </td>
                            </tr>
                            <tr v-if="!requests.length">
                                <td colspan="4" class="px-5 py-8 text-center text-gray-400 text-sm italic">
                                    Este utilizador não efetuou requisições.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </AppLayout>
</template>