<template>
    <div class="text-right">
        <Menu as="div" class="relative inline-block" v-slot="{open}">
            <MenuButton class="editor-button" :class="{ 'bg-gray-100': open }">
                <FaceSmileIcon class="h-4 w-4" />
            </MenuButton>

            <transition
                enter-active-class="transition duration-100 ease-out"
                enter-from-class="transform scale-95 opacity-0"
                enter-to-class="transform scale-100 opacity-100"
                leave-active-class="transition duration-75 ease-in"
                leave-from-class="transform scale-100 opacity-100"
                leave-to-class="transform scale-95 opacity-0"
            >
                <MenuItems class="absolute right-0 mt-2 w-56 origin-top-right">
                    <emoji-picker @emoji-click="insertEmoji($event.detail.unicode)"></emoji-picker>
                </MenuItems>
            </transition>
        </Menu>
    </div>
</template>

<script setup>
import {Menu, MenuButton, MenuItems} from '@headlessui/vue'
import 'emoji-picker-element'
import {FaceSmileIcon} from "@heroicons/vue/24/outline";
import {useEditorSelection} from "@/Composables/useEditorSelection.js";

const props = defineProps({
    editor: Object
})

const { restore } = useEditorSelection(props.editor)

const insertEmoji = (emoji) => {
    if (!props.editor) return

    if (!props.editor.isFocused) {
        restore()
    }

    props.editor.chain().focus().insertContent(emoji + ' ').run()
}
</script>


