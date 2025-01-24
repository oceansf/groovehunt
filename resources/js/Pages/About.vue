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
                        Groovehunt is a marketplace for buying and selling physical music formats like vinyl records, CDs, and cassettes. This site was born out of a need for <strong>low seller-fees</strong> and an <strong>easy-to-use</strong> platform for music collectors.
                    </p>
                    <br />
                    <p class="mt-2 text-lg leading-8 text-gray-600">
                        We offer a low <strong>5%</strong> seller's fee which is <em>only</em> applied to the total listed price. This is much lower compared to the 9-12% on competing platforms.
                    </p>
                    <br>
                    <p class="mt-2 text-lg leading-8 text-gray-600">
                        In the near future, we aim to offer sellers tools that will allow them to increase their sales and gain exposure for their store. Thank you for checking out Groovehunt and happy shopping!
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
