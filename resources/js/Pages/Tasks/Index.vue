<template>
    <AppLayout>
<!--        <SandboxModeInfoPanel />-->

        <div class="flex items-center justify-end px-4 sm:px-6 lg:px-8 pb-4">
            <PrimaryButton @click="showCreateTaskModal = true" >
                <PlusIcon class="h-4 w-4" />
                <span>Izveidot uzdevumu</span>
            </PrimaryButton>
            <CreateTaskModal :show="showCreateTaskModal" @close="showCreateTaskModal = false" />
        </div>
        <div class="flex gap-4 px-4 sm:px-6 lg:px-8 overflow-x-auto pb-4 2xl:grid 2xl:grid-cols-4 2xl:gap-4 2xl:overflow-x-visible">
            <div
                v-for="status in statuses"
                :key="status.id"
                class="col-span-1 bg-slate-100 rounded p-3 min-w-3xs 2xl:w-auto"
            >
                <div class="border-b-2 mb-4 pb-2 border-indigo-200 flex items-center justify-between">
                    <div class="flex items-center">
                        <h3 class="uppercase font-semibold text-sm text-gray-700 mr-2">{{ status.title }}</h3>
                        <span class="inline-flex items-center justify-center w-5 h-5 rounded-xs bg-indigo-100 text-xs font-bold text-indigo-500">
                            {{ status.tasks.length }}
                        </span>
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
import { PlusIcon } from '@heroicons/vue/24/outline';
import Task from "@/Components/Task/Task.vue";
import {ref, provide, onMounted, watch} from "vue";
import TaskDetailsModal from "@/Components/Task/TaskDetailsModal/TaskDetailsModal.vue";
import {VueDraggable} from "vue-draggable-plus";
import {router} from "@inertiajs/vue3";
import PrimaryButton from "@/Components/shared/Buttons/PrimaryButton.vue";
import CreateTaskModal from "@/Components/Task/TaskDetailsModal/CreateTaskModal.vue";
import SandboxModeInfoPanel from "@/Components/SandboxModeInfoPanel.vue";

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
const showCreateTaskModal = ref(false);

// Watch if any tasks have been updated and refresh selected task value
watch(() => props.statuses, (newStatuses) => {
    const updatedTask = newStatuses
        .flatMap(status => status.tasks)
        .find(task => task.id === selectedTask.value?.id);

    if (updatedTask) {
        selectedTask.value = updatedTask;
    }
}, { deep: true });

const openTaskDetailsModal = (task) => {
    if (!task) return;
    selectedTask.value = task;
    showTaskDetailsModal.value = true;

    router.push({
        url: route('tasks.show', {taskIdentifier: task.identifier}),
        preserveScroll: true,
        preserveState: true
    })
};

const closeTaskDetailsModal = () => {
    selectedTask.value = null;
    showTaskDetailsModal.value = false;

    router.push({
        url: route('tasks.index'),
        preserveScroll: true,
        preserveState: true
    })
};

const updateTaskStatus = (event) => {
    const newIndex = event.newIndex + 1;
    const movedTask = event.clonedData;
    const newStatusId = event.to.getAttribute("data-status-id");

    if (newIndex || (movedTask && newStatusId)) {
        router.patch(route('tasks.update-status', { task: movedTask.id, status: newStatusId }), {
            order: newIndex
        }, {
            preserveScroll: true
        });
    }
};

watch(
    () => props.task,
    (newTask) => {
        if (newTask) {
            openTaskDetailsModal(newTask);
        } else {
            closeTaskDetailsModal();
        }
    },
    { immediate: true }
);
</script>

<style scoped>
.ghost {
    opacity: 0 !important;
}
</style>
