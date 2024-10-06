<template>
  <div>
    <h1>{{ listing.title }}</h1>
    <img :src="listing.image_url" :alt="listing.title" class="w-full h-64 object-cover">
    <p>Artist: {{ listing.artist }}</p>
    <p>Price: ${{ listing.price }}</p>
    <p>Condition: {{ listing.condition }}</p>
    <p>Description: {{ listing.description }}</p>
  </div>
</template>

<script setup>
import { defineProps } from 'vue';

const props = defineProps({
  listing: Object
});
</script>