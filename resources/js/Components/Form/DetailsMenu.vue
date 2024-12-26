<script setup>
import { ref } from "vue";
import FormSelectInput from "./FormSelectInput.vue";
import FormInputLabel from "./FormInputLabel.vue";
import FormTextInput from "./FormTextInput.vue";

defineProps({
    form: {
        type: Object,
        required: true,
    },
    type: String,
    options: Array,
    modelValue: [String, Number],
    id: String,
    label: String,
    optional: {
        type: Boolean,
        default: false,
    },
});

const isOpen = ref(false);

const genres = [
    { value: "Blues", label: "Blues" },
    { value: "Brass & Military", label: "Brass & Military" },
    { value: "Children's", label: "Children's" },
    { value: "Classical", label: "Classical" },
    { value: "Electronic", label: "Electronic" },
    { value: "Folk, World, & Country", label: "Folk, World, & Country" },
    { value: "Funk / Soul", label: "Funk / Soul" },
    { value: "Hip-Hop", label: "Hip-Hop" },
    { value: "Jazz", label: "Jazz" },
    { value: "Latin", label: "Latin" },
    { value: "Non-Music", label: "Non-Music" },
    { value: "Pop", label: "Pop" },
    { value: "Reggae", label: "Reggae" },
    { value: "Rock", label: "Rock" },
    { value: "Stage & Screen", label: "Stage & Screen" },
];

const speeds = [
    { value: "33", label: "33 RPM" },
    { value: "45", label: "45 RPM" },
    { value: "16", label: "16 RPM" },
    { value: "78", label: "78 RPM" },
];

const sizes = [
    { value: "12", label: '12"' },
    { value: "7", label: '7"' },
    { value: "10", label: '10"' },
    { value: "2", label: '2"' },
    { value: "3", label: '3"' },
    { value: "5", label: '5"' },
    { value: "6", label: '6"' },
    { value: "8", label: '8"' },
    { value: "9", label: '9"' },
    { value: "11", label: '11"' },
    { value: "13", label: '13"' },
];

const types = [
    { value: "lp", label: "LP" },
    { value: "ep", label: "EP" },
    { value: "box-set", label: "Box Set" },
    { value: "double-lp", label: "Double LP" },
    { value: "maxi-single", label: "Maxi-Single" },
    { value: "mini-lp", label: "Mini LP" },
    { value: "single", label: "Single" },
    { value: "triple-lp", label: "Triple LP" },
];

const colors = [
    { value: "black", label: "Black" },
    { value: "beige", label: "Beige" },
    { value: "blue", label: "Blue" },
    { value: "brown", label: "Brown" },
    { value: "gold", label: "Gold" },
    { value: "gray", label: "Gray" },
    { value: "green", label: "Green" },
    { value: "orange", label: "Orange" },
    { value: "pink", label: "Pink" },
    { value: "purple", label: "Purple" },
    { value: "red", label: "Red" },
    { value: "yellow", label: "Yellow" },
    { value: "multicolor", label: "Multicolor" },
    { value: "clear", label: "Clear" },
    { value: "white", label: "White" },
    { value: "picture", label: "Picture Disc" },
    { value: "splatter", label: "Splatter" },
    { value: "marble", label: "Marble" },
    { value: "split", label: "Split Color" },
];
</script>

<template>
    <!-- Collapsible content -->
    <div class="w-full rounded-lg bg-slate-50 p-4">
        <!-- Main collapsible button -->
        <button
            type="button"
            @click="isOpen = !isOpen"
            class="flex w-full items-center justify-between rounded-lg transition-colors duration-200"
        >
            <FormInputLabel text="Additional item details" optional />
        </button>
        <p class="mt-1 text-sm leading-6 text-gray-600">
            Enter more details to help buyers find your listing.
        </p>
        <div class="mt-4 space-y-2">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <FormSelectInput
                    :form="form"
                    v-model="form.genre"
                    id="genre"
                    type="genre"
                    :options="genres"
                    label="Genre"
                    :optional="true"
                />
                <FormSelectInput
                    :form="form"
                    v-model="form.speed"
                    id="speed"
                    type="speed"
                    :options="speeds"
                    label="Speed"
                    :optional="true"
                />
                <FormSelectInput
                    :form="form"
                    v-model="form.color"
                    id="color"
                    type="color"
                    :options="colors"
                    label="Color"
                    :optional="true"
                />
            </div>
        </div>

        <!-- Collapsible content -->
        <div v-show="isOpen" class="mt-4 space-y-4">
            <div class="space-y-2">
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <FormTextInput
                        :form="form"
                        v-model="form.release_country"
                        id="release_country"
                        label="Country/Region of Manufacture"
                        placeholder="United States"
                        :optional="true"
                    />
                    <FormTextInput
                        :form="form"
                        v-model="form.release_year"
                        id="release_year"
                        label="Release Year"
                        :placeholder="new Date().getFullYear().toString()"
                        :optional="true"
                    />
                    <FormTextInput
                        :form="form"
                        v-model="form.release_label"
                        id="release_label"
                        label="Record Label"
                        placeholder="e.g., Universal Music Group"
                        :optional="true"
                    />
                    <FormTextInput
                        :form="form"
                        v-model="form.release_cat_no"
                        id="release_cat_no"
                        label="Catalog Number"
                        placeholder="e.g., SAMLP000"
                        :optional="true"
                    />
                    <FormTextInput
                        :form="form"
                        v-model="form.release_matrix_no"
                        id="release_matrix_no"
                        label="Vinyl Matrix Number"
                        placeholder="e.g., XTAL001-A, SD 18114-A, ST-AL-32037"
                        :optional="true"
                    />
                    <FormTextInput
                        :form="form"
                        v-model="form.release_upc"
                        id="release_upc"
                        label="UPC"
                        placeholder="e.g., XTAL001-A"
                        :optional="true"
                    />
                </div>
            </div>
        </div>
        <button
            type="button"
            @click="isOpen = !isOpen"
            class="mt-4 font-medium hover:underline"
        >
            <div class="flex items-center">
                <span>Show {{ isOpen ? "less" : "more" }}</span>
                <svg
                    class="h-5 w-5"
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
            </div>
        </button>
    </div>
</template>
