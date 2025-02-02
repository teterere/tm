<template>
    <div class="py-4 border-b border-gray-200">
        <Disclosure v-slot="{ open }" :defaultOpen="true">
            <div class="flex items-start justify-between">
                <DisclosureButton class="outline-0 w-full cursor-pointer">
                    <div class="flex items-start gap-x-2 mb-2">
                        <button class="bg-gray-100 rounded-sm p-1">
                            <ChevronDownIcon :class="{ 'rotate-180 transform': open }" class="w-3 h-3" />
                        </button>

                        <div class="w-full">
                            <h5 class="text-sm font-bold text-gray-400 text-start mb-2">Uzdevumā izpildāmie darbi</h5>
                            <TaskProgressbar :task="task" />
                        </div>
                    </div>
                </DisclosureButton>

                <TaskChecklistOptionsDropdown :task="task" />
            </div>

            <DisclosurePanel class="text-gray-500">
                <div class="ml-6">
                    <NewChecklistItemInput :task="task" />

                    <draggable
                        :disabled="draggingDisabled"
                        v-model="form.items"
                        group="checklist-items"
                        item-key="id"
                        class="space-y-1 max-h-72 overflow-y-auto"
                        @end="updateOrder">
                        <template #item="{element}">
                            <TaskListItem :item="element" :key="element.id" @edit-status-changed="updateDraggingStatus" />
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
import {useForm} from "@inertiajs/vue3";
import {ref, watch} from "vue";
import TaskChecklistOptionsDropdown from "@/Components/Task/TaskDetailsModal/TaskChecklist/TaskChecklistOptionsDropdown.vue";

const props = defineProps({
    task: Object
});

const draggingDisabled = ref(false);

const form = useForm({
    items: props.task.checklist_items
});

const updateOrder = (event) => {
    if (event.oldIndex !== event.newIndex) {
        form.patch(route('tasks.checklist-items.update-order', { task: props.task.id }), {
            preserveScroll: true
        });
    }
};

const updateDraggingStatus = (newValue) => {
    draggingDisabled.value = newValue;
};

watch(() => props.task.checklist_items, (newItems) => {
    form.items = [...newItems];
});
</script>
