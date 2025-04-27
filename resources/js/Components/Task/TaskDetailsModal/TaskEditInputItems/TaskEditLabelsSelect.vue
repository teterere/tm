<template>
    <div v-if="editStatus" class="min-w-full relative">
        <multiselect
            id="labels-multiselect"
            ref="inputRef"
            v-model="form.selectedLabels"
            :options="filteredOptions"
            :multiple="true"
            track-by="title"
            label="title"
            :close-on-select="false"
            :clear-on-select="true"
            :preserve-search="true"
            :taggable="true"
            :hide-selected="true"
            :show-labels="false"
            :tag-placeholder="''"
            :searchable="true"
            placeholder=""
            @close="handleBlur"
            @tag="addTag"
            :filter-method="filterLabels"
        >
            <template v-slot:option="{ option }">
                <div v-if="option.isTag" class="label-option--add">
                    <span class="mr-1">{{ option.label }} </span> <span>(izveidot)</span>
                </div>
                <div v-else class="label-option">
                    {{ option.title }}
                </div>
            </template>
            <template v-slot:tag="{ option, remove }">
              <span class="label-tag bg-gray-200 text-gray-700 text-xs rounded px-1.5 py-0.5 flex items-center mr-1 mb-1">
                {{ option.title }}
                <button type="button" @mousedown.prevent.stop="remove(option)" class="ml-1 text-gray-500 hover:text-red-600">
                    <XMarkIcon class="w-3 h-3" />
                </button>
              </span>
            </template>
        </multiselect>
    </div>

    <div v-else @click="enableEditStatus" class="flex flex-wrap gap-1.5 w-full hover:bg-gray-100 rounded-xs p-1 min-h-[2rem] cursor-pointer">
        <template v-if="form.selectedLabels.length">
          <span v-for="label in form.selectedLabels" :key="label.id || label.title" class="bg-gray-200 text-gray-700 rounded px-2 py-0.5 text-xs flex items-center">
            {{ label.title }}
          </span>
        </template>
        <span v-else class="text-sm text-gray-600">Pievienot etiķetes</span>
    </div>
</template>

<script setup>
import { ref, inject, computed, watch, nextTick } from 'vue'
import Multiselect from 'vue-multiselect'
import 'vue-multiselect/dist/vue-multiselect.min.css'
import {XMarkIcon} from "@heroicons/vue/24/outline";
import {useForm} from "@inertiajs/vue3";

const emit = defineEmits(['update'])

const labels = inject('labels', []);
const task = inject('task', null)

const editStatus = ref(false)
const inputRef = ref(null)
const query = ref('')

// Focus dropdown when edit status is enabled
watch(editStatus, async (val) => {
    if (val) {
        await nextTick()
        inputRef.value?.activate()
    }
})

// Normalize search string for case-insensitive  search, removes diacritical marks
function normalizeString(str) {
    return (str || '')
        .toLowerCase()
        .normalize('NFD')
        .replace(/[\u0300-\u036f]/g, '')
}

function filterLabels(option, label, search) {
    if (!search) {
        return true;
    }

    return normalizeString(label).includes(normalizeString(search));
}

const addTag = (newTag) => {
    const tagObj = { id: null, title: newTag };
    form.selectedLabels.push(tagObj);
}

// Filter labels to only show the ones that are not assigned yet
const filteredOptions = computed(() => {
    const selectedIds = new Set(form.selectedLabels.map(label => label.id));

    return labels.filter(label => !selectedIds.has(label.id))
})

const enableEditStatus = () => {
    editStatus.value = true
}

const handleBlur = () => {
    editStatus.value = false
}

const form = useForm({
    selectedLabels: task?.labels ? [...task.labels] : []
});

watch(() => form.selectedLabels, () => {
        if (task) {
            form.post(route('tasks.labels.add', {task: task.id}), {
                preserveScroll: true,
                onSuccess: () => {
                    query.value = '';
                },
            });

            return;
        }

        emit('update', {field: 'label_ids', value: form.selectedLabels});
    },
    {deep: true}
);
</script>
