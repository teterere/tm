<template>
    <div class="col-span-2 p-2 rounded-xs">
            <Disclosure v-slot="{ open }" :defaultOpen="true">
                <div class="flex items-center justify-between">
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
                    <Menu as="div" class="relative inline-block pl-6">
                        <MenuButton class="bg-gray-100 hover:bg-gray-200 rounded-sm p-1 cursor-pointer">
                            <EllipsisHorizontalIcon class="w-3 h-3" />
                        </MenuButton>

                        <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                            <MenuItems class="absolute right-0 z-10 mt-2 w-52 origin-top-right rounded-md bg-white ring-1 shadow-lg ring-black/5 focus:outline-hidden py-1">
                                <MenuItem @click="showConfirmDeletionDialog = true" v-slot="{ active }">
                                    <button :class="[active ? 'bg-gray-100 text-gray-900 outline-hidden' : 'text-gray-700', 'flex w-full items-center cursor-pointer px-4 py-2 text-sm']">
                                        <TrashIcon class="w-4 h-4 mr-2" />
                                        <span>Dzēst uzdevumu</span>
                                    </button>
                                </MenuItem>
                            </MenuItems>
                        </transition>
                    </Menu>

                    <ConfirmDeletionDialog :show="showConfirmDeletionDialog" @confirm="deleteTask" @close="showConfirmDeletionDialog = false">
                        <template #title>Dzēst uzdevumu?</template>
                        <template #description>Uzdevums un ar to saistītie dati tiks neatgriezeniski dzēsti. Šo darbību nav iespējams atsaukt.</template>
                    </ConfirmDeletionDialog>
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
import {Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems} from "@headlessui/vue";
import {ChevronDownIcon} from "@heroicons/vue/24/outline";
import {inject, ref} from "vue";
import {EllipsisHorizontalIcon, TrashIcon} from "@heroicons/vue/24/outline/index.js";
import ConfirmDeletionDialog from "@/Components/ConfirmDeletionDialog.vue";
import {router} from "@inertiajs/vue3";

const task = inject('task');
const showConfirmDeletionDialog = ref(false);

const deleteTask = () => {
    router.delete(route('tasks.delete', {task: task.id}), {
        onSuccess: () => {
            router.visit(route('tasks.index'));
        }
    });
}
</script>

