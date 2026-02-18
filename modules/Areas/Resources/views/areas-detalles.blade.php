<x-layouts.app :title="__('Detalles del Área')">

    {{-- Contenedor principal --}}
    <div class="max-w-4xl mx-auto space-y-4 md:space-y-6 px-4 sm:px-6 lg:px-8">

        {{-- Encabezado --}}
        <div class="bg-gradient-to-r from-blue-50 via-white to-indigo-50 border border-blue-100 rounded-xl md:rounded-2xl p-4 md:p-6 shadow-sm">
            <div class="flex flex-col gap-3 md:gap-4 md:flex-row md:items-center md:justify-between">
                <div class="space-y-2">
                    <p class="inline-flex items-center text-xs font-semibold uppercase tracking-[0.2em] text-blue-600 bg-blue-50 rounded-full px-3 py-1">
                        <span class="w-2 h-2 bg-blue-500 rounded-full mr-2"></span>
                        Detalles
                    </p>
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-slate-900 leading-tight">Detalles del Área</h1>
                        <p class="text-sm md:text-base text-slate-500">Información completa del área seleccionada.</p>
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 md:gap-3">
                    <a href="{{ route('areas.edit', $area) }}"
                       class="inline-flex items-center justify-center gap-2 bg-amber-500 hover:bg-amber-600 text-white px-4 py-2.5 rounded-xl font-medium transition-all duration-200 shadow-sm hover:shadow-md whitespace-nowrap text-sm md:text-base">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        <span>Editar</span>
                    </a>
                    <a href="{{ route('areas.index') }}"
                       class="inline-flex items-center justify-center gap-2 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 px-4 py-2.5 rounded-xl font-medium transition-all duration-200 shadow-sm hover:shadow-md whitespace-nowrap text-sm md:text-base">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        <span>Volver</span>
                    </a>
                </div>
            </div>
        </div>

        {{-- Tarjeta de información principal --}}
        <div class="bg-white border border-slate-200 rounded-xl md:rounded-2xl shadow-sm p-4 md:p-6">
            <div class="space-y-4 md:space-y-6">
                {{-- Nombre --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Nombre del Área
                    </label>
                    <p class="text-base md:text-lg font-semibold text-slate-800 break-words">{{ $area->name }}</p>
                </div>

                {{-- Descripción --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Descripción
                    </label>
                    <p class="text-sm md:text-base text-slate-700 leading-relaxed break-words">
                        {{ $area->description ?? 'Sin descripción disponible.' }}
                    </p>
                </div>

                {{-- Información adicional --}}
                <div class="bg-slate-50 border border-slate-100 rounded-lg md:rounded-xl p-3 md:p-4 space-y-2">
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Información del Registro</p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 md:gap-4 text-sm">
                        <div>
                            <p class="text-slate-400 text-xs md:text-sm">Creado el:</p>
                            <p class="text-slate-700 font-medium text-sm md:text-base">{{ $area->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-slate-400 text-xs md:text-sm">Última actualización:</p>
                            <p class="text-slate-700 font-medium text-sm md:text-base">{{ $area->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>

                {{-- Estadísticas --}}
                <div class="bg-emerald-50 border border-emerald-100 rounded-lg md:rounded-xl p-3 md:p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm md:text-base text-emerald-700 font-medium">Unidades Productivas</p>
                            <p class="text-xs text-emerald-600">Asociadas a este área</p>
                        </div>
                        <div class="text-2xl md:text-3xl font-bold text-emerald-600">
                            {{ $area->productiveUnits()->count() }}
                        </div>
                    </div>
                </div>

                {{-- Botones de acción --}}
                <div class="flex flex-col-reverse gap-3 pt-4 border-t border-slate-100 sm:flex-row sm:justify-end">
                    <a href="{{ route('areas.index') }}"
                       class="inline-flex items-center justify-center gap-2 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 px-4 md:px-6 py-2.5 md:py-3 rounded-xl font-medium transition-all duration-200 shadow-sm hover:shadow-md text-sm md:text-base">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        <span>Volver</span>
                    </a>
                    <a href="{{ route('areas.edit', $area) }}"
                       class="inline-flex items-center justify-center gap-2 bg-amber-500 hover:bg-amber-600 text-white px-4 md:px-6 py-2.5 md:py-3 rounded-xl font-medium transition-all duration-200 shadow-sm hover:shadow-md text-sm md:text-base">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        <span>Editar Área</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

</x-layouts.app>
