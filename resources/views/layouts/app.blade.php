<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
    @stack('styles')
</head>
<body class="text-gray-800 bg-gray-200 relative">

    <div id="app">

        <nav class="relative p-4 pb-0 container mx-auto flex flex-col md:flex-row md:items-center justify-between">
            <div class="text-xl">
                <a href="{{ route('audits') }}" class="no-underline text-gray-800">Lighthouse keeper</a>
            </div>

            <div class="md:flex flex-1 items-center">

                <div class="relative group ml-auto flex">

                    <a href="{{ route('audits.create') }}"
                       class="md:px-4 px-2 py-4 block text-black no-underline hover:bg-gray-100">
                        New audit
                    </a>
                    <a href="{{ route('audits.index') }}"
                       class="md:px-4 px-2 py-4 block text-black no-underline hover:bg-gray-100">
                        All audits
                    </a>

                </div>
            </div>
        </nav>

        <main class="">
            @yield('content')
        </main>

        <flash message="{{ session('flash') }}" level="{{ session('flash_level', 'info') }}"></flash>
    </div>

    <script src="{{ mix('js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>
