<template>
    <div class="relative">
        <OnClickOutside v-if="editStatus" :options="options" @trigger="disableEditStatus">
            <input v-model="form.title" ref="titleInput" type="text" class="font-medium block w-full rounded-xs bg-white p-2 text-xl text-gray-900 outline-1 outline-offset-0 outline-gray-200 border-gray-200 focus:outline-1 focus:-outline-offset-0 focus:outline-gray-200 focus:ring-gray-200 focus:border-gray-200" />
        </OnClickOutside>

        <h2 v-else @click="enableEditStatus" class="text-xl font-medium hover:bg-gray-100 p-2 border-1 border-transparent hover:cursor-text">
            {{ task.title }}
        </h2>

        <div ref="actionButtons" v-if="editStatus" class="absolute right-1 top-1/2 transform -translate-y-1/2 flex gap-2">
            <button @mousedown.stop="submit" class="action-button p-1.5">
                <CheckIcon class="w-4 h-4" />
            </button>
            <button @click="disableEditStatus" class="action-button p-1.5">
                <XMarkIcon class="w-4 h-4" />
            </button>
        </div>
    </div>
</template>

<script setup>
import {inject, nextTick, ref} from "vue";
import {useForm} from "@inertiajs/vue3";
import {OnClickOutside} from '@vueuse/components';
import {CheckIcon, XMarkIcon} from "@heroicons/vue/24/outline";

const task = inject('task');

const titleInput = ref(null);
const actionButtons = ref(null);

const options = { ignore: [actionButtons] };

const form = useForm({
    title: task.title
});

const editStatus = ref(false);

const enableEditStatus = () => {
    editStatus.value = true;
    form.title = task.title;

    nextTick(() => {
        if (titleInput) {
            titleInput.value.focus();
        }
    });
};

const disableEditStatus = () => {
    editStatus.value = false;
};

const submit = () => {
    if (form.title === task.title) {
        editStatus.value = false;

        return;
    }

    form.patch(route('tasks.update', { task: task.id }), {
        preserveScroll: true,
        onSuccess: () => {
            editStatus.value = false;
        },
    });
};
</script>
