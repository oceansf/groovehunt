<script setup>
import {
    Dialog,
    DialogPanel,
    Disclosure,
    DisclosureButton,
    DisclosurePanel,
    TransitionChild,
    TransitionRoot,
} from "@headlessui/vue";
import { XMarkIcon, PlusIcon, MinusIcon } from "@heroicons/vue/24/outline";
import FilterIcon from "./FilterIcon.vue";
import filtersArr from "../Shared/filtersArr";
import { ref} from "vue";

const props = defineProps({
    mobileFiltersOpen: Boolean,
    filters: Array,
});

const emit = defineEmits(["update:mobileFiltersOpen", "handleSubmit"]);

const selectedFilters = ref(props.filters);

const handleSubmit = () => {
    emit("handleSubmit", selectedFilters.value);
    closeDialog();
};

const closeDialog = () => {
    emit("update:mobileFiltersOpen", false);
};
</script>

<template>
    <TransitionRoot as="template" :show="mobileFiltersOpen">
        <Dialog
            as="div"
            class="relative z-40 lg:hidden"
            @close="closeDialog"
        >
            <TransitionChild
                as="template"
                enter="transition-opacity ease-linear duration-300"
                enter-from="opacity-0"
                enter-to="opacity-100"
                leave="transition-opacity ease-linear duration-300"
                leave-from="opacity-100"
                leave-to="opacity-0"
            >
                <div class="fixed inset-0 bg-black bg-opacity-25" />
            </TransitionChild>

            <div class="fixed inset-0 z-40 flex">
                <TransitionChild
                    as="template"
                    enter="transition ease-in-out duration-300 transform"
                    enter-from="translate-x-full"
                    enter-to="translate-x-0"
                    leave="transition ease-in-out duration-300 transform"
                    leave-from="translate-x-0"
                    leave-to="translate-x-full"
                >
                    <DialogPanel
                        class="relative ml-auto flex h-full w-full max-w-xs flex-col overflow-y-auto bg-white py-4 pb-12 shadow-xl"
                    >
                        <div class="flex items-center justify-between px-4">
                            <h2 class="text-lg font-medium text-gray-900">
                                Filters
                            </h2>
                            <button
                                type="button"
                                class="-mr-2 flex h-10 w-10 items-center justify-center rounded-md bg-white p-2 text-gray-400"
                                @click="closeDialog"
                            >
                                <span class="sr-only">Close menu</span>
                                <XMarkIcon class="h-6 w-6" aria-hidden="true" />
                            </button>
                        </div>

                        <!-- Filters -->
                        <form
                            @submit.prevent="handleSubmit"
                            class="mt-4 flex flex-col"
                        >
                            <div class="px-4" v-if="selectedFilters.length > 0">
                                <button
                                    type="submit"
                                    class="w-full rounded bg-slate-900 px-4 py-2 text-white transition hover:bg-slate-700"
                                >
                                    Apply Filters
                                </button>
                            </div>

                            <div
                                class="mt-4 flex-1 overflow-y-auto border-t border-gray-200"
                            >
                                <h3 class="sr-only">Filters</h3>

                                <Disclosure
                                    as="div"
                                    v-for="section in filtersArr"
                                    :key="section.id"
                                    class="border-t border-gray-200 px-4 py-6"
                                    v-slot="{ open }"
                                >
                                    <h3 class="-mx-2 -my-3 flow-root">
                                        <DisclosureButton
                                            class="flex w-full items-center justify-between bg-white px-2 py-3 text-gray-400 hover:text-gray-500"
                                        >
                                            <div
                                                class="flex items-center gap-2"
                                            >
                                                <FilterIcon
                                                    :icon="
                                                        section.name.toLowerCase()
                                                    "
                                                    class="h-5 w-5"
                                                    aria-hidden="true"
                                                />
                                                <span
                                                    class="font-medium text-gray-900"
                                                >
                                                    {{ section.name }}
                                                </span>
                                            </div>
                                            <span
                                                class="ml-6 flex items-center"
                                            >
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
                                        <div class="space-y-6">
                                            <div
                                                v-for="(
                                                    option, optionIdx
                                                ) in section.options"
                                                :key="option.value"
                                                class="flex items-center"
                                            >
                                                <input
                                                    v-model="selectedFilters"
                                                    :id="`filter-mobile-${section.id}-${optionIdx}`"
                                                    :name="`${section.id}[]`"
                                                    :value="option.value"
                                                    type="checkbox"
                                                    class="h-4 w-4 rounded border-gray-300 text-blue-500 focus:ring-blue-500"
                                                />
                                                <label
                                                    :for="`filter-mobile-${section.id}-${optionIdx}`"
                                                    class="ml-3 min-w-0 flex-1 text-gray-600"
                                                >
                                                    {{ option.label }}
                                                </label>
                                            </div>
                                        </div>
                                    </DisclosurePanel>
                                </Disclosure>
                            </div>
                        </form>
                    </DialogPanel>
                </TransitionChild>
            </div>
        </Dialog>
    </TransitionRoot>
</template>
