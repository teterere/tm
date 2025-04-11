<template>
    <div class="flex items-start space-x-4 mb-2  p-3">
        <div class="min-w-0 flex-1 relative">
            <div class="bg-white">
                <label for="comment" class="sr-only">Pievienot komentāru</label>
                <textarea
                    ref="textarea"
                    name="comment"
                    id="comment"
                    class="block w-full resize-none bg-gray-100 rounded px-3 pt-1.5 pb-5 text-base text-gray-900 placeholder:text-gray-400 outline-none focus:border-0 focus:ring-0 sm:text-sm/6 border-0 min-h-18 max-h-56 overflow-y-auto"
                    placeholder="Pievienot komentāru..."
                    v-model="input"
                    oninput="this.style.height = ''; this.style.height = this.scrollHeight + 'px';" />
            </div>

            <div v-if="showButtons" class="flex justify-end space-x-3 mt-2">
                <OutlineButton @click="input = ''">Atcelt</OutlineButton>
                <PrimaryButton @click="submit" type="submit" class=" bottom-1.5 right-1 inline-flex items-center rounded-sm bg-indigo-500 px-3 py-1.5 text-sm font-medium text-white hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    Pievienot
                </PrimaryButton>
            </div>
        </div>
    </div>
</template>

<script setup>
import {ref, inject, watch, nextTick} from 'vue';
import {useForm} from "@inertiajs/vue3";
import {useTextareaAutosize} from "@vueuse/core";
import OutlineButton from "@/Components/shared/Buttons/OutlineButton.vue";
import PrimaryButton from "@/Components/shared/Buttons/PrimaryButton.vue";

const task = inject('task');
const { textarea, input } = useTextareaAutosize();
const showButtons = ref(false);

const form = useForm({
    body: ''
});

const submit = () => {
    form.transform((data) => ({
        ...data,
        body: input.value
    })).post(route('tasks.comments.store', {task: task.id}), {
        preserveScroll: true,
        onSuccess: () => {
            input.value = '';
        },
    });
};

const focusWithMention = (username) => {
    input.value = `@${username} `
    nextTick(() => {
        textarea.value?.focus()
    });
}

defineExpose({
    focusWithMention
});

watch(input, () => {
    showButtons.value = input.value.length !== 0;
});
</script>
