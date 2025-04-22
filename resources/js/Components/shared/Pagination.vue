<template>
    <div class="flex items-center justify-between py-3">
        <div class="flex flex-1 justify-between sm:hidden">
            <Link
                v-if="meta.prev_page_url"
                :href="meta.prev_page_url"
                class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
            >Previous</Link>
            <Link
                v-if="meta.next_page_url"
                :href="meta.next_page_url"
                class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
            >Next</Link>
        </div>
        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
            <nav class="isolate inline-flex gap-x-1" aria-label="Pagination">
                <template v-for="(pageData, index) in visiblePages" :key="index">
                    <span v-if="pageData.page === '...'" class="pagination-button disabled">...</span>
                    <Link
                        v-else
                        :href="pageData.url"
                        preserve-state
                        preserve-scroll
                        replace
                        class="pagination-button"
                        :class="{ 'active': meta.current_page === pageData.page }"
                    >
                        {{ pageData.page }}
                    </Link>
                </template>

            </nav>
        </div>
    </div>
</template>

<script setup>
import { computed } from "vue";
import { ChevronLeftIcon, ChevronRightIcon } from "@heroicons/vue/24/outline";
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    meta: Object
});

const visiblePages = computed(() => {
    const totalPages = props.meta.last_page;
    const currentPage = props.meta.current_page;
    const surroundingPages = 3;
    const range = [];
    let left = currentPage - surroundingPages;
    let right = currentPage + surroundingPages;

    if (left > 1) {
        range.push({ page: 1, url: findPageUrl(1) })
    }

    if (left > 2) {
        range.push({ page: '...', url: null })
    }

    for (let i = left; i <= right; i++) {
        if (i > 0 && i <= totalPages) {
            range.push({ page: i, url: findPageUrl(i) });
        }
    }

    if (right < totalPages - 1) {
        range.push({ page: '...', url: null })
    }

    if (right < totalPages) {
        range.push({ page: totalPages, url: findPageUrl(totalPages) })
    }

    return range;
});

const findPageUrl = (page) => {
    return props.meta.links.find(link => link.label == page.toString())?.url ?? '#';
}
</script>
