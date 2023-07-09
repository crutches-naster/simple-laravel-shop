<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'My Laravel shop') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>

    <!-- Scripts -->
    @vite(['resources/admin/css/app.scss', 'resources/admin/js/app.js'])
</head>
<body class="m-0 font-sans text-base antialiased font-normal leading-default bg-gray-50 text-slate-500">
<div class="min-h-screen bg-gray-100">
    <!-- Side navbar -->
    @include('admin.navs.side_nav')
    <main class="ease-soft-in-out xl:ml-68.5 relative h-full max-h-screen rounded-xl transition-all duration-200">
        <!-- Top navbar -->
        @include('admin.navs.top_nav')
        {{ $slot }}
    </main>
</div>
</body>
</html>
