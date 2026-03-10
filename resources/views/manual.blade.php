<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.styles')
    @include('partials.librerias-cdn')
</head>

<body
    class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-emerald-50/30 antialiased"
    style="font-family: 'Inter', sans-serif;"
>
    <!-- Header -->
    <header class="relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-emerald-600/90 via-emerald-700/85 to-teal-800/90"></div>
        <div class="absolute top-0 right-0 w-96 h-96 bg-white/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
        <div class="absolute bottom-0 left-0 w-80 h-80 bg-emerald-400/10 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2"></div>

        <div class="relative z-10 px-6 py-8 lg:px-12">
            <!-- Top Bar -->
            <div class="flex items-center justify-between mb-10" data-aos="fade-down" data-aos-delay="100">
                <div class="text-white">
                    <p class="text-sm font-semibold tracking-wider uppercase opacity-90">
                        Centro Formativo La Angostura
                    </p>
                    <p class="text-xs font-light tracking-wide opacity-70 mt-1">
                        Control de residuos sólidos
                    </p>
                </div>
                <a
                    href="{{ route('home') }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-white/10 backdrop-blur-sm border border-white/30 text-white font-medium text-sm rounded-lg hover:bg-white/20 hover:border-white/50 hover:-translate-y-0.5 transition-all duration-300"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Inicio
                </a>
            </div>

            <!-- Title -->
            <div class="text-center pb-8" data-aos="fade-up" data-aos-delay="200">
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white uppercase tracking-widest drop-shadow-lg">
                    Manual de Usuario
                </h1>
                <p class="text-white/70 mt-3 text-sm font-light tracking-wider">
                    SCR · Sistema de Clasificación de Residuos Sólidos
                </p>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="relative z-10 -mt-8 px-4 md:px-6 lg:px-8 pb-16">
        <section class="max-w-4xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">

                <!-- Card: Descripción -->
                <article
                    class="bg-white/90 backdrop-blur-sm rounded-2xl border-2 border-emerald-500/20 shadow-xl shadow-emerald-900/5 overflow-hidden"
                    data-aos="fade-up"
                    data-aos-delay="100"
                >
                    <div class="p-6 lg:p-8">
                        <div class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white text-xs font-semibold uppercase tracking-wider rounded-md mb-5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            ¿Qué contiene?
                        </div>
                        <ul class="space-y-3 text-slate-600 text-sm leading-relaxed">
                            <li class="flex items-start gap-2">
                                <span class="mt-1 w-2 h-2 rounded-full bg-emerald-500 shrink-0"></span>
                                Guía de navegación por módulos del sistema
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="mt-1 w-2 h-2 rounded-full bg-emerald-500 shrink-0"></span>
                                Instrucciones para el registro de muestras de residuos
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="mt-1 w-2 h-2 rounded-full bg-emerald-500 shrink-0"></span>
                                Gestión de unidades productivas y áreas
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="mt-1 w-2 h-2 rounded-full bg-emerald-500 shrink-0"></span>
                                Generación e interpretación de reportes
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="mt-1 w-2 h-2 rounded-full bg-emerald-500 shrink-0"></span>
                                Administración de roles y usuarios
                            </li>
                        </ul>
                    </div>
                </article>

                <!-- Card: Descarga -->
                <article
                    class="bg-white/90 backdrop-blur-sm rounded-2xl border-2 border-emerald-500/20 shadow-xl shadow-emerald-900/5 overflow-hidden flex flex-col"
                    data-aos="fade-up"
                    data-aos-delay="200"
                >
                    <div class="p-6 lg:p-8 flex flex-col items-center text-center gap-5 flex-1 justify-center">
                        <!-- Icono PDF -->
                        <div class="w-20 h-20 rounded-2xl bg-red-50 border-2 border-red-200 flex items-center justify-center shadow-md">
                            <svg class="w-10 h-10 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6zm-1 1.5L18.5 9H13V3.5zM8.5 17.5c-.3 0-.5-.1-.7-.2-.5-.3-.6-.9-.3-1.4.2-.3 1.3-1.5 3.5-2.5-.8 1.9-1.4 3.1-1.8 3.6-.2.3-.4.5-.7.5zm7-4.5c.4.3.5.8.2 1.2-.1.2-.3.3-.5.3-.5 0-1.2-.6-2-1.7 1 .1 1.8.1 2.3.2zm-2.7.1c-.5-.9-.9-1.9-1.2-2.8.5-.1 1-.2 1.5-.2.6 0 1.1.1 1.5.2-.3.9-.7 1.9-1.2 2.8h-.6zm-1.8-5.6c.1-.4.3-.6.5-.6s.4.2.5.6c.1.5.1 1.2 0 2.1-.4-.9-.9-1.8-1-2.1zm-1.5 5.8c-1.5.8-2.4 1.7-2.7 2.1-.2.2-.2.5 0 .7.1.1.2.2.4.2.3 0 .6-.2.8-.5.4-.6 1-1.8 1.8-3.7-.1.4-.2.8-.3 1.2z"/>
                            </svg>
                        </div>

                        <div>
                            <h2 class="text-slate-800 font-bold text-lg mb-1">Manual_Usuario_SCR_v2.pdf</h2>
                            <p class="text-slate-500 text-xs">Documento PDF · Versión 2</p>
                        </div>

                        <!-- Botón de descarga -->
                        <a
                            href="{{ route('manual.download') }}"
                            class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white font-semibold text-sm uppercase tracking-wider rounded-lg shadow-lg shadow-emerald-500/25 hover:shadow-xl hover:shadow-emerald-500/30 hover:-translate-y-0.5 transition-all duration-300"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                            Descargar Manual
                        </a>
                    </div>
                </article>

            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="px-4 md:px-6 lg:px-8 pb-8" data-aos="fade-up" data-aos-delay="300">
        <div class="max-w-4xl mx-auto text-center border-t border-slate-200/60 pt-6">
            <p class="text-xs text-slate-500">
                © {{ date('Y') }} SCR - Sistema de Control de Residuos.
                Centro de Formación Agroindustrial La Angostura - SENA
            </p>
        </div>
    </footer>

    @include('partials.footer-script-cdn')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof AOS === 'undefined') return;
            AOS.init({
                duration: 800,
                easing: 'ease-out-cubic',
                once: true,
                offset: 50
            });
        });
    </script>
</body>
</html>
