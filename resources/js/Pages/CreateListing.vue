<script setup>
import { PhotoIcon } from "@heroicons/vue/24/solid";
import { useForm } from "@inertiajs/vue3";
import DetailsMenu from "@/Components/DetailsMenu.vue";

const form = useForm({
    title: "",
    artist: "",
    genre: "",
    format: "",
    mediaCondition: "",
    sleeveCondition: "",
    description: "",
    photos: [],
    price: "",
    shippingCost: "",
});

const genres = [
    { value: "blues", label: "Blues" },
    { value: "brass-military", label: "Brass & Military" },
    { value: "children", label: "Children's" },
    { value: "classical", label: "Classical" },
    { value: "electronic", label: "Electronic" },
    { value: "folk-world-country", label: "Folk, World, & Country" },
    { value: "funk-soul", label: "Funk / Soul" },
    { value: "hip-hop", label: "Hip-Hop" },
    { value: "jazz", label: "Jazz" },
    { value: "latin", label: "Latin" },
    { value: "non-music", label: "Non-Music" },
    { value: "pop", label: "Pop" },
    { value: "reggae", label: "Reggae" },
    { value: "rock", label: "Rock" },
    { value: "stage-screen", label: "Stage & Screen" },
];

const handleSubmit = () => {
    form.post(route("listings.store"), {
        preserveScroll: true,
        onSuccess: () => {
            // Optional: Add success notification or redirect
        },
    });
};

const handleFileUpload = (e) => {
    const files = Array.from(e.target.files);
    if (files.length > 12) {
        alert("You can only upload up to 12 photos");
        e.target.value = "";
        return;
    }
    form.photos = files;
};
</script>

