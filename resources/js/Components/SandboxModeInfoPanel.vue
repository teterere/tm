<template>
    <div class="flex justify-center w-full">
        <div v-if="remainingTime" class="w-full bg-white shadow flex justify-center items-center py-4 px-6 mb-4 text-sm font-medium text-gray-800">
            <div class="text-3xl mr-2">🕓</div>
            <p>Demo sesija beigsies pēc <span class="font-bold">{{ remainingTime }}</span>. Visi dati tiks automātiski dzēsti.</p>
        </div>

        <TransitionRoot as="template" :show="showDemoExpiredModal">
            <Dialog class="relative z-50" @close="$emit('close')">
                <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                    <div class="fixed inset-0 bg-gray-500/75 transition-opacity" />
                </TransitionChild>

                <div class="fixed inset-0 z-40 bg-black/10 backdrop-blur-xs">
                    <div class="flex min-h-full items-center justify-center p-4 text-center sm:items-center sm:p-0">
                        <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                            <DialogPanel class="relative transform overflow-hidden rounded bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-xl p-8">
                                <div class="text-center space-y-8">
                                    <div class="text-6xl">🕓</div>

                                    <div class="space-y-4">
                                        <h2 class="text-4xl font-bold">Demo sesija beigusies</h2>

                                        <p class="text-sm italic text-gray-700">Paldies, ka izmēģināji!</p>

                                        <p class="text-gray-700 py-2">
                                            Tava demo sesija ir beigusies un visi testa dati tika automātiski izdzēsti.<br />
                                            Ja vēlies, vari sākt jaunu sesiju vai uzzināt vairāk par projektu un tā izstrādātāju.
                                        </p>
                                    </div>

                                    <div class="w-2/3 mx-auto space-y-4 pb-4">
                                        <SecondaryButton size="xl" class="w-full justify-center">
                                            Par projektu
                                        </SecondaryButton>
                                        <SecondaryButton size="xl" class="w-full justify-center">
                                            Par izstrādātāju
                                        </SecondaryButton>
                                        <PrimaryButton @click="openDemo" size="xl" class="w-full justify-center">
                                            Izveidot jaunu demo sesiju
                                        </PrimaryButton>
                                    </div>
                                </div>
                            </DialogPanel>
                        </TransitionChild>
                    </div>
                </div>
            </Dialog>
        </TransitionRoot>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import {router, usePage} from '@inertiajs/vue3'
import {Dialog, DialogPanel, TransitionChild, TransitionRoot} from "@headlessui/vue";
import PrimaryButton from "@/Components/shared/Buttons/PrimaryButton.vue";
import SecondaryButton from "@/Components/shared/Buttons/SecondaryButton.vue";

const sandboxExpiresAt = usePage().props.sandbox_expires_at
const remainingTime = ref(null)
const showDemoExpiredModal = ref(false)

onMounted(() => {
    if (!sandboxExpiresAt) return

    const updateCountdown = () => {
        const now = Math.floor(Date.now() / 1000)
        const secondsLeft = sandboxExpiresAt - now

        if (secondsLeft <= 0) {
            remainingTime.value = '00:00'
            showDemoExpiredModal.value = true

            return
        }

        const minutes = Math.floor(secondsLeft / 60)
        const seconds = secondsLeft % 60

        remainingTime.value = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`
    }

    updateCountdown()
    setInterval(updateCountdown, 1000)
});

const openDemo = () => {
    router.visit(route('demo.login'), {
        method: 'post',
        onSuccess: () => {
            showDemoExpiredModal.value = false;
        }
    });
}
</script>

