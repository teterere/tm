<template>
    <div class="mb-4 px-2 py-1 rounded-sm group">
        <div class="flex space-x-2">
            <img class="inline-block size-10 rounded-full mt-1"
                 :src="comment.author.avatar_path"
                 alt="Darbinieka attēls"/>

            <div class="w-full">
                <div class="space-x-2 mb-1 pl-1.5">
                    <span class="text-sm font-semibold text-gray-600">{{ comment.author.name }}</span>
                    <span class="text-xs text-gray-400">{{ comment.created_at }}</span>
                </div>

                <textarea v-if="editStatus" v-model="input" ref="textarea" class="w-full text-sm block w-full rounded-xs bg-white p-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-200 border-gray-200 placeholder:text-gray-400 sm:text-sm/6 focus:ring-0 focus:ring-gray-200 focus:border-gray-200" />
                <p v-else class="text-sm/6 text-gray-700 p-1.5">{{ comment.body }}</p>

                <div v-if="editStatus" class="flex gap-x-2 justify-end items-center w-full mt-1">
                    <TaskCommentActionButton @click="submit">Saglabāt</TaskCommentActionButton>
                    <TaskCommentActionButtonDivider />
                    <TaskCommentActionButton @click="disableEditStatus">Atcelt</TaskCommentActionButton>
                </div>

                <div v-else class="flex gap-x-2 justify-end w-full opacity-0 group-hover:opacity-100 transition-opacity duration-150">
                    <TaskCommentActionButton @click="$emit('reply', comment.author.name)">Atbildēt</TaskCommentActionButton>
                    <div v-if="comment.author.is_auth" class="flex items-center gap-x-2">
                        <TaskCommentActionButtonDivider />
                        <TaskCommentActionButton @click="enableEditStatus">Labot</TaskCommentActionButton>
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
import {nextTick, ref} from "vue";
import TaskCommentActionButtonDivider from "@/Components/Task/TaskDetailsModal/TaskComments/TaskCommentActionButtonDivider.vue";
import {router, useForm} from "@inertiajs/vue3";
import {useTextareaAutosize} from "@vueuse/core";
import ConfirmDeletionDialog from "@/Components/ConfirmDeletionDialog.vue";

const props = defineProps({
    comment: Object
});

const editStatus = ref(false);
const showConfirmDeletionDialog = ref(false);

const form = useForm({
    comment: props.comment.body
});

const { textarea, input } = useTextareaAutosize();

const enableEditStatus = () => {
    editStatus.value = true;
    input.value = props.comment.body;

    nextTick(() => {
        if (textarea) {
            textarea.value.focus();
        }
    });
};

const disableEditStatus = () => {
    editStatus.value = false;
};

const submit = () => {
    if (input.value === props.comment.body) {
        editStatus.value = false;

        return;
    }

    form.transform((data) => ({
        ...data,
        body: input.value
    })).patch(route('tasks.comments.update', { task: props.comment.task_id, comment: props.comment.id }), {
        preserveScroll: true,
        onSuccess: () => {
            editStatus.value = false;
        },
    });
};

const deleteComment = () => {
    router.delete(route('tasks.comments.delete', { task: props.comment.task_id, comment: props.comment.id }), {
        preserveScroll: true,
        onSuccess: () => {
            showConfirmDeletionDialog.value = false;
        },
    });
};
</script>
