<template>
    <Menu as="div" class="relative inline-block text-left">
        <MenuButton :class="['inline-flex w-full justify-center gap-x-1.5 rounded-xs py-1 text-sm font-medium cursor-pointer']">
            <TaskPriorityLabel :priority="task.priority" />
        </MenuButton>

        <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
            <MenuItems class="absolute left-0 z-10 mt-2 w-32 origin-top-right rounded-md bg-white ring-1 shadow-lg ring-black/5 focus:outline-hidden">
                <div class="py-1 space-y-1">
                    <MenuItem v-for="priority in priorities" v-slot="{ active }">
                        <button @click="updatePriority(priority)" :class="[active ? 'outline-hidden bg-gray-100' : 'text-gray-700', 'flex items-center justify-between px-3 py-2 text-sm w-full cursor-pointer text-start']">
                            <TaskPriorityLabel :priority="priority" />
                            <CheckIcon v-if="task.priority.id === priority.id" class="w-4 h-4 text-green-600" />
                        </button>
                    </MenuItem>
                </div>
            </MenuItems>
        </transition>
    </Menu>
</template>

<script setup>
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue';
import {router} from "@inertiajs/vue3";
import TaskPriorityLabel from "@/Components/Task/TaskPriority/TaskPriorityLabel.vue";
import {CheckIcon} from "@heroicons/vue/24/outline";

const props = defineProps({
    task: Object,
    priorities: Object
});

const updatePriority = (priority) => {
    router.patch(route('tasks.update-priority', { task: props.task.id, priority: priority.id }), {}, {
        preserveScroll: true
    });
}
</script>
