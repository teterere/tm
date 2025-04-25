<template>
    <button
        :disabled="!editor"
        @click="editor?.chain().focus()[action]().run()"
        class="editor-button"
        :class="{ 'bg-gray-100': editor?.isActive(isActive) }"
    >
        <component :is="icons[icon]" class="h-4 w-4" />
    </button>
</template>

<script setup>
import { BoldIcon, ItalicIcon, UnderlineIcon, StrikethroughIcon, ListBulletIcon, NumberedListIcon, PhotoIcon } from '@heroicons/vue/24/outline'

const props = defineProps({
    editor: Object,
    action: String,
    isActive: String,
    icon: String
});

const icons = {
    BoldIcon,
    ItalicIcon,
    UnderlineIcon,
    StrikethroughIcon,
    ListBulletIcon,
    NumberedListIcon,
    PhotoIcon
};
</script>
