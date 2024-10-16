<script setup>
import { ref, watch } from "vue";
import { usePage } from "@inertiajs/vue3";
import Navbar from "@/Components/Navbar.vue";
import SuccessAlert from "@/Components/successAlert.vue";
import Footer from "@/Components/Footer.vue";

const showAlert = ref(false);
const alertMessage = ref("");

const page = usePage();

watch(
    () => page.props.auth.check,
    (newValue, oldValue) => {
        if (oldValue && !newValue) {
            // User has logged out
            alertMessage.value = "signed out";
            showAlert.value = true;
            setTimeout(() => {
                showAlert.value = false;
            }, 3000); // Hide after 3 seconds
        }
    }
);

const closeAlert = () => {
    showAlert.value = false;
};
</script>

<template>
    <Navbar />
    <SuccessAlert
        v-if="showAlert"
        :message="alertMessage"
        @close="closeAlert"
    />
    <slot />
    <Footer />
</template>
