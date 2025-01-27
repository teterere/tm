<template>
    <div class="bg-white rounded p-3 mb-3 shadow-sm">
        <div class="flex justify-between">
            <div class="flex space-x-2">
                <span class="inline-flex items-center gap-x-1.5 rounded-md bg-red-100 px-1.5 py-0.5 text-xs font-medium text-red-700">
                <svg class="size-1.5 fill-red-500" viewBox="0 0 6 6" aria-hidden="true">
                  <circle cx="3" cy="3" r="3"/>
                </svg>
                {{ task.priority.title }}
              </span>

                <div v-if="task.labels.length" class="flex items-center space-x-1">
                    <span v-for="label in task.labels"
                          class="inline-flex items-center rounded-md px-1.5 py-0.5 text-xs font-medium text-blue-700"
                          :style="{ backgroundColor: label.color }"
                    >
                        <span :style="{ color: label.color, filter: 'brightness(30%)'}">{{ label.title }}</span>
                    </span>
                </div>
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
                    <CheckCircleIcon class="h-4 w-4 text-gray-400 mr-1" />
                    <div class="flex text-xs font-medium text-gray-400">
                        <span>{{ task.completed_checklist_items_count }}</span>
                        <span>/</span>
                        <span>{{ task.checklist_items.length}}</span>
                    </div>
                </div>

                <div class="flex items-center">
                    <EnvelopeIcon class="h-4 w-4 text-gray-400 mr-1" />
                    <span class="text-xs text-gray-400">2</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import {CheckCircleIcon, ClockIcon, EllipsisHorizontalIcon, EnvelopeIcon} from "@heroicons/vue/24/outline/index.js";

const props = defineProps({
    task: Object
});
</script>
