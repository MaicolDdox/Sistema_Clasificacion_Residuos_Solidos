<x-layouts.app :title="__('Acceso denegado')">
    <div class="max-w-2xl mx-auto mt-8 space-y-6">

        <div class="bg-white border border-slate-200 rounded-2xl p-8 shadow-sm text-center space-y-5">

            {{-- Icono --}}
            <div class="mx-auto w-16 h-16 rounded-2xl bg-red-50 border border-red-100 flex items-center justify-center">
                <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                </svg>
            </div>

            {{-- Código y título --}}
            <div>
                <p class="text-xs font-semibold uppercase tracking-widest text-red-400 mb-1">HTTP 403 - NO AUTORIZADO</p>
                <h1 class="text-2xl font-bold text-slate-900">Sin permisos de acceso</h1>
                <p class="text-sm text-slate-500 mt-1">Sistema de Clasificación de Residuos — SCR</p>
            </div>

            {{-- Mensaje --}}
            <div class="rounded-xl border border-red-100 bg-red-50 px-5 py-4 text-left space-y-2">
                <p class="text-sm font-semibold text-red-800">Tu cuenta no tiene acceso a este recurso</p>
                <p class="text-sm text-red-700 leading-relaxed">
                    El rol asignado a tu cuenta no cuenta con los permisos necesarios para acceder a esta
                    sección o realizar esta acción dentro del sistema.
                </p>
                <p class="text-sm text-red-700 leading-relaxed">
                    Si crees que esto es un error, contacta a las <span class="font-semibold">Gestora Ambiental</span>
                    para revisar los permisos de tu cuenta.
                </p>
            </div>

            {{-- Botón volver --}}
            <div class="pt-2">
                <a
                    href="{{ route('dashboard') }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-emerald-500 text-white text-sm font-medium hover:bg-emerald-400 transition-colors duration-200"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Volver al Dashboard
                </a>
            </div>

        </div>

    </div>
</x-layouts.app>
