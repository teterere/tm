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
                                <h5 class="font-semibold text-gray-400">Jauns uzdevums</h5>
                                <div @click="show = false; $emit('close')" class="cursor-pointer p-2">
                                    <XMarkIcon class="w-6 h-6"></XMarkIcon>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-6 md:gap-x-8">
                                <TaskInfoPanel class="order-1 md:order-2 md:col-span-2" />
                                <div class="order-2 md:order-1 md:col-span-4">
                                    <div class="mb-4">
                                        <label for="title" class="text-sm font-semibold text-gray-600">Virsraksts <span class="text-red-800">*</span></label>
                                        <input v-model="form.title" type="text" id="title" class="font-medium block w-full rounded-xs bg-white p-2 text-xl text-gray-900 outline-1 outline-offset-0 outline-gray-200 border-gray-200 focus:outline-1 focus:-outline-offset-0 focus:outline-gray-200 focus:ring-gray-200 focus:border-gray-200" />
                                    </div>
                                    <label class="text-sm font-semibold text-gray-600">Apraksts</label>
                                    <Wysiwyg :showActionButtons="false" />
                                    <div class="flex items-center space-x-4 justify-end">
                                        <OutlineButton>Atcelt</OutlineButton>
                                        <PrimaryButton>Izveidot</PrimaryButton>
                                    </div>
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
import {useForm} from "@inertiajs/vue3";
import Wysiwyg from "@/Components/shared/wysiwyg/Wysiwyg.vue";
import PrimaryButton from "@/Components/shared/Buttons/PrimaryButton.vue";
import OutlineButton from "@/Components/shared/Buttons/OutlineButton.vue";

const props = defineProps({
    show: {
        type: Boolean,
        default: false
    },
});

const emit = defineEmits(['close']);

const form = useForm({
    title: '',
    description: '',
    status_id: 1,
    assignee_id: null,
    priority_id: 1,
    due_date: null,
    estimate: null
});

const close = () => {
    emit('close');
}

const updateFormProperty = () => {

}
</script>
