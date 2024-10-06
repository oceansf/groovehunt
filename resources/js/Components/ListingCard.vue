<script setup>
import { computed } from "vue";

const props = defineProps({
    release: Object,
    windowWidth: Number,
});

const titleClass = computed(() =>
    props.windowWidth < 768
        ? "text-sm font-bold text-black"
        : "text-base font-bold text-black"
);

const truncatedTitle = computed(() =>
    truncateText(props.windowWidth < 768 ? 18 : 28, props.release.title)
);

const truncatedArtist = computed(() => truncateText(18, props.release.artist));

const price = computed(() => (Math.random() * 50 + 10).toFixed());

function truncateText(length, text) {
    return text.length <= length ? text : `${text.slice(0, length)}...`;
}
</script>

<template>
    <div>
          <img
              class="h-auto max-w-full rounded-lg"
              src="https://placehold.co/600x600?text=Album+Cover"
              alt=""
          />    
        <div class="flex justify-between mt-2 px-1 mb-2">
            <div class="flex flex-col">
                <span :class="titleClass">
                    {{ truncatedTitle }}
                </span>
                <span class="text-sm md:text-base text-slate-500">
                    {{ truncatedArtist }}
                </span>
            </div>
            <div class="flex flex-col">
                <span class="text-sm md:text-base font-bold self-end">
                    ${{ price }}
                </span>
            </div>
        </div>
    </div>
</template>
