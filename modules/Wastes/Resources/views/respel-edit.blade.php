<x-layouts.app :title="__('Editar residuo peligroso')">
    <div class="max-w-3xl mx-auto space-y-6">
        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
            <h1 class="text-2xl font-bold text-slate-900 mb-1">Editar residuo peligroso (RESPEL)</h1>
            <p class="text-sm text-slate-500 mb-4">Unidad productiva: <span class="font-semibold text-slate-800">{{ $unit->name }}</span></p>

            <form action="{{ route('hazardou-wastes.update', $hazardouWaste) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @include('partials.ui.form.input', [
                        'name' => 'entry_date',
                        'label' => 'Fecha y hora de entrada',
                        'type' => 'datetime-local',
                        'required' => true,
                        'value' => optional($hazardouWaste->entry_date)->format('Y-m-d\TH:i'),
                    ])

                    @include('partials.ui.form.select', [
                        'name' => 'waste_type',
                        'label' => 'Tipo de residuo',
                        'required' => true,
                        'value' => $hazardouWaste->waste_type,
                        'options' => [
                            'Residuo Quimico' => 'Residuo Quimico',
                            'Residuo Biologico' => 'Residuo Biologico',
                            'Residuo Organico Peligroso' => 'Residuo Organico Peligroso',
                        ],
                    ])
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @include('partials.ui.form.input', [
                        'name' => 'amount',
                        'label' => 'Cantidad (kg)',
                        'type' => 'number',
                        'required' => true,
                        'value' => $hazardouWaste->amount,
                        'min' => 0.01,
                        'step' => '0.01',
                        'placeholder' => 'Ej: 50.20, min: 1.00',
                    ])
                </div>

                @include('partials.ui.form.textarea', [
                    'name' => 'observations',
                    'label' => 'Observaciones',
                    'rows' => 3,
                    'value' => $hazardouWaste->observations,
                ])

                @include('partials.ui.form.input', [
                    'name' => 'evidence_image',
                    'label' => 'Imagen de evidencia (opcional)',
                    'type' => 'file',
                    'accept' => '.jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp',
                    'help' => 'Formatos permitidos: JPG, JPEG, PNG, WEBP. Tamaño máximo: 5 MB.',
                ])

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
