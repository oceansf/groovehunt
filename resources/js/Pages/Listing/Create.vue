<script setup>
import { ref, watch } from "vue";
import { useForm, Head } from "@inertiajs/vue3";
import { DiscAlbum } from "lucide-vue-next";
import DetailsMenu from "@/Components/Form/DetailsMenu.vue";
import FormTextInput from "@/Components/Form/FormTextInput.vue";
import FormSelectInput from "@/Components/Form/FormSelectInput.vue";
import FormTextarea from "@/Components/Form/FormTextarea.vue";
import FormFileUpload from "@/Components/Form/FormFileUpload.vue";
import {
    Switch,
    SwitchDescription,
    SwitchGroup,
    SwitchLabel,
} from "@headlessui/vue";
import FormCurrencyInput from "@/Components/Form/FormCurrencyInput.vue";
import formats from "../../Shared/formats";
import conditions from "../../Shared/conditions";
import countries from "../../Shared/countries";

const allowOffers = ref(false);

// Sync allowOffers with form state
watch(allowOffers, (newValue) => {
    form.allow_offers = newValue;
});

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
    ships_from: "",
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

// TODO - Add shipping-from field and frontend validation
const handleSubmit = () => {
    form.post(route("listings.store"), {
        preserveScroll: true,
        onSuccess: () => {
            // Optional: Add success notification or redirect
            console.log("Form submitted successfully");
        },
        onError: (errors) => {
            console.error("Form submission errors:", errors);
        },
    });
};

watch(
    () => form.data,
    (newVal) => {
        console.log("Form state updated:", newVal);
    },
    { deep: true },
);
</script>

