<script setup>
import { ref, watch, onMounted } from "vue";
import { usePage } from "@inertiajs/vue3";
import Navbar from "@/Components/Navbar.vue";
import SuccessAlert from "@/Components/SuccessAlert.vue";
import Footer from "@/Components/Footer.vue";

const showAlert = ref(false);
const alertMessage = ref("");

const page = usePage();

const showAlertMessage = (message) => {
    alertMessage.value = message;
    showAlert.value = true;
    setTimeout(() => {
        closeAlert();
    }, 3000); // Hide after 3 seconds
};

// Check for login on component mount
onMounted(() => {
    if (page.props.auth.user) {
        showAlertMessage("Signed in successfully");
    }
});

// Watch for changes in auth state
watch(
    () => page.props.auth.user,
    (newValue, oldValue) => {
        if (oldValue && !newValue) {
            // User has logged out
            showAlertMessage("Signed out successfully");
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
