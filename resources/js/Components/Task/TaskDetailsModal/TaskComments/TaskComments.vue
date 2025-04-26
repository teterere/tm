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
                        <span class="text-xs font-semibold border bg-gray-50 text-gray-500 py-0.5 px-1.5 rounded">{{ task.comments_count }}</span>
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
                <Wysiwyg ref="commentInputField" @submit="addComment" submitButtonText="Pievienot" cancelButtonText="Notīrīt" />

                <div class="relative">
                    <div v-if="loading" class="absolute inset-0 bg-white/60 flex items-center justify-center z-10">
                        <span class="inline-block w-8 h-8 border-4 border-gray-300 border-t-blue-500 rounded-full animate-spin"></span>
                    </div>

                    <div v-if="error" class="text-center py-6 font-semibold">
                        {{ error }}
                    </div>

                    <div v-else :class="{ 'opacity-75 pointer-events-none': loading }">
                        <TaskComment
                            v-for="comment in comments"
                            :key="comment.id"
                            :comment="comment"
                            :edit-status="editingCommentId === comment.id"
                            @edit="editingCommentId = comment.id"
                            @close-edit="editingCommentId = null"
                            @reply="handleReply"
                            @commentUpdated="refreshComments"
                        />

                        <div v-if="!loading && comments.length === 0" class="text-gray-400 text-center">Nav komentāru</div>
                    </div>
                </div>

                <Pagination v-if="meta.last_page > 1" :meta="meta" @changePage="fetchComments"/>
            </DisclosurePanel>
        </Disclosure>
    </div>
</template>

<script setup>
import TaskComment from "@/Components/Task/TaskDetailsModal/TaskComments/TaskComment.vue";
import {Disclosure, DisclosureButton, DisclosurePanel} from "@headlessui/vue";
import {ChevronDownIcon, BarsArrowDownIcon, BarsArrowUpIcon} from "@heroicons/vue/24/outline";
import Pagination from "@/Components/shared/Pagination.vue";
import {onMounted, ref} from "vue";
import Wysiwyg from "@/Components/shared/wysiwyg/Wysiwyg.vue";
import {useForm} from "@inertiajs/vue3";

const props = defineProps({
    task: Object
});

const commentInputField = ref(null);
const comments = ref([])
const loading = ref(false)
const error = ref(null)
const direction = ref('desc')
const meta = ref({})
const page = ref(1);
const editingCommentId = ref(null);

onMounted(() => fetchComments());

const fetchComments = async (customPage = null) => {
    loading.value = true
    error.value = null

    try {
        const response = await axios.get(route('tasks.comments.index', {task: props.task.id}), {
            params: {
                direction: direction.value,
                page: customPage ?? page.value
            }
        });
        comments.value = response.data.data
        meta.value = response.data.meta
        page.value = meta.value.current_page
    } catch (err) {
        error.value = 'Neizdevās ielādēt komentārus'
    } finally {
        loading.value = false
    }
}

const toggleDirection = (newDirection) => {
    if (direction.value !== newDirection) {
        direction.value = newDirection;
        page.value = 1;
        fetchComments(1);
    }
}

const form = useForm({
    body: ''
});

const addComment = (content) => {
    form.transform((data) => ({
        ...data,
        body: content
    })).post(route('tasks.comments.store', { task: props.task.id }), {
        preserveScroll: true,
        onSuccess: () => {
            refreshComments();
            commentInputField.value.clear();
        },
    });
}

const refreshComments = () => {
    page.value = 1;
    fetchComments(1);
}

const handleReply = (username) => {
    commentInputField.value?.focusWithMention?.(username)
}
</script>

