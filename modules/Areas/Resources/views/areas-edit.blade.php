<x-layouts.app :title="__('Editar Área')">
    <div class="max-w-3xl mx-auto space-y-6">
        <x-ui.page-header
            eyebrow="Catalogo"
            title="Editar Area"
            subtitle="Modifica la informacion del area seleccionada."
            eyebrowTone="emerald"
        >
            <x-slot:actions>
                <a href="{{ route('areas.index') }}" class="px-4 py-2 rounded-lg border border-slate-200 text-slate-700 hover:bg-slate-50 transition text-sm">
                    Volver al listado
                </a>
            </x-slot:actions>
        </x-ui.page-header>

        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
            <form action="{{ route('areas.update', $area) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                @include('partials.ui.form.input', [
                    'name' => 'name',
                    'label' => 'Nombre del área',
                    'required' => true,
                    'value' => $area->name,
                    'placeholder' => 'Ej: Área de Producción',
                ])

                @include('partials.ui.form.textarea', [
                    'name' => 'description',
                    'label' => 'Descripción',
                    'value' => $area->description,
                    'rows' => 4,
                    'placeholder' => 'Describe brevemente el propósito y función del área...',
                    'help' => 'Máximo 1000 caracteres.',
                ])

                <div class="rounded-xl border border-slate-200 bg-slate-50 p-4 space-y-2">
                    <p class="text-xs uppercase tracking-wide text-slate-500 font-semibold">Información del registro</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm text-slate-600">
                        <p><span class="font-medium text-slate-700">Creado:</span> {{ $area->created_at->format('d/m/Y H:i') }}</p>
                        <p><span class="font-medium text-slate-700">Actualizado:</span> {{ $area->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4">
                    <a href="{{ route('areas.index') }}" class="px-4 py-2 rounded-lg border border-slate-200 text-slate-700 hover:bg-slate-50 transition">Cancelar</a>
                    <button type="submit" class="px-4 py-2 rounded-lg bg-emerald-500 text-white hover:bg-emerald-400 transition">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
