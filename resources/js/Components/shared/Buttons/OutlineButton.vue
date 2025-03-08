<template>
    <button
        type="button"
        :class="['btn bg-white text-gray-900 ring-inset ring-1 ring-gray-200 hover:bg-gray-50', sizeClasses[size]]">
        <slot />
    </button>
</template>

<script setup>
defineProps({
    size: {
        type: String,
        default: 'md'
    }
});

const sizeClasses = {
    xs: 'px-2 py-1 text-xs',
    sm: 'px-2 py-1 text-sm',
    md: 'px-2.5 py-1.5 text-sm',
    lg: 'px-3 py-2 text-sm',
    xl: 'px-3.5 py-2.5 text-sm'
};
</script>
