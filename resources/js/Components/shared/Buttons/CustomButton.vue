<template>
    <component :is="component" :href="href" type="button" :class="['btn flex items-center space-x-2', sizeClasses[size]]">
        <slot/>
    </component>
</template>

<script setup>
import {computed} from 'vue';
import {Link} from '@inertiajs/vue3';

const props = defineProps({
    size: {
        type: String,
        default: 'md'
    },
    href: {
        type: String,
        default: null
    }
});

const component = computed(() => {
    return props.href ? Link : 'button';
});

const sizeClasses = {
    xs: 'px-2 py-1 text-xs',
    sm: 'px-2 py-1 text-sm',
    md: 'px-2.5 py-1.5 text-sm',
    lg: 'px-3 py-2 text-sm',
    xl: 'px-3.5 py-2.5 text-md'
};
</script>
