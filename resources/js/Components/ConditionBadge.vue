<script setup>
import { computed } from "vue";

const props = defineProps({
    condition: {
        type: String,
        required: true,
    },
    size: {
        type: String,
        default: "md",
        validator: (value) => ["sm", "md", "lg"].includes(value),
    },
});

const formattedCondition = computed(() => {
    return props.condition.replace("Plus", "+");
});

const conditionColorClass = computed(() => {
    switch (props.condition) {
        case "Mint":
        case "Near Mint":
        case "Very Good Plus":
        case "Very Good":
            return "bg-green-100 text-green-800";
        case "Good Plus":
        case "Good":
            return "bg-blue-100 text-blue-800";
        case "Fair":
            return "bg-yellow-100 text-yellow-800";
        case "Poor":
            return "bg-red-100 text-red-800";
        default:
            return "bg-gray-100 text-gray-800";
    }
});
</script>

<template>
    <span
        :class="[
            'rounded-full font-semibold',
            {
                'px-2 py-0.5 text-xs': size === 'sm',
                'px-3 py-1 text-sm': size === 'md',
                'px-4 py-1.5 text-base': size === 'lg',
            },
            conditionColorClass,
        ]"
    >
        {{ formattedCondition }}
    </span>
</template>
