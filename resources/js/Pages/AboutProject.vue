<template>
    <AppLayout>
        <section class="flex flex-col md:flex-row md:pl-12 pt-22">
            <div class="flex flex-col justify-center px-6 md:w-1/2">
                <div class="space-y-6 md:space-y-8 max-w-prose">
                <h1 class="text-5xl font-bold text-gray-900">Par projektu</h1>

                <div>
                    <p class="text-sm uppercase tracking-wide text-gray-500 mb-2">Uzdevumu pārvaldības sistēmas piemērs</p>
                    <p class="text-gray-700">
                        Šis projekts tika izstrādāts, lai demonstrētu manas spējas fullstack izstrādē. Projekts darbojas izolētā sanbox vidē, kurā iespējams brīvi testēt funkcionalitāti un dati tiks automātiski dzēsti pēc 15 minūtēm.
                    </p>
                </div>

                <div class="">
                    <p class="text-sm text-gray-600 mb-2">Izstrādē izmantotās tehnoloģijas</p>
                    <div class="flex flex-wrap gap-2">
                        <span v-for="technology in technologies" class="inline-flex items-center gap-2 bg-gray-100 px-3 py-1 rounded-full text-sm font-medium border">
                          <img :src="'/storage/used-technologies/' + technology.logo" alt="Laravel" class="h-4 w-4" />
                          {{ technology.title }}
                        </span>
                    </div>
                </div>

                <div class="flex flex-col md:flex-row md:flex-wrap gap-3 pt-4 px-8 md:px-0">
                    <PrimaryButton :href="route('demo.login')" method="post" as="button" class="py-3 justify-center">
                        <span>Atvērt demo kontu</span>
                        <ArrowLongRightIcon class="size-4" />
                    </PrimaryButton>

                    <a href="https://gitlab.com/portfolio8403007/task-manager" target="_blank" class="btn flex items-center space-x-2 px-2.5 py-1.5 text-sm bg-white text-gray-900 ring-inset ring-1 ring-gray-200 hover:bg-gray-50 py-3 justify-center py-3 justify-center">
                        <CodeBracketIcon class="size-4" />
                        <span>Skatīt kodu GitLab</span>
                    </a>

                    <OutlineButton :href="route('about-developer')" class="py-3 justify-center">
                        <UserIcon class="size-4" />
                        <span>Par izstrādātāju</span>
                    </OutlineButton>
                </div>
            </div>
            </div>

            <div class="hidden md:block md:w-1/2 relative left-0 top-0 top-0 min-h-[600px]">
                <img
                    src="/storage/dashboard.png"
                    alt="Uzdevumu dēlis"
                    class="h-full object-cover object-left shadow-xl"
                />
            </div>
        </section>
    </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import OutlineButton from "@/Components/shared/Buttons/OutlineButton.vue";
import PrimaryButton from "@/Components/shared/Buttons/PrimaryButton.vue";
import {useForm} from '@inertiajs/vue3';
import {ArrowLongRightIcon, CodeBracketIcon, UserIcon} from '@heroicons/vue/24/outline';

const form = useForm({});

const technologies = [
    {title: 'Laravel 11', logo: 'laravel.svg'},
    {title: 'Vue 3', logo: 'vue.svg'},
    {title: 'Inertia.js', logo: 'inertia.svg'},
    {title: 'Tailwind CSS', logo: 'tailwind.svg'},
];
</script>
