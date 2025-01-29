<template>
    <div class="flex -ml-2">
        <div @mouseover="showActionButtons = true"
             @mouseleave="showActionButtons = false"
             :class="showActionButtons ? 'bg-gray-100' : ''"
             class="flex w-full items-center justify-between px-1">
            <div class="flex items-center">
                <div class="flex items-center justify-center text-gray-300 hover:text-gray-400 cursor-pointer p-2 mr-1">
                    <Bars3Icon class="h-4 w-4" />
                </div>
                <input @change="toggleCompleted" type="checkbox" :id="'item-' + item.id" :checked="item.completed" class="border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:checked:bg-gray-100 forced-colors:appearance-auto mr-2" />
                <label :for="'item-' + item.id" class="text-sm" :class="item.completed ? 'line-through text-gray-400' : 'text-gray-600'">
                    {{ item.description }}
                </label>
            </div>
            <div v-if="showActionButtons" class="flex gap-x-1">
                <button @mousedown.prevent="" class="bg-white hover:bg-gray-200 p-1 rounded-sm cursor-pointer">
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
import {Bars3Icon, PencilIcon, TrashIcon} from "@heroicons/vue/24/outline/index.js";
import {ref} from "vue";

const props = defineProps({
    item: Object
})

const showActionButtons = ref(false);

const deleteItem = () => {
    router.delete(route('tasks.checklist-items.delete', { task: props.item.task_id, item: props.item.id }), {
        preserveScroll: true
    });
}

const emit = defineEmits(['update']);

const completionStatusForm = useForm({});
const toggleCompleted = () => {
    completionStatusForm.post(route('tasks.checklist-items.toggle-complete', { task: props.item.task_id, item: props.item.id }), {
        preserveScroll: true
    });

    emit('update')
};
</script>

<style scoped>
    input {
        border-radius: 3px;
    }
</style>
