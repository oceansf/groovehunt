<script setup>
import { Disclosure, DisclosureButton, DisclosurePanel } from "@headlessui/vue";
import { PlusIcon, MinusIcon } from "@heroicons/vue/24/outline";
import FilterIcon from "./FilterIcon.vue";
import filtersArr from "../Shared/filtersArr";
import { ref } from "vue";

const props = defineProps({
    filters: Array,
});

const checkedFilters = ref(props.filters);

</script>

<template>
    <div
        class="sticky top-[92px] hidden h-screen overflow-y-scroll no-scrollbar pb-36 pr-4 lg:block"
    >
        <form @submit.prevent="">
            <div class="mb-2 flex flex-col gap-2">
                <h2 class="text-xl font-medium">Filters</h2>
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
                        class="flex w-full items-center justify-between bg-slate-50 py-3 text-sm text-gray-400 hover:text-gray-500"
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
