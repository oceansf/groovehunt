<script setup lang="ts">
import { ref } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import DeleteUserForm from "./Partials/DeleteUserForm.vue";
import UpdatePasswordForm from "./Partials/UpdatePasswordForm.vue";
import UpdateProfileInformationForm from "./Partials/UpdateProfileInformationForm.vue";
import { Head } from "@inertiajs/vue3";
import axiosInstance from "../../../axios";

defineProps<{
    mustVerifyEmail?: boolean;
    status?: string;
}>();

const accountCreatePending = ref(false);
const accountLinkCreatePending = ref(false);
const error = ref(false);
const connectedAccountId = ref(null);

// Method to create a Stripe account
const createAccount = async () => {
    console.log("Create Account button clicked"); // Debugging
    accountCreatePending.value = true;
    error.value = false;

    try {
        console.log("Sending request to /create-account"); // Debugging
        const response = await axiosInstance.post("/create-account");
        console.log("Response received:", response); // Debugging
        connectedAccountId.value = response.data.account;
    } catch (err) {
        console.error("Error creating account:", err); // Debugging
        error.value = true;
    } finally {
        accountCreatePending.value = false;
    }
};

const createAccountLink = async () => {
    accountLinkCreatePending.value = true;
    error.value = false;

    try {
        const response = await axiosInstance.post("/create-account-link", {
            account: connectedAccountId.value,
        });

        if (response.data.url) {
            window.location.href = response.data.url;
        }

        if (response.data.error) {
            error.value = true;
        }
    } catch (err) {
        error.value = true;
    } finally {
        accountLinkCreatePending.value = false;
    }
};
</script>

<template>
    <Head title="Profile" />
    <div class="py-12">
        <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
            <header class="text-3xl font-semibold tracking-tight">
                Account settings
            </header>
            <hr />
            <div class="p-4 sm:rounded-lg sm:p-8">
                <UpdateProfileInformationForm
                    :must-verify-email="mustVerifyEmail"
                    :status="status"
                    class="max-w-xl"
                />
            </div>
            <hr />
            <div class="p-4 sm:rounded-lg sm:p-8">
                <UpdatePasswordForm class="max-w-xl" />
            </div>
            <hr />
            <div class="p-4 sm:rounded-lg sm:p-8">
                <h2 class="text-lg font-medium text-gray-900">
                    Connect to Stripe
                </h2>
                <p class="mt-1 mb-6 text-sm text-gray-600">
                    Click the button below to connect your Groovehunt store to your Stripe account and start accepting payments.
                </p>
                <h2 v-if="connectedAccountId">
                    Add information to start accepting money
                </h2>
                <p v-if="connectedAccountId">
                    Groovehunt partners with Stripe to help you receive payments
                    while keeping your personal and bank details secure.
                </p>
                <div v-if="!accountCreatePending && !connectedAccountId">
                    <button @click="createAccount" class="btn btn-outline btn-primary">
                        Sign up
                    </button>
                </div>
                <div v-if="connectedAccountId && !accountLinkCreatePending">
                    <button @click="createAccountLink" class="btn btn-primary mt-3">
                        Add information
                    </button>
                    <p class="text-xs text-gray-600">*You will be redirected to Stripe to add your payment information</p>
                </div>
                <p v-if="error" class="error">Something went wrong!</p>
                <div
                    v-if="
                        connectedAccountId ||
                        accountCreatePending ||
                        accountLinkCreatePending
                    "
                    class="dev-callout"
                >
                    <p v-if="connectedAccountId">
                        Your connected account ID is:
                        <code class="bold">{{ connectedAccountId }}</code>
                    </p>
                    <p v-if="accountCreatePending">
                        Creating a connected account...
                    </p>
                    <p v-if="accountLinkCreatePending">
                        Creating a new Account Link...
                    </p>
                </div>
            </div>
            <hr />
            <div class="p-4 sm:rounded-lg sm:p-8">
                <DeleteUserForm class="max-w-xl" />
            </div>
        </div>
    </div>
</template>
