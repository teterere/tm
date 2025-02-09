<template>
    <Menu as="div" class="relative inline-block text-left">
        <MenuButton :class="['inline-flex w-full justify-center gap-x-1.5 rounded-xs px-3 py-1 text-sm font-medium shadow-xs cursor-pointer', statusBackgroundColors[task.status.key]]">
            {{ task.status.title }}
            <ChevronDownIcon class="-mr-1 size-5" aria-hidden="true" />
        </MenuButton>

        <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
            <MenuItems class="absolute left-0 z-10 mt-2 w-46 origin-top-right rounded-md bg-white ring-1 shadow-lg ring-black/5 focus:outline-hidden">
                <div class="py-1 space-y-1">
                    <MenuItem v-for="status in statuses" v-slot="{ active }">
                        <button @click="updateStatus(status)" :class="[active ? 'outline-hidden bg-gray-100' : 'text-gray-700', 'flex items-center justify-between px-3 py-2 text-sm w-full cursor-pointer text-start']">
                            <span :class="['px-3 py-1.5 font-semibold uppercase text-xs rounded-xs', statusBackgroundColors[status.key]]">
                                {{ status.title }}
                            </span>
                            <CheckIcon v-if="task.status.id === status.id" class="w-4 h-4 text-green-600" />
                        </button>
                    </MenuItem>
                </div>
            </MenuItems>
        </transition>
    </Menu>
</template>

<script setup>
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue';
import { ChevronDownIcon } from '@heroicons/vue/20/solid';
import {router} from "@inertiajs/vue3";
import {CheckIcon} from "@heroicons/vue/24/outline/index.js";

const props = defineProps({
    task: Object,
    statuses: Object
});

const statusBackgroundColors = {
    todo: 'bg-zinc-200 text-zinc-700',
    in_progress: 'bg-blue-200 text-blue-900',
    in_review: 'bg-amber-200 text-amber-700',
    done: 'bg-green-200 text-green-800'
};

const updateStatus = (status) => {
    router.patch(route('tasks.update-status', { task: props.task.id, status: status.id }), {}, {
        preserveScroll: true
    });
}
</script>
