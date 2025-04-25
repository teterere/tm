<template>
    <Combobox v-if="editStatus" as="div" v-model="selectedAssignee" @update:modelValue="query = ''" class="w-full">
        <div class="relative mt-2">
            <ComboboxInput
                class="block w-full rounded-md bg-white py-1.5 pr-12 pl-3 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                @change="query = $event.target.value"
                @blur="handleBlur"
                :display-value="(person) => person?.name" />
            <ComboboxButton class="absolute inset-y-0 right-0 flex items-center rounded-r-md px-2 focus:outline-hidden">
                <ChevronUpDownIcon class="size-5 text-gray-400" aria-hidden="true" />
            </ComboboxButton>

            <ComboboxOptions v-if="filteredPeople.length > 0" hold open class="absolute z-10 mt-1 max-h-56 w-full overflow-auto rounded-md bg-white py-1 text-base ring-1 shadow-lg ring-black/5 focus:outline-hidden sm:text-sm">
                <ComboboxOption v-for="employee in filteredPeople" :key="employee.id" :value="employee" as="template" v-slot="{ active, selected }">
                    <li :class="['relative cursor-default py-2 pr-9 pl-3 select-none', active ? 'bg-indigo-600 text-white outline-hidden' : 'text-gray-900']">
                        <div class="flex items-center">
                            <img :src="employee.avatar_url" alt="Lietotāja attēls" class="size-7 shrink-0 rounded-full" />
                            <span :class="['ml-3 truncate', selected && 'font-semibold']">
                                {{ employee.name }}
                              </span>
                        </div>
                        <span v-if="selected" :class="['absolute inset-y-0 right-0 flex items-center pr-4', active ? 'text-white' : 'text-indigo-600']">
                          <CheckIcon class="size-5" aria-hidden="true" />
                        </span>
                    </li>
                </ComboboxOption>
            </ComboboxOptions>
        </div>
    </Combobox>

    <div v-else @click="enableEditStatus" class="flex items-center w-full hover:bg-gray-100 rounded-xs space-x-2 p-1">
        <img class="inline-block size-7 rounded-full" :src="task.assignee.avatar_url" alt="Lietotāja attēls"/>
        <span class="text-sm text-gray-600">{{ task.assignee.name }}</span>
    </div>
</template>

<script setup>
import {computed, inject, ref, watch} from 'vue'
import {Combobox, ComboboxButton, ComboboxInput, ComboboxOption, ComboboxOptions} from '@headlessui/vue'
import { ChevronUpDownIcon } from '@heroicons/vue/16/solid'
import { CheckIcon } from '@heroicons/vue/20/solid'
import {useForm} from "@inertiajs/vue3";

const employees = inject('employees');
const task = inject('task');

const query = ref('')
const filteredPeople = computed(() =>
    query.value === ''
        ? employees
        : employees.filter((person) => {
            return person.name.toLowerCase().includes(query.value.toLowerCase())
        }),
);

const handleBlur = () => {
    editStatus.value = false;
    query.value = '';
};

const enableEditStatus = () => {
    editStatus.value = true;
};

const editStatus = ref(false);

const selectedAssignee = ref(task.assignee);
const form = useForm({
    assignee_id: task.assignee_id
});

watch(selectedAssignee, () => {
    if (selectedAssignee.id === task.assignee_id) {
        return;
    }

    submit();
});

const submit = () => {
    form.transform(data => ({
        ...data,
        assignee_id: selectedAssignee.value.id,
    })).patch(route('tasks.update', task.id), {
        preserveScroll: true,
        onSuccess: () => {
            editStatus.value = false;
        }
    });
};
</script>
