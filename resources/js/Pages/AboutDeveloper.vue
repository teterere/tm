<template>
    <AppLayout>
        <div class="md:w-2/3 flex flex-col justify-center px-6 md:pl-12 md:py-22 space-x-12">
            <h1 class="text-5xl font-bold text-gray-900 mb-8">Par izstrādātāju</h1>

            <div class="space-y-12 text-gray-700">
                <div class="space-y-4">
                    <p>
                        Esmu web izstrādātāja ar vairāku gadu pieredzi backend un frontend izstrādē. Ikdienā strādāju ar Laravel, Vue.js un Inertia.js, veidojot risinājumus, kas ir gan funkcionāli, gan vizuāli pārdomāti.
                    </p>

                    <p>
                        Lielāko pieredzi esmu guvusi <strong>Tet</strong> un <strong>DeskTime</strong> uzņēmumos, strādājot komandās pēc Agile un Scrum principiem.
                    </p>

                    <p>
                        Man ir svarīga koda kvalitāte, saprotama struktūra, lietotāja pieredze un kopējais produkta tēls.
                    </p>
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

                <div>
                    <div class="flex items-center gap-x-2 bg-white border pl-2 pr-4 py-4">
                        <span class="text-4xl">👋</span>
                        <div>
                            <p>Esmu atvērta jaunām iespējām. Ja tev šķiet, ka mēs varētu sadarboties, sazinies ar mani!</p>
                            <a href="mailto:ieva.avota@protonmail.com" class="font-semibold hover:underline">
                                ieva.avota@protonmail.com
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
</script>
