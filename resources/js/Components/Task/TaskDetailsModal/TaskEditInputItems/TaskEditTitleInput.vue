<template>
    <div class="relative">
        <OnClickOutside v-if="editStatus" :options="options">
            <input v-if="editStatus" v-model="form.title" ref="titleInput" type="text" class="font-medium block w-full rounded-xs bg-white p-2 text-xl text-gray-900 outline-1 outline-offset-0 outline-gray-200 border-gray-200 focus:outline-1 focus:-outline-offset-0 focus:outline-gray-200 focus:ring-gray-200 focus:border-gray-200" />
        </OnClickOutside>

        <h2 v-else @click="enableEditStatus" class="text-xl font-medium hover:bg-gray-100 p-2 border-1 border-transparent hover:cursor-text">
            {{ task.title }}
        </h2>

        <div ref="actionButtons" v-if="editStatus" class="absolute right-1 top-1/2 transform -translate-y-1/2 flex gap-2">
            <button @mousedown.stop="submit" class="bg-gray-100 hover:bg-gray-200 p-1.5 rounded-sm cursor-pointer">
                <CheckIcon class="w-4 h-4" />
            </button>
            <button @click="disableEditStatus" class="bg-gray-100 hover:bg-gray-200 p-1.5 rounded-sm cursor-pointer">
                <XMarkIcon class="w-4 h-4" />
            </button>
        </div>
    </div>
</template>

<script setup>
import {nextTick, ref} from "vue";
import {useForm} from "@inertiajs/vue3";
import {OnClickOutside} from '@vueuse/components';
import {CheckIcon, XMarkIcon} from "@heroicons/vue/24/outline";

const props = defineProps({
    task: Object
});

const titleInput = ref(null);
const actionButtons = ref(null);

const options = { ignore: [actionButtons] }

const form = useForm({
    title: props.task.title
});

const editStatus = ref(false);

const enableEditStatus = () => {
    editStatus.value = true;
    form.title = props.task.title;

    nextTick(() => {
        if (titleInput) {
            titleInput.value.focus();
        }
    });
};

const disableEditStatus = () => {
    editStatus.value = false;
}

const submit = () => {
    if (form.title === props.task.title) {
        editStatus.value = false;

        return;
    }

    form.patch(route('tasks.update', { task: props.task.id }), {
        preserveScroll: true,
        onSuccess: () => {
            editStatus.value = false;
        },
    });
}
</script>
