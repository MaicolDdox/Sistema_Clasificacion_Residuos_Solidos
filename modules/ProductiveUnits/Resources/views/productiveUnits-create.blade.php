<x-layouts.app :title="__('Nueva Unidad Productiva')">

    {{-- Contenedor principal --}}
    <div class="max-w-4xl mx-auto space-y-6">

        {{-- Encabezado --}}
        <div class="bg-gradient-to-r from-emerald-50 via-white to-cyan-50 border border-emerald-100 rounded-2xl p-6 shadow-sm">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div class="space-y-2">
                    <p class="inline-flex items-center text-xs font-semibold uppercase tracking-[0.2em] text-emerald-600 bg-emerald-50 rounded-full px-3 py-1">
                        <span class="w-2 h-2 bg-emerald-500 rounded-full mr-2"></span>
                        Crear
                    </p>
                    <div>
                        <h1 class="text-3xl font-bold text-slate-900 leading-tight">Nueva Unidad Productiva</h1>
                        <p class="text-slate-500">Complete el formulario para registrar una nueva unidad productiva.</p>
                    </div>
                </div>
                <a href="{{ route('productive-units.index') }}"
                   class="inline-flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2.5 rounded-xl font-medium transition-all duration-200 shadow-sm hover:shadow-md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>Volver</span>
                </a>
            </div>
        </div>

        {{-- Mensajes de confirmacion --}}
        @include('partials.session-message')

        {{-- Formulario --}}
        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6">
            <form action="{{ route('productive-units.store') }}" method="POST" class="space-y-6">
                @csrf

                {{-- Select de Area --}}
                <div>
                    <label for="area_id" class="block text-sm font-semibold text-slate-700 mb-2">
                        Area <span class="text-red-500">*</span>
                    </label>
                    <select name="area_id" id="area_id" required
                            class="w-full px-4 py-3 rounded-lg border border-slate-200 bg-white text-sm text-slate-700 focus:ring-2 focus:ring-emerald-200 focus:border-emerald-400 shadow-sm transition-all">
                        <option value="">-- Seleccione un Area --</option>
                        
                        @foreach($areas as $area)
                            <option value="{{ $area->id }}" {{ old('area_id') == $area->id ? 'selected' : '' }}>
                                {{ $area->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('area_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Campo Nombre --}}
                <div>
                    <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">
                        Nombre de la Unidad <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                           class="w-full px-4 py-3 rounded-lg border border-slate-200 bg-white text-sm text-slate-700 focus:ring-2 focus:ring-emerald-200 focus:border-emerald-400 shadow-sm transition-all"
                           placeholder="Ej: Unidad de Aguacate">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Campo Descripcion --}}
                <div>
                    <label for="description" class="block text-sm font-semibold text-slate-700 mb-2">
                        Descripcion
                    </label>
                    <textarea name="description" id="description" rows="4"
                              class="w-full px-4 py-3 rounded-lg border border-slate-200 bg-white text-sm text-slate-700 focus:ring-2 focus:ring-emerald-200 focus:border-emerald-400 shadow-sm transition-all resize-none"
                              placeholder="Descripcion opcional de la unidad productiva">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Select de Tipo de Residuo --}}
                <div>
                    <label for="waste_type" class="block text-sm font-semibold text-slate-700 mb-2">
                        Tipo de Residuo <span class="text-red-500">*</span>
                    </label>
                    <select name="waste_type" id="waste_type" required
                            class="w-full px-4 py-3 rounded-lg border border-slate-200 bg-white text-sm text-slate-700 focus:ring-2 focus:ring-emerald-200 focus:border-emerald-400 shadow-sm transition-all">
                        <option value="">-- Seleccione el tipo de residuo --</option>
                        <option value="convencional" {{ old('waste_type') == 'convencional' ? 'selected' : '' }}>
                            Residuos Convencionales
                        </option>
                        <option value="respel" {{ old('waste_type') == 'respel' ? 'selected' : '' }}>
                            Residuos Respel
                        </option>
                        <option value="ambos" {{ old('waste_type') == 'ambos' ? 'selected' : '' }}>
                            Ambos (Convencional y Respel)
                        </option>
                    </select>
                    @error('waste_type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-xs text-slate-500">
                        Seleccione el tipo de residuo que puede manejar esta unidad productiva.
                    </p>
                </div>

                {{-- Botones de accion --}}
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-200">
                    <a href="{{ route('productive-units.index') }}"
                       class="px-6 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-medium transition-all duration-200">
                        Cancelar
                    </a>
                    <button type="submit"
                            class="px-6 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white rounded-xl font-medium transition-all duration-200 shadow-sm hover:shadow-md">
                        Guardar Unidad
                    </button>
                </div>
            </form>
        </div>
    </div>

</x-layouts.app>

