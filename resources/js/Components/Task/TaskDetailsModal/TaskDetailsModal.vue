<template>
    <TransitionRoot as="template" :show="show">
        <Dialog as="div" class="relative z-50" @close="$emit('close')">
            <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0 bg-[rgba(107,114,128,0.6)] transition-opacity" />
            </TransitionChild>

            <div class="fixed inset-0 z-10 overflow-y-auto">
                <div class="flex min-h-full items-end md:justify-center p-0 md:p-4 text-center sm:items-center">
                    <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                        <DialogPanel class="relative transform max-w-screen sm:max-w-5xl md:rounded bg-white px-2 md:px-4 text-left shadow-xl transition-all sm:my-8 w-full sm:px-6 sm:pt-3 sm:pb-6">
                            <div class="flex justify-between items-center border-b border-gray-200 py-2 md:pt-0 md:pb-2 mb-2 md:mb-4">
                                <div @click="copyToClipboard(task.identifier)" class="flex items-center gap-x-1 text-xs font-medium text-gray-900 bg-gray-100 hover:bg-gray-200 p-2 rounded-sm cursor-pointer">
                                    <LinkIcon class="h-4 w-4" />
                                    <h5>{{ task.identifier }}</h5>
                                </div>
                                <div @click="show = false; $emit('close')" class="cursor-pointer p-2">
                                    <XMarkIcon class="w-6 h-6"></XMarkIcon>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-6 md:space-x-8">
                                <TaskInfoPanel class="order-1 md:order-2 md:col-span-2" />
                                <div class="order-2 md:order-1 md:col-span-4">
                                    <div class="border-b border-gray-200 pb-4">
                                        <TaskEditTitleInput />
                                        <TaskEditDescriptionInput />
                                    </div>

                                    <TaskChecklist :task="task" />
                                    <TaskComments :task="task" />
                                </div>
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
import {XMarkIcon, LinkIcon} from "@heroicons/vue/24/outline";
import TaskInfoPanel from "@/Components/Task/TaskDetailsModal/TaskInfo/TaskInfoPanel.vue";
import TaskComments from "@/Components/Task/TaskDetailsModal/TaskComments/TaskComments.vue";
import TaskEditTitleInput from "@/Components/Task/TaskDetailsModal/TaskEditInputItems/TaskEditTitleInput.vue";
import TaskEditDescriptionInput from "@/Components/Task/TaskDetailsModal/TaskEditInputItems/TaskEditDescriptionInput.vue";
import {provide} from "vue";

const props = defineProps({
    show: {
        type: Boolean,
        default: false
    },
    task: Object
});

provide('task', props.task);

const emit = defineEmits(['close']);

const copyToClipboard = (text) => {
    if (navigator.clipboard) {
        navigator.clipboard.writeText(text).then(() => {
            console.log('Nokopēts:', text);
        }).catch(err => {
            console.error('Kļūda kopējot:', err);
        });
    } else {
        console.error('Clipboard API nav pieejams šajā vidē.');
    }
};

const close = () => {
    emit('close');
};
</script>
