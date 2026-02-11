<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="csrf-token" content="{{ csrf_token() }}" />

<title>{{ $title ?? 'Panel' }} - Clasificación de Residuos Sólidos</title>
<meta name="description" content="Sistema de clasificación y control de residuos sólidos - Centro de Formación Agroindustrial La Angostura, SENA.">
<meta name="robots" content="noindex, nofollow">

<!-- Favicon -->
<link rel="icon" href="{{ asset('img/logo_header.jpeg') }}" type="image/jpeg">
<link rel="apple-touch-icon" href="{{ asset('img/logo_header.jpeg') }}">

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

@vite(['resources/css/app.css', 'resources/js/app.js'])
@fluxAppearance