<template>
    <div class="mx-auto mb-32 mt-12 max-w-3xl px-3">
        <form @submit.prevent="handleSubmit" novalidate>
            <div class="space-y-12">
                <div class="border-b border-gray-900/10 pb-12">
                    <!-- Clear section heading -->
                    <h2 class="text-3xl font-bold leading-7 text-gray-900">
                        Create a listing
                    </h2>
                    <br />
                    <p class="mt-1 text-sm leading-6 text-gray-600">
                        Enter details about your listing to list on the market.
                        The more information you provide about your listing the
                        more potential buyers can make an informed decision.
                    </p>

                    <!-- Single column layout -->
                    <div class="mt-10 space-y-8">
                        <!-- Title field -->
                        <div>
                            <label
                                for="title"
                                class="block text-sm font-medium leading-6 text-gray-900"
                                >Title</label
                            >
                            <div class="mt-2">
                                <input
                                    type="text"
                                    id="title"
                                    v-model="form.title"
                                    class="block w-full rounded-md border-0 px-3 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    placeholder="e.g., Abbey Road 1969 First Pressing"
                                />
                                <p
                                    v-if="form.errors.title"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ form.errors.title }}
                                </p>
                            </div>
                        </div>

                        <!-- Artist field -->
                        <div>
                            <label
                                for="artist"
                                class="block text-sm font-medium leading-6 text-gray-900"
                                >Artist</label
                            >
                            <div class="mt-2">
                                <input
                                    type="text"
                                    id="artist"
                                    v-model="form.artist"
                                    class="block w-full rounded-md border-0 px-3 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    placeholder="e.g., The Beatles"
                                />
                                <p
                                    v-if="form.errors.artist"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ form.errors.artist }}
                                </p>
                            </div>
                        </div>

                        <hr />
                        <div>
                            <h2
                                class="text-xl font-semibold leading-7 text-gray-900"
                            >
                                Item details
                            </h2>
                            <p class="mt-1 text-sm leading-6 text-gray-600">
                                Enter specific details about your listing
                            </p>
                        </div>

                        <!-- Format field -->
                        <div>
                            <label
                                for="media-condition"
                                class="block text-sm font-medium leading-6 text-gray-900"
                                >Format</label
                            >
                            <div class="mt-2">
                                <select
                                    id="media-condition"
                                    v-model="form.format"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                >
                                    <option value="">Select a format</option>
                                    <option value="vinyl">Vinyl</option>
                                    <option value="cd">CD</option>
                                    <option value="casette">Casette</option>
                                </select>
                                <p
                                    v-if="form.errors.format"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ form.errors.format }}
                                </p>
                            </div>
                        </div>

                        <!-- Media condition field -->
                        <div>
                            <label
                                for="media-condition"
                                class="block text-sm font-medium leading-6 text-gray-900"
                                >Media condition</label
                            >
                            <div class="mt-2">
                                <select
                                    id="media-condition"
                                    v-model="form.mediaCondition"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                >
                                    <option value="">Select a condition</option>
                                    <option value="M">Mint (M)</option>
                                    <option value="NM">
                                        Near Mint (NM or NM-)
                                    </option>
                                    <option value="VG+">
                                        Very Good Plus (VG+)
                                    </option>
                                    <option value="VG">Very Good (VG)</option>
                                    <option value="G+">Good Plus (G+)</option>
                                    <option value="G">Good (G)</option>
                                    <option value="F">Fair (F)</option>
                                    <option value="P">Poor (P)</option>
                                </select>
                                <p
                                    v-if="form.errors.mediaCondition"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ form.errors.mediaCondition }}
                                </p>
                            </div>
                        </div>

                        <!-- Sleeve condition field -->
                        <div>
                            <label
                                for="sleeve-condition"
                                class="block text-sm font-medium leading-6 text-gray-900"
                                >Sleeve condition</label
                            >
                            <div class="mt-2">
                                <select
                                    id="sleeve-condition"
                                    v-model="form.sleeveCondition"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                >
                                    <option value="">Select a condition</option>
                                    <option value="M">Mint (M)</option>
                                    <option value="NM">
                                        Near Mint (NM or NM-)
                                    </option>
                                    <option value="VG+">
                                        Very Good Plus (VG+)
                                    </option>
                                    <option value="VG">Very Good (VG)</option>
                                    <option value="G+">Good Plus (G+)</option>
                                    <option value="G">Good (G)</option>
                                    <option value="F">Fair (F)</option>
                                    <option value="P">Poor (P)</option>
                                </select>
                                <p
                                    v-if="form.errors.sleeveCondition"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ form.errors.sleeveCondition }}
                                </p>
                            </div>
                        </div>

                        <!-- Photos upload -->
                        <div>
                            <label
                                for="photos"
                                class="block text-sm font-medium leading-6 text-gray-900"
                                >Photos</label
                            >
                            <p class="mt-1 text-sm leading-6 text-gray-600">
                                Add up to 12 photos. The first photo will be
                                your listing's cover photo.
                            </p>
                            <div
                                class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10"
                            >
                                <div class="text-center">
                                    <PhotoIcon
                                        class="mx-auto h-12 w-12 text-gray-300"
                                        aria-hidden="true"
                                    />
                                    <div
                                        class="mt-4 flex text-sm leading-6 text-gray-600"
                                    >
                                        <label
                                            for="file-upload"
                                            class="relative cursor-pointer rounded-md bg-white font-semibold text-blue-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-blue-600 focus-within:ring-offset-2 hover:text-blue-500"
                                        >
                                            <span>Upload images</span>
                                            <input
                                                id="file-upload"
                                                type="file"
                                                multiple
                                                accept="image/*"
                                                class="sr-only"
                                                @change="handleFileUpload"
                                            />
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p class="text-xs leading-5 text-gray-600">
                                        PNG, JPG, GIF up to 10MB each
                                    </p>
                                </div>
                            </div>
                            <p
                                v-if="form.errors.photos"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.photos }}
                            </p>
                        </div>

                        <!-- Description field -->
                        <div>
                            <label
                                for="description"
                                class="block text-sm font-medium leading-6 text-gray-900"
                                >Description</label
                            >
                            <p class="mt-1 text-sm text-gray-500">
                                Provide details about the item's condition and
                                any other relevant information
                            </p>
                            <div class="mt-2">
                                <textarea
                                    id="description"
                                    v-model="form.description"
                                    rows="4"
                                    class="block w-full rounded-md border-0 px-3 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                />
                                <p
                                    v-if="form.errors.description"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ form.errors.description }}
                                </p>
                            </div>
                        </div>
                        <DetailsMenu />
                        <hr />

                        <!-- Price field -->
                        <div>
                            <h2
                                class="text-xl font-semibold leading-7 text-gray-900"
                            >
                                Pricing
                            </h2>
                            <p class="mt-1 text-sm leading-6 text-gray-600">
                                Enter how much the buyer will pay for your item
                                and any additional costs for shipping to them
                            </p>
                        </div>
                        <div>
                            <label
                                for="price"
                                class="block text-sm font-medium leading-6 text-gray-900"
                                >Listing price</label
                            >
                            <p class="mt-1 text-sm text-gray-500">
                                Enter price in USD
                            </p>
                            <div class="relative mt-2 rounded-md shadow-sm">
                                <div
                                    class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3"
                                >
                                    <span class="text-gray-500 sm:text-sm"
                                        >$</span
                                    >
                                </div>
                                <input
                                    type="number"
                                    name="price"
                                    id="price"
                                    min="0.00"
                                    step="0.01"
                                    max="2500"
                                    v-model="form.price"
                                    class="block w-full rounded-md border-0 py-1.5 pl-7 pr-12 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    placeholder="0.00"
                                    aria-describedby="price-currency"
                                />
                                <p
                                    v-if="form.errors.price"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ form.errors.price }}
                                </p>
                                <div
                                    class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3"
                                >
                                    <span
                                        class="text-gray-500 sm:text-sm"
                                        id="price-currency"
                                        >USD</span
                                    >
                                </div>
                            </div>
                        </div>

                        <!-- Shipping field -->
                        <div>
                            <label
                                for="price"
                                class="block text-sm font-medium leading-6 text-gray-900"
                                >Shipping cost</label
                            >
                            <p class="mt-1 text-sm text-gray-500">
                                Enter cost for shipping
                            </p>
                            <div class="relative mt-2 rounded-md shadow-sm">
                                <div
                                    class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3"
                                >
                                    <span class="text-gray-500 sm:text-sm"
                                        >$</span
                                    >
                                </div>
                                <input
                                    type="number"
                                    name="price"
                                    id="price"
                                    min="0.00"
                                    step="0.01"
                                    max="2500"
                                    v-model="form.shippingCost"
                                    class="block w-full rounded-md border-0 py-1.5 pl-7 pr-12 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    placeholder="0.00"
                                    aria-describedby="price-currency"
                                />
                                <p
                                    v-if="form.errors.shippingCost"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ form.errors.shippingCost }}
                                </p>
                                <div
                                    class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3"
                                >
                                    <span
                                        class="text-gray-500 sm:text-sm"
                                        id="price-currency"
                                        >USD</span
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action buttons -->
            <div class="mt-6 flex items-center justify-end gap-x-6">
                <button
                    type="button"
                    class="text-sm font-semibold leading-6 text-gray-900"
                    :disabled="form.processing"
                >
                    Cancel
                </button>
                <button
                    type="submit"
                    class="rounded-md bg-slate-900 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-slate-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:opacity-50"
                    :disabled="form.processing"
                >
                    <span v-if="form.processing">Listing...</span>
                    <span v-else>List item for sale</span>
                </button>
            </div>
        </form>
    </div>
</template>
