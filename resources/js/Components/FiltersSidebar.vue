<script setup>
import { Disclosure, DisclosureButton, DisclosurePanel } from "@headlessui/vue";
import { PlusIcon, MinusIcon } from "@heroicons/vue/24/outline";
import FilterIcon from "./FilterIcon.vue";

defineProps({
    filters: Array,
});
</script>

<template>
    <div
        class="sticky top-[95px] z-10 hidden h-screen overflow-y-auto pb-36 pr-4 lg:block"
    >
        <h2 class="hidden text-xl font-medium md:inline-block">Filters</h2>
        <form>
            <Disclosure
                as="div"
                v-for="section in filters"
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
                                :icon="section.name.toLocaleLowerCase()"
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
                                :id="`filter-${section.id}-${optionIdx}`"
                                :name="`${section.id}[]`"
                                :value="option.value"
                                type="checkbox"
                                :checked="option.checked"
                                class="h-4 w-4 cursor-pointer rounded border-gray-300 text-blue-500 focus:ring-blue-500"
                            />
                            <label
                                :for="`filter-${section.id}-${optionIdx}`"
                                class="ml-3 cursor-pointer text-sm text-gray-600"
                            >
                                {{ option.label }}</label
                            >
                        </div>
                    </div>
                </DisclosurePanel>
            </Disclosure>
        </form>
    </div>
</template>
