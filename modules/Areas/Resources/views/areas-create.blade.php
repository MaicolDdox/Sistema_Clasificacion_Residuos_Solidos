<x-layouts.app :title="__('Nueva Área')">
    <div class="max-w-3xl mx-auto space-y-6">
        <x-ui.page-header
            eyebrow="Catalogo"
            title="Nueva Area"
            subtitle="Completa el formulario para registrar una nueva area en el sistema."
            eyebrowTone="emerald"
        >
            <x-slot:actions>
                <a href="{{ route('areas.index') }}" class="px-4 py-2 rounded-lg border border-slate-200 text-slate-700 hover:bg-slate-50 transition text-sm">
                    Volver al listado
                </a>
            </x-slot:actions>
        </x-ui.page-header>

        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
            <form action="{{ route('areas.store') }}" method="POST" class="space-y-4">
                @csrf

                @include('partials.ui.form.input', [
                    'name' => 'name',
                    'label' => 'Nombre del área',
                    'required' => true,
                    'placeholder' => 'Ej: Área de Producción',
                ])

                @include('partials.ui.form.textarea', [
                    'name' => 'description',
                    'label' => 'Descripción',
                    'rows' => 4,
                    'placeholder' => 'Describe brevemente el propósito y función del área...',
                    'help' => 'Máximo 1000 caracteres.',
                ])

                <div class="flex items-center justify-end gap-3 pt-4">
                    <a href="{{ route('areas.index') }}" class="px-4 py-2 rounded-lg border border-slate-200 text-slate-700 hover:bg-slate-50 transition">Cancelar</a>
                    <button type="submit" class="px-4 py-2 rounded-lg bg-emerald-500 text-white hover:bg-emerald-400 transition">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
