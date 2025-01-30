<template>
  <div class="border-t border-gray-200 bg-white p-4">
    <div class="flex items-center">
      <div class="relative flex-1">
        <input
          type="text"
          v-model="newMessage"
          @keyup.enter="sendMessage"
          placeholder="Type a message..."
          class="w-full rounded-full border border-gray-300 px-4 py-2 pr-10 focus:outline-none focus:ring-2 focus:ring-blue-500"
        />
        <button
          @click="toggleEmojiPicker"
          class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700 focus:outline-none"
        >
          <EmojiIcon class="h-5 w-5" />
        </button>
      </div>
      <button
        @click="sendMessage"
        class="ml-2 rounded-full bg-blue-500 p-2 text-white hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500"
      >
        <SendIcon class="h-5 w-5" />
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { SendIcon, SmileIcon as EmojiIcon } from 'lucide-vue-next';

const newMessage = ref('');
const showEmojiPicker = ref(false);

const sendMessage = () => {
  if (newMessage.value.trim()) {
    // Emit the message to the parent component
    emit('send-message', newMessage.value);
    newMessage.value = '';
  }
};

const toggleEmojiPicker = () => {
  showEmojiPicker.value = !showEmojiPicker.value;
};

const addEmoji = (emoji) => {
  newMessage.value += emoji;
  showEmojiPicker.value = false;
};
</script>

