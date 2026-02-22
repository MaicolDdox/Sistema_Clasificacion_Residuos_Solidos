<x-layouts.app :title="__('Editar Unidad Productiva')">
    <div class="max-w-3xl mx-auto space-y-6">
        <x-ui.page-header
            eyebrow="Catalogo"
            title="Editar Unidad Productiva"
            subtitle="Modifica la informacion de la unidad productiva seleccionada."
            eyebrowTone="emerald"
        >
            <x-slot:actions>
                <a href="{{ route('productive-units.index') }}" class="px-4 py-2 rounded-lg border border-slate-200 text-slate-700 hover:bg-slate-50 transition text-sm">
                    Volver al listado
                </a>
            </x-slot:actions>
        </x-ui.page-header>

        @include('partials.session-message')

        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
            <form action="{{ route('productive-units.update', $productiveUnit) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                @include('partials.ui.form.select', [
                    'name' => 'area_id',
                    'label' => 'Area',
                    'required' => true,
                    'placeholder' => 'Seleccione un area',
                    'options' => $areas->pluck('name', 'id')->toArray(),
                    'value' => $productiveUnit->area_id,
                    'useOptionKeys' => true,
                ])

                @include('partials.ui.form.input', [
                    'name' => 'name',
                    'label' => 'Nombre de la unidad',
                    'required' => true,
                    'value' => $productiveUnit->name,
                    'placeholder' => 'Ej: Unidad de Aguacate',
                ])

                @include('partials.ui.form.textarea', [
                    'name' => 'description',
                    'label' => 'Descripcion',
                    'value' => $productiveUnit->description,
                    'rows' => 4,
                    'placeholder' => 'Descripcion opcional de la unidad productiva',
                ])

                @include('partials.ui.form.select', [
                    'name' => 'waste_type',
                    'label' => 'Tipo de residuo',
                    'required' => true,
                    'value' => $productiveUnit->waste_type,
                    'placeholder' => 'Seleccione el tipo de residuo',
                    'options' => [
                        'Residuos Solidos' => 'Residuos Solidos (RESOL)',
                        'Residuos Peligrosos' => 'Residuos Peligrosos (RESPEL)',
                        'RESOL/RESPEL' => 'Ambos (RESOL/RESPEL)',
                    ],
                    'help' => 'Selecciona el tipo de residuo que puede manejar esta unidad productiva.',
                ])

                <div class="rounded-xl border border-slate-200 bg-slate-50 p-4 space-y-2">
                    <p class="text-xs uppercase tracking-wide text-slate-500 font-semibold">Informacion del registro</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm text-slate-600">
                        <p><span class="font-medium text-slate-700">Creado:</span> {{ $productiveUnit->created_at?->format('d/m/Y H:i') }}</p>
                        <p><span class="font-medium text-slate-700">Actualizado:</span> {{ $productiveUnit->updated_at?->format('d/m/Y H:i') }}</p>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4">
                    <a href="{{ route('productive-units.index') }}" class="px-4 py-2 rounded-lg border border-slate-200 text-slate-700 hover:bg-slate-50 transition">Cancelar</a>
                    @can('productive-units.update')
                        <button type="submit" class="px-4 py-2 rounded-lg bg-emerald-500 text-white hover:bg-emerald-400 transition">Actualizar</button>
                    @endcan
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
