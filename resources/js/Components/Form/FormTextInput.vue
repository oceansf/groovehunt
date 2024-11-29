<script setup>
import { defineProps, defineEmits } from "vue";
import FormInputLabel from "./FormInputLabel.vue";
import FormError from "./FormError.vue";

const props = defineProps({
    form: {
        type: Object,
        required: true,
    },
    modelValue: {
        type: [String, Number],
        default: "",
    },
    value: {
        type: [String, Number],
        default: "",
    },
    placeholder: {
        type: String,
        default: "",
    },
    id: {
        type: String,
        required: true,
    },
    label: {
        type: String,
        required: true,
    },
    optional: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(["update:modelValue"]);
</script>

<template>
    <div>
        <FormInputLabel :for="id" :text="label" :optional="optional" />
        <input
            :id="id"
            type="text"
            :value="modelValue"
            @input="emit('update:modelValue', $event.target.value)"
            :placeholder="placeholder"
            class="mt-1 block w-full rounded-md border-0 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-500 sm:text-sm sm:leading-6"
        />
        <FormError :message="form?.errors?.[id]" />
    </div>
</template>
