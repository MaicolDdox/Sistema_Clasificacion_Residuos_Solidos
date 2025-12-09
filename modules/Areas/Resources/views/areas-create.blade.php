<x-layouts.app :title="__('Nueva Área')">

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
                        <h1 class="text-3xl font-bold text-slate-900 leading-tight">Nueva Área</h1>
                        <p class="text-slate-500">Completa el formulario para registrar una nueva área en el sistema.</p>
                    </div>
                </div>
                <a href="{{ route('areas.index') }}"
                   class="inline-flex items-center gap-2 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 px-4 py-2.5 rounded-xl font-medium transition-all duration-200 shadow-sm hover:shadow-md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>Volver</span>
                </a>
            </div>
        </div>

        {{-- Mensajes de confirmación --}}
        @include('partials.session-message')

        {{-- Formulario --}}
        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6">
            <form action="{{ route('areas.store') }}" method="POST" class="space-y-6">
                @csrf

                {{-- Nombre --}}
                <div>
                    <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">
                        Nombre del Área <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                        required
                        placeholder="Ej: Área de Producción"
                        class="w-full px-4 py-3 rounded-xl border @error('name') border-red-300 focus:ring-red-200 focus:border-red-400 @else border-slate-200 focus:ring-2 focus:ring-emerald-200 focus:border-emerald-400 @enderror bg-white text-slate-700 placeholder-slate-400 transition-all duration-200"
                    >
                    @error('name')
                        <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Descripción --}}
                <div>
                    <label for="description" class="block text-sm font-semibold text-slate-700 mb-2">
                        Descripción
                    </label>
                    <textarea
                        id="description"
                        name="description"
                        rows="4"
                        placeholder="Describe brevemente el propósito y función del área..."
                        class="w-full px-4 py-3 rounded-xl border @error('description') border-red-300 focus:ring-red-200 focus:border-red-400 @else border-slate-200 focus:ring-2 focus:ring-emerald-200 focus:border-emerald-400 @enderror bg-white text-slate-700 placeholder-slate-400 transition-all duration-200 resize-none"
                    >{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                    <p class="mt-2 text-xs text-slate-400">Máximo 1000 caracteres</p>
                </div>

                {{-- Botones de acción --}}
                <div class="flex flex-col-reverse gap-3 pt-4 border-t border-slate-100 sm:flex-row sm:justify-end">
                    <a href="{{ route('areas.index') }}"
                       class="inline-flex items-center justify-center gap-2 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 px-6 py-3 rounded-xl font-medium transition-all duration-200 shadow-sm hover:shadow-md">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        <span>Cancelar</span>
                    </a>
                    <button type="submit"
                            class="inline-flex items-center justify-center gap-2 bg-emerald-500 hover:bg-emerald-600 text-white px-6 py-3 rounded-xl font-medium transition-all duration-200 shadow-sm hover:shadow-md">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Guardar Área</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

</x-layouts.app>


