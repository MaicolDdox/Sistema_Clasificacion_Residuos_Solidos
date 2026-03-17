<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Error - Mensaje' }} — SCR</title>
    <link rel="icon" href="{{ asset('img/logo_header.jpeg') }}" type="image/jpeg">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css'])
</head>
<body class="font-sans antialiased bg-slate-50 min-h-screen flex flex-col">

    {{-- Top bar --}}
    <header class="bg-white border-b border-slate-200 px-4 py-3">
        <div class="max-w-5xl mx-auto flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-emerald-50/80 border border-emerald-100 flex items-center justify-center overflow-hidden">
                    <img src="{{ asset('img/imagen1.png') }}" alt="SCR" class="w-6 h-6 object-contain">
                </div>
                <div>
                    <p class="text-sm font-semibold text-slate-800 leading-none">SCR</p>
                    <p class="text-[10px] text-slate-400">Clasificación de Residuos</p>
                </div>
            </div>
            @auth
            <div class="flex gap-5">
                <span class="text-xs text-slate-500">Tu correo: {{ Auth::user()->email }}</span>
                 <span class="text-xs text-slate-500">Rol Actual: {{ Auth::user()->roles()->first()?->name }}</span>
                 </div>
            @endauth
        </div>
    </header>

    {{-- Contenido --}}
    <main class="flex-1 flex items-center justify-center p-4 sm:p-8">
        {{ $slot }}
    </main>

</body>
</html>
