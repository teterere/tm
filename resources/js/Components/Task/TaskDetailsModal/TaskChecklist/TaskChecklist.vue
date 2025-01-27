<template>
    <div class="py-4 border-b border-gray-200">
        <Disclosure v-slot="{ open }" :defaultOpen="true">
            <DisclosureButton class="outline-0 w-full">
                <div class="flex items-start gap-x-2 mb-2">
                    <button class="bg-gray-100 rounded-sm p-1">
                        <ChevronDownIcon :class="open && 'rotate-180 transform'" class="w-3 h-3" />
                    </button>

                    <div class="w-full">
                        <h5 class="text-sm font-bold text-gray-400 text-start mb-2">Uzdevumā izpildāmie darbi</h5>
                        <TaskProgressbar :task="task" />
                    </div>
                </div>
            </DisclosureButton>

            <DisclosurePanel class="text-gray-500">
                <div class="ml-6">
                    <NewChecklistItemInput :task="task" />

                    <draggable
                        v-model="task.checklist_items"
                        group="people"
                        item-key="id"
                        class="space-y-1 max-h-72 overflow-y-auto" >
                        <template #item="{element}">
                            <TaskListItem :item="element" />
                        </template>
                    </draggable>
                </div>
            </DisclosurePanel>
        </Disclosure>
    </div>
</template>

<script setup>
import {Disclosure, DisclosureButton, DisclosurePanel} from "@headlessui/vue";
import TaskListItem from "@/Components/Task/TaskDetailsModal/TaskChecklist/TaskChecklistItem.vue";
import {ChevronDownIcon} from "@heroicons/vue/24/outline/index.js";
import TaskProgressbar from "@/Components/Task/TaskDetailsModal/TaskChecklist/TaskProgressbar.vue";
import NewChecklistItemInput from "@/Components/Task/TaskDetailsModal/TaskChecklist/NewChecklistItemInput.vue";
import draggable from 'vuedraggable'

defineProps({
    task: Object
})
</script>
