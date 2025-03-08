<template>
    <AppLayout>
        <div class="grid grid-cols-4 px-4 sm:px-6 lg:px-8 space-x-4">
            <div
                v-for="status in statuses"
                :key="status.id"
                class="col-span-1 bg-slate-100 rounded p-3"
            >
                <div class="border-b-2 mb-4 pb-2 border-indigo-200 flex items-center justify-between">
                    <div class="flex items-center">
                        <h3 class="uppercase font-semibold text-sm text-gray-700 mr-2">{{ status.title }}</h3>
                        <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-indigo-100 text-xs font-bold text-indigo-500">
                            {{ status.tasks.length }}
                        </span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <PlusIcon class="h-4 w-4 text-gray-400" />
                        <EllipsisHorizontalIcon class="h-4 w-4 text-gray-400" />
                    </div>
                </div>

                <VueDraggable
                    v-model="status.tasks"
                    @sort="updateTaskStatus"
                    :data-status-id="status.id"
                    :key="status.id"
                    ghostClass="ghost"
                    animation="150"
                    group="statuses"
                    class="min-h-full"
                >
                    <Task
                        v-for="task in status.tasks"
                        :key="task.id"
                        :task="task"
                        @click="openTaskDetailsModal(task)"
                    />
                </VueDraggable>
            </div>
        </div>

        <TaskDetailsModal
            v-if="showTaskDetailsModal"
            :show="showTaskDetailsModal"
            :task="selectedTask"
            @close="closeTaskDetailsModal"
        />
    </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { PlusIcon, EllipsisHorizontalIcon } from '@heroicons/vue/24/outline';
import Task from "@/Components/Task/Task.vue";
import {ref, provide, onMounted, watch} from "vue";
import TaskDetailsModal from "@/Components/Task/TaskDetailsModal/TaskDetailsModal.vue";
import {VueDraggable} from "vue-draggable-plus";
import {router} from "@inertiajs/vue3";

const props = defineProps({
    statuses: Array,
    task: Object,
    priorities: Object,
    labels: Object,
    employees: Object
});

provide('statuses', props.statuses);
provide('priorities', props.priorities);
provide('labels', props.labels);
provide('employees', props.employees);

const selectedTask = ref(props.task);
const showTaskDetailsModal = ref(false);

const openTaskDetailsModal = (task) => {
    if (!task) return;
    selectedTask.value = task;
    showTaskDetailsModal.value = true;
    window.history.replaceState({}, '', `/uzdevumi/${task.identifier}`);
};

const closeTaskDetailsModal = () => {
    selectedTask.value = null;
    showTaskDetailsModal.value = false;
    window.history.replaceState({}, '', '/uzdevumi');
};

const updateTaskStatus = (event) => {
    const newIndex = event.newIndex + 1;
    const movedTask = event.clonedData; // Nokopētais uzdevums (satur pilnu task objektu)
    const newStatusId = event.to.getAttribute("data-status-id"); // Statusa ID, kurā uzdevums tika ielikts

    if (newIndex || (movedTask && newStatusId)) {
        router.patch(route('tasks.update-status', { task: movedTask.id, status: newStatusId }), {
            order: newIndex
        }, {
            preserveScroll: true
        });
    }
};

onMounted(() => {
    if (props.task) {
        openTaskDetailsModal(props.task);
    }
});

// Watch if any tasks have been updated and refresh selected task value
watch(() => props.statuses, (newStatuses) => {
    const updatedTask = newStatuses
        .flatMap(status => status.tasks)
        .find(task => task.id === selectedTask.value?.id);

    if (updatedTask) {
        selectedTask.value = updatedTask;
    }
}, { deep: true });
</script>

<style scoped>
.ghost {
    opacity: 0 !important;
}
</style>
