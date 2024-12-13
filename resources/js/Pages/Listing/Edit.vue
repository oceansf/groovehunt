<script setup>
import { ref, watch, onMounted } from "vue";
import { useForm } from "@inertiajs/vue3";
import { DiscAlbum, Trash2, EditIcon } from "lucide-vue-next";
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
import DeleteConfirmModal from "@/Components/DeleteConfirmModal.vue";
import formats from "../../Shared/formats";
import conditions from "../../Shared/conditions";

const props = defineProps({
    listing: {
        type: Object,
        required: true,
    },
});

const showDeleteModal = ref(false);
const allowOffers = ref(props.listing.allow_offers);

// Sync allowOffers with form state
watch(allowOffers, (newValue) => {
    form.allow_offers = newValue;
});

const form = useForm({
    title: props.listing.data.title || "",
    artist: props.listing.data.artist || "",
    format: props.listing.data.format || "",
    media_condition: props.listing.data.media_condition || "",
    sleeve_condition: props.listing.data.sleeve_condition || "",
    description: props.listing.data.description || "",
    images: props.listing.data.images || [],
    price: props.listing.data.price || "",
    allow_offers: props.listing.data.allow_offers || false,
    min_offer: props.listing.data.min_offer || "",
    shipping: props.listing.data.shipping || "",
    genre: props.listing.data.genre || "",
    speed: props.listing.data.speed || "",
    color: props.listing.data.color || "",
    release_country: props.listing.data.release_country || "",
    release_year: props.listing.data.release_year || "",
    release_label: props.listing.data.release_label || "",
    release_cat_no: props.listing.data.release_cat_no || "",
    release_matrix_no: props.listing.data.release_matrix_no || "",
    release_upc: props.listing.data.release_upc || "",
});

// Rest of the component logic remains the same
const handleSubmit = () => {
    // Get the original values from props
    const original = props.listing;

    // Create an object to store only changed values
    const changes = {};

    // Compare each field and only include changed ones
    Object.keys(form).forEach((key) => {
        if (form[key] !== original[key]) {
            changes[key] = form[key];
        }
    });

    // Only submit if there are actually changes
    if (Object.keys(changes).length > 0) {
        form.put(
            route("listings.update", { listing: props.listing.data.id }),
            changes,
            {
                preserveScroll: true,
                onSuccess: () => {
                    console.log("Listing updated successfully");
                },
                onError: (errors) => {
                    console.error("Form submission errors:", errors);
                },
            },
        );
    }
};

const confirmDelete = () => {
    showDeleteModal.value = true;
};

const handleDelete = () => {
    form.delete(route("listings.destroy", { listing: props.listing.data.id }), {
        onSuccess: () => {
            console.log("Listing deleted successfully");
            showDeleteModal.value = false;
        },
        onError: (errors) => {
            console.error("Delete errors:", errors);
            showDeleteModal.value = false;
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
    <div class="mx-auto mb-32 mt-12 max-w-3xl px-3">
        <form @submit.prevent="handleSubmit" enctype="multipart/form-data">
            <div class="space-y-12">
                <div class="border-b border-gray-900/10 pb-12">
                    <!-- Header remains the same -->
                    <header>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <EditIcon :size="32" />
                                <h2
                                    class="text-3xl font-bold leading-7 text-gray-900"
                                >
                                    Edit listing
                                </h2>
                            </div>
                        </div>
                        <p class="mt-4 text-sm leading-6 text-gray-600">
                            Update the details of your listing. The more
                            information you provide about your listing the more
                            potential buyers can make an informed decision.
                        </p>
                    </header>

                    <div class="mt-10 space-y-8">
                        <!-- Title field -->
                        <FormTextInput
                            :form="form"
                            id="title"
                            v-model="form.title"
                            placeholder="e.g., The Beatles"
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
                                Update specific details about your listing
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
                        <div>
                            <FormFileUpload
                                :form="form"
                                v-model="form.images"
                                id="images"
                                label="Photos"
                                help-text="Add up to 12 photos. The first photo will be your listing's cover photo. Current photos will be replaced if you upload new ones."
                            />
                        </div>

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
                        <!-- TODO: Fix details menu not submitting changes -->
                        <!-- Additional fields -->
                        <DetailsMenu :form="form" />

                        <hr />

                        <!-- Pricing section -->
                        <div>
                            <h2
                                class="text-xl font-semibold leading-7 text-gray-900"
                            >
                                Pricing
                            </h2>
                            <p class="mt-1 text-sm leading-6 text-gray-600">
                                Update the price and shipping costs for your
                                item
                            </p>
                        </div>

                        <!-- Price field -->
                        <FormCurrencyInput
                            :form="form"
                            v-model="form.price"
                            id="price"
                            label="Price"
                            placeholder="0.00"
                            currency="USD"
                            currency-symbol="$"
                        />

                        <!-- Allow offers switch -->
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
                                    >
                                        Allow offers?
                                    </SwitchLabel>
                                    <SwitchDescription
                                        as="span"
                                        class="text-sm text-gray-600"
                                    >
                                        Buyers interested in your item can make
                                        you offers. You can accept, counter or
                                        decline.
                                    </SwitchDescription>
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

                        <!-- Shipping field -->
                        <FormCurrencyInput
                            :form="form"
                            v-model="form.shipping"
                            id="shipping"
                            label="Shipping Cost"
                            :optional="true"
                        />
                    </div>
                </div>
            </div>

            <!-- Action buttons -->
            <div class="mt-6 flex items-center justify-between gap-x-6">
                <button
                    type="button"
                    @click.prevent="confirmDelete"
                    class="inline-flex items-center gap-2 rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500"
                >
                    <Trash2 class="h-4 w-4" />
                    Delete Listing
                </button>
                <div class="flex gap-6">
                    <Link
                        as="button"
                        :href="route('listings.show', { listing: props.listing.data.id })"
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
                        <span v-if="form.processing">Saving...</span>
                        <span v-else>Save changes</span>
                    </button>
                </div>
            </div>
        </form>

        <!-- Delete Modal -->
        <DeleteConfirmModal
            :is-open="showDeleteModal"
            :is-loading="form.processing"
            @close="showDeleteModal = false"
            @confirm="handleDelete"
        />
    </div>
</template>
