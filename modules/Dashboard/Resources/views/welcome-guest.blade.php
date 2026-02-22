<x-layouts.app :title="__('Bienvenido')">
    <div class="max-w-2xl mx-auto mt-8 space-y-6">

        {{-- Card principal --}}
        <div class="bg-white border border-slate-200 rounded-2xl p-8 shadow-sm text-center space-y-4">

            {{-- Icono --}}
            <div class="mx-auto w-16 h-16 rounded-2xl bg-amber-50 border border-amber-100 flex items-center justify-center">
                <svg class="w-8 h-8 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>


            <div>
                <h1 class="text-2xl font-bold text-slate-900">
                    Bienvenido, {{ auth()->user()->name }}
                </h1>
                <p class="text-sm text-slate-500 mt-1">Sistema de Clasificación de Residuos — SCR</p>
            </div>

            {{-- Mensaje de estado --}}
            <div class="rounded-xl border border-amber-200 bg-amber-50 px-5 py-4 text-left space-y-2">
                <p class="text-sm font-semibold text-amber-800">Tu cuenta está pendiente de activación</p>
                <p class="text-sm text-amber-700 leading-relaxed">
                    Actualmente tienes el rol de <span class="font-semibold">Invitado</span>. Esto significa que aún no tienes
                    acceso a los módulos del sistema (Áreas, Unidades Productivas y Residuos).
                </p>
                <p class="text-sm text-amber-700 leading-relaxed">
                    Contacta a la <span class="font-semibold">Gestora Ambiental</span> para que te asigne el rol correspondiente
                    y puedas comenzar a trabajar en el sistema.
                </p>
            </div>

            {{-- Acceso al perfil --}}
            <p class="text-xs text-slate-400">
                Mientras tanto, puedes revisar y actualizar tu
                <a href="{{ route('profile.edit') }}" class="text-emerald-600 hover:text-emerald-500 font-medium underline underline-offset-2">
                    información de perfil
                </a>.
            </p>
        </div>

    </div>
</x-layouts.app>
