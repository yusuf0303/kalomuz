<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'KalomUz 📖') }}</title>
        <link rel="icon" href="{{ secure_asset('images/brandlogo/KalomUzLogoTransparent.png') }}" type="image/png">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Google Fonts -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">


        <!-- Custom Styles (Tartibli) -->
        <link href="{{ secure_asset('css/base.css') }}" rel="stylesheet">
        <link href="{{ secure_asset('css/animations.css') }}" rel="stylesheet">
        <link href="{{ secure_asset('css/navbar.css') }}" rel="stylesheet">
        <link href="{{ secure_asset('css/hero-section.css') }}" rel="stylesheet">
        <link href="{{ secure_asset('css/section-info.css') }}" rel="stylesheet">
        <link href="{{ secure_asset('css/section-features.css') }}" rel="stylesheet">
        <link href="{{ secure_asset('css/section-contact.css') }}" rel="stylesheet">
        <link href="{{ secure_asset('css/quran-player.css') }}" rel="stylesheet">
        <link href="{{ secure_asset('css/quran-quiz.css') }}" rel="stylesheet">
        <link href="{{ secure_asset('css/sajda-ayah.css') }}" rel="stylesheet">
        <link href="{{ secure_asset('css/modal.css') }}" rel="stylesheet">
        <link href="{{ secure_asset('css/footer.css') }}" rel="stylesheet">
        <link href="{{ secure_asset('css/main.css') }}" rel="stylesheet">
        <link href="{{ secure_asset('css/responsive.css') }}" rel="stylesheet">
        <link href="{{ secure_asset('css/auth.css') }}" rel="stylesheet">
        <link href="{{ secure_asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body>
        <div id="app">
            <!-- Navbar (auth + guest) -->
            @include('partials.navbar')

            <main class="py-4" style="padding-bottom: 0!important;">
                @yield('content')
            </main>

            @if (!View::hasSection('no-footer'))
                @include('partials.footer')
            @endif

        </div>

        <!-- Bootstrap JS Bundle (for dropdowns, modals, etc) -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        <!-- Custom Scripts -->
        <script src="{{ secure_asset('js/main.js') }}" defer></script>
        <script src="{{ secure_asset('js/savedAyahModal.js') }}" defer></script>
        <script src="{{ secure_asset('js/navbar.js') }}" defer></script>
        <script src="{{ secure_asset('js/quran_quiz.js') }}" defer></script>
        <script src="{{ secure_asset('js/sajda-ayah.js') }}" defer></script>
        <script src="{{ secure_asset('js/surah-info.js') }}" defer></script>
        @stack('scripts')
<script>document.addEventListener("DOMContentLoaded", function() { const mobileMenuBtn = document.querySelector(".hamburger"); const navbar = document.querySelector(".navbar"); if (mobileMenuBtn && navbar) { mobileMenuBtn.addEventListener("click", function() { navbar.classList.toggle("active"); }); } });</script>
    </body>
</html>
