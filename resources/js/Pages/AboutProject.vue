<template>
    <AppLayout>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center p-8">
            <div>
                <h3 class="text-5xl font-bold text-gray-700 mb-8">Par projektu</h3>

                <p class="mb-4">
                    Šī ir vienkāršota Jira alternatīva, ko izstrādāju kā portfolio projektu, lai parādītu savas spējas UX, frontend un backend izstrādē.
                </p>
                <p class="mb-4">
                    Projekts nodrošina Kanban uzdevumu pārvaldību ar iespēju pievienot, rediģēt, dzēst uzdevumus un komentārus.
                </p>
                <p class="mb-4">
                    Katra demo sesija ir izolēta (“sandbox mode”) – katram lietotājam tiek izveidots atsevišķs pagaidu konts.
                </p>
                <p class="mb-4">
                    Projekts izstrādāts ar Vue 3, Laravel 11 un Tailwind CSS.
                </p>
                <div class="flex gap-6 mt-8">
                    <OutlineButton size="xl">Par projekta izstrādātāju</OutlineButton>

                    <Link :href="route('demo.login')" method="post" as="button" class="btn flex items-center space-x-2 bg-indigo-600 text-white hover:bg-indigo-500 focus-visible:outline-indigo-600 px-3.5 py-2.5 text-sm">
                        Atvērt Demo kontu
                    </Link>
                </div>
            </div>

            <div class="flex justify-center">
                <img src="/storage/dashboard.png"
                     class="max-w-[600px] w-full object-contain rounded-2xl border-[12px] shadow-2xl"
                     style="border-color: #f1f3ff; box-shadow: 0 40px 60px rgb(223,223,223);"
                     alt="Dashboard" />
            </div>
        </div>


    </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import OutlineButton from "@/Components/shared/Buttons/OutlineButton.vue";
import PrimaryButton from "@/Components/shared/Buttons/PrimaryButton.vue";
import {Cog8ToothIcon} from "@heroicons/vue/20/solid";
import { Link } from '@inertiajs/vue3'
</script>

<style scoped>
    .background-icon {
        width: 60rem;
        height: 60rem;
    }

    .grid-background {
        background-image: linear-gradient(#fbfbfb 1px, transparent 1px), linear-gradient(to right, #fbfbfb 1px, transparent 1px);
        background-size: 77px 77px;
        background-color: #ffffff;
    }

    img {
        position: relative;
        right: -15%;
        box-shadow: -10.5px 9px 52px 18px #e0e0e0;
    }
</style>
