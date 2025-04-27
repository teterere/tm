<template>
    <VueDatePicker
        v-model="form.due_date"
        auto-apply
        :enable-time-picker="false"
        @update:model-value="submit"
    >
        <template #trigger>
            <span class="w-full block hover:bg-gray-100 cursor-pointer p-1 pl-2 rounded-xs text-sm text-gray-600">
                {{ formattedDate }}
            </span>
        </template>
    </VueDatePicker>
</template>

<script setup>
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';
import { useForm } from "@inertiajs/vue3";
import { computed, inject } from "vue";

const task = inject('task', null);
const emit = defineEmits(['update']);

const form = useForm({
    due_date: task?.due_date_raw ? new Date(task.due_date_raw) : null
});

const formatDate = (date) => {
    if (!date) return null;
    try {
        const options = { day: 'numeric', month: 'long' };
        return new Date(date).toLocaleDateString('lv-LV', options);
    } catch {
        return null;
    }
};

const formattedDate = computed(() => {
    if (!form.due_date) {
        return '-';
    }

    return formatDate(form.due_date) ?? '-';
});

const submit = () => {
    if (task) {
        form.patch(route('tasks.update', task.id), {
            preserveScroll: true
        });
        return;
    }

    emit('update', { field: 'due_date', value: form.due_date });
};
</script>
