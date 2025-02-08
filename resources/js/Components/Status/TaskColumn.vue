<template>
    <div ref="parent">
        <div
            v-for="(task, index) in tasks"
            :index="index"
            class="bg-white p-3 shadow-sm mb-2"
        >{{ task.title }}
        </div>
    </div>
</template>

<script setup>
import {useDragAndDrop} from "vue-fluid-dnd";
import {ref} from "vue";

const props = defineProps(['tasks']);

const taskList = ref(props.tasks);

const { parent } = useDragAndDrop(taskList,{
    draggingClass: "dragging-pokemon"
});

</script>
