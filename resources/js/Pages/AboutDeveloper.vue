<template>
    <AppLayout>
        <section class="grid md:grid-cols-3 md:pl-12 py-22 space-x-12">
            <div class="col-span-2 flex flex-col justify-center px-6">
                <h1 class="text-5xl font-bold text-gray-900 mb-8">Par izstrādātāju</h1>

                <div class="space-y-18 text-gray-700">
                    <div class="space-y-4">
                        <p>
                            Esmu web izstrādātāja ar vairāku gadu pieredzi backend un frontend izstrādē. Ikdienā strādāju ar Laravel, Vue un Inertia.js, veidojot risinājumus, kas ir gan funkcionāli, gan vizuāli pārdomāti.
                        </p>

                        <p>
                            Lielāko pieredzi esmu guvusi <strong>Tet</strong> un <strong>DeskTime</strong> uzņēmumos, strādājot komandās pēc Agile un Scrum principiem.
                        </p>

                        <p>
                            Man ir svarīga koda kvalitāte, saprotama struktūra, lietotāja pieredze un kopējais produkta tēls.
                        </p>
                    </div>

                    <div>
                        <p>Esmu atvērta jaunām iespējām. Ja tev šķiet, ka mēs varētu sadarboties, sazinies ar mani!</p>
                        <div class="flex items-center gap-2">
                            <span class="text-lg">✉️</span>
                            <span class="font-semibold">ieva.avota@protonmail.com</span>
                        </div>
                    </div>

                    <div class="space-y-8">
                        <div>
                            <p class="font-semibold mb-1">Tehnoloģijas un valodas:</p>
                            <ul class="flex items-start flex-wrap gap-2">
                                <li v-for="title in ['PHP', 'JavaScript', 'Laravel', 'Vue.js', 'Nuxt.js', 'Joomla', 'Scss', 'BootStrap', 'Tailwind', 'Git']" class="bg-gray-200 rounded-full py-1 px-3 text-xs font-semibold">
                                    {{ title }}
                                </li>
                            </ul>
                        </div>

                        <div>
                            <p class="font-semibold mb-1">Citi rīki:</p>
                            <ul class="flex items-start flex-wrap gap-2">
                                <li v-for="title in ['Jira', 'ClickUp', 'Figma', 'GitLab']" class="bg-gray-200 rounded-full py-1 px-3 text-xs font-semibold">
                                    {{ title }}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { EnvelopeIcon } from '@heroicons/vue/24/outline';
</script>
