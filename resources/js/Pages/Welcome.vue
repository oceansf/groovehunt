<script setup>
import { ref, computed } from "vue";
import { useWindowSize } from "@vueuse/core";
import Navbar from "../Components/Navbar.vue";
import ListingCard from "../Components/ListingCard.vue";
import vinylReleasesData from "../vinylReleases.json";

import Layout from '../Layouts/AppLayout.vue';

const { width, height } = useWindowSize();
const vinylReleases = ref(vinylReleasesData.vinylReleases);

</script>

<template>
<Layout>
    <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-1 md:gap-2">
            <ListingCard
                v-for="release in vinylReleases"
                :key="release.id"
                :release="release"
                :window-width="width"
            />
        </div>
    </div>
</Layout>

</template>
