<template>
    <div class="mb-4">
        <input v-if="editStatus" v-model="form.title" v-on-click-outside="disableEditStatus" type="text" class="font-medium block w-full rounded-xs bg-white p-2 text-xl text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-1 focus:-outline-offset-0 focus:outline-gray-200 focus:ring-gray-200 focus:border-gray-200" />

        <h2 v-else @click="editStatus = true" class="text-xl font-medium hover:bg-gray-100 p-2 border-1 border-transparent hover:cursor-text">
            {{ task.title }}
        </h2>
    </div>
</template>

<script setup>
import {ref} from "vue";
import {useForm} from "@inertiajs/vue3";
import {vOnClickOutside} from '@vueuse/components';

const props = defineProps({
    task: Object
})

const form = useForm({
    title: props.task.title
});

const editStatus = ref(false);

const disableEditStatus = () => {
    editStatus.value = false;
}
</script>
