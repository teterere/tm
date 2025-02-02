<template>
    <Menu as="div" class="relative inline-block pl-6">
        <MenuButton class="bg-gray-100 hover:bg-gray-200 rounded-sm p-1 cursor-pointer">
            <EllipsisHorizontalIcon class="w-3 h-3" />
        </MenuButton>

        <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
            <MenuItems class="absolute right-0 z-10 mt-2 w-52 origin-top-right rounded-md bg-white ring-1 shadow-lg ring-black/5 focus:outline-hidden py-1">
                <MenuItem @click="deleteAllChecklistItemsForTask" v-slot="{ active }">
                    <button :class="[active ? 'bg-gray-100 text-gray-900 outline-hidden' : 'text-gray-700', 'flex w-full items-center cursor-pointer px-4 py-2 text-sm']">
                        <TrashIcon class="w-4 h-4 text-rose-900 mr-2" />
                        <span>Dzēst visus ierakstus</span>
                    </button>
                </MenuItem>
            </MenuItems>
        </transition>
    </Menu>
</template>

<script setup>
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import {EllipsisHorizontalIcon, TrashIcon} from "@heroicons/vue/24/outline";
import {router} from "@inertiajs/vue3";

const props = defineProps({
    task: Object
});

const deleteAllChecklistItemsForTask = () => {
    router.delete(route('tasks.checklist-items.delete-all-for-task', { task: props.task.id }), {
        preserveScroll: true
    });
};
</script>
