<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'KalomUz 📖') }}</title>
        <link rel="icon" href="{{ asset('images/brandlogo/KalomUzLogoTransparent.png') }}" type="image/png">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Google Fonts -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

{{--        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">--}}

        <!-- Custom Styles (Tartibli) -->
        <link href="{{ asset('css/base.css') }}" rel="stylesheet">
        <link href="{{ asset('css/animations.css') }}" rel="stylesheet">
        <link href="{{ asset('css/navbar.css') }}" rel="stylesheet">
        <link href="{{ asset('css/hero-section.css') }}" rel="stylesheet">
        <link href="{{ asset('css/section-info.css') }}" rel="stylesheet">
        <link href="{{ asset('css/section-features.css') }}" rel="stylesheet">
        <link href="{{ asset('css/section-contact.css') }}" rel="stylesheet">
        <link href="{{ asset('css/quran-player.css') }}" rel="stylesheet">
        <link href="{{ asset('css/quran-quiz.css') }}" rel="stylesheet">
        <link href="{{ asset('css/sajda-ayah.css') }}" rel="stylesheet">
        <link href="{{ asset('css/modal.css') }}" rel="stylesheet">
        <link href="{{ asset('css/footer.css') }}" rel="stylesheet">
        <link href="{{ asset('css/main.css') }}" rel="stylesheet">
        <link href="{{ asset('css/responsive.css') }}" rel="stylesheet">
        <link href="{{ asset('css/auth.css') }}" rel="stylesheet">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body>
        <div id="app">
            <!-- Navbar (auth + guest) -->
            @include('partials.navbar')

            <main class="py-4" style="padding-bottom: 0!important;">
                @yield('content')
            </main>

            @include('partials.footer')
        </div>

        <!-- Bootstrap JS Bundle (for dropdowns, modals, etc) -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        <!-- Custom Scripts -->
        <script src="{{ asset('js/main.js') }}" defer></script>
        <script src="{{ asset('js/savedAyahModal.js') }}" defer></script>
        <script src="{{ asset('js/navbar.js') }}" defer></script>
        <script src="{{ asset('js/quran_quiz.js') }}" defer></script>
        <script src="{{ asset('js/sajda-ayah.js') }}" defer></script>
        <script src="{{ asset('js/surah-info.js') }}" defer></script>
        @stack('scripts')
    </body>
</html>
