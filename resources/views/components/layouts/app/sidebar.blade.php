<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

    @include('partials.styles')

    @include('partials.librerias-cdn')

</head>
@php
    $sidebarAreas = \Modules\Areas\Models\Area::orderBy('name')->get();
@endphp
<body
    class="font-sans antialiased bg-slate-50 min-h-screen"
    x-data="{
        sidebarOpen: false,
        openResiduesAreaModal: false,
        selectedAreaId: '',
        tomSelectInstance: null,
        initTomSelect() {
            if (this.tomSelectInstance || !window.TomSelect) return;
            const selectEl = this.$refs.areaSelect;
            if (selectEl) {
                this.tomSelectInstance = new TomSelect(selectEl, {
                    placeholder: 'Selecciona un área',
                    allowEmptyOption: true,
                    maxOptions: 200,
                    plugins: ['dropdown_input'],
                });
            }
        },
        openResiduesModal() {
            this.openResiduesAreaModal = true;
            this.$nextTick(() => this.initTomSelect());
        },
        goToUnits() {
            if (!this.selectedAreaId) return;
            const baseUrl = '{{ route('wastes.units.byArea', ['area' => '__AREA__']) }}';
            window.location.href = baseUrl.replace('__AREA__', this.selectedAreaId);
        }
    }"
