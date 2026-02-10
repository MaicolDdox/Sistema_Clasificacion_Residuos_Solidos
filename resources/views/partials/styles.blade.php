<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- SEO Primary Meta Tags -->
<title>Clasificación de Residuos Sólidos - Sistema de Control SCR</title>
<meta name="description" content="Aplicativo web de clasificación de residuos sólidos del Centro de Formación Agroindustrial La Angostura - SENA. Sistema para la gestión, clasificación y control ambiental de residuos sólidos.">
<meta name="keywords" content="clasificación de residuos sólidos, gestión de residuos, control ambiental, residuos sólidos, reciclaje, manejo ambiental, SENA, La Angostura, centro de formación agroindustrial, puntos ecológicos, acopio de residuos">
<meta name="author" content="Centro de Formación Agroindustrial La Angostura - SENA">
<meta name="robots" content="index, follow">
<link rel="canonical" href="{{ url('/') }}">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="{{ url('/') }}">
<meta property="og:title" content="Clasificación de Residuos Sólidos - SCR">
<meta property="og:description" content="Sistema web para la clasificación y control de residuos sólidos del Centro de Formación Agroindustrial La Angostura - SENA.">
<meta property="og:image" content="{{ asset('img/LOGO S.C.R.jpg') }}">
<meta property="og:locale" content="es_CO">
<meta property="og:site_name" content="SCR - Sistema de Clasificación de Residuos Sólidos">

<!-- Twitter -->
<meta name="twitter:card" content="summary">
<meta name="twitter:title" content="Clasificación de Residuos Sólidos - SCR">
<meta name="twitter:description" content="Sistema web para la clasificación y control de residuos sólidos del Centro de Formación Agroindustrial La Angostura.">
<meta name="twitter:image" content="{{ asset('img/LOGO S.C.R.jpg') }}">

<!-- Favicon -->
<link rel="icon" href="{{ asset('img/LOGO S.C.R.jpg') }}" type="image/jpeg" class="rounded-md object-cover">
<link rel="apple-touch-icon" href="{{ asset('img/LOGO S.C.R.jpg') }}" class="rounded-md object-cover">

<!-- Fonts -->
<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700" rel="stylesheet" />

<!-- Scripts -->
@vite(['resources/css/app.css', 'resources/js/app.js'])
