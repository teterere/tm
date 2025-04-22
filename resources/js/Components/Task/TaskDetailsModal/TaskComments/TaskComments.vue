<template>
    <div class="py-4">
        <Disclosure v-slot="{ open }" :defaultOpen="true">
            <div class="flex items-center justify-between mb-2">
                <DisclosureButton class="outline-0">
                    <div class="flex items-center gap-x-2 mb-2">
                        <button class="bg-gray-100 hover:bg-gray-200 rounded-sm p-1">
                            <ChevronDownIcon :class="open && 'rotate-180 transform'" class="w-3 h-3" />
                        </button>
                        <h5 class="text-sm font-bold text-gray-400">Komentāri</h5>
                        <span class="text-xs font-semibold border bg-gray-50 text-gray-500 py-0.5 px-1.5 rounded">{{ task.comments.meta.total }}</span>
                    </div>
                </DisclosureButton>
                <div>
                    <button v-if="direction === 'desc'" @click="toggleDirection('asc')" class="flex items-center gap-x-1 rounded-sm text-gray-400 hover:bg-gray-100 hover:text-gray-600 py-1 px-2">
                        <BarsArrowUpIcon class="h-4 w-4" />
                        <span class="text-xs font-semibold">Jaunākie vispirms</span>
                    </button>
                    <button v-if="direction === 'asc'" @click="toggleDirection('desc')" class="flex items-center gap-x-1 rounded-sm text-gray-400 hover:bg-gray-100 hover:text-gray-600 py-1 px-2">
                        <BarsArrowDownIcon class="h-4 w-4" />
                        <span class="text-xs font-semibold">Vecākie vispirms</span>
                    </button>
                </div>
            </div>
            <DisclosurePanel class="text-gray-500">
                <AddCommentInput ref="commentInputField" />
                <TaskComment v-for="comment in task.comments.data" :comment="comment" @reply="handleReply" />
                <div class="flex justify-center">
                    <Pagination v-if="task.comments.meta.last_page > 1" :meta="task.comments.meta" />
                </div>
            </DisclosurePanel>
        </Disclosure>
    </div>
</template>

<script setup>
import TaskComment from "@/Components/Task/TaskDetailsModal/TaskComments/TaskComment.vue";
import {Disclosure, DisclosureButton, DisclosurePanel} from "@headlessui/vue";
import {ChevronDownIcon, BarsArrowDownIcon, BarsArrowUpIcon} from "@heroicons/vue/24/outline/index";
import AddCommentInput from "@/Components/Task/TaskDetailsModal/TaskComments/CommentInput.vue";
import Pagination from "@/Components/shared/Pagination.vue";
import {ref} from "vue";

const props = defineProps({
    task: Object
});

const emit = defineEmits(['directionChanged']);

const direction = ref('desc');
const commentInputField = ref(null);

const handleReply = (username) => {
    commentInputField.value?.focusWithMention?.(username)
}

const toggleDirection = (newDirection) => {
    direction.value = newDirection;
    emit('directionChanged', direction.value);
}
</script>
