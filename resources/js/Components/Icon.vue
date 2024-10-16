<script setup>
import {
    MusicalNoteIcon,
    CalendarDateRangeIcon,
    GlobeAmericasIcon,
} from "@heroicons/vue/20/solid";
import { Disc } from "lucide-vue-next";

defineProps({
    icon: String,
});
</script>

<template>
    <MusicalNoteIcon v-if="icon === 'genre'" />
    <Disc v-else-if="icon === 'format'" :size="20" />
    <GlobeAmericasIcon v-else-if="icon === 'country'" />
    <CalendarDateRangeIcon v-else-if="icon === 'decade'" />
</template>
