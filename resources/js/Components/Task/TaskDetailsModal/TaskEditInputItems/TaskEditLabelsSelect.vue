<template>
    <Combobox as="div" v-model="form.selectedLabels" :open="isOpen" @update:modelValue="query = ''" class="w-full" multiple>
        <div class="relative w-full mt-2">
            <ComboboxButton
                @click="toggleDropdown"
                class="selected-labels-container w-full hover:bg-gray-100 rounded-xs text-sm px-2 py-1 text-gray-900 cursor-pointer flex flex-wrap gap-2 items-center">
                <template v-if="task.labels.length > 0">
                    <div ref="taskLabelRef" class="flex flex-wrap gap-1.5">
                        <TaskLabel v-for="label in task.labels" :key="label.id" :label="label" :removeButton="isOpen" @remove.stop="removeLabel(label)" />
                    </div>
                </template>
                <span v-else-if="!task.labels.length && !isOpen" class="text-gray-600">Pievienot</span>
            </ComboboxButton>

            <ComboboxInput v-if="isOpen"
                           class="block w-full rounded-xs bg-white py-1 pr-12 pl-3 mt-1 text-sm text-gray-900 focus:border-gray-300 focus:ring-gray-300 placeholder:text-gray-400 sm:text-sm"
                           @change="query = $event.target.value"
                           @blur="handleBlur($event)"
                           :display-value="() => query"
            />

            <ComboboxOptions v-if="isOpen && (filteredLabels.length > 0 || newLabel)"
                             class="absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base ring-1 shadow-lg ring-black/5 focus:outline-none sm:text-sm">
                <ComboboxOption v-for="label in filteredLabels" :key="label.id" :value="label" as="template" v-slot="{ active, selected }">
                    <li :class="['relative cursor-default py-2 pr-9 pl-3 select-none', active ? 'bg-indigo-600 text-white' : 'text-gray-900']">
                        <span :class="['block truncate', selected && 'font-semibold']">{{ label.title }}</span>
                    </li>
                </ComboboxOption>
                <ComboboxOption v-if="newLabel" :value="newLabel" as="template" v-slot="{ active, selected }">
                    <li :class="['relative cursor-default py-2 pr-9 pl-3 select-none', active ? 'bg-indigo-600 text-white' : 'text-gray-900']">
                        <span :class="['block truncate', selected && 'font-semibold']">{{ query }} (jauna birka)</span>
                    </li>
                </ComboboxOption>
            </ComboboxOptions>
        </div>
    </Combobox>
</template>

<script setup>
import {computed, ref, watch} from 'vue';
import {Combobox, ComboboxButton, ComboboxInput, ComboboxOption, ComboboxOptions} from '@headlessui/vue';
import TaskLabel from "@/Components/Task/TaskLabel/TaskLabel.vue";
import {router, useForm} from "@inertiajs/vue3";

const props = defineProps({
    labels: Array,
    task: Object
});

const form = useForm({
    selectedLabels: []
});

const query = ref('');
const isOpen = ref(false);
const taskLabelRef = ref(null);

const filteredLabels = computed(() => {
    const normalizedQuery = query.value.trim().toLowerCase();
    const labelsNotAssignedToTask = props.labels.filter(label => !props.task.labels.some(taskLabel => taskLabel.id === label.id));

    return normalizedQuery
        ? labelsNotAssignedToTask.filter(label => label.title.toLowerCase().includes(normalizedQuery))
        : labelsNotAssignedToTask;
});

watch(() => form.selectedLabels, () => {
    addLabels();
});

const handleBlur = (event) => {
    if (event.relatedTarget && event.relatedTarget.classList.contains('selected-labels-container')) {
        return;
    }

    isOpen.value = false;
    query.value = '';
};

const toggleDropdown = () => {
    isOpen.value = !isOpen.value;
};

const newLabel = computed(() => {
    return query.value === '' ? null : { id: null, title: query.value }
});

const addLabels = () => {
    form.post(route('tasks.labels.add', { task: props.task.id }), {
        preserveScroll: true,
        onSuccess: () => {
            query.value = '';
        },
    });
};

const removeLabel = (label) => {
    router.delete(route('tasks.labels.remove', { task: props.task.id, label: label.id }), {
        preserveScroll: true,
        onSuccess: () => {
            if (!props.task.labels.length) {
                isOpen.value = false;
            }
        },
    });
};
</script>
