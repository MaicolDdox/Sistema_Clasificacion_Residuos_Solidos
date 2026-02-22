@props([
    'modalId' => 'global-confirm-modal',
    'title' => 'Confirmar acción',
    'message' => '¿Deseas continuar con esta operación?',
    'confirmButtonText' => 'Confirmar',
    'formId' => null,
])

<div
    x-data="window.uiConfirmModal({
        modalId: @js($modalId),
        title: @js($title),
        message: @js($message),
        confirmButtonText: @js($confirmButtonText),
        formId: @js($formId),
    })"
    x-init="init()"
    x-on:keydown.window="if (isOpen) handleDialogKeydown($event)"
>
    <div
        x-cloak
        x-show="isOpen"
        x-transition.opacity
        class="fixed inset-0 z-[110] bg-slate-900/60 flex items-center justify-center px-4"
        @click.self="close()"
    >
        <div
            x-ref="dialog"
            role="dialog"
            aria-modal="true"
            :aria-labelledby="`${modalId}-title`"
            :aria-describedby="`${modalId}-message`"
            class="bg-white rounded-2xl shadow-2xl w-full max-w-md border border-slate-200"
            x-show="isOpen"
            x-transition.scale.origin-center
            @click.stop
        >
            <div class="p-6 space-y-4">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900" :id="`${modalId}-title`" x-text="title"></h3>
                        <p class="text-sm text-slate-500 mt-1" :id="`${modalId}-message`" x-text="message"></p>
                    </div>
                    <button
                        type="button"
                        class="text-slate-400 hover:text-slate-600 transition"
                        @click="close()"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        <span class="sr-only">Cerrar</span>
                    </button>
                </div>

                <div class="flex items-center justify-end gap-3">
                    <button
                        type="button"
                        class="inline-flex items-center justify-center rounded-lg border border-slate-200 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50 transition"
                        x-show="!hideCancel"
                        @click="close()"
                    >
                        <span x-text="cancelButtonText"></span>
                    </button>
                    <button
                        x-ref="confirmButton"
                        type="button"
                        class="inline-flex items-center justify-center rounded-lg px-4 py-2 text-sm font-medium transition"
                        :class="confirmButtonClass()"
                        @click="confirm()"
                    >
                        <span x-text="confirmButtonText"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
