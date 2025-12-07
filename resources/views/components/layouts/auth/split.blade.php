<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white antialiased dark:bg-linear-to-b dark:from-neutral-950 dark:to-neutral-900">
        <div class="relative grid h-dvh flex-col items-center justify-center px-8 sm:px-0 lg:max-w-none lg:grid-cols-2 lg:px-0">

            <div
                class="bg-muted relative hidden h-full flex-col p-10 text-white lg:flex dark:border-e dark:border-neutral-800 bg-cover bg-center"
                style="background-image: url('{{ asset('img/auth.jpg') }}');"
            >
                <div class="absolute inset-0 bg-neutral-900/70"></div>
                <a href="{{ route('home') }}" class="relative z-20 flex items-center text-lg font-medium" wire:navigate>
                    {{ config('app.name', 'SCR') }}
                </a>

                <div class="relative z-20 mt-auto space-y-6">
                    <blockquote class="space-y-3 max-w-xl">
                        <p class="text-lg font-medium leading-relaxed text-gray-100 drop-shadow">
                            SERVICIO NACIONAL DE APRENDIZAJE SENASENA EMPRESA
                        </p>
                        <footer>
                            <flux:heading class="text-gray-200 drop-shadow-sm">Sistema De Clasificacion Residuos Solidos</flux:heading>
                        </footer>
                    </blockquote>
                </div>
            </div>

            <div class="w-full lg:p-8">
                <div class="mx-auto flex w-full flex-col justify-center space-y-6 sm:w-[350px]">
                    <a href="{{ route('home') }}" class="z-20 flex flex-col items-center gap-2 font-medium lg:hidden" wire:navigate>
                        <span class="sr-only">{{ config('app.name', 'SCR') }}</span>
                    </a>
                    <div class="flex justify-center">
                        <img
                            src="{{ asset('img/imagen1.png') }}"
                            alt="Logo Sistema de Clasificacion de Residuos"
                            class="h-16 w-auto object-contain drop-shadow"
                            loading="lazy"
                        />
                    </div>
                    {{ $slot }}
                </div>
            </div>
        </div>
        @fluxScripts
    </body>
</html>
