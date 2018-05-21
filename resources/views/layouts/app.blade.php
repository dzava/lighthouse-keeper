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

        <button title="Create new audit"
            class="input-reset fixed right-1 bottom-1 br-pill w3 h3 z-999 outline-0 bg-purple b--black-10 shadow-1"
            data-toggle-modal="#new-audit-modal">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10 10" class="w1 h1">
                <path fill="white" d="M 6,4 H 9.9999998 V 6 H 6 v 4 H 4 V 6 H 0 V 4 H 4 V 0 h 2 z"></path>
            </svg>
        </button>

        <div class="modal" id="new-audit-modal">
            <div class="modal-mask" data-toggle-modal="#new-audit-modal"></div>
            <div class="mw7 center pa3 mt3 bg-white shadow-5 z-5">
                <form action="{{ route('audits.store') }}" method="POST">
                    @csrf
                    <input type="text" class="input-reset border-box pa2 mb2 w-100 mw-100 ba b--black-20"
                           placeholder="Name this audit"
                           name="name" required>
                    <input type="url" class="input-reset border-box pa2 mb2 w-100 mw-100 ba b--black-20"
                           placeholder="Url"
                           name="url" required>

                    <div class="flex flex-wrap items-center justify-between-ns pa3 ba b--light-gray">
                        <label class="pr2 pb2 pb0-ns">
                            <input type="checkbox" name="accessibility" checked> Accessibility
                        </label>
                        <label class="pr2 pb2 pb0-ns">
                            <input type="checkbox" name="best_practices" checked> Best Practices
                        </label>
                        <label class="pr2 pb2 pb0-ns">
                            <input type="checkbox" name="performance" checked> Performance
                        </label>
                        <label class="pr2 pb2 pb0-ns">
                            <input type="checkbox" name="pwa"> P.W.A
                        </label>
                        <label class="pr2 pb2 pb0-ns">
                            <input type="checkbox" name="seo" checked> SEO
                        </label>
                    </div>

                    <div class="tr">
                        <button class="input-reset relative pa3 mt3 bg-white br1 ba b--black-20">
                            Audit
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    @stack('scripts')
    <script>
        document.querySelectorAll('[data-toggle-modal]').forEach(el => {
            let modal = document.querySelector(el.dataset['toggleModal'])
            if (!modal) {
                return
            }
            el.addEventListener('click', () => {
                modal.classList.toggle('open')
            })
        })
    </script>
</body>
</html>
