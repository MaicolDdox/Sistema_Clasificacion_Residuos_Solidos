<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

    @include('partials.styles')

    @include('partials.librerias-cdn')

</head>
<body class="font-sans antialiased bg-slate-50 min-h-screen">

    <div class="flex min-h-screen">

        <!-- Sidebar -->
        <aside class="w-72 bg-white border-r border-slate-200/80 flex flex-col fixed h-full z-40">

            <!-- Logo Section -->
            <div
                class="p-6 border-b border-slate-100"
                data-aos="fade-right"
                data-aos-duration="600"
            >
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
                        <p class="text-xs text-slate-400 font-medium">Gestión de residuos</p>
                    </div>
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

                    {{-- CONTENIDO PARA AGREGAR LOS ITEMS DE AREAS --}}
                    @include('components.layouts.app.menu.areas.area-list')

                    {{-- CONTENIDO PARA AGREGAR LOS ITEMS DE UNIDADES PRODUCTIVAS --}}
                    @include('components.layouts.app.menu.unidades.unidades-list')

                    {{-- CONTENIO PARA AGREGAR LOS ITEMS DE RESIDUOS --}}
                    @include('components.layouts.app.menu.residuos.residuos-list')

                    {{-- CONTENIDO PARA AGREGAR LOS ITEMS DE ROLES --}}
                    @include('components.layouts.app.menu.roles.roles-list')
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
        <main class="flex-1 ml-72">
            <div class="p-8">
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

</body>
</html>
