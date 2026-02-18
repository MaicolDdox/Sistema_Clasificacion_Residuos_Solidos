<x-layouts.app :title="__('Editar Rol')">
    <div class="max-w-3xl mx-auto space-y-6">
        <x-ui.page-header
            eyebrow="Sistema de Roles"
            title="Editar rol de usuario"
            subtitle="Modifica el rol asignado al usuario seleccionado."
            eyebrowTone="emerald"
        >
            <x-slot:actions>
                <a href="{{ route('roles.index') }}" class="px-4 py-2 rounded-lg border border-slate-200 text-slate-700 hover:bg-slate-50 transition text-sm">
                    Volver al listado
                </a>
            </x-slot:actions>
        </x-ui.page-header>

        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
            <div class="rounded-xl border border-slate-200 bg-slate-50 p-4 space-y-1">
                <p class="text-xs uppercase tracking-wide text-slate-500 font-semibold">Usuario</p>
                <p class="text-sm font-semibold text-slate-900">{{ $user->name }}</p>
                <p class="text-xs text-slate-500">{{ $user->email }}</p>
            </div>

            <form action="{{ route('roles.update', $user->id) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                @include('partials.ui.form.select', [
                    'name' => 'role',
                    'label' => 'Nuevo rol',
                    'required' => true,
                    'placeholder' => 'Selecciona un rol',
                    'options' => $roles->pluck('name', 'name')->toArray(),
                    'value' => $currentRole?->name,
                    'help' => $currentRole
                        ? 'Rol actual: '.$currentRole->name
                        : 'Este usuario no tiene ningún rol asignado.',
                ])

                <div class="flex items-center justify-end gap-3 pt-4">
                    <a href="{{ route('roles.index') }}" class="px-4 py-2 rounded-lg border border-slate-200 text-slate-700 hover:bg-slate-50 transition">Cancelar</a>
                    <button type="submit" class="px-4 py-2 rounded-lg bg-emerald-500 text-white hover:bg-emerald-400 transition">Actualizar rol</button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
