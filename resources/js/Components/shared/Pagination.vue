<template>
    <div class="flex items-center justify-between py-3">
        <button
            v-if="meta.prev_page_url"
            @click="changePage(meta.current_page - 1)"
            class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
        >Iepriekšējā</button>
        <button
            v-if="meta.next_page_url"
            @click="changePage(meta.current_page + 1)"
            class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
        >Nākamā</button>

        <!-- Advanced: lappušu numuri -->
        <nav class="isolate inline-flex gap-x-1" aria-label="Pagination">
            <template v-for="(pageData, index) in visiblePages" :key="index">
                <span v-if="pageData.page === '...'" class="pagination-button disabled">...</span>
                <button
                    v-else
                    @click="changePage(pageData.page)"
                    :disabled="meta.current_page === pageData.page"
                    class="pagination-button"
                    :class="{ 'active': meta.current_page === pageData.page }"
                >
                    {{ pageData.page }}
                </button>
            </template>
        </nav>
    </div>
</template>

<script setup>
import { computed } from "vue";

const props = defineProps({
    meta: Object
});
const emit = defineEmits(['changePage']);

const visiblePages = computed(() => {
    const totalPages = props.meta.last_page;
    const currentPage = props.meta.current_page;
    const surroundingPages = 2;
    const range = [];
    let left = currentPage - surroundingPages;
    let right = currentPage + surroundingPages;

    if (left > 1) {
        range.push({ page: 1 })
    }

    if (left > 2) {
        range.push({ page: '...' })
    }

    for (let i = left; i <= right; i++) {
        if (i > 0 && i <= totalPages) {
            range.push({ page: i });
        }
    }

    if (right < totalPages - 1) {
        range.push({ page: '...' })
    }

    if (right < totalPages) {
        range.push({ page: totalPages })
    }

    return range;
});

const changePage = (page) => {
    if (page !== props.meta.current_page && page !== '...') {
        emit('changePage', page);
    }
};
</script>
