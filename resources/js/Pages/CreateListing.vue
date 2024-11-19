<script setup>
import { ref, watch } from "vue";
import { useForm } from "@inertiajs/vue3";
import { PhotoIcon } from "@heroicons/vue/24/solid";
import { DiscAlbum } from "lucide-vue-next";
import DetailsMenu from "@/Components/Form/DetailsMenu.vue";
import FormTextInput from "@/Components/Form/FormTextInput.vue";
import FormInputLabel from "@/Components/Form/FormInputLabel.vue";
import FormError from "@/Components/Form/FormError.vue";
import FormSelectInput from "@/Components/Form/FormSelectInput.vue";
import {
    Switch,
    SwitchDescription,
    SwitchGroup,
    SwitchLabel,
} from "@headlessui/vue";
import FormCurrencyInput from "@/Components/Form/FormCurrencyInput.vue";
import formats from "../Shared/formats";
import conditions from "../Shared/conditions";

const allowOffers = ref(false);

const form = useForm({
    title: "",
    artist: "",
    format: "",
    media_condition: "",
    sleeve_condition: "",
    description: "",
    images: [],
    price: "",
    allow_offers: false,
    min_offer: "",
    shipping: "",
    genre: "",
    speed: "",
    color: "",
    release_country: "",
    release_year: "",
    release_label: "",
    release_cat_no: "",
    release_matrix_no: "",
    release_upc: "",
});

const handleSubmit = () => {
    form.submit("post", route("listings.store"), {
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
    form.images = files;
};
</script>

<template>
    <div class="mx-auto mb-32 mt-12 max-w-3xl px-3">
        <form @submit.prevent="handleSubmit" novalidate>
            <div class="space-y-12">
                <div class="border-b border-gray-900/10 pb-12">
                    <!-- Heading -->
                    <header>
                        <div class="flex items-center gap-2">
                            <DiscAlbum :size="32" />
                            <h2
                                class="text-3xl font-bold leading-7 text-gray-900"
                            >
                                Create a listing
                            </h2>
                        </div>
                        <br />
                        <p class="mt-1 text-sm leading-6 text-gray-600">
                            Enter details about your listing to list on the
                            market. The more information you provide about your
                            listing the more potential buyers can make an
                            informed decision.
                        </p>
                    </header>

                    <!-- Single column layout -->
                    <div class="mt-10 space-y-8">
                        <!-- Title field -->
                        <div>
                            <FormInputLabel for="title" text="Title" />
                            <FormTextInput
                                :form="form"
                                v-model="form.title"
                                id="title"
                                placeholder="e.g., Abbey Road 1969 First Pressing"
                            />
                            <FormError :message="form.errors.title" />
                        </div>

                        <!-- Artist field -->
                        <div>
                            <FormInputLabel for="artist" text="Artist" />
                            <FormTextInput
                                :form="form"
                                v-model="form.artist"
                                id="title"
                                placeholder="e.g., The Beatles"
                            />
                            <FormError :message="form.errors.artist" />
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
                            <div class="mt-2">
                                <FormInputLabel for="format" text="Format" />
                                <FormSelectInput
                                    id="format"
                                    v-model="form.format"
                                    type="format"
                                    :options="formats"
                                />
                                <FormError :message="form.errors.format" />
                            </div>
                        </div>

                        <!-- Media condition field -->
                        <div>
                            <FormInputLabel
                                for="media-condition"
                                text="Media condition"
                            />
                            <FormSelectInput
                                id="media-condition"
                                v-model="form.media_condition"
                                type="condition"
                                :options="conditions"
                            />
                            <FormError :message="form.errors.media_condition" />
                        </div>

                        <!-- Sleeve condition field -->
                        <div>
                            <FormInputLabel
                                for="sleeve-condition"
                                text="Sleeve condition"
                                optional
                            />
                            <FormSelectInput
                                id="sleeve-condition"
                                v-model="form.sleeve_condition"
                                type="condition"
                                :options="conditions"
                            />
                            <FormError
                                :message="form.errors.sleeve_condition"
                            />
                        </div>

                        <!-- Photos upload -->
                        <div>
                            <label
                                for="images"
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
                            <FormError :message="form.errors.images" />
                        </div>

                        <!-- Description field -->
                        <div>
                            <FormInputLabel text="Description" optional />
                            <p class="mt-1 text-sm text-gray-500">
                                Provide details about the item's condition and
                                any other relevant information
                            </p>
                            <div class="mt-2">
                                <textarea
                                    id="description"
                                    v-model="form.description"
                                    rows="4"
                                    class="block w-full rounded-md border-0 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                />
                                <p
                                    v-if="form.errors.description"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ form.errors.description }}
                                </p>
                            </div>
                        </div>
                        <DetailsMenu :form="form" />
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
                            <FormInputLabel text="Price" />
                            <FormCurrencyInput />
                        </div>

                        <!-- Offer switch -->
                        <div>
                            <SwitchGroup
                                as="div"
                                class="flex items-center justify-between"
                            >
                                <span class="flex flex-grow flex-col">
                                    <SwitchLabel
                                        as="span"
                                        class="text-sm/6 font-medium text-gray-900"
                                        passive
                                        >Allow offers?</SwitchLabel
                                    >
                                    <SwitchDescription
                                        as="span"
                                        class="text-sm text-gray-600"
                                        >Buyers interested in your item can make
                                        you offers. You can accept, counter or
                                        decline.</SwitchDescription
                                    >
                                </span>
                                <Switch
                                    v-model="allowOffers"
                                    :class="[
                                        allowOffers
                                            ? 'bg-blue-500'
                                            : 'bg-gray-200',
                                        'relative ml-2 inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none',
                                    ]"
                                >
                                    <span
                                        aria-hidden="true"
                                        :class="[
                                            allowOffers
                                                ? 'translate-x-5'
                                                : 'translate-x-0',
                                            'pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out',
                                        ]"
                                    />
                                </Switch>
                            </SwitchGroup>
                            <div v-if="allowOffers">
                                <FormCurrencyInput />
                                <p class="mt-1 text-sm text-gray-400">
                                    Enter the minimum price you'll consider
                                </p>
                            </div>
                        </div>

                        <!-- Shipping field -->
                        <div>
                            <label
                                for="shipping_cost"
                                class="block text-sm/6 font-medium text-gray-900"
                                >Shipping cost</label
                            >
                            <FormCurrencyInput />
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
