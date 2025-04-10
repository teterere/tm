<template>
    <div class="mb-4 p-2 rounded-sm group">
        <div class="flex space-x-3">
            <img class="inline-block size-10 rounded-full mt-1"
                 :src="comment.author.avatar_path"
                 alt="Darbinieka attēls"/>

            <div class="w-full">
                <div class="space-x-2 mb-1">
                    <span class="text-sm font-semibold text-gray-600">{{ comment.author.name }}</span>
                    <span class="text-xs text-gray-400">{{ comment.created_at }}</span>
                </div>
                <p class="text-sm/6 text-gray-700">{{ comment.body }}</p>

                <div class="flex gap-x-2 justify-end w-full opacity-0 group-hover:opacity-100 transition-opacity duration-150">
                    <TaskCommentActionButton>Atbildēt</TaskCommentActionButton>
                    <div v-if="comment.author.is_auth" class="flex items-center gap-x-2">
                        <svg class="size-1 fill-gray-300" viewBox="0 0 6 6" aria-hidden="true">
                            <circle cx="3" cy="3" r="3" />
                        </svg>
                        <TaskCommentActionButton>Labot</TaskCommentActionButton>
                        <svg class="size-1 fill-gray-300" viewBox="0 0 6 6" aria-hidden="true">
                            <circle cx="3" cy="3" r="3" />
                        </svg>
                        <TaskCommentActionButton>Dzēst</TaskCommentActionButton>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import TaskCommentActionButton from "@/Components/Task/TaskDetailsModal/TaskComments/TaskCommentActionButton.vue";

const props = defineProps({
    comment: Object
});
</script>
