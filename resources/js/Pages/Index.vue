<script setup>
import { ref } from "vue";
import { Menu, MenuButton, MenuItem, MenuItems } from "@headlessui/vue";
import {
    ChevronDownIcon,
    FunnelIcon,
    ListBulletIcon,
} from "@heroicons/vue/20/solid";
import ListingsGrid from "@/Components/ListingsGrid.vue";
import MobileFilterDialog from "@/Components/MobileFilterDialog.vue";
import FiltersSidebar from "@/Components/FiltersSidebar.vue";
import filters from "../Shared/filters";

const props = defineProps({
    listings: Object,
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,

    searchResults: Array,
    filters: Object,
});

console.log(props.searchResults);

const sortOptions = [
    { name: "Most Popular", href: "#", current: true },
    { name: "Newest", href: "#", current: false },
    { name: "Seller Rating", href: "#", current: false },
    { name: "Price: Low to High", href: "#", current: false },
    { name: "Price: High to Low", href: "#", current: false },
];

const mobileFiltersOpen = ref(false);
</script>

<template>
    <div class="bg-white">
        <div>
            <MobileFilterDialog
                v-model:mobileFiltersOpen="mobileFiltersOpen"
                :filters="filters"
            />

            <main class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="flex items-baseline justify-between border-b border-gray-200 px-3 pb-6 pt-12 md:px-0"
                >
                    <h1 class="text-4xl font-bold tracking-tight text-gray-900">
                        Market
                    </h1>
                    <!-- Sort & Filter controls -->
                    <div class="flex items-center">
                        <Menu as="div" class="relative inline-block text-left">
                            <div>
                                <MenuButton
                                    class="group inline-flex justify-center text-sm font-medium text-gray-700 hover:text-gray-900"
                                >
                                    Sort
                                    <ChevronDownIcon
                                        class="-mr-1 ml-1 h-5 w-5 flex-shrink-0 text-gray-400 group-hover:text-gray-500"
                                        aria-hidden="true"
                                    />
                                </MenuButton>
                            </div>

                            <transition
                                enter-active-class="transition ease-out duration-100"
                                enter-from-class="transform opacity-0 scale-95"
                                enter-to-class="transform opacity-100 scale-100"
                                leave-active-class="transition ease-in duration-75"
                                leave-from-class="transform opacity-100 scale-100"
                                leave-to-class="transform opacity-0 scale-95"
                            >
                                <MenuItems
                                    class="absolute right-0 z-10 mt-2 w-40 origin-top-right rounded-md bg-white shadow-2xl ring-1 ring-black ring-opacity-5 focus:outline-none"
                                >
                                    <div class="py-1">
                                        <MenuItem
                                            v-for="option in sortOptions"
                                            :key="option.name"
                                            v-slot="{ active }"
                                        >
                                            <a
                                                :href="option.href"
                                                :class="[
                                                    option.current
                                                        ? 'font-medium text-gray-900'
                                                        : 'text-gray-500',
                                                    active ? 'bg-gray-100' : '',
                                                    'block px-4 py-2 text-sm',
                                                ]"
                                                >{{ option.name }}</a
                                            >
                                        </MenuItem>
                                    </div>
                                </MenuItems>
                            </transition>
                        </Menu>

                        <button
                            type="button"
                            class="-m-2 ml-5 p-2 text-gray-400 hover:text-gray-500 sm:ml-7"
                        >
                            <span class="sr-only">View list</span>
                            <ListBulletIcon
                                class="h-5 w-5"
                                aria-hidden="true"
                            />
                        </button>

                        <button
                            type="button"
                            class="-m-2 ml-4 p-2 text-gray-400 hover:text-gray-500 sm:ml-6 lg:hidden"
                            @click="mobileFiltersOpen = true"
                        >
                            <span class="sr-only">Filters</span>
                            <FunnelIcon class="h-5 w-5" aria-hidden="true" />
                        </button>
                    </div>
                </div>

                <section aria-labelledby="filters-heading" class="pb-24 pt-6">
                    <h2 id="filters-heading" class="sr-only">Filters</h2>

                    <div class="grid grid-cols-1 gap-y-10 lg:grid-cols-5">
                        <!-- Filters side menu -->
                        <FiltersSidebar :filters="filters" />

                        <!-- Product grid -->
                        <div class="lg:col-span-4">
                            <ListingsGrid :listings="listings" />
                        </div>
                    </div>
                </section>
            </main>
        </div>
    </div>
</template>
