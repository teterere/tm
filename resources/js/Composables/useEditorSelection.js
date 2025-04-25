import { ref, watch, onBeforeUnmount } from 'vue'

export function useEditorSelection(editor) {
    const lastSelection = ref(null)
    const disposables = []

    const stop = watch(
        () => editor,
        (instance) => {
            if (!instance) return

            const offSelection = instance.on('selectionUpdate', ({ editor }) => {
                lastSelection.value = editor.state.selection
            })

            const offBlur = instance.on('blur', ({ editor }) => {
                lastSelection.value = editor.state.selection
            })

            disposables.push(offSelection, offBlur)
        },
        { immediate: true }
    )

    onBeforeUnmount(() => {
        stop()
        disposables.forEach((off) => off())
    })

    function restore() {
        if (!editor || !lastSelection.value) return

        const tr = editor.state.tr.setSelection(lastSelection.value)
        editor.view.dispatch(tr)
    }

    return {
        lastSelection,
        restore
    }
}
