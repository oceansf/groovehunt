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
    <!-- When the mobile menu is open, add `overflow-hidden` to the `body` element to prevent double scrollbars -->
    <Popover as="template" v-slot="{ open }">
        <nav
            :class="[
                open ? 'fixed inset-0 z-40 overflow-y-auto' : '',
                'sticky top-0 z-40 border-b bg-white bg-opacity-85 backdrop-blur backdrop-filter lg:overflow-y-visible',
            ]"
        >
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div
                    class="relative flex justify-between lg:gap-8 xl:grid xl:grid-cols-12"
                >
                    <div
                        class="flex md:absolute md:inset-y-0 md:left-0 lg:static xl:col-span-2"
                    >
                        <LogoLink size="sm" />
                    </div>

                    <div
                        class="align-cen min-w-0 flex-1 md:px-8 lg:px-0 xl:col-span-6"
                    >
                        <Searchbar />
                    </div>

                    <div
                        class="col-span-4 hidden justify-end sm:ml-6 sm:flex sm:space-x-8"
                    >
                        <Link
                            v-for="link in navLinks"
                            :key="link.name"
                            :href="link.href"
                            :method="link.method"
                            :class="[
                                'inline-flex items-center border-b-4 px-1 pt-1 text-sm font-medium tracking-tight',
                                currentPath === link.href
                                    ? 'border-slate-500 text-gray-900'
                                    : 'border-transparent text-gray-500 transition hover:border-gray-300 hover:text-gray-700',
                            ]"
                        >
                            {{ link.name }}
                        </Link>

                        <div
                            v-if="!auth.check"
                            class="inline-flex items-center px-1 pt-1 text-sm font-medium tracking-tight"
                        >
                            <Link
                                href="/login"
                                method="get"
                                as="button"
                                type="button"
                                class="text-sm font-medium text-gray-500 hover:text-gray-700 hover:underline"
                                >Log in</Link
                            >
                        </div>
                        <!-- Profile button -->
                        <Menu
                            v-else
                            as="div"
                            class="relative inline-block self-center text-left"
                        >
                            <div class="">
                                <MenuButton
                                    class="group inline-flex justify-center text-sm font-medium text-gray-700 hover:text-gray-900"
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
                                    </span>
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
                                    class="absolute left-0 z-10 mt-1 w-40 origin-top-right rounded-md bg-white shadow-2xl ring-1 ring-black ring-opacity-5 focus:outline-none"
                                >
                                    <div class="py-1">
                                        <MenuItem
                                            v-for="option in userNavigation"
                                            :key="option.name"
                                            v-slot="{ active }"
                                        >
                                            <Link
                                                :href="option.href"
                                                :method="option.method"
                                                :class="[
                                                    option.current
                                                        ? 'font-medium text-gray-900'
                                                        : 'text-gray-500',
                                                    active ? 'bg-gray-100' : '',
                                                    'block cursor-pointer px-4 py-2 text-sm hover:bg-black/5',
                                                ]"
                                                ><span>{{
                                                    option.name
                                                }}</span></Link
                                            >
                                        </MenuItem>
                                    </div>
                                </MenuItems>
                            </transition>
                        </Menu>
                    </div>
                    <div
                        class="flex items-center md:absolute md:inset-y-0 md:right-0 lg:hidden"
                    >
                        <!-- Mobile menu button -->
                        <PopoverButton
                            class="relative -mx-2 inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500"
                        >
                            <span class="absolute -inset-0.5" />
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

            <PopoverPanel as="nav" class="lg:hidden" aria-label="Global">
                <div class="mx-auto max-w-3xl space-y-1 px-2 pb-3 pt-2 sm:px-4">
                    <Link
                        v-for="link in navLinks"
                        as="span"
                        :key="link.name"
                        :href="link.href"
                        :aria-current="link.current ? 'page' : undefined"
                        :class="[
                            currentPath === link.href
                                ? 'bg-gray-100 text-gray-900'
                                : 'hover:bg-gray-50',
                            'block rounded-md px-3 py-2 text-base font-medium',
                        ]"
                        >{{ link.name }}</Link
                    >
                </div>
                <div
                    v-if="auth.check"
                    class="border-t border-gray-200 pb-3 pt-4"
                >
                    <div
                        class="mx-auto flex max-w-3xl items-center px-4 sm:px-6"
                    >
                        <div class="flex-shrink-0">
                            <img
                                class="h-10 w-10 rounded-full"
                                :src="auth.user.avatar"
                                alt=""
                            />
                        </div>
                        <div class="ml-3">
                            <div class="text-base font-medium text-gray-800">
                                {{ auth.user.name }}
                            </div>
                            <div class="text-sm font-medium text-gray-500">
                                {{ auth.user.email }}
                            </div>
                        </div>
                    </div>

                    <div class="mx-auto mt-3 max-w-3xl space-y-1 px-2 sm:px-4">
                        <Link
                            v-for="item in userNavigation"
                            :key="item.name"
                            :href="item.href"
                            :method="item.method"
                            class="block rounded-md px-3 py-2 text-base font-medium text-gray-500 hover:bg-gray-50 hover:text-gray-900"
                            >{{ item.name }}</Link
                        >
                    </div>
                </div>
                <div
                    v-else
                    class="mx-auto max-w-3xl space-y-1 border-t border-gray-200 px-2 pb-3 pt-2 sm:px-4"
                >
                    <Link
                        href="/login"
                        method="get"
                        class="block rounded-md px-5 py-2 text-base font-medium text-gray-500 hover:bg-gray-50 hover:text-gray-900"
                        >Log In</Link
                    >
                    <Link
                        href="/register"
                        method="get"
                        class="block rounded-md bg-slate-900 px-5 py-2 text-base font-medium text-gray-100 hover:bg-gray-50 hover:text-gray-900"
                        >Register</Link
                    >
                </div>
            </PopoverPanel>
        </nav>
    </Popover>
</template>
