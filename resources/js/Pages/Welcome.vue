<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    canRegister: Boolean,
});
</script>

<template>
<div class="h-screen flex flex-col ">

    <!-- Nav -->
    <nav class="absolute top-0 left-0 w-full z-10 bg-black/30 backdrop-blur-md border-b border-white/10 px-6 py-4 flex justify-between items-center">
        <div class="flex items-center gap-2 text-white font-semibold text-lg">
            Biblioteca
        </div>

        <div class="flex gap-3" v-if="! $page.props.auth.user">
            <Link :href="route('login')" class="text-sm text-white hover:text-gray-200 px-4 py-2 rounded-md transition">
                Entrar
            </Link>

            <Link
                v-if="canRegister"
                :href="route('register')"
                class="text-sm bg-white/20 text-white px-4 py-2 rounded-md hover:bg-white/30 transition"
            >
                Criar conta
            </Link>
        </div>
    </nav>

    <!-- Hero -->
    <div 
        class="hero h-screen"
        style="background-image: url(/images/background.jpg);"
    >
        <div class="hero-overlay bg-black/50 "></div>

        <div class="hero-content text-neutral-content text-center">
            <div class="max-w-md opacity-0 animate-fade-slide">
                <h1 class="mb-5 text-5xl font-bold">Gere a tua biblioteca</h1>

                <p class="mb-5">
                    Organiza livros, autores e editoras num só lugar, de forma simples e rápida.
                </p>

                <Link
                    :href="route('login')"
                    class="bg-white/30 text-white px-8 py-3 rounded-lg text-base font-medium hover:bg-white/40 transition"
                >
                    Entrar na plataforma
                </Link>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="absolute bottom-0 left-0 w-full footer sm:footer-horizontal place-items-center bg-black/30 backdrop-blur-md text-center text-sm text-white p-6 border-t border-white/10">
        © {{ new Date().getFullYear() }} Biblioteca · INOVCORP
    </footer>

</div>
</template>