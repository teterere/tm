<template>
    <Menu as="div" class="relative inline-block text-left">
        <MenuButton :class="['inline-flex items-center w-full justify-center gap-x-1 rounded-xs px-3 py-1 text-sm font-medium cursor-pointer']">
            <span :class="['w-4 h-4 rounded-sm', statusBackgroundColors[selectedStatus.key]]"></span>
                <span class="px-1 py-1.5 font-medium uppercase text-xs rounded-xs">
                {{ selectedStatus.title }}
            </span>
        </MenuButton>

        <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
            <MenuItems class="absolute left-0 z-10 mt-2 w-46 origin-top-right rounded-md bg-white ring-1 shadow-lg ring-black/5 focus:outline-hidden">
                <div class="py-1 space-y-1">
                    <MenuItem v-for="status in filteredStatuses" v-slot="{ active }">
                        <button @click="updateStatus(status)" :class="[active ? 'outline-hidden bg-gray-100' : 'text-gray-800', 'flex items-center px-3 py-2 text-sm w-full cursor-pointer text-start']">
                            <span :class="['w-4 h-4 rounded-sm', statusBackgroundColors[status.key]]"></span>
                            <span class="px-3 py-1.5 font-medium uppercase text-xs rounded-xs">
                                {{ status.title }}
                            </span>
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
import {computed, inject, ref} from "vue";

const emit = defineEmits(['update']);

const statuses = inject('statuses');
const task = inject('task', null);

const statusBackgroundColors = {
    todo: 'bg-zinc-300',
    in_progress: 'bg-blue-300',
    in_review: 'bg-amber-300',
    done: 'bg-green-300'
};

const selectedStatus = ref(task?.status || statuses[0]);

const filteredStatuses = computed(() => {
    return statuses.filter(priority => {
        return priority.id !== selectedStatus.value.id;
    });
});

const updateStatus = (status) => {
    if (task) {
        router.patch(route('tasks.update-status', { task: task.id, status: status.id }), {}, {
            preserveScroll: true
        });

        return;
    }

    selectedStatus.value = status;
    emit('update', {field: 'status_id', value: status.id});
};
</script>
