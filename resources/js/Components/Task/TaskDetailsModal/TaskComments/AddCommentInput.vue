<template>
    <div class="flex items-start space-x-4 mb-2 bg-gray-50 p-3">
        <div class="shrink-0">
            <img class="inline-block size-10 rounded-full" :src="$page.props.auth.user.avatar_path" alt="" />
        </div>
        <div class="min-w-0 flex-1 relative">
            <div class="bg-white">
                <label for="comment" class="sr-only">Pievienot komentāru</label>
                <textarea
                    rows="1"
                    name="comment"
                    id="comment"
                    class="block w-full resize-none bg-white px-3 py-1.5 text-base text-gray-900 placeholder:text-gray-400 outline-none focus:border-0 focus:ring-0 sm:text-sm/6 border-0"
                    placeholder="Pievienot komentāru..."
                    v-model="form.body"
                    oninput="this.style.height = ''; this.style.height = this.scrollHeight + 'px';" />

                <!-- Spacer element to match the height of the toolbar -->
                <div class="py-2" aria-hidden="true">
                    <div class="py-px">
                        <div class="h-6" />
                    </div>
                </div>
            </div>

            <transition
                enter-active-class="transition-opacity duration-150"
                enter-from-class="opacity-0"
                enter-to-class="opacity-100"
                leave-active-class="transition-opacity duration-150"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0">
                <button  @click="submit" type="submit" class="absolute bottom-1.5 right-1 inline-flex items-center rounded-sm bg-indigo-500 px-3 py-1.5 text-sm font-medium text-white hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    Pievienot
                </button>
            </transition>
        </div>
    </div>
</template>

<script setup>
import { ref, inject } from 'vue';
import {useForm} from "@inertiajs/vue3";

const task = inject('task');
const showSubmitButton = ref(false);

const form = useForm({
    body: ''
});

const submit = () => {
    form.post(route('tasks.comments.store', {task: task.id}), {
        preserveScroll: true,
        onSuccess: () => {
            form.body = '';
            showSubmitButton.value = false;
        },
    });
};
</script>
