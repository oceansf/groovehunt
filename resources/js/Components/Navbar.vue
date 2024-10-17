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
import { MagnifyingGlassIcon } from "@heroicons/vue/20/solid";
import { Bars3Icon, XMarkIcon } from "@heroicons/vue/24/outline";

const page = usePage();
const auth = computed(() => page.props.auth);
const currentPath = computed(() => usePage().url);

const mockuser = {
    name: "Chelsea Hagon",
    email: "chelsea.hagon@example.com",
    imageUrl:
        "https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80",
};
const links = [
    { name: "Market".toUpperCase(), href: "/" },
    { name: "Sell".toUpperCase(), href: "/sell" },
    { name: "About".toUpperCase(), href: "/about" },
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
                'sticky top-0 z-40 bg-white border-b lg:overflow-y-visible backdrop-filter backdrop-blur bg-opacity-75',
            ]"
        >
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div
                    class="relative flex justify-between lg:gap-8 xl:grid xl:grid-cols-12"
                >
                    <div
                        class="flex md:absolute md:inset-y-0 md:left-0 lg:static xl:col-span-2"
                    >
                        <Link
                            href="/"
                            class="flex flex-shrink-0 items-center gap-2"
                        >
                            <img
                                class="h-8 w-auto"
                                src="https://res.cloudinary.com/oceansf/image/upload/v1728751022/vinyl-logo_zmvc9b.png"
                                alt="Groove Hunt"
                            />
                            <span
                                class="hidden md:block text-xl text-black font-bold tracking-tight font-['Helvetica']"
                                >groovehunt</span
                            >
                        </Link>
                    </div>
                    <div class="min-w-0 flex-1 md:px-8 lg:px-0 xl:col-span-5">
                        <div
                            class="flex items-center px-6 py-4 md:mx-auto md:max-w-3xl lg:mx-0 lg:max-w-none xl:px-0"
                        >
                            <div class="w-full">
                                <label for="search" class="sr-only"
                                    >Search</label
                                >
                                <div class="relative">
                                    <div
                                        class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3"
                                    >
                                        <MagnifyingGlassIcon
                                            class="h-5 w-5 text-gray-400"
                                            aria-hidden="true"
                                        />
                                    </div>
                                    <input
                                        id="search"
                                        name="search"
                                        class="block w-full rounded-md border-0 bg-white py-1.5 pl-10 pr-3 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6"
                                        placeholder="Search by title or artist..."
                                        type="search"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="hidden sm:ml-6 sm:flex justify-end sm:space-x-8 col-span-5">
                        <Link
                            v-for="link in links"
                            :key="link.name"
                            :href="link.href"
                            :class="[
                                'inline-flex items-center px-1 pt-1 text-sm font-medium tracking-tight',
                                currentPath === link.href
                                    ? 'border-b-2 border-slate-500 text-gray-900'
                                    : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700',
                            ]"
                        >
                            {{ link.name }}
                        </Link>
                        <!-- <Link href="/login" method="post" as="button" type="button">Log In</Link> -->
                        <div v-if="!auth.check" class="flex items-baseline gap-2 self-center">
                            <Link
                                href="/login"
                                method="get"
                                as="button"
                                type="button"
                                class="px-1 pt-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:underline"
                                >Log In</Link
                            >
                            <Link
                                href="/register"
                                method="get"
                                as="button"
                                type="button"
                                class="rounded-md h-8 bg-slate-900 px-3 text-sm font-semibold text-gray-100 shadow-sm hover:text-white hover:bg-slate-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600"
                                >Register</Link
                            >
                        </div>
                        <!-- Profile button -->
                        <Menu
                            v-else
                            as="div"
                            class="relative inline-block text-left self-center"
                        >
                            <div class="">
                                <MenuButton
                                    class="group inline-flex justify-center text-sm font-medium text-gray-700 hover:text-gray-900"
                                >
                                    <span class="relative inline-block">
                                        <img
                                            class="h-10 w-10 rounded-full"
                                            src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                            alt="Profile picture"
                                        />
                                        <span
                                            class="absolute right-0 top-0 block h-2.5 w-2.5 rounded-full bg-red-400 ring-2 ring-white"
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
                                            v-slot="{close}"
                                        >
                                        
                                            <Link
                                                as="span"
                                                :href="option.href"
                                                :method="option.method"
                                                :class="[
                                                    option.current
                                                        ? 'font-medium text-gray-900'
                                                        : 'text-gray-500',
                                                    active ? 'bg-gray-100' : '',
                                                    'block px-4 py-2 text-sm cursor-pointer',
                                                ]"
                                                
                                                ><span @click="close">{{ option.name }}</span></Link
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
                            class="relative -mx-2 inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500"
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
                        v-for="link in links"
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
                                :src="mockuser.imageUrl"
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
                    class="border-t border-gray-200 mx-auto max-w-3xl space-y-1 px-2 pb-3 pt-2 sm:px-4"
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
                        class="block rounded-md px-5 py-2 text-base font-medium text-gray-100 bg-slate-900 hover:bg-gray-50 hover:text-gray-900"
                        >Register</Link
                    >
                </div>
            </PopoverPanel>
        </nav>
    </Popover>
</template>
