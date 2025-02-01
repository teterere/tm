<template>
    <div class="flex -ml-2">
        <div @mouseover="showActionButtons = true"
             @mouseleave="showActionButtons = false"
             :class="showActionButtons || editStatus ? 'bg-gray-100' : ''"
             class="flex w-full items-center justify-between px-1">
            <div class="flex items-center w-full">
                <div class="flex items-center justify-center text-gray-300 hover:text-gray-400 cursor-pointer p-2 mr-1">
                    <Bars3Icon class="h-4 w-4" />
                </div>
                <input @change="toggleCompleted" type="checkbox" :id="'item-' + item.id" :checked="item.completed" class="border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:checked:bg-gray-100 forced-colors:appearance-auto mr-2" />
                <input ref="inputRef" v-if="editStatus" v-model="form.description" @keyup.enter="updateItem" type="text" class="block w-full rounded-md bg-white px-1 -ml-1 mr-1 py-0 text-base text-gray-900 placeholder:text-gray-400 sm:text-sm/6 outline-0 border-0 focus:ring-0 focus:border-0 focus:outline-0">
                <label v-else :for="'item-' + item.id" class="w-full cursor-pointer text-sm" :class="{'line-through text-gray-400': item.completed, 'text-gray-600': !item.completed}">
                    {{ item.description }}
                </label>
            </div>
            <div v-if="editStatus" class="flex gap-x-1">
                <button @mousedown.prevent="editStatus = false" class="bg-white hover:bg-gray-200 p-1 rounded-sm cursor-pointer">
                    <XMarkIcon class="w-4 h-4" />
                </button>
                <button @mousedown.prevent="updateItem" class="bg-white hover:bg-gray-200 p-1 rounded-sm cursor-pointer">
                    <CheckIcon class="w-4 h-4" />
                </button>
            </div>
            <div v-else v-if="showActionButtons" class="flex gap-x-1">
                <button @mousedown.prevent="editStatus = true" class="bg-white hover:bg-gray-200 p-1 rounded-sm cursor-pointer">
                    <PencilIcon class="w-4 h-4" />
                </button>
                <button @mousedown.prevent="deleteItem" class="bg-white hover:bg-gray-200 p-1 rounded-sm cursor-pointer">
                    <TrashIcon class="w-4 h-4" />
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import {router, useForm} from "@inertiajs/vue3";
import {Bars3Icon, PencilIcon, TrashIcon, CheckIcon, XMarkIcon} from "@heroicons/vue/24/outline/index.js";
import {nextTick, ref, watch} from "vue";

const props = defineProps({
    item: Object
});

const emit = defineEmits(['edit-status-changed']);

const showActionButtons = ref(false);
const editStatus = ref(false);
const inputRef = ref(null);

watch(editStatus, async (newValue) => {
    emit('edit-status-changed', newValue);

    if (newValue === true) {
        await nextTick();
        inputRef.value?.focus();
    }
});

const deleteItem = () => {
    router.delete(route('tasks.checklist-items.delete', { task: props.item.task_id, item: props.item.id }), {
        preserveScroll: true
    });
}

const toggleCompleted = () => {
    router.patch(route('tasks.checklist-items.toggle-complete', { task: props.item.task_id, item: props.item.id }), {}, {
        preserveScroll: true
    });
};

const form = useForm({
    description: props.item.description
});

const updateItem = () => {
    form.patch(route('tasks.checklist-items.update', { task: props.item.task_id, item: props.item.id}), {
        preserveScroll: true,
        onSuccess: () => {
            editStatus.value = false;
        }
    });
}
</script>

<style scoped>
    input {
        border-radius: 3px;
    }

    input[type="text"] {
        user-select: text !important;
    }
</style>
