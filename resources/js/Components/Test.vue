<template>
    <div ref="status" style="width: 40%; display: block">
        <div
            v-for="(element, index) in listToSort"
            :index="index"
            class="bg-white p-3 shadow-sm mb-2"
        >{{ element.number }}
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
import { useDragAndDrop } from "vue-fluid-dnd";

const listToSort = ref([
    {
        number: 1,
    },
    {
        number: 2,
    },
    {
        number: 3,
    },
    //...
]);
const { parent: status } = useDragAndDrop(listToSort);

</script>
