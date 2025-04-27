<template>
    <div v-if="editStatus" class="min-w-full">
        <multiselect
            id="labels-multiselect"
            ref="inputRef"
            v-model="selectedLabels"
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
            placeholder="Pievienot etiķetes"
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
                <button type="button" @click.stop="remove(option)" class="ml-1 text-gray-500 hover:text-red-600">
                    <XMarkIcon class="w-3 h-3" />
                </button>
              </span>
            </template>
        </multiselect>
    </div>

    <div v-else @click="enableEditStatus" class="flex flex-wrap gap-1.5 w-full hover:bg-gray-100 rounded-xs p-1 min-h-[2rem] cursor-pointer">
        <template v-if="selectedLabels.length">
      <span v-for="label in selectedLabels" :key="label.id || label.title" class="bg-gray-200 text-gray-700 rounded px-2 py-0.5 text-xs flex items-center">
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
import {XMarkIcon} from "@heroicons/vue/24/outline/index.js";

const emit = defineEmits(['update'])

const labels = inject('labels', []) // Pieņemam, ka labels ir [{id, title}, ...]
const task = inject('task', null)

const editStatus = ref(false)
const inputRef = ref(null)
const query = ref('')

const selectedLabels = ref(
    task?.labels ? [...task.labels] : []
)

// Pēc atvēršanas autofokusē dropdown
watch(editStatus, async (val) => {
    if (val) {
        await nextTick()
        inputRef.value?.activate()
    }
})

// Meklēšana neatkarīgi no diakritikām
function normalizeString(str) {
    return (str || '')
        .toLowerCase()
        .normalize('NFD')
        .replace(/[\u0300-\u036f]/g, '')
}

function filterLabels(option, label, search) {
    if (!search) return true
    return normalizeString(label).includes(normalizeString(search))
}

// Jaunas birkas pievienošana (on tag)
const addTag = (newTag) => {
    // Reāli vajadzētu izsaukt API lai izveido birku, šeit tikai piemērs:
    const tagObj = { id: null, title: newTag }
    selectedLabels.value.push(tagObj)
}

// Pieprasījuma options, kas nesatur jau izvēlētos
const filteredOptions = computed(() => {
    const selectedIds = new Set(selectedLabels.value.map(l => l.id))
    return labels.filter(l => !selectedIds.has(l.id))
})

// Read/Write režīms
const enableEditStatus = () => { editStatus.value = true }
const handleBlur = () => { editStatus.value = false }

// Pēc izmaiņām izsauc patch vai emit
watch(selectedLabels, () => {
    if (task) {
        // Patch uz serveri, piemērs:
        // TODO: aizvieto ar savu api call
        // form.post(...);

        return;
    }

    emit('update', {field: 'label_ids', value: selectedLabels.value});
})
</script>
