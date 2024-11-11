<script setup>
defineProps({
    showMessageModal: Boolean,
    messageForm: Object,
    closeMessageModal: Function,
    sendMessage: Function,
});
</script>

<template>
    <div>
        <Teleport to="body">
            <Transition
                enter-active-class="transition ease-out duration-300"
                enter-from-class="opacity-0"
                enter-to-class="opacity-100"
                leave-active-class="transition ease-in duration-200"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0"
            >
                <div
                    v-if="showMessageModal"
                    class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 p-4"
                    @click="handleOutsideClick"
                >
                    <Transition
                        enter-active-class="transition ease-out duration-300"
                        enter-from-class="opacity-0 scale-95"
                        enter-to-class="opacity-100 scale-100"
                        leave-active-class="transition ease-in duration-200"
                        leave-from-class="opacity-100 scale-100"
                        leave-to-class="opacity-0 scale-95"
                    >
                        <div
                            v-if="showMessageModal"
                            class="relative w-full max-w-md transform rounded-lg bg-white p-6"
                        >
                            <!-- Close button -->
                            <button
                                @click="closeMessageModal"
                                class="absolute right-2 top-2 text-gray-500 hover:text-gray-700 focus:outline-none"
                                aria-label="Close modal"
                            >
                                <X class="h-6 w-6" />
                            </button>

                            <h2 class="mb-2 text-xl font-semibold">
                                Message Seller
                            </h2>

                            <p class="mb-6 text-gray-700">
                                Have questions for the seller regarding this
                                listing? Ask them here.
                            </p>
                            <form
                                @submit.prevent="sendMessage"
                                class="space-y-4"
                            >
                                <div>
                                    <label
                                        for="message"
                                        class="block text-sm font-medium text-gray-700"
                                        >Message</label
                                    >
                                    <textarea
                                        id="message"
                                        v-model="messageForm.message"
                                        rows="4"
                                        placeholder="Request more details or discuss price.."
                                        required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    ></textarea>
                                </div>
                                <div class="flex justify-end space-x-2">
                                    <button
                                        type="button"
                                        @click="closeMessageModal"
                                        class="rounded-md border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                                    >
                                        Cancel
                                    </button>
                                    <button
                                        type="submit"
                                        class="rounded-md border border-transparent bg-slate-900 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                                    >
                                        Send Message
                                    </button>
                                </div>
                            </form>
                        </div>
                    </Transition>
                </div>
            </Transition>
        </Teleport>
    </div>
</template>
