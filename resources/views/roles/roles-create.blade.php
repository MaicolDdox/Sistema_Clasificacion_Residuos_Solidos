<x-layouts.app :title="__('Asignar Rol')">
    <div class="max-w-3xl mx-auto space-y-6">
        <x-ui.page-header
            eyebrow="Sistema de Roles"
            title="Asignar rol a usuario"
            subtitle="Selecciona un usuario y asigna el rol correspondiente."
            eyebrowTone="emerald"
        >
            <x-slot:actions>
                <a href="{{ route('roles.index') }}" class="px-4 py-2 rounded-lg border border-slate-200 text-slate-700 hover:bg-slate-50 transition text-sm">
                    Volver al listado
                </a>
            </x-slot:actions>
        </x-ui.page-header>

        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
            <form action="{{ route('roles.store') }}" method="POST" class="space-y-4">
                @csrf

                @include('partials.ui.form.select', [
                    'name' => 'user_id',
                    'label' => 'Usuario',
                    'required' => true,
                    'placeholder' => 'Selecciona un usuario',
                    'options' => $users->mapWithKeys(fn ($user) => [
                        $user->id => $user->name.' ('.$user->email.')',
                    ])->toArray(),
                    'help' => 'Selecciona el usuario al que deseas asignar un rol.',
                    'useOptionKeys' => true,
                ])

                @include('partials.ui.form.select', [
                    'name' => 'role',
                    'label' => 'Rol',
                    'required' => true,
                    'placeholder' => 'Selecciona un rol',
                    'options' => $roles->pluck('name', 'name')->toArray(),
                    'help' => 'El rol define los permisos del usuario en el sistema.',
                ])

                <div class="flex items-center justify-end gap-3 pt-4">
                    <a href="{{ route('roles.index') }}" class="px-4 py-2 rounded-lg border border-slate-200 text-slate-700 hover:bg-slate-50 transition">Cancelar</a>
                    <button type="submit" class="px-4 py-2 rounded-lg bg-emerald-500 text-white hover:bg-emerald-400 transition">Asignar rol</button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
