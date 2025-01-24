<script setup>
import { Disclosure, DisclosureButton, DisclosurePanel } from "@headlessui/vue";
import { PlusIcon, MinusIcon, XMarkIcon } from "@heroicons/vue/24/outline";
import FilterIcon from "./FilterIcon.vue";
import filtersArr from "../Shared/filtersArr";
import { ref, computed } from "vue";

const props = defineProps({
    filters: Array,
});

const checkedFilters = ref(props.filters);

const emit = defineEmits(["handleChange"]);
const clearFilters = () => {
    checkedFilters.value = [];
    emit("handleChange", checkedFilters.value);
};

// Compute the active filter tags with their labels
const activeFilterTags = computed(() => {
    const tags = [];
    filtersArr.forEach((section) => {
        section.options.forEach((option) => {
            if (checkedFilters.value.includes(option.value)) {
                tags.push({
                    value: option.value,
                    label: option.label,
                });
            }
        });
    });
    return tags;
});

const removeFilter = (filterValue) => {
    checkedFilters.value = checkedFilters.value.filter(
        (value) => value !== filterValue,
    );
    emit("handleChange", checkedFilters.value);
};
</script>

<template>
    <div
        class="no-scrollbar sticky top-[92px] hidden h-screen overflow-y-scroll pb-36 pr-4 lg:block"
    >
        <form @submit.prevent="">
            <div class="mb-2 flex flex-col gap-2">
                <h2 class="text-xl font-medium">Filters</h2>
            </div>
            <button
                v-if="checkedFilters.length > 0"
                type="button"
                @click="clearFilters"
                class="mb-2 w-full rounded-md border border-slate-300 bg-gray-50 px-2 py-1 text-slate-700 transition hover:bg-gray-100"
            >
                Clear Filters
            </button>
            <!-- Active Filter Tags -->
            <div
                v-if="activeFilterTags.length > 0"
                class="flex flex-wrap gap-2"
            >
                <div
                    v-for="tag in activeFilterTags"
                    :key="tag.value"
                    class="inline-flex items-center gap-1 rounded-full bg-blue-50 px-2 py-1 text-sm text-blue-600"
                >
                    <span>{{ tag.label }}</span>
                    <button
                        type="button"
                        @click="removeFilter(tag.value)"
                        class="inline-center rounded-full hover:bg-blue-100"
                    >
                        <XMarkIcon class="h-4 w-4" aria-hidden="true" />
                        <span class="sr-only"
                            >Remove filter for {{ tag.label }}</span
                        >
                    </button>
                </div>
            </div>
            <Disclosure
                as="div"
                v-for="section in filtersArr"
                :key="section.id"
                class="border-b border-gray-200 py-6"
                v-slot="{ open }"
                default-open
            >
                <h3 class="-my-3 flow-root">
                    <DisclosureButton
                        class="flex w-full items-center justify-between bg-white py-3 text-sm text-gray-400 hover:text-gray-500"
                    >
                        <div class="flex items-center gap-2">
                            <FilterIcon
                                :icon="section.name.toLowerCase()"
                                class="h-5 w-5"
                                aria-hidden="true"
                            />
                            <span class="font-medium text-gray-900">{{
                                section.name
                            }}</span>
                        </div>
                        <span class="ml-6 flex items-center">
                            <PlusIcon
                                v-if="!open"
                                class="h-5 w-5"
                                aria-hidden="true"
                            />
                            <MinusIcon
                                v-else
                                class="h-5 w-5"
                                aria-hidden="true"
                            />
                        </span>
                    </DisclosureButton>
                </h3>
                <DisclosurePanel open class="pt-6">
                    <div class="space-y-4 pl-1">
                        <div
                            v-for="(option, optionIdx) in section.options"
                            :key="option.value"
                            class="flex items-center"
                        >
                            <input
                                @change="$emit('handleChange', checkedFilters)"
                                v-model="checkedFilters"
                                :id="`filter-${section.id}-${optionIdx}`"
                                :name="`${section.id}[]`"
                                :value="option.value"
                                type="checkbox"
                                class="h-4 w-4 cursor-pointer rounded border-gray-300 text-blue-500 focus:ring-blue-500"
                            />
                            <label
                                :for="`filter-${section.id}-${optionIdx}`"
                                class="ml-3 cursor-pointer text-sm text-gray-600"
                            >
                                {{ option.label }}
                            </label>
                        </div>
                    </div>
                </DisclosurePanel>
            </Disclosure>
        </form>
    </div>
</template>
