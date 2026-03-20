<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import PageHeader from '@/Components/PageHeader.vue'
import { useForm, usePage, Link, router } from '@inertiajs/vue3'
import { ref, watch } from 'vue'

const props = defineProps({
    requests: Array,
    filters: Object,
    stats: Object,
})

const isAdmin = usePage().props.auth.user.roles?.some(r => r.name === 'admin')

const statusColor = (status) => ({
    pendente:  'bg-yellow-100 text-yellow-800',
    aprovada:  'bg-green-100 text-green-800',
    devolvida: 'bg-blue-100 text-blue-800',
    rejeitada: 'bg-red-100 text-red-800',
}[status] ?? '')

const approve = (id) => useForm({}).patch(route('book-requests.approve', id))
const reject  = (id) => useForm({}).patch(route('book-requests.reject', id))

const showModal = ref(false)
const selectedId = ref(null)
const returnDate = ref(new Date().toISOString().split('T')[0])

function openModal(id) {
    selectedId.value = id
    showModal.value = true
}

function closeModal() {
    showModal.value = false
}

function confirmReturn() {
    useForm({ returned_at: returnDate.value }).patch(route('book-requests.returned', selectedId.value))
    closeModal()
}

function deleteRequest(id) {
    if (confirm('Tens a certeza que queres apagar este registo?')) {
        useForm({}).delete(route('book-requests.destroy', id))
    }
}

function clearRequests() {
    if (confirm('Tens a certeza que queres apagar TODAS as requisições?')) {
        useForm({}).delete(route('book-requests.clear'))
    }
}

function isLate(req) {
    if (!req.returned_at || !req.due_date) return false
    return new Date(req.returned_at) > new Date(req.due_date)
}

// Filtros
const filterBook    = ref(props.filters?.book     ?? '')
const filterUser    = ref(props.filters?.user     ?? '')
const filterStatus  = ref(props.filters?.status   ?? '')
const filterDate    = ref(props.filters?.date     ?? '')
const filterDueDate = ref(props.filters?.due_date ?? '')

let debounceTimer = null
function applyFilters() {
    clearTimeout(debounceTimer)
    debounceTimer = setTimeout(() => {
        router.get(route('book-requests.index'), {
            book:     filterBook.value     || undefined,
            user:     filterUser.value     || undefined,
            status:   filterStatus.value   || undefined,
            date:     filterDate.value     || undefined,
            due_date: filterDueDate.value  || undefined,
        }, { preserveState: true, replace: true })
    }, 350)
}

watch([filterBook, filterUser, filterStatus, filterDate, filterDueDate], applyFilters)
</script>

