<x-layouts.app :title="__('Asignar Rol')">
    <div class="max-w-3xl mx-auto space-y-6">
        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
            <h1 class="text-2xl font-bold text-slate-900 mb-1">Asignar rol a usuario</h1>
            <p class="text-sm text-slate-500 mb-4">Selecciona un usuario y asigna el rol correspondiente.</p>

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
