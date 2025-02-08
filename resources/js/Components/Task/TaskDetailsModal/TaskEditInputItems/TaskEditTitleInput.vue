<template>
    <div class="relative mb-4">
        <input v-if="editStatus" v-model="form.title" v-on-click-outside="disableEditStatus" ref="titleInput" type="text" class="font-medium block w-full rounded-xs bg-white p-2 text-xl text-gray-900 outline-1 outline-offset-0 outline-gray-200 border-gray-200 focus:outline-1 focus:-outline-offset-0 focus:outline-gray-200 focus:ring-gray-200 focus:border-gray-200" />

        <h2 v-else @click="enableEditStatus" class="text-xl font-medium hover:bg-gray-100 p-2 border-1 border-transparent hover:cursor-text">
            {{ task.title }}
        </h2>

        <div v-if="editStatus" class="absolute right-1 top-1/2 transform -translate-y-1/2 flex gap-2">
            <button class="bg-gray-100 hover:bg-gray-200 p-1.5 rounded-sm cursor-pointer">
                <XMarkIcon class="w-4 h-4" />
            </button>
            <button class="bg-gray-100 hover:bg-gray-200 p-1.5 rounded-sm cursor-pointer">
                <CheckIcon class="w-4 h-4" />
            </button>
        </div>
    </div>
</template>

<script setup>
import {nextTick, ref} from "vue";
import {useForm} from "@inertiajs/vue3";
import {vOnClickOutside} from '@vueuse/components';
import {CheckIcon, XMarkIcon} from "@heroicons/vue/24/outline/index.js";

const props = defineProps({
    task: Object
});

const titleInput = ref(null);

const form = useForm({
    title: props.task.title
});

const editStatus = ref(false);

const enableEditStatus = () => {
    editStatus.value = true;

    nextTick(() => {
        if (titleInput) {
            titleInput.value.focus();
        }
    });
}

const disableEditStatus = () => {
    editStatus.value = false;
}
</script>
