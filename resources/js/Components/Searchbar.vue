<script setup>
import { ref, watch } from "vue";
import { router } from "@inertiajs/vue3";
import { MagnifyingGlassIcon } from "@heroicons/vue/20/solid";

const searchQuery = ref("");
const isLoading = ref(false);
const showResults = ref(false);

const handleSearch = (e) => {
    // Remove async since we're using Inertia
    e.preventDefault();

    if (!searchQuery.value.trim()) return;

    isLoading.value = true;
    showResults.value = true;

    router.get(
        "/search",
        {
            query: searchQuery.value,
        },
        {
            preserveState: true,
            preserveScroll: true,
            onSuccess: () => {
                isLoading.value = false;
                showResults.value = true;
            },
            onError: (errors) => {
                console.error("Search failed:", errors);
                isLoading.value = false;
            },
        },
    );
};
</script>

<template>
    <div
        class="flex items-center px-6 py-4 md:mx-auto md:max-w-3xl lg:mx-0 lg:max-w-none xl:px-0"
    >
        <div class="w-full">
            <form @submit.prevent="handleSearch">
                <label for="search" class="sr-only">Search</label>
                <div class="relative">
                    <div
                        class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3"
                    >
                        <MagnifyingGlassIcon
                            class="h-5 w-5 text-gray-400"
                            aria-hidden="true"
                        />
                    </div>
                    <input
                        id="search"
                        v-model="searchQuery"
                        name="search"
                        class="block w-full rounded-md border-0 bg-white py-1.5 pl-10 pr-3 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6"
                        placeholder="Search by title or artist..."
                        type="search"
                    />
                </div>
            </form>
        </div>
    </div>
</template>
