<template>
    <div class="col-span-2 space-y-4">
        <TaskInfo title="Statuss">
            <TaskStatusDropdown :task="task" :statuses="statuses" />
        </TaskInfo>

        <TaskInfo title="Prioritāte">
            <TaskEditPriorityDropdown :task="task" :priorities="priorities" />
        </TaskInfo>
        <TaskInfo title="Birkas">
            <TaskEditLabelsSelect :labels="labels" :task="task" />
        </TaskInfo>
        <TaskInfo title="Termiņš">
            <TaskEditDueDateInput :task="task" />
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
            <TaskEditTimeEstimateInput :task="task" />
        </TaskInfo>
    </div>
</template>

<script setup>
import TaskInfo from "@/Components/Task/TaskDetailsModal/TaskInfo/TaskInfoItem.vue";
import TaskStatusDropdown from "@/Components/Task/TaskDetailsModal/TaskEditInputItems/TaskStatusDropdown.vue";
import TaskEditPriorityDropdown
    from "@/Components/Task/TaskDetailsModal/TaskEditInputItems/TaskEditPriorityDropdown.vue";
import TaskEditLabelsSelect from "@/Components/Task/TaskDetailsModal/TaskEditInputItems/TaskEditLabelsSelect.vue";
import TaskEditDueDateInput from "@/Components/Task/TaskDetailsModal/TaskEditInputItems/TaskEditDueDateInput.vue";
import TaskEditTimeEstimateInput
    from "@/Components/Task/TaskDetailsModal/TaskEditInputItems/TaskEditTimeEstimateInput.vue";

defineProps({
    task: Object,
    statuses: Object,
    priorities: Object,
    labels: Object
})
</script>

