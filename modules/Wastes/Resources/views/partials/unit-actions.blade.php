<div
    class="flex items-center gap-2"
    x-data="{
        showRegister: false,
        showView: false,
        goTo(url) { window.location.href = url; }
    }"
>
    <button
        type="button"
        class="inline-flex items-center gap-1 px-3 py-2 rounded-lg bg-emerald-500/90 text-white text-sm font-semibold hover:bg-emerald-400 transition"
        @click="showRegister = true"
    >
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v12m6-6H6"/>
        </svg>
        Registrar residuo
    </button>

    <button
        type="button"
        class="inline-flex items-center gap-1 px-3 py-2 rounded-lg bg-teal-500/90 text-white text-sm font-semibold hover:bg-teal-400 transition"
        @click="showView = true"
    >
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
        </svg>
        Ver residuos
    </button>

    {{-- Modal registrar --}}
    <div
        x-show="showRegister"
        x-transition.opacity
        class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 px-4"
    >
        <div
            class="bg-white rounded-2xl shadow-2xl w-full max-w-md border border-slate-200"
            x-show="showRegister"
            x-transition.scale.origin-center
        >
            <div class="p-6 space-y-4">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-xs uppercase tracking-[0.2em] text-emerald-600 font-semibold">Registrar</p>
                        <h3 class="text-xl font-bold text-slate-900">¿Qué tipo de residuo deseas registrar?</h3>
                        <p class="text-sm text-slate-500 mt-1">Unidad: {{ $unit->name }}</p>
                    </div>
                    <button type="button" class="text-slate-400 hover:text-slate-600" @click="showRegister = false">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="grid grid-cols-1 gap-3">
                    <button
                        type="button"
                        class="w-full px-4 py-3 rounded-xl border border-emerald-200 text-emerald-700 font-semibold hover:bg-emerald-50 transition"
                        @click="goTo('{{ route('wastes.create', ['unit' => $unit->id]) }}')"
                    >
                        Residuo sólido (RESOL)
                    </button>
                    <button
                        type="button"
                        class="w-full px-4 py-3 rounded-xl border border-teal-200 text-teal-700 font-semibold hover:bg-teal-50 transition"
                        @click="goTo('{{ route('hazardou-wastes.create', ['unit' => $unit->id]) }}')"
                    >
                        Residuo peligroso (RESPEL)
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal ver --}}
    <div
        x-show="showView"
        x-transition.opacity
        class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 px-4"
    >
        <div
            class="bg-white rounded-2xl shadow-2xl w-full max-w-md border border-slate-200"
            x-show="showView"
            x-transition.scale.origin-center
        >
            <div class="p-6 space-y-4">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-xs uppercase tracking-[0.2em] text-emerald-600 font-semibold">Ver registros</p>
                        <h3 class="text-xl font-bold text-slate-900">Selecciona el tipo de registros</h3>
                        <p class="text-sm text-slate-500 mt-1">Unidad: {{ $unit->name }}</p>
                    </div>
                    <button type="button" class="text-slate-400 hover:text-slate-600" @click="showView = false">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="grid grid-cols-1 gap-3">
                    <button
                        type="button"
                        class="w-full px-4 py-3 rounded-xl border border-emerald-200 text-emerald-700 font-semibold hover:bg-emerald-50 transition"
                        @click="goTo('{{ route('wastes.byUnit', ['unit' => $unit->id]) }}')"
                    >
                        RESOL
                    </button>
                    <button
                        type="button"
                        class="w-full px-4 py-3 rounded-xl border border-teal-200 text-teal-700 font-semibold hover:bg-teal-50 transition"
                        @click="goTo('{{ route('hazardou-wastes.byUnit', ['unit' => $unit->id]) }}')"
                    >
                        RESPEL
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
