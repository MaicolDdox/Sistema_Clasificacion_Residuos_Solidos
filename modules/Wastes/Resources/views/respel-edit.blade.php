<x-layouts.app :title="__('Editar residuo peligroso')">
    <div class="max-w-3xl mx-auto space-y-6">
        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
            <h1 class="text-2xl font-bold text-slate-900 mb-1">Editar residuo peligroso (RESPEL)</h1>
            <p class="text-sm text-slate-500 mb-4">Unidad productiva: <span class="font-semibold text-slate-800">{{ $unit->name }}</span></p>

            <form action="{{ route('hazardou-wastes.update', $hazardouWaste) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-slate-700">Fecha y hora de entrada</label>
                        <input
                            type="datetime-local"
                            name="entry_date"
                            required
                            value="{{ old('entry_date', optional($hazardouWaste->entry_date)->format('Y-m-d\TH:i')) }}"
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
                                <option value="{{ $type }}" @selected(old('waste_type', $hazardouWaste->waste_type) === $type)>{{ $type }}</option>
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
                            value="{{ old('amount', $hazardouWaste->amount) }}"
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
                    >{{ old('observations', $hazardouWaste->observations) }}</textarea>
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-medium text-slate-700">Imagen de evidencia (opcional)</label>
                    <input
                        type="file"
                        name="evidence_image"
                        accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                        class="w-full rounded-lg border @error('evidence_image') border-red-300 focus:ring-red-200 focus:border-red-400 @else border-slate-200 focus:ring-2 focus:ring-emerald-200 focus:border-emerald-400 @enderror px-3 py-2 text-sm bg-white"
                    >
                    <p class="text-xs text-slate-400">Formatos permitidos: JPG, JPEG, PNG, WEBP. Tamaño máximo: 5 MB.</p>
                    @error('evidence_image')
                        <p class="text-sm text-red-600 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                @if ($hazardouWaste->evidence_image)
                    <div class="rounded-xl border border-slate-200 bg-slate-50 p-4 space-y-3">
                        <div class="flex items-center justify-between gap-3">
                            <p class="text-sm font-medium text-slate-700">Imagen de evidencia actual</p>
                            <a
                                href="{{ \Illuminate\Support\Facades\Storage::url($hazardouWaste->evidence_image) }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="text-sm text-emerald-600 hover:text-emerald-500 font-medium"
                            >
                                Ver imagen actual
                            </a>
                        </div>
                        <img
                            src="{{ \Illuminate\Support\Facades\Storage::url($hazardouWaste->evidence_image) }}"
                            alt="Imagen de evidencia RESPEL"
                            class="w-full max-w-xs rounded-lg border border-slate-200 object-cover"
                        >
                    </div>
                @endif

                <div class="flex items-center justify-end gap-3 pt-4">
                    <a href="{{ route('hazardou-wastes.byUnit', ['unit' => $unit->id]) }}" class="px-4 py-2 rounded-lg border border-slate-200 text-slate-700 hover:bg-slate-50 transition">Cancelar</a>
                    <button type="submit" class="px-4 py-2 rounded-lg bg-emerald-500 text-white hover:bg-emerald-400 transition">Actualizar</button>
                </div>
            </form>
        </div>
    </div>

    @include('partials.footer-script-cdn')
</x-layouts.app>
