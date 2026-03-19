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
                    Equipo de Desarrollo
                </h1>
                <p class="text-white/70 mt-3 text-sm font-light tracking-wider">
                    Aprendices SENA · Centro de Formación Agroindustrial La Angostura
                </p>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="relative z-10 -mt-8 px-4 md:px-6 lg:px-8 pb-16">
        <section class="max-w-5xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">

                <!-- Card 1: John Sebastian Lopez -->
                <article
                    class="group bg-white/90 backdrop-blur-sm rounded-2xl border-2 border-emerald-500/20 shadow-xl shadow-emerald-900/5 overflow-hidden hover:shadow-2xl hover:shadow-emerald-900/10 hover:-translate-y-2 transition-all duration-500"
                    data-aos="fade-up"
                    data-aos-delay="100"
                >
                    <div class="p-6 flex flex-col items-center text-center">
                        <!-- Foto -->
                        <div class="w-28 h-28 rounded-full overflow-hidden border-4 border-emerald-200 shadow-lg shadow-emerald-500/20 mx-auto mb-4">
                            <img
                                src="{{ asset('apprentices/imagen_1.png') }}"
                                alt="John Sebastian Lopez"
                                class="w-full h-full object-cover"
                                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                            />
                            <div style="display:none;width:100%;height:100%;align-items:center;justify-content:center;font-size:1.5rem;font-weight:700;color:white;" class="bg-gradient-to-br from-emerald-400 to-teal-600">
                                JS
                            </div>
                        </div>

                        <!-- Nombre -->
                        <h1 class="text-base font-bold text-slate-800 rounded-full p-1 mb-3 leading-tight">John Sebastian Lopez T.</h1>
                        <a href="https://github.com/JonnaDev" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 mb-3 px-3 py-1 rounded-full text-xs font-semibold bg-gray-900 text-white hover:bg-gray-700 transition-colors duration-200">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 0C5.374 0 0 5.373 0 12c0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23A11.509 11.509 0 0 1 12 5.803c1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576C20.566 21.797 24 17.3 24 12c0-6.627-5.373-12-12-12z"/>
                            </svg>
                            GitHub
                        </a>

                        <!-- Roles -->
                        <div class="flex flex-wrap justify-center gap-1 mb-4">
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700 border border-emerald-200">Backend</span>
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-sky-100 text-sky-700 border border-sky-200">Front-End</span>
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-pink-100 text-pink-700 border border-pink-200">Deploy</span>
                        </div>

                        <div class="w-full h-px bg-slate-100 mb-4"></div>

                        <!-- Tecnologías -->
                        <div class="flex flex-wrap justify-center gap-1.5">
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-red-50 text-red-600 border border-red-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500 shrink-0"></span>Laravel
                            </span>
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-900 border border-blue-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 shrink-0"></span>PHP
                            </span>
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-50 text-yellow-700 border border-yellow-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-yellow-400 shrink-0"></span>JavaScript
                            </span>
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-cyan-50 text-cyan-600 border border-cyan-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-cyan-400 shrink-0"></span>TailwindCSS
                            </span>
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-600 border border-blue-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-400 shrink-0"></span>Alpine.js
                            </span>
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-600 border border-slate-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-slate-400 shrink-0"></span>SQL
                            </span>
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-purple-50 text-purple-600 border border-purple-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-purple-400 shrink-0"></span>Flux
                            </span>
                        </div>
                    </div>
                </article>

                <!-- Card 2: Maicol Duvan -->
                <article
                    class="group bg-white/90 backdrop-blur-sm rounded-2xl border-2 border-emerald-500/20 shadow-xl shadow-emerald-900/5 overflow-hidden hover:shadow-2xl hover:shadow-emerald-900/10 hover:-translate-y-2 transition-all duration-500"
                    data-aos="fade-up"
                    data-aos-delay="200"
                >
                    <div class="p-6 flex flex-col items-center text-center">
                        <!-- Foto -->
                        <div class="w-28 h-28 rounded-full overflow-hidden border-4 border-emerald-200 shadow-lg shadow-emerald-500/20 mx-auto mb-4">
                            <img
                                src="{{ asset('apprentices/imagen_2.png') }}"
                                alt="Maicol Duvan"
                                class="w-full h-full object-cover"
                                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                            />
                            <div style="display:none;width:100%;height:100%;align-items:center;justify-content:center;font-size:1.5rem;font-weight:700;color:white;" class="bg-gradient-to-br from-blue-400 to-indigo-600">
                                MD
                            </div>
                        </div>

                        <!-- Nombre -->
                        <h1 class="text-base font-bold text-slate-800 rounded-full p-1 mb-3 leading-tight">Maicol Duvan Gasca Rodas</h1>
                        <a href="https://github.com/MaicolDdox" target="_blank" rel="noopener noreferrer" class="inline-flex gap-1.5 mb-3 px-3 py-1 items-center rounded-full text-xs font-semibold bg-gray-900 text-white hover:bg-gray-700 transition-colors duration-200">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 0C5.374 0 0 5.373 0 12c0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23A11.509 11.509 0 0 1 12 5.803c1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576C20.566 21.797 24 17.3 24 12c0-6.627-5.373-12-12-12z"/>
                            </svg>
                            GitHub
                        </a>

                        <!-- Roles -->
                        <div class="flex flex-wrap justify-center gap-1 mb-4">
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-700 border border-indigo-200">Arquitecto del Sistema</span>
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700 border border-emerald-200">Backend</span>
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-sky-100 text-sky-700 border border-sky-200">Front-End</span>
                        </div>

                        <div class="w-full h-px bg-slate-100 mb-4"></div>

                        <!-- Tecnologías -->
                        <div class="flex flex-wrap justify-center gap-1.5">
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-red-50 text-red-600 border border-red-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500 shrink-0"></span>Laravel
                            </span>
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-900 border border-blue-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 shrink-0"></span>PHP
                            </span>
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-50 text-yellow-700 border border-yellow-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-yellow-400 shrink-0"></span>JavaScript
                            </span>
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-cyan-50 text-cyan-600 border border-cyan-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-cyan-400 shrink-0"></span>TailwindCSS
                            </span>
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-600 border border-blue-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-400 shrink-0"></span>Alpine.js
                            </span>
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-600 border border-slate-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-slate-400 shrink-0"></span>SQL
                            </span>
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-purple-50 text-purple-600 border border-purple-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-purple-400 shrink-0"></span>Flux
                            </span>
                        </div>
                    </div>
                </article>

                <!-- Card 3: Juan Pablo Motta -->
                <article
                    class="group bg-white/90 backdrop-blur-sm rounded-2xl border-2 border-emerald-500/20 shadow-xl shadow-emerald-900/5 overflow-hidden hover:shadow-2xl hover:shadow-emerald-900/10 hover:-translate-y-2 transition-all duration-500"
                    data-aos="fade-up"
                    data-aos-delay="300"
                >
                    <div class="p-6 flex flex-col items-center text-center">
                        <!-- Foto -->
                        <div class="w-28 h-28 rounded-full overflow-hidden border-4 border-emerald-200 shadow-lg shadow-emerald-500/20 mx-auto mb-4">
                            <img
                                src="{{ asset('apprentices/imagen_3.png') }}"
                                alt="Juan Pablo Motta"
                                class="w-full h-full object-cover"
                                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                            />
                            <div style="display:none;width:100%;height:100%;align-items:center;justify-content:center;font-size:1.5rem;font-weight:700;color:white;" class="bg-gradient-to-br from-teal-400 to-emerald-600">
                                JP
                            </div>
                        </div>

                        <!-- Nombre -->
                        <h1 class="text-base font-bold text-slate-800 mb-3 leading-tight">Juan Pablo Motta</h1>

                        <a href="https://github.com/JuanMotta20" target="_blank" rel="noopener noreferrer" class="inline-flex gap-1.5 mb-3 px-3 py-1 items-center rounded-full text-xs font-semibold bg-gray-900 text-white hover:bg-gray-700 transition-colors duration-200">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 0C5.374 0 0 5.373 0 12c0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23A11.509 11.509 0 0 1 12 5.803c1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576C20.566 21.797 24 17.3 24 12c0-6.627-5.373-12-12-12z"/>
                            </svg>
                            GitHub
                        </a>

                        <!-- Roles -->
                        <div class="flex flex-wrap justify-center gap-1 mb-4">
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-teal-100 text-teal-700 border border-teal-200">Documentador</span>
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-700 border border-amber-200">Analista</span>
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700 border border-emerald-200">Backend</span>
                        </div>

                        <div class="w-full h-px bg-slate-100 mb-4"></div>

                        <!-- Tecnologías -->
                        <div class="flex flex-wrap justify-center gap-1.5">

                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-red-50 text-red-600 border border-red-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500 shrink-0"></span>Laravel
                            </span>

                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-900 border border-blue-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 shrink-0"></span>PHP
                            </span>

                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-cyan-50 text-cyan-600 border border-cyan-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-cyan-400 shrink-0"></span>TailwindCSS
                            </span>

                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-50 text-yellow-700 border border-yellow-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-yellow-400 shrink-0"></span>JavaScript
                            </span>

                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-600 border border-blue-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-400 shrink-0"></span>Alpine.js
                            </span>

                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-600 border border-slate-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-slate-400 shrink-0"></span>SQL
                            </span>
                            
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-purple-50 text-purple-600 border border-purple-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-purple-400 shrink-0"></span>Flux
                            </span>


                            
                        </div>
                    </div>
                </article>

                <!-- Card 4: Alejandro Castañeda — centrado en lg -->
                <article
                    class="group bg-white/90 backdrop-blur-sm rounded-2xl border-2 border-emerald-500/20 shadow-xl shadow-emerald-900/5 overflow-hidden hover:shadow-2xl hover:shadow-emerald-900/10 hover:-translate-y-2 transition-all duration-500 lg:col-start-2"
                    data-aos="fade-up"
                    data-aos-delay="400"
                >
                    <div class="p-6 flex flex-col items-center text-center">
                        <!-- Foto -->
                        <div class="w-28 h-28 rounded-full overflow-hidden border-4 border-emerald-200 shadow-lg shadow-emerald-500/20 mx-auto mb-4">
                            <img
                                src="{{ asset('apprentices/imagen_4.png') }}"
                                alt="Alejandro Castañeda"
                                class="w-full h-full object-cover"
                                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                            />
                            <div style="display:none;width:100%;height:100%;align-items:center;justify-content:center;font-size:1.5rem;font-weight:700;color:white;" class="bg-gradient-to-br from-slate-400 to-slate-600">
                                AC
                            </div>
                        </div>

                        <!-- Nombre -->
                        <h1 class="text-base font-bold text-slate-800 mb-3 leading-tight">Alejandro Castañeda</h1>

                        <!-- Roles -->
                        <div class="flex flex-wrap justify-center gap-1 mb-4">
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-teal-100 text-teal-700 border border-teal-200">Documentador</span>
                        </div>

                        <div class="w-full h-px bg-slate-100 mb-4"></div>

                        <!-- Tecnologías -->
                        <div class="flex flex-wrap justify-center gap-1.5">
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-red-50 text-red-600 border border-red-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500 shrink-0"></span>Laravel
                            </span>
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-cyan-50 text-cyan-600 border border-cyan-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-cyan-400 shrink-0"></span>TailwindCSS
                            </span>
                        </div>
                    </div>
                </article>

            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="px-4 md:px-6 lg:px-8 pb-8" data-aos="fade-up" data-aos-delay="500">
        <div class="max-w-5xl mx-auto text-center border-t border-slate-200/60 pt-6">
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
