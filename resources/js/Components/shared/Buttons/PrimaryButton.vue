<template>
    <CustomButton :size="size" :href="href" class="bg-indigo-600 text-white hover:bg-indigo-500 focus-visible:outline-indigo-600">
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
