<script setup>
import { computed } from "vue";
import { usePage } from "@inertiajs/vue3";
import {
    Popover,
    PopoverButton,
    PopoverPanel,
    Menu,
    MenuButton,
    MenuItem,
    MenuItems,
} from "@headlessui/vue";
import { Bars3Icon, XMarkIcon } from "@heroicons/vue/24/outline";
import LogoLink from "./LogoLink.vue";
import Searchbar from "./Searchbar.vue";

const page = usePage();
const auth = computed(() => page.props.auth);
const currentPath = computed(() => usePage().url);

const navLinks = [
    { name: "MARKET", method: "get", href: "/" },
    { name: "SELL", method: "get", href: "/sell" },
    { name: "ABOUT", method: "get", href: "/about" },
];

const userNavigation = [
    { name: "Profile", href: "/profile", method: "get", current: false },
    { name: "Messages", href: "#", method: "get", current: false },
    { name: "Wishlist", href: "#", method: "get", current: false },
    { name: "Sign Out", href: "/logout", method: "post", current: false },
];
</script>

<template>
    <Popover as="template" v-slot="{ open, close }">
        <nav
            :class="[
                'sticky top-0 z-40 border-b bg-white bg-opacity-75 backdrop-blur backdrop-filter',
            ]"
        >
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div
                    class="relative flex justify-between lg:gap-8 xl:grid xl:grid-cols-12"
                >
                    <!-- Logo -->
                    <div
                        class="flex md:absolute md:inset-y-0 md:left-0 lg:static xl:col-span-2"
                    >
                        <LogoLink size="sm" />
                    </div>

                    <!-- Search -->
                    <div
                        class="align-cen min-w-0 flex-1 md:px-8 lg:px-0 xl:col-span-6"
                    >
                        <Searchbar />
                    </div>

                    <!-- Desktop Navigation -->
                    <div
                        class="hidden lg:flex lg:items-center lg:justify-end xl:col-span-4"
                    >
                        <div class="flex space-x-8 h-full">
                            <Link
                                v-for="link in navLinks"
                                as="button"
                                :key="link.name"
                                :href="link.href"
                                :method="link.method"
                                :class="[
                                    'inline-flex items-center border-b-4 px-1 pt-1 text-sm font-medium tracking-tight cursor-pointer',
                                    currentPath === link.href
                                        ? 'border-slate-500 text-gray-900'
                                        : 'border-transparent text-gray-500 transition hover:border-gray-300 hover:text-gray-700',
                                ]"
                            >
                                {{ link.name }}
                            </Link>

                            <!-- Profile Dropdown for Desktop -->
                            <div v-if="!auth.check" class="flex">
                                <Link
                                    href="/login"
                                    method="get"
                                    as="button"
                                    type="button"
                                    class="text-sm font-medium text-gray-500 hover:text-gray-700 hover:underline"
                                >
                                    Log in
                                </Link>
                            </div>

                            <!-- Profile Menu for Desktop -->
                            <Menu
                                v-else
                                as="div"
                                class="relative inline-flex items-center"
                                v-slot="{ close: menuClose }"
                            >
                                <MenuButton
                                    class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-900 focus:outline-none"
                                >
                                    <span class="relative inline-block">
                                        <img
                                            class="h-10 w-10 rounded-full border"
                                            :src="
                                                auth.user.avatar ||
                                                'http://www.gravatar.com/avatar/?d=mp'
                                            "
                                            alt="Profile picture"
                                        />
                                        <span
                                            class="absolute right-0 top-0 block h-2.5 w-2.5 rounded-full bg-red-400 ring-2 ring-white"
                                        />
                                    </span>
                                </MenuButton>

                                <transition
                                    enter-active-class="transition ease-out duration-100"
                                    enter-from-class="transform opacity-0 scale-95"
                                    enter-to-class="transform opacity-100 scale-100"
                                    leave-active-class="transition ease-in duration-75"
                                    leave-from-class="transform opacity-100 scale-100"
                                    leave-to-class="transform opacity-0 scale-95"
                                >
                                    <MenuItems
                                        class="absolute right-0 top-full z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                                    >
                                        <MenuItem
                                            v-for="option in userNavigation"
                                            :key="option.name"
                                            v-slot="{ active }"
                                            as="div"
                                        >
                                            <Link
                                                :href="option.href"
                                                :method="option.method"
                                                as="button"
                                                class="block w-full text-left"
                                                :class="[
                                                    active
                                                        ? 'bg-gray-100 text-gray-900'
                                                        : 'text-gray-500',
                                                    'px-4 py-2 text-sm hover:bg-black/5',
                                                ]"
                                                @click="menuClose"
                                            >
                                                {{ option.name }}
                                            </Link>
                                        </MenuItem>
                                    </MenuItems>
                                </transition>
                            </Menu>
                        </div>
                    </div>

                    <!-- Mobile menu button -->
                    <div class="flex items-center lg:hidden">
                        <PopoverButton
                            class="relative -mx-2 inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500"
                        >
                            <span class="sr-only">Open menu</span>
                            <Bars3Icon
                                v-if="!open"
                                class="block h-6 w-6"
                                aria-hidden="true"
                            />
                            <XMarkIcon
                                v-else
                                class="block h-6 w-6"
                                aria-hidden="true"
                            />
                        </PopoverButton>
                    </div>
                </div>
            </div>

            <!-- Mobile menu panel -->
            <transition
                enter-active-class="duration-200 ease-out"
                enter-from-class="opacity-0 scale-95"
                enter-to-class="opacity-100 scale-100"
                leave-active-class="duration-100 ease-in"
                leave-from-class="opacity-100 scale-100"
                leave-to-class="opacity-0 scale-95"
            >
                <PopoverPanel
                    class="absolute inset-x-0 top-full z-40 transform shadow-lg ring-1 ring-black ring-opacity-5 lg:hidden bg-white"
                >
                    <!-- Your existing mobile menu content with @click="close" -->
                    <div class="space-y-1 px-2 pb-3 pt-2">
                        <Link
                            v-for="link in navLinks"
                            :key="link.name"
                            :href="link.href"
                            @click="close"
                            :class="[
                                currentPath === link.href
                                    ? 'bg-gray-100 text-gray-900'
                                    : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900',
                                'block rounded-md px-3 py-2 text-base font-medium',
                            ]"
                        >
                            {{ link.name }}
                        </Link>
                    </div>

                    <!-- User section for mobile -->
                    <div
                        v-if="auth.check"
                        class="border-t border-gray-200 pb-3 pt-4"
                    >
                        <div class="px-4 sm:px-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <img
                                        class="h-10 w-10 rounded-full"
                                        :src="
                                            auth.user.avatar ||
                                            'http://www.gravatar.com/avatar/?d=mp'
                                        "
                                        alt=""
                                    />
                                </div>
                                <div class="ml-3">
                                    <div
                                        class="text-base font-medium text-gray-800"
                                    >
                                        {{ auth.user.name }}
                                    </div>
                                    <div
                                        class="text-sm font-medium text-gray-500"
                                    >
                                        {{ auth.user.email }}
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3 space-y-1">
                                <Link
                                    v-for="item in userNavigation"
                                    :key="item.name"
                                    :href="item.href"
                                    :method="item.method"
                                    as="button"
                                    @click="close"
                                    class="block w-full rounded-md px-3 py-2 text-left text-base font-medium text-gray-500 hover:bg-gray-50 hover:text-gray-900"
                                >
                                    {{ item.name }}
                                </Link>
                            </div>
                        </div>
                    </div>

                    <!-- Login/Register section for mobile -->
                    <div v-else class="border-t border-gray-200 px-4 py-4">
                        <div class="space-y-1">
                            <Link
                                href="/login"
                                @click="close"
                                class="block rounded-md px-3 py-2 text-base font-medium text-gray-500 hover:bg-gray-50 hover:text-gray-900"
                            >
                                Log in
                            </Link>
                            <Link
                                href="/register"
                                @click="close"
                                class="block rounded-md px-3 py-2 text-base font-medium text-gray-500 hover:bg-gray-50 hover:text-gray-900"
                            >
                                Register
                            </Link>
                        </div>
                    </div>
                </PopoverPanel>
            </transition>
        </nav>
    </Popover>
</template>
