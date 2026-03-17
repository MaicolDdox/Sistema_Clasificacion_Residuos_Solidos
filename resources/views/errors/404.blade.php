<x-layouts.error :title="__('Página no encontrada')">
    <div class="max-w-2xl w-full mx-auto">

        <div class="bg-white border border-slate-200 rounded-2xl p-8 shadow-sm text-center space-y-5">

            {{-- Icono --}}
            <div class="mx-auto w-16 h-16 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-center">
                <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>

            {{-- Código y título --}}
            <div>
                <p class="text-xs font-semibold uppercase tracking-widest text-slate-400 mb-1">HTTP 404 - NO ENCONTRADO</p>
                <h1 class="text-2xl font-bold text-slate-900">Página no encontrada</h1>
                <p class="text-sm text-slate-500 mt-1">Sistema de Clasificación de Residuos — SCR</p>
            </div>

            {{-- Mensaje --}}
            <div class="rounded-xl border border-slate-100 bg-slate-50 px-5 py-4 text-left space-y-2">
                <p class="text-sm font-semibold text-slate-700">El recurso que buscas no existe</p>
                <p class="text-sm text-slate-600 leading-relaxed">
                    La ruta o recurso al que intentas acceder no existe en el sistema.
                    Puede que haya sido eliminado, movido o que la URL sea incorrecta.
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
</x-layouts.error>
