<template>
    <div class="w-full">
        <!-- Main collapsible button -->
        <button
            type="button"
            @click="isOpen = !isOpen"
            class="flex w-full items-center justify-between rounded-lg transition-colors duration-200"
        >
            <span class="font-medium text-gray-800"
                >Additional item details
                <em class="font-light text-slate-500">Optional</em></span
            >
            <svg
                class="h-5 w-5 transition-transform duration-200"
                :class="{ 'rotate-180': isOpen }"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 20 20"
                fill="currentColor"
            >
                <path
                    fill-rule="evenodd"
                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                    clip-rule="evenodd"
                />
            </svg>
        </button>
        <p class="mt-1 text-sm leading-6 text-gray-600">
            Enter more details to give buyers more information about your
            listing.
        </p>

        <!-- Collapsible content -->
        <div
            v-show="isOpen"
            class="mt-2 space-y-4 rounded-lg border border-gray-200 p-4"
        >
            <!-- Pressing Information -->
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">
                    Pressing Information
                </label>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div>
                        <label class="block text-sm text-gray-600"
                            >Country</label
                        >
                        <input
                            type="text"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        />
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600"
                            >Release Year</label
                        >
                        <input
                            type="text"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        />
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600">Genre</label>
                        <select
                            id="genre"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        >
                            <option value="">Select a genre</option>
                            <option
                                v-for="genre in genres"
                                :key="genre.value"
                                :value="genre.value"
                            >
                                {{ genre.label }}
                            </option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Matrix/Runout Numbers -->
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">
                    Matrix/Runout Numbers
                </label>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div>
                        <label class="block text-sm text-gray-600"
                            >Side A</label
                        >
                        <input
                            type="text"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        />
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600"
                            >Side B</label
                        >
                        <input
                            type="text"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        />
                    </div>
                </div>
            </div>

            <!-- Detailed Condition -->
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">
                    Detailed Condition Notes
                </label>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm text-gray-600"
                            >Vinyl Condition Details</label
                        >
                        <textarea
                            rows="3"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            placeholder="Describe any specific marks, scratches, or playback issues..."
                        ></textarea>
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600"
                            >Sleeve Condition Details</label
                        >
                        <textarea
                            rows="3"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            placeholder="Describe any wear, seam splits, or other sleeve details..."
                        ></textarea>
                    </div>
                </div>
            </div>

            <!-- Additional Features -->
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">
                    Additional Features
                </label>
                <div class="space-y-2">
                    <label class="flex items-center space-x-2">
                        <input
                            type="checkbox"
                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                        />
                        <span class="text-sm text-gray-600"
                            >Gatefold Sleeve</span
                        >
                    </label>
                    <label class="flex items-center space-x-2">
                        <input
                            type="checkbox"
                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                        />
                        <span class="text-sm text-gray-600"
                            >Includes Original Inserts</span
                        >
                    </label>
                    <label class="flex items-center space-x-2">
                        <input
                            type="checkbox"
                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                        />
                        <span class="text-sm text-gray-600">Colored Vinyl</span>
                    </label>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";

const isOpen = ref(false);

const genres = [
    { value: "blues", label: "Blues" },
    { value: "brass-military", label: "Brass & Military" },
    { value: "children", label: "Children's" },
    { value: "classical", label: "Classical" },
    { value: "electronic", label: "Electronic" },
    { value: "folk-world-country", label: "Folk, World, & Country" },
    { value: "funk-soul", label: "Funk / Soul" },
    { value: "hip-hop", label: "Hip-Hop" },
    { value: "jazz", label: "Jazz" },
    { value: "latin", label: "Latin" },
    { value: "non-music", label: "Non-Music" },
    { value: "pop", label: "Pop" },
    { value: "reggae", label: "Reggae" },
    { value: "rock", label: "Rock" },
    { value: "stage-screen", label: "Stage & Screen" },
];
</script>
