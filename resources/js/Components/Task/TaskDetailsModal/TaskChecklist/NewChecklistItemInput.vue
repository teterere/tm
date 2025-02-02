<template>
    <div class="relative mb-3">
        <input
            v-model="form.description"
            @focus="showActionButtons = true"
            @blur="showActionButtons = false"
            @keyup.enter="submitForm"
            @input="form.clearErrors('description')"
            type="text"
            class="block w-full rounded-xs bg-white pl-3 pr-16 py-1 text-base text-gray-900 outline-1 border-gray-200 focus:ring-0 focus:border-0 placeholder:text-gray-400 sm:text-sm/5"
            :class="form.errors.description ? 'outline-red-400' : 'outline-gray-200'"
            placeholder="Pievienot ierakstu" />
        <p v-if="form.errors.description" class="text-red-500 text-xs mt-3 ml-1">
            {{ form.errors.description }}
        </p>
        <div v-show="showActionButtons" class="absolute right-1 top-0.5 flex gap-x-1">
            <button @mousedown.prevent="submitForm" class="bg-gray-100 hover:bg-gray-200 p-1 rounded-sm cursor-pointer" aria-label="Apstiprināt">
                <CheckIcon class="w-4 h-4" />
            </button>
            <button @mousedown.prevent="resetInput" class="bg-gray-100 hover:bg-gray-200 p-1 rounded-sm cursor-pointer" aria-label="Atcelt">
                <XMarkIcon class="w-4 h-4" />
            </button>
        </div>
    </div>
</template>

<script setup>
import {CheckIcon, XMarkIcon} from "@heroicons/vue/24/outline/index.js";
import {ref} from "vue";
import {useForm} from "@inertiajs/vue3";

const props = defineProps({
   task: Object
});

const showActionButtons = ref(false);

const form = useForm({
    description: ''
});

const resetInput = () => {
    form.description = '';
    form.clearErrors('description');
}

const submitForm = () => {
    form.post(route('tasks.checklist-items.store', { task: props.task.id }), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
        },
    });
};
</script>
