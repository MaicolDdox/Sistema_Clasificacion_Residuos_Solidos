<x-layouts.app :title="__('Detalle RESOL #'.$waste->id)">
    @php
        $canEdit = (Auth::user()->hasRole('Aprendiz') && $waste->user_id === Auth::id())
            || (!Auth::user()->hasRole('Aprendiz') && Auth::user()->can('wastes.edit'));
    @endphp

    <div class="max-w-4xl mx-auto space-y-6">
        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
            <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-emerald-600 font-semibold">RESOL</p>
                    <h1 class="text-2xl font-bold text-slate-900">Detalle del registro #{{ $waste->id }}</h1>
                    <p class="text-sm text-slate-500">Consulta detallada del residuo sólido registrado.</p>
                </div>
                <div class="flex items-center gap-2">
                    @if($canEdit)
                        <a href="{{ route('wastes.edit', $waste) }}" class="px-4 py-2 rounded-lg bg-amber-500 text-white text-sm font-semibold hover:bg-amber-400 transition">
                            Editar
                        </a>
                    @endif
                    <a href="{{ route('wastes.byUnit', ['unit' => $waste->productive_unit_id]) }}" class="px-4 py-2 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50 transition text-sm">
                        Volver al listado
                    </a>
                </div>
            </div>
        </div>

        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 space-y-5">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-xs uppercase tracking-wide text-slate-400">Fecha de entrada</p>
                    <p class="text-slate-800 font-semibold">{{ optional($waste->entry_date)->format('d/m/Y H:i') }}</p>
                </div>
                <div>
                    <p class="text-xs uppercase tracking-wide text-slate-400">Unidad productiva</p>
                    <p class="text-slate-800 font-semibold">{{ $waste->productiveUnit?->name ?? 'Sin unidad' }}</p>
                </div>
                <div>
                    <p class="text-xs uppercase tracking-wide text-slate-400">Tipo de residuo</p>
                    <p class="text-slate-800 font-semibold">{{ $waste->waste_type }}</p>
                </div>
                <div>
                    <p class="text-xs uppercase tracking-wide text-slate-400">Cantidad</p>
                    <p class="text-slate-800 font-semibold">{{ $waste->amount }}</p>
                </div>
                <div>
                    <p class="text-xs uppercase tracking-wide text-slate-400">Responsable</p>
                    <p class="text-slate-800 font-semibold">{{ $waste->user?->name ?? 'Sin usuario' }}</p>
                </div>
                <div>
                    <p class="text-xs uppercase tracking-wide text-slate-400">Registrado el</p>
                    <p class="text-slate-800 font-semibold">{{ optional($waste->created_at)->format('d/m/Y H:i') }}</p>
                </div>
            </div>

            <div>
                <p class="text-xs uppercase tracking-wide text-slate-400">Observaciones</p>
                <p class="text-slate-700">{{ $waste->observations ?: 'Sin observaciones' }}</p>
            </div>

            @if($waste->evidence_image)
                <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                    <p class="text-xs uppercase tracking-wide text-slate-400 mb-2">Evidencia registrada</p>
                    <img
                        src="{{ \Illuminate\Support\Facades\Storage::url($waste->evidence_image) }}"
                        alt="Evidencia RESOL"
                        class="w-full max-w-sm rounded-lg border border-slate-200 object-cover"
                    >
                </div>
            @endif
        </div>
    </div>

    @include('partials.footer-script-cdn')
</x-layouts.app>
