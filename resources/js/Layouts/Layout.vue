<script setup>
import Navbar from "@/Components/Navbar.vue";
import Footer from "@/Components/Footer.vue";
</script>

<template>
        <Navbar />
        <!-- TODO: Add authentication alerts -->
        <slot />
        <Footer />
</template>
