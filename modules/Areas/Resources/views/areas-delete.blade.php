<x-layouts.app :title="__('Eliminar Área')">

    {{-- Contenedor principal --}}
    <div class="max-w-4xl mx-auto space-y-4 md:space-y-6 px-4 sm:px-6 lg:px-8">

        {{-- Encabezado --}}
        <div class="bg-gradient-to-r from-red-50 via-white to-rose-50 border border-red-100 rounded-xl md:rounded-2xl p-4 md:p-6 shadow-sm">
            <div class="flex flex-col gap-3 md:gap-4 md:flex-row md:items-center md:justify-between">
                <div class="space-y-2">
                    <p class="inline-flex items-center text-xs font-semibold uppercase tracking-[0.2em] text-red-600 bg-red-50 rounded-full px-3 py-1">
                        <span class="w-2 h-2 bg-red-500 rounded-full mr-2"></span>
                        Eliminar
                    </p>
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-slate-900 leading-tight">Eliminar Área</h1>
                        <p class="text-sm md:text-base text-slate-500">Confirma la eliminación del área seleccionada.</p>
                    </div>
                </div>
                <a href="{{ route('areas.index') }}"
                   class="inline-flex items-center justify-center gap-2 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 px-4 py-2.5 rounded-xl font-medium transition-all duration-200 shadow-sm hover:shadow-md whitespace-nowrap">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>Volver</span>
                </a>
            </div>
        </div>

        {{-- Mensajes de confirmación --}}
        @include('partials.session-message')

        {{-- Tarjeta de advertencia --}}
        <div class="bg-white border border-slate-200 rounded-xl md:rounded-2xl shadow-sm overflow-hidden">
            {{-- Header de advertencia --}}
            <div class="bg-gradient-to-r from-red-500 to-rose-600 px-4 md:px-6 py-3 md:py-4">
                <div class="flex items-center gap-2 md:gap-3">
                    <div class="w-10 h-10 md:w-12 md:h-12 bg-white/20 backdrop-blur-sm rounded-lg md:rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg md:text-xl font-bold text-white">Confirmar Eliminación</h2>
                        <p class="text-red-100 text-xs md:text-sm">Esta acción no se puede deshacer</p>
                    </div>
                </div>
            </div>

            {{-- Contenido de advertencia --}}
            <div class="p-4 md:p-6 space-y-4 md:space-y-6">
                {{-- Información del área --}}
                <div class="bg-slate-50 border border-slate-100 rounded-lg md:rounded-xl p-3 md:p-4">
                    <div class="flex items-start gap-3 md:gap-4">
                        <div class="flex-shrink-0 hidden sm:block">
                            <div class="w-10 h-10 md:w-12 md:h-12 bg-red-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 md:w-6 md:h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-base md:text-lg font-semibold text-slate-800 mb-2 break-words">Área: {{ $area->name }}</h3>
                            <p class="text-sm md:text-base text-slate-600 mb-3 md:mb-4">
                                ¿Estás seguro de que deseas eliminar esta área? Esta acción eliminará permanentemente el registro del sistema.
                            </p>
                            @if($area->productiveUnits()->count() > 0)
                                <div class="bg-amber-50 border border-amber-200 rounded-lg md:rounded-xl p-3 md:p-4">
                                    <div class="flex items-start gap-2 md:gap-3">
                                        <svg class="w-4 h-4 md:w-5 md:h-5 text-amber-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <div class="min-w-0">
                                            <p class="text-xs md:text-sm font-semibold text-amber-800 mb-1">Advertencia</p>
                                            <p class="text-xs md:text-sm text-amber-700 break-words">
                                                Este área tiene <strong>{{ $area->productiveUnits()->count() }}</strong> unidad(es) productiva(s) asociada(s).
                                                No podrás eliminar el área hasta que elimines o reasignes todas las unidades productivas.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="bg-blue-50 border border-blue-200 rounded-lg md:rounded-xl p-3 md:p-4">
                                    <div class="flex items-start gap-2 md:gap-3">
                                        <svg class="w-4 h-4 md:w-5 md:h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <div class="min-w-0">
                                            <p class="text-xs md:text-sm font-semibold text-blue-800 mb-1">Información</p>
                                            <p class="text-xs md:text-sm text-blue-700 break-words">
                                                Este área no tiene unidades productivas asociadas. Puedes eliminarla de forma segura.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Información adicional --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 md:gap-4 pt-3 md:pt-4 border-t border-slate-100">
                    <div class="bg-slate-50 rounded-lg md:rounded-xl p-3 md:p-4">
                        <div class="flex items-center gap-2 mb-2">
                            <svg class="w-4 h-4 md:w-5 md:h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide">Creado el</p>
                        </div>
                        <p class="text-sm md:text-base text-slate-700 font-medium">{{ $area->created_at->format('d/m/Y H:i') }}</p>
                    </div>

                    <div class="bg-slate-50 rounded-lg md:rounded-xl p-3 md:p-4">
                        <div class="flex items-center gap-2 mb-2">
                            <svg class="w-4 h-4 md:w-5 md:h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582M20 20v-5h-.581M5.582 9A7 7 0 0112 5c2.761 0 5.112 1.59 6.418 3.922M18.418 15A7 7 0 0112 19a7 7 0 01-6.418-3.922" />
                            </svg>
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide">Última actualización</p>
                        </div>
                        <p class="text-sm md:text-base text-slate-700 font-medium">{{ $area->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Formulario de eliminación --}}
        <div class="bg-white border border-slate-200 rounded-xl md:rounded-2xl shadow-sm p-4 md:p-6">
            <form action="{{ route('areas.destroy', $area) }}" method="POST" class="space-y-4 md:space-y-6">
                @csrf
                @method('DELETE')

                {{-- Botones de acción --}}
                <div class="flex flex-col-reverse gap-3 pt-4 border-t border-slate-100 sm:flex-row sm:justify-end">
                    <a href="{{ route('areas.index') }}"
                       class="inline-flex items-center justify-center gap-2 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 px-4 md:px-6 py-2.5 md:py-3 rounded-xl font-medium transition-all duration-200 shadow-sm hover:shadow-md text-sm md:text-base">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        <span>Cancelar</span>
                    </a>
                    <button type="submit"
                            @if($area->productiveUnits()->count() > 0) disabled @endif
                            class="inline-flex items-center justify-center gap-2 bg-red-500 hover:bg-red-600 @if($area->productiveUnits()->count() > 0) opacity-50 cursor-not-allowed @endif text-white px-4 md:px-6 py-2.5 md:py-3 rounded-xl font-medium transition-all duration-200 shadow-sm hover:shadow-md text-sm md:text-base">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        <span>Eliminar Área</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

</x-layouts.app>


