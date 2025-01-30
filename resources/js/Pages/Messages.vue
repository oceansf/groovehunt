<script setup>
import { ref, computed, onMounted } from "vue";
import MessageInput from "@/Components/MessageInput.vue";

// Mock data for chats
const chats = ref([
    {
        id: 1,
        name: "Alice Johnson",
        lastMessage: "See you tomorrow!",
        messages: [
            { id: 1, sender: "other", text: "Hey, how are you?" },
            { id: 2, sender: "user", text: "I'm good, thanks! How about you?" },
            {
                id: 3,
                sender: "other",
                text: "Doing well. Are we still on for tomorrow?",
            },
            { id: 4, sender: "user", text: "Yes, definitely!" },
            { id: 5, sender: "other", text: "Great! See you tomorrow!" },
        ],
    },
    {
        id: 2,
        name: "Bob Smith",
        lastMessage: "Thanks for your help!",
        messages: [
            {
                id: 1,
                sender: "other",
                text: "Hi, I need some assistance with a project.",
            },
            { id: 2, sender: "user", text: "Sure, what can I help you with?" },
            {
                id: 3,
                sender: "other",
                text: "I'm stuck on the database design.",
            },
            {
                id: 4,
                sender: "user",
                text: "Let's schedule a call to discuss it.",
            },
            {
                id: 5,
                sender: "other",
                text: "Sounds good. Thanks for your help!",
            },
        ],
    },
]);

const activeChatId = ref(null);
const newMessage = ref("");

const activeChat = computed(() =>
    chats.value.find((chat) => chat.id === activeChatId.value),
);

const setActiveChat = (id) => {
    activeChatId.value = id;
};

const sendMessage = () => {
    if (newMessage.value.trim() && activeChat.value) {
        activeChat.value.messages.push({
            id: Date.now(),
            sender: "user",
            text: newMessage.value.trim(),
        });
        activeChat.value.lastMessage = newMessage.value.trim();
        newMessage.value = "";
    }
};

// Set the most recent conversation as active when the component mounts
onMounted(() => {
    if (chats.value.length > 0) {
        // Sort chats by the timestamp of their last message
        const sortedChats = [...chats.value].sort((a, b) => {
            const aLastMessageTime = a.messages[a.messages.length - 1].id;
            const bLastMessageTime = b.messages[b.messages.length - 1].id;
            return bLastMessageTime - aLastMessageTime;
        });

        // Set the most recent chat as active
        setActiveChat(sortedChats[0].id);
    }
});
</script>

<template>
    <div class="flex max-w-7xl mx-auto h-screen bg-gray-100 border-x border-b">
        <!-- Sidebar -->
        <div class="w-64 overflow-y-auto border-r border-gray-200 bg-white">
            <div class="p-4">
                <h2 class="text-xl font-semibold text-gray-800">
                    Messages
                </h2>
            </div>
            <ul>
                <li
                    v-for="chat in chats"
                    :key="chat.id"
                    @click="setActiveChat(chat.id)"
                    class="cursor-pointer p-4 transition-colors duration-150 hover:bg-gray-50"
                    :class="{ 'bg-blue-50': activeChatId === chat.id }"
                >
                    <div class="flex items-center">
                        <div
                            class="h-10 w-10 flex-shrink-0 rounded-full bg-gray-300"
                        ></div>
                        <div class="ml-3">
                            <p class="font-medium text-gray-900">
                                {{ chat.name }}
                            </p>
                            <p class="truncate text-sm text-gray-500">
                                {{ chat.lastMessage }}
                            </p>
                        </div>
                    </div>
                </li>
            </ul>
        </div>

        <!-- Conversation Container -->
        <div class="flex flex-1 flex-col">
            <!-- Conversation Header -->
            <div
                class="flex items-center border-b border-gray-200 bg-white p-4"
            >
                <div class="h-10 w-10 rounded-full bg-gray-300"></div>
                <h2 class="ml-3 text-xl font-semibold text-gray-800">
                    {{ activeChat ? activeChat.name : "No conversations" }}
                </h2>
            </div>

            <!-- Messages -->
            <div class="flex-1 space-y-4 overflow-y-auto p-4">
                <template v-if="activeChat">
                    <div
                        v-for="message in activeChat.messages"
                        :key="message.id"
                        class="flex"
                        :class="{ 'justify-end': message.sender === 'user' }"
                    >
                        <div
                            class="max-w-xs rounded-lg p-3 lg:max-w-md xl:max-w-lg"
                            :class="
                                message.sender === 'user'
                                    ? 'bg-blue-500 text-white'
                                    : 'bg-gray-200'
                            "
                        >
                            {{ message.text }}
                        </div>
                    </div>
                </template>
                <div v-else class="flex h-full items-center justify-center">
                    <p class="text-lg text-gray-500">
                        No conversations available
                    </p>
                </div>
            </div>

            <!-- Message Input -->
            <MessageInput v-model="newMessage" @send-message="sendMessage" />
        </div>
    </div>
</template>
