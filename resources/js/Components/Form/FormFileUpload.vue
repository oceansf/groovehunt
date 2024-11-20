<script setup>
import { ref, onBeforeUnmount } from "vue";
import { PhotoIcon, XMarkIcon } from "@heroicons/vue/24/solid";
import FormInputLabel from "./FormInputLabel.vue";
import FormError from "./FormError.vue";

const props = defineProps({
    form: {
        type: Object,
        required: true,
    },
    modelValue: {
        type: Array,
        default: () => [],
    },
    id: {
        type: String,
        required: true,
    },
    label: {
        type: String,
        required: true,
    },
    helpText: {
        type: String,
        default: "",
    },
    maxFiles: {
        type: Number,
        default: 12,
    },
    maxFileSize: {
        type: Number,
        default: 10,
    },
});

const emit = defineEmits(["update:modelValue"]);
const fileInput = ref(null);
const dragOver = ref(false);
const previewUrls = ref([]);

// Create preview URLs for the images
const updatePreviews = (files) => {
    // Clear old preview URLs
    previewUrls.value.forEach((url) => URL.revokeObjectURL(url));
    previewUrls.value = Array.from(files).map((file) =>
        URL.createObjectURL(file),
    );
};

const handleFileUpload = (e) => {
    const newFiles = Array.from(e.target.files || e.dataTransfer.files);
    const totalFiles = props.modelValue.length + newFiles.length;

    // Validate number of files
    if (totalFiles > props.maxFiles) {
        alert(`You can only upload up to ${props.maxFiles} files`);
        if (fileInput.value) fileInput.value.value = "";
        return;
    }

    // Validate file sizes
    const oversizedFiles = newFiles.filter(
        (file) => file.size > props.maxFileSize * 1024 * 1024,
    );
    if (oversizedFiles.length > 0) {
        alert(`Some files exceed the ${props.maxFileSize}MB limit`);
        if (fileInput.value) fileInput.value.value = "";
        return;
    }

    const updatedFiles = [...props.modelValue, ...newFiles];
    emit("update:modelValue", updatedFiles);
    updatePreviews(updatedFiles);
};

const handleDragOver = (e) => {
    e.preventDefault();
    dragOver.value = true;
};

const handleDragLeave = (e) => {
    e.preventDefault();
    dragOver.value = false;
};

const handleDrop = (e) => {
    e.preventDefault();
    dragOver.value = false;
    handleFileUpload(e);
};

const removeFile = (index) => {
    const newFiles = [...props.modelValue];
    newFiles.splice(index, 1);
    emit("update:modelValue", newFiles);

    // Remove preview URL
    URL.revokeObjectURL(previewUrls.value[index]);
    previewUrls.value.splice(index, 1);
};

const clearFiles = () => {
    emit("update:modelValue", []);
    // Clear preview URLs
    previewUrls.value.forEach((url) => URL.revokeObjectURL(url));
    previewUrls.value = [];
    if (fileInput.value) fileInput.value.value = "";
};

// Initialize previews if there are existing files
if (props.modelValue.length > 0) {
    updatePreviews(props.modelValue);
}

// Cleanup preview URLs when component is unmounted
onBeforeUnmount(() => {
    previewUrls.value.forEach((url) => URL.revokeObjectURL(url));
});
</script>

<template>
    <div>
        <FormInputLabel :for="id" :text="label" />
        <p v-if="helpText" class="mt-1 text-sm leading-6 text-gray-600">
            {{ helpText }}
        </p>

        <!-- Drag and drop zone -->
        <div
            :class="[
                'mt-2 flex justify-center rounded-lg border-2 border-dashed px-6 py-10',
                dragOver ? 'border-blue-500 bg-blue-50' : 'border-gray-900/25',
                modelValue.length > 0 && 'bg-gray-50',
            ]"
            @dragover="handleDragOver"
            @dragleave="handleDragLeave"
            @drop="handleDrop"
        >
            <div class="w-full text-center">
                <!-- Upload UI when no files are selected -->
                <div v-if="!modelValue.length">
                    <PhotoIcon
                        class="mx-auto h-12 w-12 text-gray-300"
                        aria-hidden="true"
                    />
                    <div
                        class="mt-4 flex justify-center text-sm leading-6 text-gray-600"
                    >
                        <label
                            :for="id"
                            class="relative cursor-pointer rounded-md bg-white font-semibold text-blue-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-blue-600 focus-within:ring-offset-2 hover:text-blue-500"
                        >
                            <span>Upload images</span>
                            <input
                                :id="id"
                                ref="fileInput"
                                type="file"
                                multiple
                                accept="image/*"
                                class="sr-only"
                                @change="handleFileUpload"
                            />
                        </label>
                        <p class="pl-1">or drag and drop</p>
                    </div>
                    <p class="text-xs leading-5 text-gray-600">
                        PNG, JPG, GIF up to {{ maxFileSize }}MB each (max
                        {{ maxFiles }} files)
                    </p>
                </div>

                <!-- Image previews when files are selected -->
                <div v-else class="w-full">
                    <div class="mb-4 flex items-center justify-between">
                        <span class="text-sm text-gray-500">
                            {{ modelValue.length }} image{{
                                modelValue.length !== 1 ? "s" : ""
                            }}
                            selected
                        </span>
                        <div class="flex gap-2">
                            <label
                                :for="id"
                                class="cursor-pointer text-sm text-blue-600 hover:text-blue-700"
                            >
                                Add more
                                <input
                                    :id="id"
                                    ref="fileInput"
                                    type="file"
                                    multiple
                                    accept="image/*"
                                    class="sr-only"
                                    @change="handleFileUpload"
                                />
                            </label>
                            <button
                                type="button"
                                class="text-sm text-red-500 hover:text-red-700"
                                @click="clearFiles"
                            >
                                Clear all
                            </button>
                        </div>
                    </div>

                    <!-- Image grid -->
                    <div
                        class="grid grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-4"
                    >
                        <div
                            v-for="(file, index) in modelValue"
                            :key="index"
                            class="aspect-square group relative"
                        >
                            <img
                                :src="previewUrls[index]"
                                :alt="`Preview ${index + 1}`"
                                class="h-full w-full rounded-lg object-cover"
                            />
                            <div
                                class="absolute inset-0 rounded-lg bg-black bg-opacity-0 transition-all group-hover:bg-opacity-40"
                            >
                                <button
                                    type="button"
                                    class="absolute right-2 top-2 rounded-full bg-white p-1 opacity-0 transition-opacity group-hover:opacity-100"
                                    @click="removeFile(index)"
                                >
                                    <XMarkIcon class="h-4 w-4 text-gray-600" />
                                </button>
                            </div>
                            <div
                                class="absolute bottom-2 left-2 text-xs text-white opacity-0 transition-opacity group-hover:opacity-100"
                            >
                                {{ (file.size / 1024 / 1024).toFixed(1) }}MB
                            </div>
                            <div
                                v-if="index === 0"
                                class="absolute left-2 top-2 rounded-md bg-blue-500 px-2 py-1 text-xs text-white"
                            >
                                Cover
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <FormError :message="form?.errors?.[id]" />
    </div>
</template>
