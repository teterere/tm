<template>
    <div class="col-span-2 p-2 rounded-xs">
            <Disclosure v-slot="{ open }" :defaultOpen="true">
                <div class="flex items-start justify-between">
                    <DisclosureButton class="outline-0 w-full cursor-pointer">
                        <div class="flex items-start gap-x-2">
                            <button class="bg-gray-100 hover:bg-gray-200 rounded-sm p-1">
                                <ChevronDownIcon :class="{ 'rotate-180 transform': open }" class="w-3 h-3" />
                            </button>

                            <div class="w-full">
                                <h5 class="text-sm font-bold text-gray-400 text-start">Informācija</h5>
                            </div>
                        </div>
                    </DisclosureButton>
                </div>

                <DisclosurePanel>
                    <div class="space-y-1.5 md:space-y-4 py-4 p-2 border-b md:border-0">
                        <TaskInfo title="Statuss">
                            <TaskStatusDropdown @update="$emit('update', $event)" />
                        </TaskInfo>
                        <TaskInfo title="Prioritāte">
                            <TaskEditPriorityDropdown @update="$emit('update', $event)" />
                        </TaskInfo>
                        <TaskInfo title="Etiķetes">
                            <TaskEditLabelsSelect @update="$emit('update', $event)" />
                        </TaskInfo>
                        <TaskInfo title="Termiņš">
                            <TaskEditDueDateInput @update="$emit('update', $event)" />
                        </TaskInfo>
                        <TaskInfo title="Izpildītājs">
                            <TaskEditAssigneeSelect @update="$emit('update', $event)" />
                        </TaskInfo>
                        <TaskInfo title="Izpildes novērtējums">
                            <TaskEditTimeEstimateInput @update="$emit('update', $event)" />
                        </TaskInfo>
                    </div>
                </DisclosurePanel>
            </Disclosure>
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
import {Disclosure, DisclosureButton, DisclosurePanel} from "@headlessui/vue";
import {ChevronDownIcon} from "@heroicons/vue/24/outline";
</script>

