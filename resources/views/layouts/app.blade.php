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

        <a title="Create new audit" href="{{ route('audits.create') }}"
           class="fixed right-1 bottom-1 flex items-center justify-center br-pill w2 h2 z-999 outline-0 bg-purple b--black-10 shadow-1">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10 10" class="w1 h1">
                <path fill="white" d="M 6,4 H 9.9999998 V 6 H 6 v 4 H 4 V 6 H 0 V 4 H 4 V 0 h 2 z"></path>
            </svg>
        </a>

    </div>

    @stack('scripts')
</body>
</html>
