<script setup lang="ts">
import { Users, ShoppingBag, Music } from "lucide-vue-next";
import ContactForm from "@/Components/ContactForm.vue";
</script>

<template>
    <body style="overflow: hidden">
        <section
            class="px-4 py-9 2xl:container md:px-6 md:py-12 lg:px-20 lg:py-16 2xl:mx-auto"
        >
            <div class="flex flex-col justify-between gap-8 lg:flex-row">
                <div class="flex w-full flex-col justify-center lg:w-5/12">
                    <h1
                        class="pb-4 text-3xl font-bold leading-9 text-gray-800 lg:text-4xl"
                    >
                        About Us
                    </h1>
                    <p class="mt-2 text-lg leading-8 text-gray-600">
                        Groovehunt.com was born out of a passion for music and
                        the unique experience of vinyl records. Founded in 2024,
                        we've created a space where vinyl enthusiasts can
                        connect, buy, and sell their favorite records.
                    </p>
                    <br />
                    <p class="mt-2 text-lg leading-8 text-gray-600">
                        Our platform offers an authentic, easy-to-use experience
                        with a low <strong>5%</strong> selling fee (compared to the 8-11% on competing platforms). We also empower sellers with tools to grow your music business, all within a
                        carefully vetted community that ensures peace of mind
                        for every transaction.
                    </p>
                </div>
                <div class="w-full lg:w-6/12">
                    <img
                        class="h-full w-full rounded-xl"
                        src="https://res.cloudinary.com/oceansf/image/upload/c_scale,w_1000/l4d043pqwrsw9ulgcmpv.jpg"
                        alt="A collection of vinyl records"
                    />
                </div>
            </div>
        </section>
        <section>
            <ContactForm />
        </section>
    </body>
</template>
