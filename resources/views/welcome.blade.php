<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>SCR</title>

        {{-- styles --}}
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        {{-- Alpina.js --}}
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.15.2/dist/cdn.min.js"></script>

    </head>
    <body class="residuos-body">
        <header class="residuos-hero animate-fade-in">
            <div class="residuos-hero__top">
                <div class="animate-slide-down">
                    <p style="font-weight:600; letter-spacing:0.05em;">Centro Formativo La Angostura</p>
                    <small style="opacity:0.9;">Control de residuos sólidos</small>
                </div>

                <h1 class="residuos-hero__title animate-slide-up">Clasificación de Residuos</h1>

                <div class="residuos-hero__actions animate-slide-down">
                    @if(Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}"
                        class="btn-login btn-login--panel">
                        PANEL
                    </a>
                    @else
                        <a href="{{ route('login') }}"
                        class="btn-login">
                        INICIAR SESIÓN
                    </a>
                    @endauth
            @endif
                </div>
            </div>

            <div class="residuos-logo-center animate-scale-in">
                <img
                    src="{{ asset('img/LOGO S.C.R.jpg') }}"
                    alt="Control de Residuos La Angostura"
                    class="residuos-logo-image" />
            </div>
        </header>

        <main class="residuos-content">
            <section class="residuos-cards">
                <article
                    class="residuos-card animate-card-in"
                    style="animation-delay: 0.1s;">
                    <h3>Introducción</h3>
                    <p>
                        Este software está enfocado en la recepción de la información sobre la generación, clasificación y control de residuos del Centro de Formación Agroindustrial - La Angostura.
                        El sistema está desarrollado para expedir un reporte de registros de los volúmenes por tipos de residuos, lo cual permite un adecuado almacenamiento de datos que permite tomar decisiones para un manejo ambiental sostenible.
                    </p>
                </article>

                <article
                    class="residuos-card animate-card-in"
                    style="animation-delay: 0.2s;">
                    <h3>Unidades y Módulos</h3>
                    <p>
                        En el centro de formación, las unidades productivas y áreas administrativas y de formación generan distintos tipos de residuos, los cuales son dispuestos en los puntos ecológicos y centros de acopio para su adecuada identificación y clasificación, hasta la recolección que realiza el gestor ambiental (EMAC - INCIHUILA), para su adecuada disposición final.
                        El registro de la información permite implementar programas para disminuir la generación, reciclaje y la adecuada disposición de los residuos.
                    </p>
                </article>

                <article
                    class="residuos-card animate-card-in"
                    style="animation-delay: 0.3s;">
                    <h3>Reporte</h3>
                    <p>
                        El software facilita la generación de reportes por tipos de residuos semanal, mensual o anual, incluyendo un registro gráfico e indicadores que permiten realizar el análisis de la información y el seguimiento de los programas del manejo integral de los residuos sólidos generados en el centro de formación.
                    </p>
                </article>
            </section>
        </main>

        <footer
            class="residuos-footer animate-fade-in-up">
            <section>
                <h4>Soporte</h4>
                <form>
                    <input
                        type="text"
                        placeholder="Tu nombre"
                        required>
                    <input
                        type="email"
                        placeholder="Correo"
                        required>
                    <textarea
                        rows="3"
                        placeholder="Comentario"
                        required></textarea>
                    <button type="submit">Enviar</button>
                </form>
            </section>

            <section>
                <h4>Contacto</h4>
                <p style="margin-bottom:0.75rem;">Síguenos en redes para mantenerte informado.</p>
                <div class="residuos-contact">
                    <span class="animate-bounce-in" style="animation-delay: 0.1s;">F</span>
                    <span class="animate-bounce-in" style="animation-delay: 0.2s;">Y</span>
                    <span class="animate-bounce-in" style="animation-delay: 0.3s;">T</span>
                    <span class="animate-bounce-in" style="animation-delay: 0.4s;">IG</span>
                </div>
            </section>
        </footer>
    </body>
</html>
