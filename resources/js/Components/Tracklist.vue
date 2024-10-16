<template>
    <div class="w-full/12">
        <div class="inline-block min-w-full py-2 align-middle">
            <table class="min-w-full divide-y divide-gray-300">
                <tbody class="divide-y divide-gray-200">
                    <tr v-for="track in tracks" :key="track.location">
                        <td
                            class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0"
                        >
                            {{ track.location }}
                        </td>
                        <td
                            class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"
                        >
                            {{ track.title }}
                        </td>
                        <td
                            class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"
                        >
                            {{ track.length }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script setup>
const tracks = [
    { location: "A1", title: "So What", length: "9:22" },
    { location: "A2", title: "Freddie Freeloader", length: "9:46" },
    { location: "A3", title: "Blue In Green", length: "5:37" },
    { location: "B1", title: "All Blues", length: "11:33" },
    { location: "B2", title: "Flamenco Sketches", length: "9:26" },
    // More people...
];
</script>
