<template>
    <wysiwyg v-if="editStatus" :content="task.description" @submit="submit" @close="disableEditStatus" />
    <div v-else v-html="task.description" @click="enableEditStatus" class="text-sm text-gray-700 hover:bg-gray-100 p-2 border-1 border-transparent hover:cursor-text"></div>
</template>

<script setup>
import {inject, ref} from "vue";
import {useForm} from "@inertiajs/vue3";
import Wysiwyg from "@/Components/shared/wysiwyg/Wysiwyg.vue";

const task = inject('task');

const editStatus = ref(false);

const form = useForm({
    description: task.description
});

const enableEditStatus = () => {
    editStatus.value = true;
};

const disableEditStatus = () => {
    editStatus.value = false;
}

const submit = (content) => {
    if (content === task.description) {
        editStatus.value = false;

        return;
    }

    form.transform((data) => ({
        ...data,
        description: content
    })).patch(route('tasks.update', { task: task.id }), {
        preserveScroll: true,
        onSuccess: () => {
            task.description = content;
            editStatus.value = false;
        },
    });
};
</script>
