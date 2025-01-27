<script setup>
import { computed } from "vue";
import { EnvelopeIcon, StarIcon, FlagIcon } from "@heroicons/vue/20/solid";
import { usePage } from "@inertiajs/vue3";
import ListingItem from "@/Components/Listing/ListingGridItem.vue";

const props = defineProps({
    user: Object,
    userListings: Object,
});

const page = usePage();
const auth = computed(() => page.props.auth);
const userData = props.user.data;

const profile = {
    name: "Ricardo Cooper",
    email: "ricardo.cooper@example.com",
    avatar: "https://images.unsplash.com/photo-1463453091185-61582044d556?ixlib=rb-=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=8&w=1024&h=1024&q=80",
    backgroundImage:
        "https://images.unsplash.com/photo-1631692994457-622f31a30997?q=80&w=2340&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
    fields: [
        ["Phone", "(555) 123-4567"],
        ["Email", "ricardocooper@example.com"],
        ["Title", "Senior Front-End Developer"],
        ["Team", "Product Development"],
        ["Location", "San Francisco"],
        ["Sits", "Oasis, 4th floor"],
        ["Salary", "$145,000"],
        ["Birthday", "June 8, 1990"],
    ],
};

const reviews = [
    {
        id: 1,
        rating: 5,
        content: `
      <p>This icon pack is just what I need for my latest project. There's an icon for just about anything I could ever need. Love the playful look!</p>
    `,
        date: "July 16, 2021",
        datetime: "2021-07-16",
        author: "Emily Selman",
        avatarSrc:
            "https://images.unsplash.com/photo-1502685104226-ee32379fefbe?ixlib=rb-=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=8&w=256&h=256&q=80",
    },
    {
        id: 2,
        rating: 5,
        content: `
      <p>Blown away by how polished this icon pack is. Everything looks so consistent and each SVG is optimized out of the box so I can use it directly with confidence. It would take me several hours to create a single icon this good, so it's a steal at this price.</p>
    `,
        date: "July 12, 2021",
        datetime: "2021-07-12",
        author: "Hector Gibbons",
        avatarSrc:
            "https://images.unsplash.com/photo-1500648767791-00dcc994a43e?ixlib=rb-=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=8&w=256&h=256&q=80",
    },
    {
        id: 3,
        rating: 4,
        content: `
      <p>Took awhile for the seller to send my item but I eventually received it.</p>
    `,
        date: "September 15, 2020",
        datetime: "2021-07-12",
        author: "Johm Simmons",
        avatarSrc:
            "https://images.unsplash.com/placeholder-avatars/extra-large.jpg?w=150&dpr=1&crop=faces&bg=%23fff&h=150&auto=format&fit=crop&q=60&ixlib=rb-4.0.3",
    },
    // More reviews...
];

const dummyListing = {
    allow_offers: true,
    artist: "Dummy Artist",
    color: "black",
    created_at: "2025-01-08T22:29:17.000000Z",
    description: "Great condition, taking offers.",
    format: "Vinyl",
    genre: "Rock",
    id: 102,
    images: [{ url: "https://placehold.co/400x400/?text=Listing\nCover" }],
    media_condition: "Very Good",
    price: "24.97",
    release_cat_no: null,
    release_country: null,
    release_label: null,
    release_matrix_no: null,
    release_upc: null,
    release_year: "1986",
    shipping: "12.00",
    sleeve_condition: "Very Good",
    speed: "33",
    title: "Dummy Title",
    disabled: true,
};
</script>

