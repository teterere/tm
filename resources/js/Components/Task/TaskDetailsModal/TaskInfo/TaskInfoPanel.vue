<template>
    <div class="col-span-2 space-y-4">
        <TaskInfo title="Statuss">
            <TaskStatusDropdown :task="task" :statuses="statuses" />
        </TaskInfo>

        <TaskInfo title="Prioritāte">
            <TaskEditPriorityDropdown :task="task" :priorities="priorities" />
        </TaskInfo>
        <TaskInfo title="Birkas">
            <div v-if="task.labels.length" class="flex items-center space-x-1">
                <span v-for="label in task.labels"
                      class="inline-flex items-center rounded-md px-1.5 py-0.5 text-xs font-medium text-blue-700"
                      :style="{ backgroundColor: label.color }">
                    <span :style="{ color: label.color, filter: 'brightness(30%)'}">{{ label.title }}</span>
                </span>
            </div>
        </TaskInfo>
        <TaskInfo title="Termiņš">
            <span class="text-sm text-gray-600">{{ task.due_date }}</span>
        </TaskInfo>
        <TaskInfo title="Izpildītājs">
            <div class="flex items-center space-x-2">
                <img class="inline-block size-8 rounded-full"
                     src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                     alt=""/>
                <span class="text-sm text-gray-600">{{ task.assignee.name }}</span>
            </div>
        </TaskInfo>
        <TaskInfo title="Izpildes novērtējums">
            <span class="text-sm text-gray-600">{{ task.estimate }}</span>
        </TaskInfo>
    </div>
</template>

<script setup>
import TaskInfo from "@/Components/Task/TaskDetailsModal/TaskInfo/TaskInfoItem.vue";
import TaskStatusDropdown from "@/Components/Task/TaskDetailsModal/TaskEditInputItems/TaskStatusDropdown.vue";
import TaskEditPriorityDropdown
    from "@/Components/Task/TaskDetailsModal/TaskEditInputItems/TaskEditPriorityDropdown.vue";

defineProps({
    task: Object,
    statuses: Object,
    priorities: Object
})
</script>

