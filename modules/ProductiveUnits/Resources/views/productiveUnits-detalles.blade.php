<x-layouts.app :title="__('Detalles de Unidad Productiva')">

    {{-- Contenedor principal --}}
    <div class="max-w-4xl mx-auto space-y-6">

        {{-- Encabezado --}}
        <div class="bg-gradient-to-r from-emerald-50 via-white to-cyan-50 border border-emerald-100 rounded-2xl p-6 shadow-sm">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div class="space-y-2">
                    <p class="inline-flex items-center text-xs font-semibold uppercase tracking-[0.2em] text-emerald-600 bg-emerald-50 rounded-full px-3 py-1">
                        <span class="w-2 h-2 bg-emerald-500 rounded-full mr-2"></span>
                        Detalles
                    </p>
                    <div>
                        <h1 class="text-3xl font-bold text-slate-900 leading-tight">Detalles de Unidad Productiva</h1>
                        <p class="text-slate-500">Informacion completa de la unidad productiva.</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('productive-units.edit', $productiveUnit) }}"
                       class="inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-600 text-white px-4 py-2.5 rounded-xl font-medium transition-all duration-200 shadow-sm hover:shadow-md">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        <span>Editar</span>
                    </a>
                    <a href="{{ route('productive-units.index') }}"
                       class="inline-flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2.5 rounded-xl font-medium transition-all duration-200 shadow-sm hover:shadow-md">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        <span>Volver</span>
                    </a>
                </div>
            </div>
        </div>

        {{-- Mensajes de confirmacion --}}
        @include('partials.session-message')

        {{-- Tarjeta de informacion --}}
        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
            <div class="p-6 space-y-6">
                {{-- Area --}}
                <div class="flex items-start gap-4 pb-6 border-b border-slate-200">
                    <div class="w-12 h-12 bg-emerald-100 text-emerald-700 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4 6h16M4 12h16M4 18h7" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs uppercase tracking-wide text-slate-400 font-semibold mb-1">Area</p>
                        <p class="text-lg font-semibold text-slate-800">
                            {{ $productiveUnit->area?->name ?? 'Sin area asignada' }}
                        </p>
                    </div>
                </div>

                {{-- Nombre --}}
                <div class="flex items-start gap-4 pb-6 border-b border-slate-200">
                    <div class="w-12 h-12 bg-blue-100 text-blue-700 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M6 8h12M6 12h7m-7 4h9" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs uppercase tracking-wide text-slate-400 font-semibold mb-1">Nombre</p>
                        <p class="text-lg font-semibold text-slate-800">{{ $productiveUnit->name }}</p>
                    </div>
                </div>

                {{-- Descripcion --}}
                @if($productiveUnit->description)
                <div class="flex items-start gap-4 pb-6 border-b border-slate-200">
                    <div class="w-12 h-12 bg-purple-100 text-purple-700 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M8 9h8M8 13h5m-9 5h12a2 2 0 002-2V7a2 2 0 00-2-2H4a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs uppercase tracking-wide text-slate-400 font-semibold mb-1">Descripcion</p>
                        <p class="text-base text-slate-700 leading-relaxed">{{ $productiveUnit->description }}</p>
                    </div>
                </div>
                @else
                        <div class="flex items-start gap-4 pb-6 border-b border-slate-200">
                    <div class="w-12 h-12 bg-purple-100 text-purple-700 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M8 9h8M8 13h5m-9 5h12a2 2 0 002-2V7a2 2 0 00-2-2H4a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs uppercase tracking-wide text-slate-400 font-semibold mb-1">Descripcion</p>
                        <p class="text-s font-bold text-purple-100 text-slate-700 leading-relaxed">Actualmenten no tiene una descripción esta unidad productiva.</p>
                    </div>
                </div>
                @endif


                {{-- Tipo de Residuo --}}
                <div class="flex items-start gap-4 pb-6 border-b border-slate-200">
                    <div class="w-12 h-12 bg-amber-100 text-amber-700 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs uppercase tracking-wide text-slate-400 font-semibold mb-1">Tipo de Residuo</p>
                        <p class="text-lg font-semibold text-slate-800">
                            @php
                                $wasteTypeLabel = match($productiveUnit->waste_type) {
                                    'Residuos Solidos' => 'Residuos Solidos (RESOL)',
                                    'Residuos Peligrosos' => 'Residuos Peligrosos (RESPEL)',
                                    'RESOL/RESPEL' => 'Ambos (RESOL/RESPEL)',
                                    default => 'No definido'
                                };
                            @endphp
                            {{ $wasteTypeLabel }}
                        </p>
                    </div>
                </div>

                {{-- Fechas --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-indigo-100 text-indigo-700 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-xs uppercase tracking-wide text-slate-400 font-semibold mb-1">Fecha de Creacion</p>
                            <p class="text-base font-semibold text-slate-800">
                                {{ $productiveUnit->created_at?->format('d/m/Y H:i') ?? 'N/A' }}
                            </p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-rose-100 text-rose-700 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M4 4v5h.582M20 20v-5h-.581M5.582 9A7 7 0 0112 5c2.761 0 5.112 1.59 6.418 3.922M18.418 15A7 7 0 0112 19a7 7 0 01-6.418-3.922" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-xs uppercase tracking-wide text-slate-400 font-semibold mb-1">Ultima Actualizacion</p>
                            <p class="text-base font-semibold text-slate-800">
                                {{ $productiveUnit->updated_at?->format('d/m/Y H:i') ?? 'N/A' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-layouts.app>

