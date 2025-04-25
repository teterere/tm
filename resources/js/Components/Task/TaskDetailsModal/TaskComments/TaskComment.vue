<template>
    <div class="mb-4 px-2 py-1 rounded-sm group">
        <div class="flex space-x-2">
            <img class="inline-block size-10 rounded-full mt-1"
                 :src="comment.author.avatar_url"
                 alt="Darbinieka attēls"/>

            <div class="w-full">
                <div class="space-x-2 mb-1 pl-1.5">
                    <span class="text-sm font-semibold text-gray-600">{{ comment.author.name }}</span>
                    <span class="text-xs text-gray-400">{{ comment.created_at }}</span>
                </div>

                <CommentInput v-if="editStatus" :comment="comment" @close="$emit('close-edit')" @commentUpdated="$emit('commentUpdated')" />
                <div v-else v-html="comment.body" class="comment-body text-sm/6 text-gray-600 p-1.5"></div>

                <div v-if="!editStatus" class="flex gap-x-2 justify-end w-full opacity-0 group-hover:opacity-100 transition-opacity duration-150">
                    <TaskCommentActionButton @click="$emit('reply', comment.author.name)">Atbildēt</TaskCommentActionButton>
                    <div v-if="comment.author.is_auth" class="flex items-center gap-x-2">
                        <TaskCommentActionButtonDivider />
                        <TaskCommentActionButton @click="$emit('edit')">Labot</TaskCommentActionButton>
                        <TaskCommentActionButtonDivider />
                        <TaskCommentActionButton @click="showConfirmDeletionDialog = true">Dzēst</TaskCommentActionButton>
                        <ConfirmDeletionDialog :show="showConfirmDeletionDialog" @confirm="deleteComment" @close="showConfirmDeletionDialog = false">
                            <template #title>Dzēst komentāru?</template>
                            <template #description>Apstiprini, ka tiešām vēlies dzēst šo komentāru. Šo darbību nav iespējams atsaukt.</template>
                        </ConfirmDeletionDialog>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import TaskCommentActionButton from "@/Components/Task/TaskDetailsModal/TaskComments/TaskCommentActionButton.vue";
import {ref} from "vue";
import TaskCommentActionButtonDivider from "@/Components/Task/TaskDetailsModal/TaskComments/TaskCommentActionButtonDivider.vue";
import {router} from "@inertiajs/vue3";
import ConfirmDeletionDialog from "@/Components/ConfirmDeletionDialog.vue";
import CommentInput from "@/Components/Task/TaskDetailsModal/TaskComments/CommentInput.vue";

const props = defineProps({
    comment: Object,
    editStatus: Boolean
});

const emit = defineEmits(['reply', 'commentUpdated', 'edit', 'close-edit']);

const showConfirmDeletionDialog = ref(false);

const deleteComment = () => {
    router.delete(route('tasks.comments.delete', { task: props.comment.task_id, comment: props.comment.id }), {
        preserveScroll: true,
        onSuccess: () => {
            showConfirmDeletionDialog.value = false;
            emit('commentUpdated')
        },
    });
};
</script>
