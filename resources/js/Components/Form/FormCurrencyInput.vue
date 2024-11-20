<script setup>
import { defineProps, defineEmits } from "vue";
import FormInputLabel from "./FormInputLabel.vue";
import FormError from "./FormError.vue";

const props = defineProps({
    form: {
        type: Object,
        required: true
    },
    modelValue: {
        type: [String, Number],
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
    placeholder: {
        type: String,
        default: "0.00"
    },
    currency: {
        type: String,
        default: "USD"
    },
    currencySymbol: {
        type: String,
        default: "$"
    }
});

const emit = defineEmits(["update:modelValue"]);

const formatValue = (value) => {
    // Remove non-numeric characters except decimal point
    const numericValue = value.replace(/[^\d.]/g, "");
    
    // Ensure only one decimal point
    const parts = numericValue.split(".");
    if (parts.length > 2) {
        parts.splice(2);
    }
    
    // Limit decimal places to 2
    if (parts[1]?.length > 2) {
        parts[1] = parts[1].slice(0, 2);
    }
    
    return parts.join(".");
};

const handleInput = (event) => {
    const formattedValue = formatValue(event.target.value);
    emit("update:modelValue", formattedValue);
};

const handleBlur = (event) => {
    const value = event.target.value;
    if (value && !isNaN(parseFloat(value))) {
        // Format to always show 2 decimal places when leaving the field
        const formattedValue = parseFloat(value).toFixed(2);
        emit("update:modelValue", formattedValue);
    }
};
</script>

<template>
    <div>
        <FormInputLabel 
            :for="id" 
            :text="label"
            :optional="optional"
        />
        
        <div class="relative mt-2 rounded-md shadow-sm">
            <!-- Currency symbol -->
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                <span class="text-gray-500 sm:text-sm">{{ currencySymbol }}</span>
            </div>
            
            <!-- Input field -->
            <input
                :id="id"
                type="text"
                :value="modelValue"
                @input="handleInput"
                @blur="handleBlur"
                :placeholder="placeholder"
                class="block w-full rounded-md border-0 py-1.5 pl-7 pr-12 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-500 sm:text-sm sm:leading-6"
                :aria-describedby="`${id}-currency`"
            />
            
            <!-- Currency code -->
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                <span 
                    class="text-gray-500 sm:text-sm" 
                    :id="`${id}-currency`"
                >
                    {{ currency }}
                </span>
            </div>
        </div>
        
        <FormError :message="form?.errors?.[id]" />
    </div>
</template>