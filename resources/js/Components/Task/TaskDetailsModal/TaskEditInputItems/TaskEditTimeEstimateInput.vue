<template>
    <OnClickOutside v-if="editStatus" @trigger="submit">
        <input ref="estimateInput" v-if="editStatus" v-model="form.estimate" @input="filterInput" @keyup.enter="submit" type="text" class="block w-full p-1 rounded-xs bg-white text-sm text-gray-900 outline-1 outline-offset-0 outline-gray-200 border-gray-200 focus:outline-1 focus:-outline-offset-0 focus:outline-gray-200 focus:ring-gray-200 focus:border-gray-200" />
        <small class="text-gray-400 text-xs">Formāts: <span class="font-medium">1d 4h 12m</span></small>
    </OnClickOutside>
    <span v-else @click="enableEditStatus" class="w-full hover:bg-gray-100 rounded-xs p-1 pl-2 text-sm text-gray-600 cursor-text min-h-[1.75rem]">{{ form.estimate }}</span>
</template>

<script setup>
import {OnClickOutside} from "@vueuse/components";
import {inject, nextTick, ref} from "vue";
import {useForm} from "@inertiajs/vue3";

const task = inject('task', null);

const emit = defineEmits(['update']);

const editStatus = ref(false);

const form = useForm({
    estimate: task?.estimate || ''
});

const estimateInput = ref(null);

const enableEditStatus = () => {
    editStatus.value = true;

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
    if (task) {
        form.patch(route('tasks.update', task.id), {
            preserveScroll: true,
            onSuccess: () => {
                disableEditStatus();
                form.estimate = task.estimate;
            }
        });

        return;
    }

    disableEditStatus();
    emit('update', form.estimate);
};
</script>
