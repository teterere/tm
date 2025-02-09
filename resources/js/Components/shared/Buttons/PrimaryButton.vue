<template>
    <button
        type="button"
        :class="['rounded-sm bg-indigo-600 text-white font-semibold shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 cursor-pointer', sizeClasses[size]]">
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