<template>
    <AppLayout title="Requisições">
        <template #header>
            <PageHeader v-if="isAdmin" title="Requisições">
                <template #actions>
                    <button
                        @click="clearRequests"
                        class="rounded-md px-4 py-2 text-red-800 bg-gray-100 border border-gray-300 hover:bg-gray-300 transition duration-150 text-sm font-semibold"
                    >
                        Limpar Requisições
                    </button>
                </template>
            </PageHeader>
            <PageHeader v-else title="As suas requisições" />
        </template>
        
        <div class="max-w-7xl mx-auto px-4 py-8 space-y-6">
            
            <!-- Indicadores -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                <div class="rounded-2xl border border-gray-200 bg-gray-50 p-6 flex items-center gap-5">
                    <div class="w-12 h-12 rounded-xl bg-gray-200 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-widest mb-1">Requisições Ativas</p>
                        <p class="text-3xl font-bold leading-none text-gray-800">{{ stats.active }}</p>
                    </div>
                </div>

                <div class="rounded-2xl border border-gray-200 bg-gray-50 p-6 flex items-center gap-5">
                    <div class="w-12 h-12 rounded-xl bg-gray-200 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-widest mb-1">Últimos 30 Dias</p>
                        <p class="text-3xl font-bold leading-none text-gray-800">{{ stats.last_30_days }}</p>
                    </div>
                </div>

                <div class="rounded-2xl border border-gray-200 bg-gray-50 p-6 flex items-center gap-5">
                    <div class="w-12 h-12 rounded-xl bg-gray-200 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-widest mb-1">Entregues Hoje</p>
                        <p class="text-3xl font-bold leading-none text-gray-800">{{ stats.returned_today }}</p>
                    </div>
                </div>
            </div>

            <!-- Barra de filtros -->
            <div class="flex flex-wrap items-center gap-3">

                <!-- Livro -->
                <input
                    v-model="filterBook"
                    type="text"
                    placeholder="Pesquisar livro..."
                    class="rounded-lg border-gray-300 shadow-sm text-sm flex-1 min-w-48"
                />

                <!-- Utilizador (só admin) -->
                <input
                    v-if="isAdmin"
                    v-model="filterUser"
                    type="text"
                    placeholder="Pesquisar utilizador..."
                    class="rounded-lg border-gray-300 shadow-sm text-sm flex-1 min-w-48"
                />

                <!-- Estado -->
                <select
                    v-model="filterStatus"
                    class="rounded-lg border-gray-300 shadow-sm text-sm"
                >
                    <option value="">Todos os estados</option>
                    <option value="pendente">Pendente</option>
                    <option value="aprovada">Aprovada</option>
                    <option value="devolvida">Devolvida</option>
                    <option value="rejeitada">Rejeitada</option>
                </select>
                
                <!-- Data requisição -->
                <div class="flex items-center gap-2">
                    <span class="text-gray-400 text-sm">Data</span>
                    <input
                        v-model="filterDate"
                        type="date"
                        class="rounded-lg border-gray-300 shadow-sm text-sm"
                    />
                </div>

                <!-- Data devolução limite -->
                <div class="flex items-center gap-2">
                    <span class="text-gray-400 text-sm">Devolução até</span>
                    <input
                        v-model="filterDueDate"
                        type="date"
                        class="rounded-lg border-gray-300 shadow-sm text-sm"
                    />
                </div>
            </div>

            <!-- Tabela -->
            <div class="rounded-xl shadow overflow-x-auto">
                <table class="min-w-full bg-white text-sm divide-y divide-gray-200">
                    <thead class="bg-gray-50 text-left text-gray-600 uppercase text-xs">
                        <tr>
                            <th v-if="isAdmin" class="px-4 py-3 font-semibold tracking-wider">ID</th>
                            <th class="px-4 py-3 font-semibold tracking-wider">Livro</th>
                            <th v-if="isAdmin" class="px-4 py-3 font-semibold tracking-wider">Utilizador</th>
                            <th class="px-4 py-3 font-semibold tracking-wider text-center">Data</th>
                            <th class="px-4 py-3 font-semibold tracking-wider text-center">Devolução limite</th>
                            <th class="px-4 py-3 font-semibold tracking-wider text-center">Estado</th>
                            <th v-if="isAdmin" class="px-4 py-3 font-semibold tracking-wider text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <tr v-for="req in requests" :key="req.id" class="hover:bg-gray-50 transition">
                            <td v-if="isAdmin" class="px-4 py-3 text-gray-400 font-mono text-xs">{{ req.id }}</td>
                            <td class="px-4 py-3 font-medium">
                                <Link :href="route('books.show', req.book.id)" class="hover:text-blue-900 transition-colors">
                                    {{ req.book.title }}
                                </Link>
                            </td>
                            <td v-if="isAdmin" class="px-4 py-3 text-gray-600">
                                <Link :href="route('users.show', req.user.id)" class="hover:text-blue-900 transition-colors">
                                    {{ req.user.name }}
                                </Link>
                            </td>
                            <td class="px-4 py-3 text-center text-gray-600">
                                {{ new Date(req.requested_at).toLocaleDateString('pt-PT', { day: '2-digit', month: '2-digit', year: 'numeric' }) }}
                            </td>
                            <td class="px-4 py-3 text-center text-gray-600">
                                {{ new Date(req.due_date).toLocaleDateString('pt-PT', { day: '2-digit', month: '2-digit', year: 'numeric' }) }}
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex justify-center">
                                    <span
                                        class="rounded-md px-2.5 py-1 text-xs font-semibold capitalize text-center"
                                        :class="[isLate(req) ? 'bg-red-100 text-red-800' : statusColor(req.status)]"
                                    >
                                        {{ req.status }}
                                        <p v-if="isLate(req)" class="text-xs text-red-600">
                                            Atrasado {{ Math.ceil((new Date(req.returned_at) - new Date(req.due_date)) / (1000*60*60*24)) }} dias
                                        </p>
                                    </span>
                                </div>
                            </td>
                            <td v-if="isAdmin" class="px-4 py-3">
                                <div class="flex gap-2 justify-center">
                                    <button v-if="req.status === 'pendente'"
                                        @click="approve(req.id)"
                                        class="rounded-md px-3 py-1 text-xs bg-gray-800 text-gray-100 hover:bg-gray-600 transition">
                                        Aprovar
                                    </button>
                                    <button v-if="req.status === 'pendente'"
                                        @click="reject(req.id)"
                                        class="rounded-md px-3 py-1 text-xs text-red-800 bg-gray-100 border border-gray-300 hover:bg-gray-300 transition">
                                        Rejeitar
                                    </button>
                                    <button v-if="req.status === 'aprovada'"
                                        @click="openModal(req.id)"
                                        class="rounded-md px-3 py-1 text-xs bg-gray-800 text-gray-100 hover:bg-gray-600 transition">
                                        Devolvido
                                    </button>
                                    <button v-if="req.status === 'devolvida'"
                                        @click="deleteRequest(req.id)"
                                        class="rounded-md px-3 py-1 text-xs bg-gray-800 text-gray-100 hover:bg-gray-600 transition">
                                        Apagar registo
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="requests.length === 0">
                            <td colspan="7" class="px-4 py-10 text-center text-gray-400 italic">
                                Nenhuma requisição encontrada.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal devolução -->
        <div v-if="showModal" class="fixed inset-0 flex items-center justify-center bg-black/50 z-50">
            <div class="bg-white rounded-2xl shadow-xl p-6 w-80">
                <h2 class="text-lg font-semibold mb-1">Confirmar devolução</h2>
                <p class="text-sm text-gray-500 mb-4">Seleciona a data de devolução.</p>
                <input
                    type="date"
                    v-model="returnDate"
                    class="w-full mb-5 border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-300"
                />
                <div class="flex justify-end gap-2">
                    <button @click="closeModal" class="px-4 py-2 rounded-lg text-sm bg-gray-100 hover:bg-gray-200 transition">
                        Cancelar
                    </button>
                    <button @click="confirmReturn" class="px-4 py-2 rounded-lg text-sm bg-gray-800 text-white hover:bg-gray-600 transition">
                        Confirmar
                    </button>
                </div>
            </div>
        </div>

    </AppLayout>
</template>