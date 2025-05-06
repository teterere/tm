<template>
    <CustomButton :size="size" :href="href" class="bg-gray-100 text-gray-800 hover:bg-gray-200">
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
