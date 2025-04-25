<template>
    <Menu as="div" class="relative inline-block" v-slot="{open}">
        <MenuButton class="editor-button" :class="{ 'bg-gray-100': open }">
            <PhotoIcon class="h-4 w-4" />
        </MenuButton>

        <transition
            enter-active-class="transition duration-100 ease-out"
            enter-from-class="transform scale-95 opacity-0"
            enter-to-class="transform scale-100 opacity-100"
            leave-active-class="transition duration-75 ease-in"
            leave-from-class="transform scale-100 opacity-100"
            leave-to-class="transform scale-95 opacity-0"
        >
            <MenuItems class="absolute left-2 w-72 z-10 origin-top-right bg-white shadow-2xl border rounded-sm">
                <div class="flex items-center justify-between border-b border-gray-300 p-2">
                    <h5 class="font-semibold">Pievienot linku</h5>
                    <button class="p-1 bg-white hover:bg-gray-100 rounded-xs">
                        <XMarkIcon class="w-4 h-4" />
                    </button>
                </div>
                <div class="sm:mx-auto sm:w-full sm:max-w-sm px-4 py-3">
                    <label
                        for="file-upload"
                        class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 bg-gray-100 px-6 py-10 cursor-pointer"
                        @dragover.prevent
                        @drop="handleDrop"
                    >
                        <div class="text-center">
                            <PhotoIcon class="mx-auto size-12 text-gray-300" aria-hidden="true" />
                            <div class="mt-4 flex text-sm/6 text-gray-600 justify-center">
                                <span class="font-semibold text-indigo-600 hover:text-indigo-500">Izvēlies failu</span>
                                <p class="pl-1">vai ievelc to šeit</p>
                            </div>
                            <p class="text-xs/5 text-gray-600">PNG, JPG vai GIF formātā līdz 10MB</p>
                        </div>
                        <input id="file-upload" type="file" class="sr-only" @change="handleFileUpload" />
                    </label>
                </div>
            </MenuItems>
        </transition>
    </Menu>
</template>

<script setup>
import { Menu, MenuButton, MenuItems } from '@headlessui/vue'
import { LinkIcon, XMarkIcon, PhotoIcon } from '@heroicons/vue/24/outline'
import { ref } from "vue"
import { useEditorSelection } from '@/composables/useEditorSelection.js'

const props = defineProps({
    editor: Object
})

const { restore } = useEditorSelection(props.editor)
const error = ref('');

const MAX_FILE_SIZE_MB = 10
const ALLOWED_TYPES = ['image/png', 'image/jpeg', 'image/gif']

function validateFile(file) {
    error.value = ''

    if (!file) {
        error.value = 'Nav izvēlēts fails.'
        return false
    }

    if (!ALLOWED_TYPES.includes(file.type)) {
        error.value = 'Atļauti tikai PNG, JPG un GIF formāti.'
        return false
    }

    if (file.size > MAX_FILE_SIZE_MB * 1024 * 1024) {
        error.value = `Fails ir pārāk liels. Maksimālais izmērs — ${MAX_FILE_SIZE_MB} MB.`
        return false
    }

    return true
}

const handleDrop = (event) => {
    event.preventDefault()
    const file = event.dataTransfer.files[0];

    if (!validateFile(file)) {
        return;
    }

    readFile(file)
}

function readFile(file) {
    const reader = new FileReader();

    reader.onload = () => {
        insertImage(reader.result)
    }

    reader.readAsDataURL(file)
}

async function uploadFile(file, context = 'comment') {
    const formData = new FormData()
    formData.append('image', file)
    formData.append('context', context)

    const response = await axios.post(route('upload-image'), formData, {
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    })

    return response.data.url
}

const handleFileUpload = async (event) => {
    const file = event.target.files[0]
    if (!validateFile(file)) return

    try {
        const url = await uploadFile(file)
        insertImage(url)
    } catch (err) {
        error.value = 'Neizdevās ielādēt attēlu.'
    }
}

function insertImage(url) {
    if (!props.editor) return
    if (!props.editor.isFocused) restore()

    props.editor
        .chain()
        .focus()
        .setImage({
            src: url,
        })
        .run()
}
</script>
