<template>
    <div class="flex gap-3">
        <div class="flex h-6 shrink-0 items-center">
            <input @change="toggleCompleted" type="checkbox" :id="'item-' + item.id" :checked="item.completed" class="rounded-sm border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:checked:bg-gray-100 forced-colors:appearance-auto mr-2" />
            <label :for="'item-' + item.id" class="text-sm" :class="item.completed ? 'line-through text-gray-400' : 'text-gray-600'">
                {{ item.description }}
            </label>
        </div>
    </div>
</template>

<script setup>
import {useForm} from "@inertiajs/vue3";
const emit = defineEmits(['update:complete-status-changed']);

const props = defineProps({
    item: Object
})

const form = useForm({});

const toggleCompleted = () => {
    form.post(route('tasks.checklist-items.toggle-complete', { task: props.item.task_id, item: props.item.id }), {
        preserveScroll: true
    });

    emit('update:complete-status-changed');
};
</script>