>

    <div class="flex min-h-screen">

        {{-- Overlay mobile --}}
        <div
            x-show="sidebarOpen"
            x-transition.opacity
            class="fixed inset-0 bg-slate-900/50 z-40 md:hidden"
            @click="sidebarOpen = false"
        ></div>

        <!-- Sidebar -->
        <aside
            class="w-72 bg-white border-r border-slate-200/80 flex flex-col fixed h-full z-50 transition-transform duration-300 md:translate-x-0"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        >

            <!-- Logo Section -->
            <div
                class="p-6 border-b border-slate-100"
                data-aos="fade-right"
                data-aos-duration="600"
            >
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-emerald-50/80 border border-emerald-100 flex items-center justify-center overflow-hidden">
                        <img
                            src="{{ asset('img/imagen1.png') }}"
                            alt="SCR Logo"
                            class="w-8 h-8 object-contain"
                        >
                    </div>
                    <div>
                        <h1 class="text-lg font-semibold text-slate-800 tracking-tight">SCR</h1>
                        <p class="text-xs text-slate-400 font-medium">Clasificación de Residuos</p>
                    </div>
                    </div>
                    {{-- Boton cerrar sidebar en mobile --}}
                    <button
                        @click="sidebarOpen = false"
                        class="md:hidden p-1.5 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-colors"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 p-4 overflow-y-auto">

                <!-- Menu Label -->
                <p
                    class="text-[10px] font-semibold text-slate-400 uppercase tracking-widest px-3 mb-3"
                    data-aos="fade-right"
                    data-aos-duration="600"
                    data-aos-delay="100"
                >
                    Menú Principal
                </p>

                <!-- Menu Items -->
                <ul class="space-y-1">
                    <!-- Agregado Dashboard con icono de cuadrícula/grid más coherente -->
                    <li data-aos="fade-right" data-aos-duration="600" data-aos-delay="150">
                        <a
                            href="{{ route('dashboard') }}"
                            class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 hover:bg-emerald-50/60 hover:text-emerald-700 transition-all duration-300"
                        >
                            <span class="w-9 h-9 rounded-lg bg-slate-100/80 group-hover:bg-emerald-100/80 flex items-center justify-center transition-all duration-300">
                                <svg class="w-[18px] h-[18px] text-slate-500 group-hover:text-emerald-600 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                                </svg>
                            </span>
                            <span class="text-sm font-medium">Dashboard</span>
                        </a>
                    </li>

                    @role('Invitado')
                        {{-- Aviso de cuenta pendiente de activación --}}
                        <li class="px-3 py-3 mt-1">
                            <div class="rounded-xl border border-amber-200 bg-amber-50 px-3 py-3 space-y-1">
                                <p class="text-xs font-semibold text-amber-700">Cuenta en espera</p>
                                <p class="text-[11px] text-amber-600 leading-relaxed">
                                    Tu cuenta aún no tiene módulos habilitados. Contacta a la Gestora Ambiental para que te asigne un rol.
                                </p>
                            </div>
                        </li>
                    @endrole

                    @unlessrole('Invitado')
                        {{-- CONTENIDO PARA AGREGAR LOS ITEMS DE AREAS --}}
                        @include('components.layouts.app.menu.areas.area-list')

                        {{-- CONTENIDO PARA AGREGAR LOS ITEMS DE UNIDADES PRODUCTIVAS --}}
                        @include('components.layouts.app.menu.unidades.unidades-list')

                        {{-- CONTENIO PARA AGREGAR LOS ITEMS DE RESIDUOS --}}
                        @include('components.layouts.app.menu.residuos.residuos-list')

                        {{-- CONTENIDO PARA AGREGAR LOS ITEMS DE ROLES --}}
                        @include('components.layouts.app.menu.roles.roles-list')
                    @endunlessrole
                </ul>

                <!-- Divider -->
                <div
                    class="my-6 border-t border-slate-100"
                    data-aos="fade-right"
                    data-aos-duration="600"
                    data-aos-delay="400"
                ></div>

                <!-- Settings Label -->
                <p
                    class="text-[10px] font-semibold text-slate-400 uppercase tracking-widest px-3 mb-3"
                    data-aos="fade-right"
                    data-aos-duration="600"
                    data-aos-delay="450"
                >
                    Configuración
                </p>

                <ul class="space-y-1">
                    <li data-aos="fade-right" data-aos-duration="600" data-aos-delay="500">
                        <a
                            href="{{ route('profile.edit') }}"
                            class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 hover:bg-emerald-50/60 hover:text-emerald-700 transition-all duration-300"
                        >
                            <span class="w-9 h-9 rounded-lg bg-slate-100/80 group-hover:bg-emerald-100/80 flex items-center justify-center transition-all duration-300">
                                <svg class="w-[18px] h-[18px] text-slate-500 group-hover:text-emerald-600 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </span>
                            <span class="text-sm font-medium">Mi Perfil</span>
                        </a>
                    </li>

                    <li data-aos="fade-right" data-aos-duration="600" data-aos-delay="550">
                        <a
                            href="{{ route('manuales') }}"
                            class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 hover:bg-emerald-50/60 hover:text-emerald-700 transition-all duration-300"
                        >
                            <span class="w-9 h-9 rounded-lg bg-slate-100/80 group-hover:bg-emerald-100/80 flex items-center justify-center transition-all duration-300">
                                <svg class="w-[18px] h-[18px] text-slate-500 group-hover:text-emerald-600 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                            </span>
                            <span class="text-sm font-medium">Manuales</span>
                        </a>
                    </li>
                </ul>
            </nav>

            
            <!-- User Section -->
            <div
                class="p-4 border-t border-slate-100"
                data-aos="fade-up"
                data-aos-duration="600"
                data-aos-delay="550"
            >
                <div class="flex items-center gap-3 p-3 rounded-xl bg-slate-50/80 mb-3">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-emerald-400/80 to-teal-500/80 flex items-center justify-center text-white text-sm font-semibold shadow-sm">
                        {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-slate-700 truncate">{{ Auth::user()->name ?? 'Usuario' }}</p>
                        <p class="text-xs text-slate-400 truncate">{{ Auth::user()->email ?? 'email@ejemplo.com' }}</p>
                    </div>
                </div>

                <!-- Botón "Salir" con icono y texto -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button
                        type="submit"
                        class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-red-50/80 border border-red-100 text-red-600 hover:bg-red-100 hover:border-red-200 transition-all duration-300 group"
                    >
                        <svg class="w-4 h-4 text-red-500 group-hover:text-red-600 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        <span class="text-sm font-medium">Salir</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 md:ml-72">
            {{-- Top bar mobile --}}
            <div class="md:hidden sticky top-0 z-30 bg-white border-b border-slate-200 px-4 py-3 flex items-center justify-between">
                <button
                    @click="sidebarOpen = true"
                    class="p-2 rounded-lg text-slate-600 hover:bg-slate-100 transition-colors"
                >
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <div class="flex items-center gap-2">
                    <img src="{{ asset('img/imagen1.png') }}" alt="SCR" class="w-7 h-7 object-contain">
                    <span class="text-sm font-semibold text-slate-800">SCR</span>
                </div>
                <div class="w-10"></div>
            </div>

            <div class="p-4 sm:p-6 md:p-8">
                {{ $slot }}
            </div>
        </main>

    </div>

    <!-- Flux Scripts (incluye Alpine.js) -->
    @fluxScripts

    <!-- AOS Script -->
    @include('partials.footer-script-cdn')
    <!-- Script modificado para que las animaciones solo se ejecuten una vez por sesión de login -->
    <script>
        (function() {
            const animationKey = 'scr_sidebar_animated';
            const hasAnimated = sessionStorage.getItem(animationKey);

            if (!hasAnimated) {
                // Primera vez en esta sesión: mostrar animaciones
                AOS.init({
                    once: true,
                    easing: 'ease-out-cubic'
                });
                sessionStorage.setItem(animationKey, 'true');
            } else {
                // Ya se animó en esta sesión: desactivar animaciones
                document.querySelectorAll('[data-aos]').forEach(function(el) {
                    el.removeAttribute('data-aos');
                    el.removeAttribute('data-aos-duration');
                    el.removeAttribute('data-aos-delay');
                });
            }
        })();
    </script>

    {{-- Modal selección de área para residuos --}}
    <div
        x-show="openResiduesAreaModal"
        x-transition.opacity
        class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 px-4"
    >
        <div
            class="bg-white rounded-2xl shadow-2xl w-full max-w-lg border border-slate-200"
            x-show="openResiduesAreaModal"
            x-transition.scale.origin-center
        >
            <div class="p-6 space-y-4">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-xs uppercase tracking-[0.2em] text-emerald-600 font-semibold">Residuos</p>
                        <h2 class="text-2xl font-bold text-slate-900">Selecciona el área para gestionar residuos</h2>
                        <p class="text-sm text-slate-500 mt-1">Usa el selector para ir a las unidades productivas del área elegida.</p>
                    </div>
                    <button
                        type="button"
                        class="text-slate-400 hover:text-slate-600"
                        @click="openResiduesAreaModal = false"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-medium text-slate-700" for="areaSelect">Área</label>
                    <select
                        id="areaSelect"
                        x-ref="areaSelect"
                        x-model="selectedAreaId"
                        class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-200 focus:border-emerald-400"
                    >
                        <option value="">Selecciona un área</option>
                        @foreach($sidebarAreas as $area)
                            <option value="{{ $area->id }}">{{ $area->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4">
                    <button
                        type="button"
                        class="px-4 py-2 rounded-lg border border-slate-200 text-slate-700 hover:bg-slate-50 transition"
                        @click="openResiduesAreaModal = false"
                    >
                        Cancelar
                    </button>
                    <button
                        type="button"
                        class="px-4 py-2 rounded-lg bg-emerald-500 text-white hover:bg-emerald-400 transition disabled:opacity-60"
                        :disabled="!selectedAreaId"
                        @click="goToUnits()"
                    >
                        Ir a unidades
                    </button>
                </div>
            </div>
        </div>
    </div>

    @include('partials.ui.confirm-modal', [
        'modalId' => 'global-confirm-modal',
        'title' => 'Confirmar acción',
        'message' => '¿Deseas continuar con esta operación?',
        'confirmButtonText' => 'Confirmar',
    ])
    @include('partials.ui.toast-stack')

</body>
</html>
