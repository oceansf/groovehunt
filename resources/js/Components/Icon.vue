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
    <div v-if="icon === 'genre'">
        <MusicalNoteIcon />
    </div>
    <div v-else-if="icon === 'format'">
        <Disc :size="20" />
    </div>
    <div v-else-if="icon === 'country'">
        <GlobeAmericasIcon />
    </div>
    <div v-else-if="icon === 'decade'">
        <CalendarDateRangeIcon />
    </div>
</template>
