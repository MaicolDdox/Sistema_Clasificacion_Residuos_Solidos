<x-layouts.app :title="__('Registrar residuo peligroso')">
    <div class="max-w-3xl mx-auto space-y-6">
        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
            <h1 class="text-2xl font-bold text-slate-900 mb-1">Registrar residuo peligroso (RESPEL)</h1>
            <p class="text-sm text-slate-500 mb-4">Unidad productiva: <span class="font-semibold text-slate-800">{{ $unit->name }}</span></p>

            <form action="{{ route('hazardou-wastes.store') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="productive_unit_id" value="{{ $unit->id }}">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-slate-700">Fecha y hora de entrada</label>
                        <input
                            type="datetime-local"
                            name="entry_date"
                            required
                            value="{{ old('entry_date') }}"
                            class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-200 focus:border-emerald-400"
                        >
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-slate-700">Tipo de residuo</label>
                        <select
                            name="waste_type"
                            required
                            class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-200 focus:border-emerald-400"
                        >
                            <option value="">Seleccione...</option>
                            @foreach(['Residuo Quimico','Residuo Biologico','Residuo Organico Peligroso'] as $type)
                                <option value="{{ $type }}" @selected(old('waste_type') === $type)>{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-slate-700">Cantidad</label>
                        <input
                            type="number"
                            min="1"
                            name="amount"
                            required
                            value="{{ old('amount') }}"
                            class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-200 focus:border-emerald-400"
                        >
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-medium text-slate-700">Observaciones</label>
                    <textarea
                        name="observations"
                        rows="3"
                        class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-200 focus:border-emerald-400"
                    >{{ old('observations') }}</textarea>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4">
                    <a href="{{ route('hazardou-wastes.byUnit', ['unit' => $unit->id]) }}" class="px-4 py-2 rounded-lg border border-slate-200 text-slate-700 hover:bg-slate-50 transition">Cancelar</a>
                    <button type="submit" class="px-4 py-2 rounded-lg bg-emerald-500 text-white hover:bg-emerald-400 transition">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    @include('partials.footer-script-cdn')
</x-layouts.app>
