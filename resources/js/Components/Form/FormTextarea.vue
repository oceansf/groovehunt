<script setup>
import { defineProps, defineEmits } from "vue";
import FormInputLabel from "./FormInputLabel.vue";
import FormError from "./FormError.vue";

defineProps({
    form: {
        type: Object,
        required: true
    },
    modelValue: {
        type: String,
        default: ""
    },
    id: {
        type: String,
        required: true
    },
    label: {
        type: String,
        required: true
    },
    optional: {
        type: Boolean,
        default: false
    },
    helpText: {
        type: String,
        default: ""
    },
    rows: {
        type: Number,
        default: 4
    },
    placeholder: {
        type: String,
        default: ""
    }
});

const emit = defineEmits(["update:modelValue"]);
</script>

<template>
    <div>
        <FormInputLabel 
            :for="id" 
            :text="label" 
            :optional="optional" 
        />
        <p 
            v-if="helpText"
            class="mt-1 text-sm text-gray-500"
        >
            {{ helpText }}
        </p>
        <div class="mt-2">
            <textarea
                :id="id"
                :value="modelValue"
                @input="emit('update:modelValue', $event.target.value)"
                :rows="rows"
                :placeholder="placeholder"
                class="block w-full rounded-md border-0 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
            />
            <FormError :message="form?.errors?.[id]" />
        </div>
    </div>
</template>