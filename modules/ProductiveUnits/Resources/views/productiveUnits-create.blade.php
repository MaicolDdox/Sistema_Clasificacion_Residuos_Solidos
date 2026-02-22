<x-layouts.app :title="__('Nueva Unidad Productiva')">
    <div class="max-w-3xl mx-auto space-y-6">
        <x-ui.page-header
            eyebrow="Catalogo"
            title="Nueva Unidad Productiva"
            subtitle="Completa el formulario para registrar una nueva unidad productiva."
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
            <form action="{{ route('productive-units.store') }}" method="POST" class="space-y-4">
                @csrf

                @include('partials.ui.form.select', [
                    'name' => 'area_id',
                    'label' => 'Area',
                    'required' => true,
                    'placeholder' => 'Seleccione un area',
                    'options' => $areas->pluck('name', 'id')->toArray(),
                    'useOptionKeys' => true,
                ])

                @include('partials.ui.form.input', [
                    'name' => 'name',
                    'label' => 'Nombre de la unidad',
                    'required' => true,
                    'placeholder' => 'Ej: Unidad de Aguacate',
                ])

                @include('partials.ui.form.textarea', [
                    'name' => 'description',
                    'label' => 'Descripcion',
                    'rows' => 4,
                    'placeholder' => 'Descripcion opcional de la unidad productiva',
                ])

                @include('partials.ui.form.select', [
                    'name' => 'waste_type',
                    'label' => 'Tipo de residuo',
                    'required' => true,
                    'placeholder' => 'Seleccione el tipo de residuo',
                    'options' => [
                        'Residuos Solidos' => 'Residuos Solidos (RESOL)',
                        'Residuos Peligrosos' => 'Residuos Peligrosos (RESPEL)',
                        'RESOL/RESPEL' => 'Ambos (RESOL/RESPEL)',
                    ],
                    'help' => 'Selecciona el tipo de residuo que puede manejar esta unidad productiva.',
                ])

                <div class="flex items-center justify-end gap-3 pt-4">
                    <a href="{{ route('productive-units.index') }}" class="px-4 py-2 rounded-lg border border-slate-200 text-slate-700 hover:bg-slate-50 transition">Cancelar</a>
                    @can('productive-units.store')
                        <button type="submit" class="px-4 py-2 rounded-lg bg-emerald-500 text-white hover:bg-emerald-400 transition">Guardar</button>
                    @endcan
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
