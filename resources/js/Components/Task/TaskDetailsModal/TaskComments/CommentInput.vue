<template>
    <div class="flex items-start border-1 rounded-xs mb-6">
        <div class="min-w-0 flex-1">
            <div class="bg-white relative">
                <EditorContent :editor="editor" class="wysiwyg" />

                <div
                    v-if="showMentionDropdown && mentionBox?.clientRect"
                    class="fixed z-10 bg-white border rounded-xs shadow"
                    :style="mentionFixedPosition"
                >
                    <div
                        v-for="(item, index) in mentionItems"
                        :key="item.id"
                        class="px-3 py-1.5 cursor-pointer"
                        :class="{
                          'bg-gray-100': index === selectedMentionIndex
                        }"
                        @mouseenter="selectedMentionIndex = index"
                        @click="selectMentionItem(item)"
                    >
                        @{{ item.name }}
                    </div>
                </div>
            </div>

            <div class="flex justify-between items-center p-1">
                <div class="flex gap-1 flex-wrap">
                    <SimpleEditorButton
                        v-for="button in simpleEditButtons"
                        :key="button.action"
                        :editor="editor"
                        v-bind="button"
                    />
                    <AddLink :editor="editor" :lastSelection="lastEditorSelection" />
                    <InsertImage :editor="editor" />
                    <EmojiDropdown :editor="editor" />
                </div>

                <div v-if="comment" class="flex justify-end space-x-3">
                    <button
                        @click="$emit('close')"
                        class="text-xs hover:bg-gray-100 font-semibold text-gray-400 hover:text-gray-600 px-2 rounded-sm"
                    >
                        Atcelt
                    </button>
                    <PrimaryButton @click="submit">Saglabāt</PrimaryButton>
                </div>

                <div v-else class="flex justify-end space-x-3">
                    <button
                        @click="clear"
                        class="text-xs hover:bg-gray-100 font-semibold text-gray-400 hover:text-gray-600 px-2 rounded-sm"
                    >
                        Notīrīt
                    </button>
                    <PrimaryButton @click="submit">Pievienot</PrimaryButton>
                </div>
            </div>
        </div>
    </div>
</template>


<script setup>
import {ref, inject, computed} from 'vue'
import { useForm } from '@inertiajs/vue3'
import PrimaryButton from '@/Components/shared/Buttons/PrimaryButton.vue'
import { useEditor, EditorContent } from '@tiptap/vue-3'
import StarterKit from '@tiptap/starter-kit'
import Underline from '@tiptap/extension-underline'
import Strike from '@tiptap/extension-strike'
import BulletList from '@tiptap/extension-bullet-list'
import OrderedList from '@tiptap/extension-ordered-list'
import ListItem from '@tiptap/extension-list-item'
import Link from '@tiptap/extension-link'
import Image from '@tiptap/extension-image'
import EmojiDropdown from '@/Components/shared/wysiwyg/EmojiDropdown.vue'
import AddLink from '@/Components/shared/wysiwyg/InsertLink.vue'
import SimpleEditorButton from '@/Components/shared/wysiwyg/SimpleEditorButton.vue'
import InsertImage from '@/Components/shared/wysiwyg/InsertImage.vue'
import ImageResize from 'tiptap-extension-resize-image'
import Mention from '@tiptap/extension-mention'
import Suggestion from '@tiptap/suggestion'
import { useEventListener } from '@vueuse/core'

useEventListener(window, 'scroll', updateMentionPosition, true)

function updateMentionPosition() {
    if (mentionBox.value?.clientRect) {
        const props = mentionBox.value
        mentionBox.value = null
        mentionBox.value = props
    }
}

const props = defineProps({ comment: Object })
const emit = defineEmits(['close'])
const task = inject('task')

const showMentionDropdown = ref(false)
const mentionBox = ref(null)
const selectedMentionIndex = ref(0)

const employees = inject('employees');

const selectMentionItem = (item) => {
    mentionBox.value?.command(item)
    showMentionDropdown.value = false
}

const mentionItems = computed(() => {
    return mentionBox.value?.items || [];
})

