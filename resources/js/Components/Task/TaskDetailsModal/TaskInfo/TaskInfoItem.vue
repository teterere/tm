<template>
    <div class="grid grid-cols-3 items-center gap-x-2 md:gap-x-8">
        <div class="col-span-1">
            <h5 class="text-sm font-semibold text-gray-400">
                {{ title }}
            </h5>
        </div>
        <div class="col-span-2 flex items-center">
            <slot />
        </div>
    </div>
</template>

<script setup>
defineProps({
    title: String
})
</script>
