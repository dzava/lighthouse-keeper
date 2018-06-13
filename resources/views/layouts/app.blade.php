<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/tachyons@4.9.1/css/tachyons.min.css"/>
    @stack('styles')
</head>
<body class="dark-gray bg-light-gray relative">

    <div id="app">
        <main class="py-4">
            @yield('content')
        </main>

        <div class="fab">
            <button class="fab-button fab-button--primary">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="black-90 w1 h1">
                    <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z" fill="white"></path>
                </svg>
            </button>

            @stack('fab-start')
            <a class="fab-button fab-button--secondary" href="{{ route('audits.create') }}">New Audit</a>
            <a class="fab-button fab-button--secondary" href="{{ route('audits.index') }}">All Audits</a>
        </div>

        <flash message="{{ session('flash') }}" level="{{ session('flash_level', 'info') }}"></flash>
    </div>

    <script src="{{ mix('js/app.js') }}"></script>
    <script>
        Array.from(document.querySelectorAll('.fab-button--primary')).forEach(el => {
            const fab = el.closest('.fab')
            el.addEventListener('click', () => {
                fab.classList.toggle('is-expanded')
            })
        })
    </script>
    @stack('scripts')
</body>
</html>
