<template>
    <div :class="['inline-flex items-center gap-x-1 rounded-md px-1.5 py-0.5 text-xs font-medium']">
        <component :is="taskIcons[priority.key]" :class="['h-4 w-4', iconColors[priority.key]]" />
        <span class="text-gray-600">{{ priority.title }}</span>
    </div>
</template>

<script setup>
import {ChevronDoubleUpIcon, ChevronDoubleDownIcon, Bars3Icon} from "@heroicons/vue/24/outline";

defineProps({
    priority: Object
});

const iconColors = {
    low: 'text-blue-500',
    medium: 'text-amber-500',
    high: 'text-red-500'
};

const taskIcons = {
    low: ChevronDoubleDownIcon,
    medium: Bars3Icon,
    high: ChevronDoubleUpIcon
};
</script>
