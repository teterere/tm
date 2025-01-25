<template>
    <TransitionRoot as="template" :show="show">
        <Dialog as="div" class="relative z-50" @close="$emit('close')">
            <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0 bg-[rgba(107,114,128,0.6)] transition-opacity" />
            </TransitionChild>

            <div class="fixed inset-0 z-10 overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                        <DialogPanel class="relative transform sm:max-w-4xl rounded bg-white px-4 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:px-6 sm:pt-5 sm:pb-6">
                            <div class="flex justify-between items-center border-b border-gray-200 pb-2 mb-4">
                                <h3 class="text-base font-semibold text-gray-900">uzdevums</h3>
                                <div @click="show = false; $emit('close')" class="cursor-pointer p-2">
                                    <XMarkIcon class="w-6 h-6"></XMarkIcon>
                                </div>
                            </div>
                            <div class="grid grid-cols-6 space-x-8">
                                <div class="col-span-4">
                                    <div class="border-b border-gray-200 pb-4">
                                        <h2 class="text-xl font-medium mb-4">
                                            {{ task.title }}
                                        </h2>

                                        <p class="text-sm text-gray-700">
                                            {{ task.description }}
                                        </p>
                                    </div>

                                    <TaskChecklist :task="task" />
                                    <TaskComments />
                                </div>
                                <TaskInfoPanel :task="task" />
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<script setup>
import TaskChecklist from "@/Components/Task/TaskDetailsModal/TaskChecklist/TaskChecklist.vue";
import {Dialog, DialogPanel, TransitionChild, TransitionRoot} from "@headlessui/vue";
import {XMarkIcon} from "@heroicons/vue/24/outline/index.js";
import TaskInfoPanel from "@/Components/Task/TaskDetailsModal/TaskInfo/TaskInfoPanel.vue";
import TaskComments from "@/Components/Task/TaskDetailsModal/TaskComments/TaskComments.vue";

const emit = defineEmits(['close']);

defineProps({
    show: {
        type: Boolean,
        default: false
    },
    task: {
        type: Object
    }
});

const close = () => {
    emit('close');
}
</script>
