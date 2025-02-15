<template>
    <VueDatePicker v-model="form.due_date" auto-apply :enable-time-picker="false" @update:model-value="submit">
        <template #trigger>
            <span class="w-full block hover:bg-gray-100 cursor-pointer p-1 rounded-xs text-sm text-gray-600">{{ task.due_date }}</span>
        </template>
    </VueDatePicker>
</template>

<script setup>
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';
import {useForm} from "@inertiajs/vue3";

const props = defineProps({
    task: Object
});

const form = useForm({
    due_date: props.task.due_date_raw
});

const submit = () => {
    form.patch(route('tasks.update', props.task.id));
};
</script>