<template>
    <Head>
        <title>Create a listing</title>
        <meta name="description" content="Create listing page" />
    </Head>
    <div class="mx-auto mb-32 mt-12 max-w-3xl px-3">
        <form @submit.prevent="handleSubmit" enctype="multipart/form-data">
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

                    <!-- TODO: Fix no error messages showing on form submit -->
                    <!-- Single column layout -->
                    <div class="mt-10 space-y-8">
                        <!-- Title field -->
                        <FormTextInput
                            :form="form"
                            id="title"
                            v-model="form.title"
                            placeholder="e.g., Abbey Road (1969 Original Pressing)"
                            label="Title"
                        />

                        <!-- Artist field -->
                        <FormTextInput
                            :form="form"
                            id="artist"
                            v-model="form.artist"
                            placeholder="e.g., The Beatles"
                            label="Artist"
                        />

                        <hr />

                        <div class="my-2">
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
                        <FormSelectInput
                            :form="form"
                            v-model="form.format"
                            id="format"
                            type="format"
                            :options="formats"
                            label="Format"
                        />

                        <!-- Media condition field -->
                        <FormSelectInput
                            :form="form"
                            v-model="form.media_condition"
                            id="media_condition"
                            type="condition"
                            :options="conditions"
                            label="Media condition"
                        />

                        <!-- Sleeve condition field -->
                        <FormSelectInput
                            :form="form"
                            v-model="form.sleeve_condition"
                            id="sleeve_condition"
                            type="condition"
                            :options="conditions"
                            label="Sleeve condition"
                            :optional="true"
                        />
                        <!-- Photos upload -->
                        <FormFileUpload
                            :form="form"
                            v-model="form.images"
                            id="images"
                            label="Photos"
                            help-text="Add up to 12 photos. The first photo will be your listing's cover photo."
                        />

                        <!-- Description field -->
                        <FormTextarea
                            :form="form"
                            v-model="form.description"
                            id="description"
                            label="Description"
                            :optional="true"
                            help-text="Provide details about the item's condition and any other relevant information"
                            :rows="4"
                            placeholder="Enter details about your item..."
                        />

                        <!-- Additional fields -->
                        <DetailsMenu :form="form" />

                        <hr />

                        <!-- Price field -->
                        <div>
                            <h2
                                class="text-xl font-semibold leading-7 text-gray-900"
                            >
                                Pricing & Shipping
                            </h2>
                            <p class="mt-1 text-sm leading-6 text-gray-600">
                                Enter how much the buyer will pay for your item
                                and any additional costs for shipping to them
                            </p>
                        </div>

                        <FormCurrencyInput
                            :form="form"
                            v-model="form.price"
                            id="price"
                            label="Price"
                            placeholder="0.00"
                            currency="USD"
                            currency-symbol="$"
                        />

                        <!-- Allow offer switch -->
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
                                <FormCurrencyInput
                                    :form="form"
                                    v-model="form.min_offer"
                                    id="min_offer"
                                    label="Minimum Offer"
                                />
                                <p class="mt-1 text-sm text-gray-400">
                                    Enter the minimum price you'll consider
                                </p>
                            </div>
                        </div>

                        <!-- TODO: Add shipping-from field -->

                        <!-- Shipping field -->
                        <FormCurrencyInput
                            :form="form"
                            v-model="form.shipping"
                            id="shipping"
                            label="Shipping Cost"
                            :optional="true"
                        />

                        <div>
                            <div>
                                <h2
                                    class="text-xl font-semibold leading-7 text-gray-900"
                                >
                                    Shipping From
                                </h2>
                                <p class="mt-1 text-sm leading-6 text-gray-600">
                                    Use a permanent address where you can
                                    receive mail.
                                </p>
                            </div>

                            <div
                                class="mt-5 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6"
                            >
                                <div class="sm:col-span-3">
                                    <label
                                        for="country"
                                        class="block text-sm/6 font-medium text-gray-900"
                                        >Country</label
                                    >
                                    <div class="mt-2 grid grid-cols-1">
                                        <select
                                            id="country"
                                            name="country"
                                            autocomplete="country-name"
                                            class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pl-3 pr-8 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                                        >
                                            <option
                                                selected
                                                disabled
                                                hidden
                                                value=""
                                            >
                                                Select a country
                                            </option>
                                            <option
                                                v-for="country in countries"
                                                :key="country.name"
                                                :value="country.name"
                                            >
                                                {{ country.name }}
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-span-full">
                                    <label
                                        for="street-address"
                                        class="block text-sm/6 font-medium text-gray-900"
                                        >Street address</label
                                    >
                                    <div class="mt-2">
                                        <input
                                            type="text"
                                            name="street-address"
                                            id="street-address"
                                            autocomplete="street-address"
                                            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                                        />
                                    </div>
                                </div>

                                <div class="sm:col-span-2 sm:col-start-1">
                                    <label
                                        for="city"
                                        class="block text-sm/6 font-medium text-gray-900"
                                        >City</label
                                    >
                                    <div class="mt-2">
                                        <input
                                            type="text"
                                            name="city"
                                            id="city"
                                            autocomplete="address-level2"
                                            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                                        />
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label
                                        for="region"
                                        class="block text-sm/6 font-medium text-gray-900"
                                        >State / Province</label
                                    >
                                    <div class="mt-2">
                                        <input
                                            type="text"
                                            name="region"
                                            id="region"
                                            autocomplete="address-level1"
                                            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                                        />
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label
                                        for="postal-code"
                                        class="block text-sm/6 font-medium text-gray-900"
                                        >ZIP / Postal code</label
                                    >
                                    <div class="mt-2">
                                        <input
                                            type="text"
                                            name="postal-code"
                                            id="postal-code"
                                            autocomplete="postal-code"
                                            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action buttons -->
            <div class="mt-6 flex items-center justify-end gap-x-6">
                <Link
                    as="button"
                    :href="route('home')"
                    class="text-sm font-semibold leading-6 text-gray-900"
                    :disabled="form.processing"
                >
                    Cancel
                </Link>
                <button
                    type="submit"
                    class="rounded-md bg-slate-900 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-slate-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:opacity-50"
                    :disabled="form.processing"
                >
                    <span v-if="form.processing">Listing...</span>
                    <span v-else>Post listing</span>
                </button>
            </div>
        </form>
    </div>
</template>