<template>
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <!-- Profile header -->
        <div>
            <div
                class="h-32 w-full bg-[url(https://images.unsplash.com/photo-1631692994457-622f31a30997?q=80&w=2340&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D)] bg-contain bg-fixed bg-no-repeat lg:h-48"
            ></div>
            <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
                <div class="-mt-12 sm:-mt-16 sm:flex sm:items-end sm:space-x-5">
                    <div class="flex">
                        <img
                            class="size-24 rounded-full ring-4 ring-white sm:size-32"
                            :src="
                                userData.avatar_url ||
                                `https://ui-avatars.com/api/?size=200&background=random&name=${userData.name}`
                            "
                            alt="profile picture"
                        />
                    </div>

                    <div
                        class="mt-6 sm:flex sm:min-w-0 sm:flex-1 sm:items-center sm:justify-end sm:space-x-6 sm:pb-1"
                    >
                        <div class="min-w-0 flex-1 sm:mt-12 sm:hidden md:block">
                            <h1
                                class="truncate text-2xl font-bold text-gray-900"
                            >
                                {{ userData.name }}
                            </h1>
                            <p class="text-sm text-gray-500">
                                Member since
                                {{
                                    new Date(
                                        userData.joined_date,
                                    ).toLocaleDateString("en-US", {
                                        month: "long",
                                        year: "numeric",
                                    })
                                }}
                            </p>

                            <div class="flex items-center">
                                <StarIcon class="h-4 w-4 text-yellow-400" />
                                <StarIcon class="h-4 w-4 text-yellow-400" />
                                <StarIcon class="h-4 w-4 text-yellow-400" />
                                <StarIcon class="h-4 w-4 text-yellow-400" />
                                <StarIcon class="h-4 w-4 text-yellow-400" />
                                <span class="pl-1 text-sm"
                                    >4.9 (382 reviews)</span
                                >
                            </div>
                        </div>
                        <div
                            v-if="auth.user && auth.user.id !== userData.id"
                            class="mt-6 flex flex-col justify-between space-y-3 sm:flex-row sm:space-x-4 sm:space-y-0"
                        >
                            <button
                                type="button"
                                class="inline-flex justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
                            >
                                <EnvelopeIcon
                                    class="-ml-0.5 mr-1.5 size-5 text-gray-400"
                                    aria-hidden="true"
                                />
                                <span>Message</span>
                            </button>
                            <button
                                type="button"
                                class="inline-flex justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
                            >
                                <FlagIcon
                                    class="-ml-0.5 mr-1.5 size-5 text-gray-400"
                                    aria-hidden="true"
                                />
                                <span>Report</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="mt-6 hidden min-w-0 flex-1 sm:block md:hidden">
                    <h1 class="truncate text-2xl font-bold text-gray-900">
                        {{ profile.name }}
                    </h1>
                </div>
            </div>

            <!-- Profile listings -->
            <div class="px-2">
                <h1 class="mt-12 truncate text-2xl font-semibold text-gray-900">
                    About
                </h1>
                <div class="mb-8 mt-2">
                    <p class="text-gray-500">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        Placeat nobis dolores officia qui? Quibusdam ipsum iste
                        quas ipsam maxime labore autem commodi et, corrupti
                        ducimus ullam iure maiores nulla harum voluptas tempore
                        provident nemo quis? Dolorem doloribus laborum commodi
                        quasi. Debitis odio aliquam placeat? Maxime saepe
                        aperiam quos cupiditate neque.
                    </p>
                </div>
            </div>

            <hr />

            <!-- Profile listings -->
            <div class="px-2">
                <h1 class="mt-12 truncate text-2xl font-semibold text-gray-900">
                    Active Listings
                    <span v-if="userListings.data.length > 0"
                        >({{ userListings.data.length }})</span
                    >
                </h1>
                <div
                    class="mt-6 grid grid-cols-2 gap-x-2 gap-y-8 lg:grid-cols-5"
                >
                    <div
                        v-for="listing in userListings.data"
                        :key="listing.id"
                        class="group relative"
                    >
                        <ListingItem :listing="listing" />
                    </div>
                </div>
            </div>

            <!-- Sold listings -->
            <div class="px-2">
                <h1 class="mt-12 truncate text-2xl font-semibold text-gray-900">
                    Recently Sold
                </h1>
                <div
                    class="mt-6 grid grid-cols-2 gap-x-2 gap-y-8 lg:grid-cols-5"
                >
                    <div
                        v-for="listing in 4"
                        :key="listing.id"
                        class="group relative"
                    >
                        <ListingItem :listing="dummyListing" />
                    </div>
                </div>
            </div>

            <!-- Seller Reviews -->
            <div class="mb-16 px-2">
                <h1
                    class="mb-6 mt-12 truncate text-2xl font-semibold text-gray-900"
                >
                    Seller Reviews
                    <span v-if="reviews.length">({{ reviews.length }})</span>
                </h1>
                <div class="bg-white">
                    <div>
                        <h2 class="sr-only">Customer Reviews</h2>

                        <div class="-my-10">
                            <div
                                v-for="(review, reviewIdx) in reviews"
                                :key="review.id"
                                class="flex space-x-4 text-sm text-gray-500"
                            >
                                <div class="flex-none py-10">
                                    <img
                                        :src="review.avatarSrc"
                                        alt=""
                                        class="size-10 rounded-full bg-gray-100"
                                    />
                                </div>
                                <div
                                    :class="[
                                        reviewIdx === 0
                                            ? ''
                                            : 'border-t border-gray-200',
                                        'flex-1 py-10',
                                    ]"
                                >
                                    <h3 class="font-medium text-gray-900">
                                        {{ review.author }}
                                    </h3>
                                    <p>
                                        <time :datetime="review.datetime">{{
                                            review.date
                                        }}</time>
                                    </p>

                                    <div class="mt-4 flex items-center">
                                        <StarIcon
                                            v-for="rating in [0, 1, 2, 3, 4]"
                                            :key="rating"
                                            :class="[
                                                review.rating > rating
                                                    ? 'text-slate-900'
                                                    : 'text-gray-300',
                                                'size-5 shrink-0',
                                            ]"
                                            aria-hidden="true"
                                        />
                                    </div>
                                    <p class="sr-only">
                                        {{ review.rating }} out of 5 stars
                                    </p>

                                    <div
                                        class="mt-4 text-sm/6 text-gray-500"
                                        v-html="review.content"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