const mentionFixedPosition = computed(() => {
    const rect = mentionBox.value?.clientRect?.()
    if (!rect) return { top: '0px', left: '0px' }

    return {
        top: `${rect.bottom + window.scrollY}px`,
        left: `${rect.left + window.scrollX}px`,
    }
})

const mentionSuggestion = {
    char: '@',
    items: ({ query }) => employees.filter(user => user.name.toLowerCase().startsWith(query.toLowerCase())),
    command: ({ editor, range, props }) => {
        editor.chain().focus().insertContentAt(range, [
            { type: 'mention', attrs: { id: props.id, label: props.name } },
            { type: 'text', text: ' ' },
        ]).run()
    },
    render: () => {
        return {
            onStart: (props) => {
                showMentionDropdown.value = true
                mentionBox.value = props
                selectedMentionIndex.value = 0
            },
            onUpdate: (props) => {
                mentionBox.value = props
            },
            onExit: () => {
                showMentionDropdown.value = false
                mentionBox.value = null
                selectedMentionIndex.value = 0
            },
            onKeyDown: (props) => {
                const itemCount = mentionBox.value?.items.length || 0

                if (props.event.key === 'ArrowDown') {
                    selectedMentionIndex.value = (selectedMentionIndex.value + 1) % itemCount
                    return true
                }

                if (props.event.key === 'ArrowUp') {
                    selectedMentionIndex.value = (selectedMentionIndex.value - 1 + itemCount) % itemCount
                    return true
                }

                if (props.event.key === 'Enter') {
                    const item = mentionBox.value?.items[selectedMentionIndex.value]
                    if (item) {
                        mentionBox.value.command(item)
                    }
                    return true
                }

                if (props.event.key === 'Escape') {
                    showMentionDropdown.value = false
                    mentionBox.value = null
                    selectedMentionIndex.value = 0
                    return true
                }

                return false
            },
        }
    },
    allowSpaces: true
}

const editor = useEditor({
    content: props.comment?.body || '',
    extensions: [
        StarterKit,
        Suggestion,
        BulletList,
        OrderedList,
        ListItem,
        Underline,
        Strike,
        ImageResize,
        Link.configure({ openOnClick: false }),
        Image.configure({ inline: true, allowBase64: false }),
        Mention.configure({
            HTMLAttributes: {
                class: 'mention',
            },
            suggestion: mentionSuggestion,
        }),
    ],
    editorProps: {
        attributes: {
            class: 'focus:outline-none min-h-24 py-2 px-4',
        },
    },
    onUpdate: ({ editor }) => form.body = editor.getHTML(),
})

let lastEditorSelection = null
const form = useForm({ body: '' })

const simpleEditButtons = [
    { action: 'toggleBold', isActive: 'bold', icon: 'BoldIcon' },
    { action: 'toggleItalic', isActive: 'italic', icon: 'ItalicIcon' },
    { action: 'toggleUnderline', isActive: 'underline', icon: 'UnderlineIcon' },
    { action: 'toggleStrike', isActive: 'strike', icon: 'StrikethroughIcon' },
    { action: 'toggleBulletList', isActive: 'bulletList', icon: 'ListBulletIcon' },
    { action: 'toggleOrderedList', isActive: 'orderedList', icon: 'NumberedListIcon' }
]

const submit = () => {
    if (props.comment) {
        form.patch(route('tasks.comments.update', { task: task.id, comment: props.comment.id }), {
            preserveScroll: true,
            onSuccess: () => {
                emit('close')
                clear()
            },
        })
    } else {
        form.post(route('tasks.comments.store', { task: task.id }), {
            preserveScroll: true,
            onSuccess: clear,
        })
    }
}

const clear = () => {
    form.reset()
    editor?.value.commands.clearContent()
}

const focusWithMention = (username) => {
    if (!editor?.value) return
    const selection = lastEditorSelection ?? editor.value.state.selection
    editor.value.chain().focus().insertContentAt(selection, [
        { type: 'mention', attrs: { id: username.toLowerCase(), label: username } },
        { type: 'text', text: ' ' },
    ]).run()
}

defineExpose({ focusWithMention })
</script>

<style scoped>
.wysiwyg {
    border: 1px solid #ddd;
    border-radius: 2px 2px 0 0;
    position: relative;
}
</style>
