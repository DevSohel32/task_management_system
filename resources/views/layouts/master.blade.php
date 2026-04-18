<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Qtec Workspace - My Tasks</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="{{ asset('dist-front/css/style.css') }}">
</head>

<body class="bg-[#F8FAFC]">
    <div class="drawer lg:drawer-open">
        <input id="my-drawer" type="checkbox" class="drawer-toggle" />

        @include('layouts.sidebar')

        <main class="drawer-content flex flex-col min-h-screen">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
