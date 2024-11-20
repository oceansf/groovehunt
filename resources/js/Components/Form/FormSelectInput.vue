<script setup>
import { defineProps, defineEmits } from "vue";
import FormInputLabel from "./FormInputLabel.vue";
import FormError from "./FormError.vue";

defineProps({
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

const emit = defineEmits(["update:modelValue"]);
</script>

<template>
    <div>
        <FormInputLabel :for="id" :text="label" :optional="optional" />
        <select
            :id="id"
            :value="modelValue"
            @input="emit('update:modelValue', $event.target.value)"
            class="mt-1 block w-full rounded-md border-0 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:cursor-pointer focus:ring-2 focus:ring-inset focus:ring-blue-500 sm:text-sm sm:leading-6"
        >
            <option selected disabled hidden value="">
                Select a {{ type }}
            </option>
            <option
                v-for="option in options"
                :key="option.value"
                :value="option.value"
            >
                {{ option.label }}
            </option>
        </select>
        <FormError :message="form?.errors?.[id]" />
    </div>
</template>
