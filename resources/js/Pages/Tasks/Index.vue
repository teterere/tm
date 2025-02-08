<template>
    <AppLayout>
<!--        <Test />-->

<!--        <div ref="parent1">-->
<!--            <div-->
<!--                v-for="(task, index) in taskList2"-->
<!--                :index="index"-->
<!--                class="bg-white p-3 shadow-sm mb-2"-->
<!--            >{{ task.title }}-->
<!--            </div>-->
<!--        </div>-->


        <div class="grid grid-cols-4 px-4 sm:px-6 lg:px-8 space-x-4">
            <div v-for="status in statuses" class="col-span-1 bg-slate-100 rounded p-3">
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

                <TaskColumn :tasks="status.tasks" />


<!--                <div v-for="status in statuses" :key="status.id">-->
<!--                    &lt;!&ndash; Pielāgotais parent tiek piešķirts kā ref &ndash;&gt;-->
<!--                    <div :ref="(el) => getParent(status.id) && (getParent(status.id).value = el)">-->
<!--                        <div-->
<!--                            v-for="(task, index) in getTasks(status.id)"-->
<!--                            :key="task.id"-->
<!--                            class="bg-white p-3 shadow-sm mb-2"-->
<!--                        >-->
<!--                            {{ task.title }}-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->


<!--                <draggable :list="status.tasks" group="tasks" itemKey="id">-->
<!--                    <template #item="{ element }">-->
<!--                        <Task-->
<!--                            :key="element.id"-->
<!--                            :task="element"-->
<!--                            @click="openTaskDetailsModal(task)"-->
<!--                        />-->
<!--                    </template>-->
<!--                </draggable>-->
            </div>
        </div>

<!--        <TaskDetailsModal-->
<!--            v-if="showTaskDetailsModal"-->
<!--            :show="showTaskDetailsModal"-->
<!--            :task="selectedTask"-->
<!--            @close="closeTaskDetailsModal"-->
<!--        />-->
    </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";

import {PlusIcon, EllipsisHorizontalIcon} from '@heroicons/vue/24/outline';
import Task from "@/Components/Task/Task.vue";
// import TaskDetailsModal from "@/Components/Task/TaskDetailsModal/TaskDetailsModal.vue";
import Test from "@/Components/Test.vue";
import {nextTick, onMounted, ref, watch} from "vue";
import {useDragAndDrop} from "vue-fluid-dnd";
import TaskColumn from "@/Components/Status/TaskColumn.vue";

const props = defineProps({
    statuses: {
        type: Object
    },
    task: {
        type: Object
    }
});


// const taskList1 = ref(props.statuses[0].tasks);
// const taskList2 = ref(props.statuses[1].tasks);
// const taskList3 = ref(props.statuses[2].tasks);
// const taskList4 = ref(props.statuses[3].tasks);




// onMounted(async () => {
//     await nextTick();
//     taskList2.value = props.statuses[1].tasks;
//
//     const {parent: parent1} = useDragAndDrop(taskList2, {
//         droppableGroup: "group",
//         draggingClass: "dragging-pokemon",
//     });
// });



// const { parent: parent2 } = useDragAndDrop(taskList1, {
//     droppableGroup: "group",
//     draggingClass: "dragging-pokemon",
//
// });
//
// const { parent: parent3 } = useDragAndDrop(taskList3, {
//     droppableGroup: "group",
//     draggingClass: "dragging-pokemon",
//
// });
//
// const { parent: parent4 } = useDragAndDrop(taskList4, {
//     droppableGroup: "group",
//     draggingClass: "dragging-pokemon",
//
// });

const selectedTask = ref(props.task);

const showTaskDetailsModal = ref(false);

const openTaskDetailsModal = (task) => {
    if (!task) {
        return;
    }

    selectedTask.value = task;
    showTaskDetailsModal.value = true;

    window.history.replaceState({}, '', `/uzdevumi/${task.identifier}`);
};

const closeTaskDetailsModal = () => {
    selectedTask.value = null;
    showTaskDetailsModal.value = false;

    window.history.replaceState({}, '', '/uzdevumi');
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
