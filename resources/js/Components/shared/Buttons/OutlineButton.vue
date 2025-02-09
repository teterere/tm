<template>
    <button
        type="button"
        :class="['rounded-sm bg-white font-semibold text-gray-900 ring-1 shadow-xs ring-gray-300 ring-inset hover:bg-gray-50 cursor-pointer', sizeClasses[size]]">
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
