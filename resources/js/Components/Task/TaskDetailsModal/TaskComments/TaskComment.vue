<template>
    <div class="mb-4 p-2 rounded-sm">
        <div class="flex space-x-3">
            <img class="inline-block size-10 rounded-full mt-1"
                 :src="comment.author.avatar_path"
                 alt=""/>

            <div>
                <div class="space-x-2 mb-1">
                    <span class="text-sm font-semibold text-gray-600">{{ comment.author.name }}</span>
                    <span class="text-xs text-gray-400">{{ comment.created_at }}</span>
                </div>
                <p class="text-sm/6 text-gray-700">{{ comment.body }}</p>
            </div>
        </div>
    </div>
</template>

<script setup>
const props = defineProps({
    comment: Object
});
</script>
