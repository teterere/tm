<template>
    <div class="relative mb-3">
        <input
            v-model="form.description"
            @focus="showActionButtons = true"
            @blur="showActionButtons = false"
            type="text"
            class="block w-full rounded-xs bg-white pl-3 pr-16 py-1 text-base text-gray-900 outline-1 outline-gray-200 border-gray-200 focus:ring-0 focus:border-0 placeholder:text-gray-400 sm:text-sm/5"
            placeholder="Pievienot ierakstu" />
        <div v-show="showActionButtons" class="absolute right-1 bottom-0.75 flex gap-x-1">
            <button class="bg-gray-100 hover:bg-gray-200 p-1 rounded-sm cursor-pointer">
                <CheckIcon class="w-4 h-4" />
            </button>
            <button @mousedown.prevent="resetInput" class="bg-gray-100 hover:bg-gray-200 p-1 rounded-sm cursor-pointer">
                <XMarkIcon class="w-4 h-4" />
            </button>
        </div>
    </div>
</template>

<script setup>
import {CheckIcon, XMarkIcon} from "@heroicons/vue/24/outline/index.js";
import {ref} from "vue";
import {useForm} from "@inertiajs/vue3";

const showActionButtons = ref(false);

const form = useForm({
    description: ''
});

const resetInput = () => {
    form.description = '';
}
</script>
