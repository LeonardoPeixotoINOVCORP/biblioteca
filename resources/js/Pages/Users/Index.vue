<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import PageHeader from '@/Components/PageHeader.vue'
import { useForm, usePage, Link } from '@inertiajs/vue3'

const props = defineProps({
    users: Array,
})

const currentUser = usePage().props.auth.user

const changeRole = (user, role) => {
    useForm({ role }).patch(route('users.updateRole', user.id))
}

const deleteUser = (user) => {
    if (confirm(`Eliminar ${user.name}?`)) {
        useForm({}).delete(route('users.destroy', user.id))
    }
}
</script>

<template>
    <AppLayout title="Utilizadores">
        <template #header>
            <PageHeader title="Gestão de Utilizadores" />
        </template>

        <div class="py-6 max-w-5xl mx-auto">
            <div class="rounded-lg shadow">
                <table class="min-w-full bg-white text-sm divide-y divide-gray-200">
                    <thead class="bg-gray-50 text-left text-gray-600 uppercase text-xs">
                        <tr>
                            
                            <th class="px-4 py-3">Foto</th>
                            <th class="px-4 py-3">Nome</th>
                            <th class="px-4 py-3">Email</th>
                            <th class="px-4 py-3">Role</th>
                            <th class="px-4 py-3 text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <tr 
                        v-for="user in users" 
                        :key="user.id"
                        :class="user.id === currentUser.id ? 'bg-black/5 text-black/50' : ''" 
                        >
                        
                            <td class="px-4 py-3 font-medium">
                                <img
                                    v-if="user.profile_photo_path"
                                    :src="`/storage/${user.profile_photo_path}`"
                                    class="w-10 h-10 rounded-full object-cover"
                                />
                            </td>
                            
                            <td class="px-4 py-3 font-medium">
                                <Link 
                                :href="route('users.show', user.id)"
                                >
                                {{ user.name }}
                                </Link>
                            </td>
                            <td class="px-4 py-3">{{ user.email }}</td>
                            <td class="px-4 py-3 capitalize">
                                {{ user.roles[0]?.name ?? '—' }}
                            </td>
                            <td class="px-4 py-3 space-x-2">
                                <div class="flex gap-2 justify-center">
                                    <template v-if="user.id !== currentUser.id">
                                        <button
                                            v-if="user.roles[0]?.name !== 'admin'"
                                            @click="changeRole(user, 'admin')"
                                            class="rounded-md px-3 py-1 bg-gray-800 text-gray-100 hover:bg-gray-600 transition duration-150">
                                            Promover
                                        </button>
                                        <button
                                            v-if="user.roles[0]?.name === 'admin'"
                                            @click="changeRole(user, 'cidadao')"
                                            class="rounded-md px-3 py-1 text-red-800 bg-gray-100 border border-gray-300 hover:bg-gray-300 transition duration-150">
                                            Rebaixar
                                        </button>
                                        <button
                                            @click="deleteUser(user)"
                                            class="rounded-md px-3 py-1 bg-red-800 text-gray-100 hover:bg-red-700 transition duration-150">
                                            Eliminar
                                        </button>
                                    </template>
                                    <span v-else class="text-gray-400 text-xs">—</span>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="!users.length">
                            <td colspan="4" class="px-4 py-6 text-center text-gray-400">
                                Sem utilizadores.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>