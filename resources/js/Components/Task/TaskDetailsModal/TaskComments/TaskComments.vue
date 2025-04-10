<template>
    <div class="py-4">
        <Disclosure v-slot="{ open }" :defaultOpen="true">
            <DisclosureButton class="outline-0 mb-2">
                <div class="flex items-center gap-x-2 mb-2">
                    <button class="bg-gray-100 rounded-sm p-1">
                        <ChevronDownIcon :class="open && 'rotate-180 transform'" class="w-3 h-3" />
                    </button>
                    <h5 class="text-sm font-bold text-gray-400">Komentāri</h5>
                </div>
            </DisclosureButton>
            <DisclosurePanel class="text-gray-500">
                <AddCommentInput ref="addCommentInputRef" />
                <TaskComment v-for="comment in task.comments.data" :comment="comment" @reply="handleReply" />
                <Pagination v-if="task.comments.meta.last_page > 1" :meta="task.comments.meta" />
            </DisclosurePanel>
        </Disclosure>
    </div>
</template>

<script setup>
import TaskComment from "@/Components/Task/TaskDetailsModal/TaskComments/TaskComment.vue";
import {Disclosure, DisclosureButton, DisclosurePanel} from "@headlessui/vue";
import {ChevronDownIcon} from "@heroicons/vue/24/outline/index.js";
import AddCommentInput from "@/Components/Task/TaskDetailsModal/TaskComments/AddCommentInput.vue";
import Pagination from "@/Components/shared/Pagination.vue";
import {ref} from "vue";

const props = defineProps({
    task: Object
});

const addCommentInputRef = ref(null);

const handleReply = (username) => {
    addCommentInputRef.value?.focusWithMention?.(username)
}
</script>
