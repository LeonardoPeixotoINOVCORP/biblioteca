<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
});
</script>

<template>
    <div class="min-h-screen bg-gray-50 flex flex-col">

        <!-- Nav -->
        <nav class="bg-white border-b border-gray-200 px-6 py-4 flex justify-between items-center">
            <div class="flex items-center gap-2 text-gray-800 font-semibold text-lg">
                Biblioteca
            </div>
            <div class="flex gap-3" v-if="! $page.props.auth.user">
                <Link :href="route('login')" class="text-sm text-gray-600 hover:text-gray-900 px-4 py-2 rounded-md transition">
                    Entrar
                </Link>

                <Link v-if="canRegister" :href="route('register')" class="text-sm bg-gray-900 text-white px-4 py-2 rounded-md hover:bg-gray-700 transition">
                    Criar conta
                </Link>
            </div>
        </nav>

        <!-- Hero -->
        <main class="flex-1 flex flex-col items-center justify-center text-center px-6 py-24">
            <h1 class="text-5xl font-bold text-gray-900 mb-4">
                Gere a tua biblioteca
            </h1>
            <p class="text-lg text-gray-500 max-w-md mb-10">
                Organiza livros, autores e editoras num só lugar, de forma simples e rápida.
            </p>
            <Link :href="route('login')" class="bg-gray-900 text-white px-8 py-3 rounded-lg text-base font-medium hover:bg-gray-700 transition">
                Entrar na plataforma
            </Link>

        </main>

        <!-- Footer -->
        <footer class="text-center text-sm text-gray-400 py-6">
            © {{ new Date().getFullYear() }} Biblioteca · INOVCORP
        </footer>

    </div>
</template>
