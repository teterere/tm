<template>
    <div class="flex items-center">
        <span class="inline-flex items-center rounded-md px-1.5 py-0.5 text-xs font-medium bg-gray-200 text-gray-700">
            {{ label.title }}
        </span>
        <span v-if="removeButton" class="inline-flex items-center rounded-r-md -ml-1 px-1.5 py-0.5 bg-gray-200 hover:bg-gray-300 text-gray-700 hover:text-rose-700 text-xs font-medium min-h-[20px]">
            <XMarkIcon class="w-3 h-3" />
        </span>
    </div>
</template>

<script setup>
import { XMarkIcon } from "@heroicons/vue/24/outline";

defineProps({
    label: Object,
    removeButton: {
        type: Boolean,
        default: false
    }
});
</script>
