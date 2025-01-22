<template>
    <AppLayout>
        <div class="grid grid-cols-4 px-4 sm:px-6 lg:px-8 space-x-4">
            <div v-for="status in statuses.data" class="col-span-1 bg-slate-100 rounded p-3">
                <div class="border-b-2 mb-4 pb-2 border-indigo-200 flex items-center justify-between">
                    <div class="flex items-center">
                        <h3 class="uppercase font-semibold text-sm text-gray-700 mr-2">{{ status.title }}</h3>
                        <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-indigo-100 text-xs font-bold text-indigo-500">3</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <PlusIcon class="h-4 w-4 text-gray-400" />
                        <EllipsisHorizontalIcon class="h-4 w-4 text-gray-400" />
                    </div>
                </div>

                <div v-for="task in status.tasks" class="bg-white rounded p-3 mb-3 shadow-sm">
                    <div class="flex justify-between">
                        <div class="flex space-x-2">
                        <span class="inline-flex items-center gap-x-1.5 rounded-md bg-red-100 px-1.5 py-0.5 text-xs font-medium text-red-700">
                        <svg class="size-1.5 fill-red-500" viewBox="0 0 6 6" aria-hidden="true">
                          <circle cx="3" cy="3" r="3"/>
                        </svg>
                        {{ task.priority.title }}
                      </span>

                            <span class="inline-flex items-center rounded-md bg-blue-100 px-1.5 py-0.5 text-xs font-medium text-blue-700">
                            Label
                        </span>
                        </div>

                        <EllipsisHorizontalIcon class="h-4 w-4 text-gray-400" />
                    </div>

                    <div class="py-3">
                        <h3 class="font-medium mb-2">{{ task.title }}</h3>
                        <p class="text-gray-500 text-sm line-clamp-3">{{ task.description }}</p>
                    </div>
                    <div class="flex items-center border-b-1 pb-2 mb-2">
                        <ClockIcon class="h-4 w-4 text-gray-500 mr-1" />
                        <span class="text-gray-500 text-xs">{{ task.due_date }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <img class="inline-block size-8 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" />

                        <div class="flex items-center space-x-3">
                            <div class="flex items-center">
                                <CheckCircleIcon class="h-4 w-4 text-gray-500 mr-1" />
                                <span class="text-sm text-gray-500">2/4</span>
                            </div>

                            <div class="flex items-center">
                                <EnvelopeIcon class="h-4 w-4 text-gray-500 mr-1" />
                                <span class="text-sm text-gray-500">2</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";

import {
    PlusIcon,
    EllipsisHorizontalIcon,
    ClockIcon,
    EnvelopeIcon,
    CheckCircleIcon
} from '@heroicons/vue/24/outline';

const props = defineProps({
    statuses: Object
});
</script>
