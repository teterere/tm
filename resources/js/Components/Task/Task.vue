<template>
    <div class="bg-white rounded p-3 mb-3 shadow-sm cursor-pointer hover:shadow-md">
        <div class="flex justify-between">
            <div class="flex space-x-2">
                <TaskPriorityLabel :priority="task.priority" />

                <div v-if="task.labels.length" class="flex items-center gap-1.5">
                    <TaskLabel v-for="label in task.labels" :label="label" />
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
            <div class="flex-items-center space-x-2">
                <img class="inline-block size-7 rounded-full" :src="task.assignee.avatar_url" alt="" />
                <span class="text-xs text-gray-600">{{ task.assignee.name }}</span>
            </div>

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
                    <ChatBubbleOvalLeftEllipsisIcon class="h-4 w-4 text-gray-400 mr-1" />
                    <span class="text-xs text-gray-400">{{ task.comments_count }}</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import {CheckCircleIcon, ClockIcon, EllipsisHorizontalIcon, ChatBubbleOvalLeftEllipsisIcon} from "@heroicons/vue/24/outline";
import TaskPriorityLabel from "@/Components/Task/TaskPriority/TaskPriorityLabel.vue";
import TaskLabel from "@/Components/Task/TaskLabel/TaskLabel.vue";

defineProps({
    task: Object
});
</script>
