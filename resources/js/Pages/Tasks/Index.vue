<template>
    <AppLayout>
        <div class="grid grid-cols-4 px-4 sm:px-6 lg:px-8 space-x-4">
            <div v-for="status in statuses.data" class="col-span-1 bg-slate-100 rounded p-3">
                <div class="border-b-2 mb-4 pb-2 border-indigo-200 flex items-center justify-between">
                    <div class="flex items-center">
                        <h3 class="uppercase font-semibold text-sm text-gray-700 mr-2">{{ status.title }}</h3>
                        <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-indigo-100 text-xs font-bold text-indigo-500">3</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <PlusIcon class="h-4 w-4 text-gray-400" />
                        <EllipsisHorizontalIcon class="h-4 w-4 text-gray-400" />
                    </div>
                </div>

                <Task
                    v-for="task in status.tasks"
                    :key="task.id"
                    :task="task"
                    @click="openTaskDetailsModal(task.id)"
                />
            </div>
        </div>
        <TaskDetailsModal
            v-if="showTaskDetailsModal"
            :show="showTaskDetailsModal"
            :task-id="selectedTaskId"
            @close="closeTaskDetailsModal"
        />
    </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";

import {
    PlusIcon,
    EllipsisHorizontalIcon,
    ClockIcon,
    EnvelopeIcon,
    CheckCircleIcon
} from '@heroicons/vue/24/outline';
import Task from "@/Components/Task/Task.vue";
import {computed, ref} from "vue";
import TaskDetailsModal from "@/Components/Task/TaskDetailsModal/TaskDetailsModal.vue";

const props = defineProps({
    statuses: {
        type: Object
    }
});

const selectedTaskId = ref(null);
const showTaskDetailsModal = ref(false);

const openTaskDetailsModal = (taskId) => {
    selectedTaskId.value = taskId;
    showTaskDetailsModal.value = true;
};

const closeTaskDetailsModal = () => {
    selectedTaskId.value = null;
    showTaskDetailsModal.value = false;
};
</script>
