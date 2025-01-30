<script setup>
import Navbar from "@/Components/NavBar.vue";
import Footer from "@/Components/Footer.vue";
</script>

<template>
        <Navbar />
        <!-- TODO: Add authentication alerts -->
        <slot />
        <Footer />
</template>
