<template>
    <div v-if="editStatus" class="min-w-full">
        <multiselect
            id="single-select-object"
            ref="inputRef"
            v-model="selectedAssignee"
            track-by="name"
            label="name"
            :options="employees"
            :allow-empty="false"
            :show-labels="false"
            aria-label="pick a value"
            placeholder="Izvēlies izpildītāju"
            @close="handleBlur"
        >
            <template v-slot:singleLabel="{ option }">
                <span>{{ option.name }}</span>
            </template>
            <template v-slot:option="{ option }">
                <div class="flex items-center space-x-2">
                    <img v-if="option.avatar_url" :src="option.avatar_url" class="size-7 rounded-full" />
                    <span>{{ option.name }}</span>
                </div>
            </template>
        </multiselect>
    </div>

    <div v-else @click="enableEditStatus" class="flex items-center w-full hover:bg-gray-100 rounded-xs space-x-2 p-1">
        <div v-if="selectedAssignee" class="flex items-center space-x-2">
            <img class="inline-block size-7 rounded-full" :src="selectedAssignee.avatar_url" alt="Lietotāja attēls"/>
            <span class="text-sm text-gray-600">{{ selectedAssignee.name }}</span>
        </div>
        <div v-else class="flex items-center space-x-2">
            <div class="bg-gray-200 rounded-full p-1">
                <UserIcon class="size-5 text-gray-400" />
            </div>
            <span class="text-sm text-gray-600">Bez izpildītāja</span>
        </div>
    </div>
</template>

<script setup>
import {ref, inject, watch, nextTick} from 'vue'
import Multiselect from 'vue-multiselect'
import 'vue-multiselect/dist/vue-multiselect.min.css'
import {UserIcon} from '@heroicons/vue/20/solid'
import {useForm} from "@inertiajs/vue3"

const emit = defineEmits(['update']);

const employees = inject('employees');
const task = inject('task', null);

const editStatus = ref(false);
const inputRef = ref(null);

const selectedAssignee = ref(task?.assignee);
const form = useForm({
    assignee_id: task?.assignee_id || null
});

watch(editStatus, async (val) => {
    if (val) {
        await nextTick();
        inputRef.value?.activate();
    }
});

const enableEditStatus = () => {
    editStatus.value = true;
}

const handleBlur = () => {
    editStatus.value = false;
}

watch(selectedAssignee, () => {
    if (selectedAssignee.value?.id === task?.assignee_id) {
        return;
    }

    submit();
});

const submit = () => {
    if (task && selectedAssignee.value) {
        form.transform(data => ({
            ...data,
            assignee_id: selectedAssignee.value.id,
        })).patch(route('tasks.update', task.id), {
            preserveScroll: true,
            onSuccess: () => {
                editStatus.value = false;
            }
        });

        return;
    }

    emit('update', {field: 'assignee_id', value: selectedAssignee.value.id});
}
</script>
