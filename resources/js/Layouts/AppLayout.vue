<script setup>
import Navbar from "../Components/Navbar.vue";
import Footer from "@/Components/Footer.vue";
</script>

<template>
    <Navbar />
    <header class="bg-white">
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold tracking-tight text-gray-900">
                Market
            </h1>
        </div>
    </header>
    <main>
        <slot />
    </main>
    <Footer />
</template>
