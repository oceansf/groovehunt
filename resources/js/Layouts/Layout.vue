<script setup>
import { ref, watch } from "vue";
import { usePage } from "@inertiajs/vue3";
import Navbar from "@/Components/Navbar.vue";
import SuccessAlert from "@/Components/SuccessAlert.vue";
import Footer from "@/Components/Footer.vue";

const showAlert = ref(false);
const alertMessage = ref("");

const page = usePage();

watch(
    () => page.props.auth.check,
    (newValue, oldValue) => {
        if (oldValue && !newValue) {
            // User has logged out
            alertMessage.value = "Signed out";
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
    <transition
            enter-active-class="transition ease-out duration-300"
            enter-from-class="transform opacity-0"
            enter-to-class="transform opacity-100"
            leave-active-class="transition ease-in duration-300"
            leave-from-class="transform opacity-100"
            leave-to-class="transform opacity-0"
        >
        <SuccessAlert
            v-if="showAlert"
            :message="alertMessage"
            @close="closeAlert"
        />
    </transition>
    <slot />
    <Footer />
</template>
