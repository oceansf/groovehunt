<script setup>
import { XIcon } from "lucide-vue-next";

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
                    class="fixed inset-0 flex items-center justify-center z-40 bg-black bg-opacity-50 px-2"
                    @click="handleOutsideClick"
                >
                    <Transition
                        enter-active-class="transition ease-out duration-300"
                        enter-from-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        enter-to-class="opacity-100 translate-y-0 sm:scale-100"
                        leave-active-class="transition ease-in duration-200"
                        leave-from-class="opacity-100 translate-y-0 sm:scale-100"
                        leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    >
                        <div
                            v-if="showMessageModal"
                            class="relative mx-auto max-h-[90vh] min-h-[200px] w-full max-w-md transform overflow-y-auto rounded-lg bg-white p-4 sm:p-6"
                        >
                            <!-- Close button - made larger for touch targets -->
                            <button
                                @click="closeMessageModal"
                                class="absolute right-2 top-2 touch-manipulation p-2 text-gray-500 hover:text-gray-700 focus:outline-none"
                                aria-label="Close modal"
                            >
                                <XIcon class="h-7 w-7 sm:h-6 sm:w-6" />
                            </button>

                            <h2 class="mb-2 pr-8 text-xl font-semibold">
                                Message Seller
                            </h2>

                            <p
                                class="mb-4 text-sm text-gray-700 sm:mb-6 sm:text-base"
                            >
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
                                        class="mt-1 block w-full rounded-md border-gray-300 text-base shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 sm:text-sm"
                                    ></textarea>
                                </div>
                                <div
                                    class="flex flex-col justify-end space-y-2 sm:flex-row sm:space-x-2 sm:space-y-0"
                                >
                                    <button
                                        type="button"
                                        @click="closeMessageModal"
                                        class="w-full touch-manipulation rounded-md border border-gray-300 px-4 py-3 text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 sm:w-auto sm:py-2 sm:text-sm"
                                    >
                                        Cancel
                                    </button>
                                    <button
                                        type="submit"
                                        class="w-full touch-manipulation rounded-md border border-transparent bg-slate-900 px-4 py-3 text-base font-medium text-white shadow-sm hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 sm:w-auto sm:py-2 sm:text-sm"
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
