<x-layouts.app :title="__('Asignar Rol')">
    <div class="max-w-4xl mx-auto space-y-6">
        <div class="bg-gradient-to-r from-emerald-50 via-white to-cyan-50 border border-emerald-100 rounded-2xl p-4 sm:p-6 shadow-sm">
            <div class="flex items-center gap-4">
                <a href="{{ route('roles.index') }}" class="p-2 hover:bg-white rounded-lg transition-colors">
                    <svg class="w-6 h-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <div class="space-y-1">
                    <p class="inline-flex items-center text-xs font-semibold uppercase tracking-[0.2em] text-emerald-600 bg-emerald-50 rounded-full px-3 py-1">
                        <span class="w-2 h-2 bg-emerald-500 rounded-full mr-2"></span>
                        Asignacion
                    </p>
                    <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 leading-tight">Asignar Rol a Usuario</h1>
                    <p class="text-sm sm:text-base text-slate-500">Selecciona un usuario y asignale un rol en el sistema.</p>
                </div>
            </div>
        </div>

        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-xl p-4">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-red-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div class="flex-1">
                        <h3 class="text-sm font-semibold text-red-800">Errores de validacion</h3>
                        <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif
        <form action="{{ route('roles.store') }}" method="POST" class="bg-white rounded-2xl shadow-sm border border-slate-200 p-4 sm:p-6 space-y-6">
            @csrf
            <div class="space-y-2">
                <label for="user_id" class="block text-sm font-semibold text-slate-700">
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Usuario
                    </span>
                </label>
                <select id="user_id" name="user_id" class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-emerald-200 focus:border-emerald-400 text-slate-700">
                    <option value="">Selecciona un usuario</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
                <p class="text-xs text-slate-500">Selecciona el usuario al que deseas asignar un rol.</p>
            </div>
            <div class="space-y-2">
                <label for="role" class="block text-sm font-semibold text-slate-700">
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        Rol
                    </span>
                </label>
                <select id="role" name="role" class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-emerald-200 focus:border-emerald-400 text-slate-700">
                    <option value="">Selecciona un rol</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>
                            {{ $role->name }}
                        </option>
                    @endforeach
                </select>
                <p class="text-xs text-slate-500">El rol define los permisos del usuario en el sistema.</p>
            </div>
            <div class="flex flex-col sm:flex-row items-center gap-3 pt-4 border-t border-slate-100">
                <button type="submit" class="w-full sm:w-auto flex items-center justify-center gap-2 bg-emerald-500 hover:bg-emerald-400 text-white px-6 py-2.5 rounded-lg font-medium transition-all duration-200 shadow-sm hover:shadow-md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>Asignar Rol</span>
                </button>
                <a href="{{ route('roles.index') }}" class="w-full sm:w-auto flex items-center justify-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 px-6 py-2.5 rounded-lg font-medium transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <span>Cancelar</span>
                </a>
            </div>
        </form>
    </div>
</x-layouts.app>
