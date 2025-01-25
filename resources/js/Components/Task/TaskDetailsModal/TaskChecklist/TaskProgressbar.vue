<template>
    <div class="flex justify-between items-center gap-x-2">
        <div class="w-full bg-gray-200 rounded-lg h-1.5">
            <div class="bg-indigo-500 h-1.5 rounded-lg" :style="{ width: progress + '%' }"></div>
        </div>
        <div class="flex text-xs font-medium text-gray-400">
            <span>{{ task.completed_checklist_items_count }}</span>
            <span>/</span>
            <span>{{ task.checklist_items.length}}</span>
        </div>
    </div>
</template>

<script setup>
import {computed} from "vue";

const props = defineProps({
    task: Object
})

const progress = computed(() => {
    if (props.task.checklist_items.length === 0) {
        return 0;
    }

    return (props.task.completed_checklist_items_count / props.task.checklist_items.length) * 100;
})
</script>
