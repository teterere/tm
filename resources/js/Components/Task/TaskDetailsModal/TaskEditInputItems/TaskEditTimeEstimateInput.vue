<template>
    <OnClickOutside v-if="editStatus" @trigger="submit">
        <input v-if="editStatus" v-model="form.estimate" @input="filterInput" @keyup.enter="submit" ref="estimateInput" type="text" class="block w-full p-1 rounded-xs bg-white text-sm text-gray-900 outline-1 outline-offset-0 outline-gray-200 border-gray-200 focus:outline-1 focus:-outline-offset-0 focus:outline-gray-200 focus:ring-gray-200 focus:border-gray-200" />
        <small class="text-gray-400 text-xs">Formāts: <span class="font-medium">1d 4h 12m</span></small>
    </OnClickOutside>
    <span v-else @click="enableEditStatus" class="w-full hover:bg-gray-100 rounded-xs p-1 text-sm text-gray-600 cursor-text">{{ task.estimate }}</span>
</template>

<script setup>
import {OnClickOutside} from "@vueuse/components";
import {nextTick, ref} from "vue";
import {useForm} from "@inertiajs/vue3";

const props = defineProps({
    task: Object
});

const editStatus = ref(false);

const form = useForm({
    estimate: props.task.estimate
});

const estimateInput = ref(null);

const enableEditStatus = () => {
    editStatus.value = true;
    form.title = props.task.title;

    nextTick(() => {
        if (estimateInput) {
            estimateInput.value.focus();
        }
    });
};

const disableEditStatus = () => {
    editStatus.value = false;
};

const filterInput = () => {
    form.estimate = form.estimate
        .replace(/[^0-9dhm\s]/gi, '') // Izņem visus neatļautos simbolus
        .replace(/(?<!\d)[dhm]/gi, '') // Noņem "d", "h", "m", ja tie nav pēc cipara
        .replace(/([dhm])(?!\s|$)/gi, '$1 '); // Pievieno atstarpi aiz "d", "h", "m", ja tās nav beigās vai jau nav atstarpe
};

const submit = () => {
    form.patch(route('tasks.update', props.task.id), {
        preserveScroll: true,
        onSuccess: () => {
            disableEditStatus();
            form.estimate = props.task.estimate;
        }
    });
}
</script>
