<template>
    <CustomButton :size="size" :href="href" class="bg-white text-gray-900 ring-inset ring-1 ring-gray-200 hover:bg-gray-50">
        <slot />
    </CustomButton>
</template>

<script setup>
import CustomButton from "@/Components/shared/Buttons/CustomButton.vue";

defineProps({
    size: {
        type: String,
        default: 'md'
    },
    href: {
        type: String,
        default: null
    }
});
</script>
