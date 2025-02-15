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
            <TaskEditAssigneeSelect :task="task" :employees="employees" />
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
import TaskEditAssigneeSelect from "@/Components/Task/TaskDetailsModal/TaskEditInputItems/TaskEditAssigneeSelect.vue";

defineProps({
    task: Object,
    statuses: Object,
    priorities: Object,
    labels: Object,
    employees: Object
})
</script>

