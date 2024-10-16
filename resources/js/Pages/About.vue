<script setup lang="ts">
import ContactForm from '@/Components/ContactForm.vue';
</script>

<template>
    <body style="overflow: hidden">
    <div class="2xl:container 2xl:mx-auto lg:py-16 lg:px-20 md:py-12 md:px-6 py-9 px-4">
        <div class="flex flex-col lg:flex-row justify-between gap-8">
            <div class="w-full lg:w-5/12 flex flex-col justify-center">
                <h1 class="text-3xl lg:text-4xl font-bold leading-9 text-gray-800 pb-4">About Us</h1>
                <p class="font-normal text-base leading-6 text-gray-600">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum.In the first place we have granted to God, and by this our present charter confirmed for us and our heirs forever that the English Church shall be free, and shall have her rights entire, and her liberties inviolate; and we will that it be thus observed; which is apparent from</p>
            </div>
            <div class="w-full lg:w-6/12">
                <img class="w-full h-full" src="https://res.cloudinary.com/oceansf/image/upload/v1728834738/l4d043pqwrsw9ulgcmpv.jpg" alt="A collection of vinyl records" />
            </div>
        </div>
    </div>
    <ContactForm />
    </body>
</template>
