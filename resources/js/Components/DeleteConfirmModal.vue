<script setup>
import { ref } from "vue";
import { TransitionRoot, TransitionChild, Dialog, DialogPanel, DialogTitle } from "@headlessui/vue";
import { X, Trash2 } from "lucide-vue-next";

const props = defineProps({
    isOpen: {
        type: Boolean,
        required: true,
    },
    isLoading: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(['close', 'confirm']);
</script>

<template>
    <TransitionRoot appear :show="isOpen" as="template">
        <Dialog as="div" @close="emit('close')" class="relative z-50">
            <TransitionChild
                as="template"
                enter="duration-300 ease-out"
                enter-from="opacity-0"
                enter-to="opacity-100"
                leave="duration-200 ease-in"
                leave-from="opacity-100"
                leave-to="opacity-0"
            >
                <div class="fixed inset-0 bg-black bg-opacity-50" />
            </TransitionChild>

            <div class="fixed inset-0 overflow-y-auto">
                <div class="flex min-h-full items-center justify-center p-4 text-center">
                    <TransitionChild
                        as="template"
                        enter="duration-300 ease-out"
                        enter-from="opacity-0 scale-95"
                        enter-to="opacity-100 scale-100"
                        leave="duration-200 ease-in"
                        leave-from="opacity-100 scale-100"
                        leave-to="opacity-0 scale-95"
                    >
                        <DialogPanel class="relative w-full max-w-md transform overflow-hidden rounded-lg bg-white p-6 text-left align-middle shadow-xl transition-all">
                            <button
                                type="button"
                                class="absolute right-2.5 top-2.5 rounded-lg p-1.5 text-gray-400 hover:bg-gray-200 hover:text-gray-900"
                                @click="emit('close')"
                            >
                                <X class="h-5 w-5" />
                            </button>

                            <div class="text-center">
                                <Trash2 class="mx-auto mb-3.5 h-11 w-11 text-gray-400" />
                                <DialogTitle as="h3" class="mb-4 text-gray-500">
                                    Are you sure you want to delete this listing?
                                </DialogTitle>

                                <div class="flex items-center justify-center space-x-4">
                                    <button
                                        type="button"
                                        class="rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-900 focus:z-10 focus:outline-none focus:ring-4 focus:ring-primary-300"
                                        @click="emit('close')"
                                    >
                                        No, cancel
                                    </button>
                                    <button
                                        type="button"
                                        class="rounded-lg bg-red-600 px-3 py-2 text-sm font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-300"
                                        @click="emit('confirm')"
                                        :disabled="isLoading"
                                    >
                                        <span v-if="isLoading">Deleting...</span>
                                        <span v-else>Yes, I'm sure</span>
                                    </button>
                                </div>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>