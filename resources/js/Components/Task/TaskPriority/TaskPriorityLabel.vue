<template>
<span :class="['inline-flex items-center gap-x-1.5 rounded-md px-1.5 py-0.5 text-xs font-medium', backgroundColors[priority.key]]">
    <svg :class="['size-1.5', circleColors[priority.key]]" viewBox="0 0 6 6" aria-hidden="true">
      <circle cx="3" cy="3" r="3"/>
    </svg>
    {{ priority.title }}
  </span>
</template>

<script setup>
defineProps({
    priority: Object
});

const backgroundColors = {
    low: 'bg-blue-100 text-blue-700',
    medium: 'bg-orange-200 text-orange-700',
    high: 'bg-red-100 text-red-700'
};

const circleColors = {
    low: 'fill-blue-500',
    medium: 'fill-orange-500',
    high: 'fill-red-500'
}
</script>
