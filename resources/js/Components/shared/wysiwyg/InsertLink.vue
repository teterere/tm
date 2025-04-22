<template>
    <Menu as="div" class="relative inline-block" v-slot="{open, close}">
        <MenuButton class="editor-button" :class="{ 'bg-gray-100': open }">
            <LinkIcon class="h-4 w-4" />
        </MenuButton>

        <transition
            enter-active-class="transition duration-100 ease-out"
            enter-from-class="transform scale-95 opacity-0"
            enter-to-class="transform scale-100 opacity-100"
            leave-active-class="transition duration-75 ease-in"
            leave-from-class="transform scale-100 opacity-100"
            leave-to-class="transform scale-95 opacity-0"
        >
            <MenuItems class="absolute left-2 mt-1 w-72 z-10 origin-top-right bg-white shadow-2xl border rounded-sm">
                <div class="flex items-center justify-between border-b border-gray-300 p-2">
                    <h5 class="font-semibold">Pievienot linku</h5>
                    <button @click="close" class="p-1 bg-white hover:bg-gray-100 rounded-xs">
                        <XMarkIcon class="w-4 h-4" />
                    </button>
                </div>
                <div class="sm:mx-auto sm:w-full sm:max-w-sm p-4">
                    <div>
                        <label for="link" class="block text-sm font-semibold text-gray-600 mb-1">Saite</label>
                        <input v-model="url" type="text" id="link" required class="input-md" />
                    </div>

                    <div class="mb-2">
                        <div class="flex items-center justify-between mb-1">
                            <label for="link-display-text" class="block text-sm font-semibold text-gray-600">Saites teksts</label>
                            <div class="text-sm">
                                <span class="text-xs/6 text-gray-500" id="email-optional">Neobligāts</span>
                            </div>
                        </div>
                        <input v-model="displayText" type="text" id="link-display-text" class="input-md" />
                    </div>

                    <div class="flex items-center gap-x-2 mb-6">
                        <input v-model="openInNewTab" id="open-in-new-tab" type="checkbox" class="col-start-1 row-start-1 appearance-none rounded-sm border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:checked:bg-gray-100 forced-colors:appearance-auto" />
                        <label for="open-in-new-tab" class="block text-sm text-gray-800">Atvērt jaunā cilnē</label>
                    </div>

                    <div class="flex justify-between">
                        <OutlineButton @click="close">Atcelt</OutlineButton>
                        <PrimaryButton @click="insertLink">Ievietot</PrimaryButton>
                    </div>
                </div>
            </MenuItems>
        </transition>
    </Menu>
</template>

<script setup>
import { Menu, MenuButton, MenuItems } from '@headlessui/vue'
import OutlineButton from "@/Components/shared/Buttons/OutlineButton.vue"
import PrimaryButton from "@/Components/shared/Buttons/PrimaryButton.vue"
import { LinkIcon, XMarkIcon } from '@heroicons/vue/24/outline'
import { ref } from "vue"
import { useEditorSelection } from '@/composables/useEditorSelection.js'

const props = defineProps({
    editor: Object
})

const url = ref('')
const displayText = ref('')
const openInNewTab = ref(false)

const { restore } = useEditorSelection(props.editor)

function insertLink() {
    if (!props.editor) return

    const href = url.value.trim()
    const text = displayText.value.trim()
    const target = openInNewTab.value ? '_blank' : null

    if (!href) return

    if (!props.editor.isFocused) {
        restore()
    }

    props.editor
        .chain()
        .extendMarkRange('link')
        .setLink({ href, target })
        .insertContent(text || href)
        .run()

    url.value = ''
    displayText.value = ''
    openInNewTab.value = false
}
</script>

