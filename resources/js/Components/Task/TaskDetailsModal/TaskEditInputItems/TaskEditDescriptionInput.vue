<template>
    <div v-if="editStatus">
        <textarea ref="textarea" v-model="input" type="text" class="font-medium block w-full rounded-xs bg-white p-2 text-sm text-gray-900 outline-1 outline-offset-0 outline-gray-200 border-gray-200 focus:outline-1 focus:-outline-offset-0 focus:outline-gray-200 focus:ring-gray-200 focus:border-gray-200 resize-none max-h-72 overflow-y-auto mb-4" />
        <div class="flex gap-x-3">
            <PrimaryButton @click="submit" size="sm">
                Saglabāt
            </PrimaryButton>
            <OutlineButton @click="disableEditStatus" size="sm">
                Atcelt
            </OutlineButton>
        </div>
    </div>

    <p v-else @click="enableEditStatus" class="text-sm text-gray-700 hover:bg-gray-100 p-2 border-1 border-transparent hover:cursor-text">
        {{ task.description }}
    </p>
</template>

<script setup>
import {inject, nextTick, ref} from "vue";
import { useTextareaAutosize } from '@vueuse/core'
import {useForm} from "@inertiajs/vue3";
import OutlineButton from "@/Components/shared/Buttons/OutlineButton.vue";
import PrimaryButton from "@/Components/shared/Buttons/PrimaryButton.vue";

const task = inject('task');

const form = useForm({
    description: task.description
});

const { textarea, input } = useTextareaAutosize();

const editStatus = ref(false);

const enableEditStatus = () => {
    editStatus.value = true;
    input.value = task.description;

    nextTick(() => {
        if (textarea) {
            textarea.value.focus();
        }
    });
};

const disableEditStatus = () => {
    editStatus.value = false;
}

const submit = () => {
    if (input.value === task.description) {
        editStatus.value = false;

        return;
    }

    form.transform((data) => ({
        ...data,
        description: input.value
    })).patch(route('tasks.update', { task: task.id }), {
        preserveScroll: true,
        onSuccess: () => {
            editStatus.value = false;
        },
    });
};
</script>
