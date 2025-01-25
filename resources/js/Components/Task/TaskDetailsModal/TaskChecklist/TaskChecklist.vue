<template>
    <div class="py-4 border-b border-gray-200">
        <Disclosure v-slot="{ open }" :defaultOpen="true">
            <DisclosureButton class="outline-0">
                <div class="flex items-center gap-x-2 mb-2">
                    <button class="bg-gray-100 rounded-sm p-1">
                        <ChevronDownIcon :class="open && 'rotate-180 transform'" class="w-3 h-3" />
                    </button>
                    <h5 class="text-sm font-bold text-gray-400">Uzdevumā izpildāmie darbi</h5>
                </div>
            </DisclosureButton>
            <DisclosurePanel class="text-gray-500">
                <div class="space-y-1 ml-6">
                    <TaskListItem />
                    <TaskListItem />
                    <TaskListItem />
                </div>
            </DisclosurePanel>
        </Disclosure>
    </div>
</template>

<script setup>
import {Disclosure, DisclosureButton, DisclosurePanel} from "@headlessui/vue";
import TaskListItem from "@/Components/Task/TaskDetailsModal/TaskChecklist/TaskChecklistItem.vue";
import {ChevronDownIcon} from "@heroicons/vue/24/outline/index.js";

defineProps({
    task: Object
})
</script>
