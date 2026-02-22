@php
    $toastEntries = [];

    foreach (['success', 'error', 'info', 'warning'] as $level) {
        $value = session($level);

        if (! $value) {
            continue;
        }

        foreach ((array) $value as $message) {
            if (filled($message)) {
                $toastEntries[] = [
                    'type' => $level,
                    'message' => (string) $message,
                ];
            }
        }
    }
@endphp

@once
    <div
        x-data="window.uiToastStack({ initialToasts: @js($toastEntries) })"
        x-init="init()"
        class="pointer-events-none fixed z-[120] w-full px-4 bottom-4 left-1/2 -translate-x-1/2 sm:top-4 sm:right-4 sm:left-auto sm:bottom-auto sm:translate-x-0 sm:w-auto"
    >
        <div class="flex flex-col gap-3 w-full max-w-md">
            <template x-for="toast in toasts" :key="toast.id">
                <div
                    x-show="true"
                    x-transition.opacity.duration.250ms
                    x-transition.scale.origin.right.duration.250ms
                    class="pointer-events-auto w-full rounded-xl border px-4 py-3 shadow-lg backdrop-blur-sm"
                    :class="toastClass(toast)"
                    role="status"
                    aria-live="polite"
                >
                    <div class="flex items-start justify-between gap-3">
                        <p class="text-sm font-medium leading-snug" x-text="toast.message"></p>
                        <button
                            type="button"
                            class="shrink-0 rounded-md p-1 text-current/70 hover:text-current hover:bg-white/60 transition"
                            @click="dismiss(toast.id)"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            <span class="sr-only">Cerrar notificación</span>
                        </button>
                    </div>
                </div>
            </template>
        </div>
    </div>
@endonce
