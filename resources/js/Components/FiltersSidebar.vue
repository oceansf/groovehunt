<script setup>
import { Disclosure, DisclosureButton, DisclosurePanel } from "@headlessui/vue";
import { PlusIcon, MinusIcon } from "@heroicons/vue/24/outline";
import FilterIcon from "./FilterIcon.vue";
import filtersArr from "../Shared/filtersArr";
import { router } from "@inertiajs/vue3";
import { ref, reactive, computed } from "vue";

const selectedFilters = reactive({});

const hasSelectedFilters = computed(() => {
    return Object.values(selectedFilters).some(
        (filters) => Array.isArray(filters) && filters.length > 0,
    );
});

const isOptionSelected = (sectionId, optionValue) => {
    return selectedFilters[sectionId]?.includes(optionValue) || false;
};

const handleSubmit = () => {
    console.log("Sending filters:", selectedFilters);
    // Remove the data nesting, send filters directly
    router.get("/", {
        ...selectedFilters,
        preserveState: true,
        preserveScroll: true,
    });
};

const handleFilterChange = (sectionId, optionValue, optionChecked) => {
    if (!selectedFilters[sectionId]) {
        selectedFilters[sectionId] = [];
    }

    if (optionChecked) {
        selectedFilters[sectionId].push(optionValue);
    } else {
        const index = selectedFilters[sectionId].indexOf(optionValue);
        if (index > -1) {
            selectedFilters[sectionId].splice(index, 1);
        }
    }
};
</script>

<template>
    <div
        class="sticky top-[96px] hidden h-screen overflow-y-auto pb-36 pr-4 lg:block"
    >
        <form @submit.prevent="handleSubmit">
            <div class="mb-2 flex flex-col gap-2">
                <h2 class="text-xl font-medium">Filters</h2>
                <button
                    v-if="hasSelectedFilters"
                    type="submit"
                    class="rounded bg-blue-500 px-4 py-2 text-white transition-colors hover:bg-blue-600"
                >
                    Apply Filters
                </button>
            </div>
            <Disclosure
                as="div"
                v-for="section in filtersArr"
                :key="section.id"
                class="border-b border-gray-200 py-6"
                v-slot="{ open }"
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
                <DisclosurePanel class="pt-6">
                    <div class="space-y-4 pl-1">
                        <div
                            v-for="(option, optionIdx) in section.options"
                            :key="option.value"
                            class="flex items-center"
                        >
                            <input
                                @change="
                                    handleFilterChange(
                                        section.id,
                                        option.value,
                                        $event.target.checked,
                                    )
                                "
                                :id="`filter-${section.id}-${optionIdx}`"
                                :name="`${section.id}[]`"
                                :value="option.value"
                                type="checkbox"
                                :checked="
                                    isOptionSelected(section.id, option.value)
                                "
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
