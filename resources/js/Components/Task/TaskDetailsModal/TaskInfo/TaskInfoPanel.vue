<template>
    <div class="col-span-2 space-y-4">
        <TaskInfo title="Statuss">
            <TaskStatusDropdown />
        </TaskInfo>

        <TaskInfo title="Prioritāte">
            <TaskEditPriorityDropdown />
        </TaskInfo>
        <TaskInfo title="Birkas">
            <TaskEditLabelsSelect />
        </TaskInfo>
        <TaskInfo title="Termiņš">
            <TaskEditDueDateInput />
        </TaskInfo>
        <TaskInfo title="Izpildītājs">
            <TaskEditAssigneeSelect />
        </TaskInfo>
        <TaskInfo title="Izpildes novērtējums">
            <TaskEditTimeEstimateInput />
        </TaskInfo>
    </div>
</template>

<script setup>
import TaskInfo from "@/Components/Task/TaskDetailsModal/TaskInfo/TaskInfoItem.vue";
import TaskStatusDropdown from "@/Components/Task/TaskDetailsModal/TaskEditInputItems/TaskStatusDropdown.vue";
import TaskEditPriorityDropdown from "@/Components/Task/TaskDetailsModal/TaskEditInputItems/TaskEditPriorityDropdown.vue";
import TaskEditLabelsSelect from "@/Components/Task/TaskDetailsModal/TaskEditInputItems/TaskEditLabelsSelect.vue";
import TaskEditDueDateInput from "@/Components/Task/TaskDetailsModal/TaskEditInputItems/TaskEditDueDateInput.vue";
import TaskEditTimeEstimateInput from "@/Components/Task/TaskDetailsModal/TaskEditInputItems/TaskEditTimeEstimateInput.vue";
import TaskEditAssigneeSelect from "@/Components/Task/TaskDetailsModal/TaskEditInputItems/TaskEditAssigneeSelect.vue";
import {inject} from "vue";
</script>

