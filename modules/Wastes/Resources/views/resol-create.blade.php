<x-layouts.app :title="__('Registrar residuo sólido')">
    <div class="max-w-3xl mx-auto space-y-6">
        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
            <h1 class="text-2xl font-bold text-slate-900 mb-1">Registrar residuo sólido (RESOL)</h1>
            <p class="text-sm text-slate-500 mb-4">Unidad productiva: <span class="font-semibold text-slate-800">{{ $unit->name }}</span></p>

            <form action="{{ route('wastes.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <input type="hidden" name="productive_unit_id" value="{{ $unit->id }}">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @include('partials.ui.form.input', [
                        'name' => 'entry_date',
                        'label' => 'Fecha y hora de entrada',
                        'type' => 'datetime-local',
                        'required' => true,
                    ])

                    @include('partials.ui.form.select', [
                        'name' => 'waste_type',
                        'label' => 'Tipo de residuo',
                        'required' => true,
                        'options' => [
                            'Residuo Organico' => 'Residuo Organico',
                            'Residuo Ordinarios' => 'Residuo Ordinarios',
                            'Residuo Reciclables' => 'Residuo Reciclables',
                        ],
                    ])
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @include('partials.ui.form.input', [
                        'name' => 'amount',
                        'label' => 'Cantidad',
                        'type' => 'number',
                        'required' => true,
                        'min' => 1,
                    ])
                </div>

                @include('partials.ui.form.textarea', [
                    'name' => 'observations',
                    'label' => 'Observaciones',
                    'rows' => 3,
                ])

                @include('partials.ui.form.input', [
                    'name' => 'evidence_image',
                    'label' => 'Imagen de evidencia (opcional)',
                    'type' => 'file',
                    'accept' => '.jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp',
                    'help' => 'Formatos permitidos: JPG, JPEG, PNG, WEBP. Tamaño máximo: 5 MB.',
                ])

                <div class="flex items-center justify-end gap-3 pt-4">
                    <a href="{{ route('wastes.byUnit', ['unit' => $unit->id]) }}" class="px-4 py-2 rounded-lg border border-slate-200 text-slate-700 hover:bg-slate-50 transition">Cancelar</a>
                    <button type="submit" class="px-4 py-2 rounded-lg bg-emerald-500 text-white hover:bg-emerald-400 transition">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    @include('partials.footer-script-cdn')
</x-layouts.app>
