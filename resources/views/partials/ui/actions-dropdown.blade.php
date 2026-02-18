@props([
    'id',
    'actions' => [],
])

@php
    $menuActions = collect($actions)->values()->all();
@endphp

<div
    class="inline-flex justify-center w-full"
    x-data="window.uiActionsDropdown({ id: @js($id), actions: @js($menuActions) })"
>
    <button
        x-ref="trigger"
        type="button"
        class="inline-flex items-center justify-center w-9 h-9 rounded-lg border border-slate-200 bg-white text-slate-600 hover:bg-slate-50 transition disabled:opacity-60 disabled:cursor-not-allowed"
        :disabled="!hasActions()"
        :title="triggerTitle()"
        aria-haspopup="true"
        :aria-expanded="isOpen.toString()"
        :aria-controls="menuId"
        @click.prevent="toggleMenu()"
        @keydown="handleTriggerKeydown($event)"
    >
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5h.01M12 12h.01M12 19h.01" />
        </svg>
        <span class="sr-only">Acciones</span>
    </button>

    <div
        x-cloak
        x-show="isOpen"
        x-transition.origin.top.right
        x-ref="menu"
        :id="menuId"
        role="menu"
        class="fixed z-[95] w-[calc(100vw-1.5rem)] max-w-56 sm:w-56 rounded-xl border border-slate-200 bg-white shadow-xl py-1 text-left"
        :style="menuStyle()"
        @click.outside="closeMenu(false)"
        @keydown="handleMenuKeydown($event)"
    >
        <template x-for="(action, index) in normalizedActions" :key="action.key">
            <button
                type="button"
                data-menu-item
                role="menuitem"
                class="outline-none"
                :disabled="action.disabled"
                :aria-disabled="action.disabled.toString()"
                :title="action.disabledReason || action.label"
                :class="actionClass(action)"
                @click.prevent="runAction(action)"
                @focus="activeIndex = index"
            >
                <span class="truncate" x-text="action.label"></span>
            </button>
        </template>
    </div>
</div>
