<script setup>
import { CheckCircleIcon, XMarkIcon } from '@heroicons/vue/20/solid'

defineProps({
  message: String
})

const emit = defineEmits(['close'])

const closeAlert = () => {
  emit('close')
}

</script>

<template>
  <div class="fixed left-0 right-0 flex justify-center w-full mt-2 mx-2 z-10">
    <div class="rounded-md bg-green-50 border border-green-400/35 p-4 backdrop-filter backdrop-blur bg-opacity-75">
      <div class="flex">
        <div class="flex-shrink-0">
          <CheckCircleIcon class="h-5 w-5 text-green-400" aria-hidden="true" />
        </div>
        <div class="ml-3">
          <p class="text-sm font-medium text-green-800">{{ message }}</p>
        </div>
        <div class="ml-auto pl-3">
          <div class="-mx-1.5 -my-1.5">
            <button @click="closeAlert" type="button" class="inline-flex rounded-md p-1.5 text-green-500 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2 focus:ring-offset-green-50">
              <span class="sr-only">Dismiss</span>
              <XMarkIcon class="h-5 w-5" aria-hidden="true" />
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>