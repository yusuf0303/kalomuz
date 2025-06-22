@extends('layouts.app')

@section('content')
    @include('partials.hero')
    @include('partials.header')
{{--    @include('partials.section-features', ['cards' => $cards])--}}
    @include('partials.section-contact')

{{--    <div class="container py-5">--}}
{{--        <div class="row justify-content-center">--}}
{{--            <div class="col-md-8">--}}
{{--                <div class="card shadow-lg" style="border-radius: 18px;">--}}
{{--                    <div class="card-header bg-success text-white text-center" style="font-size: 1.3rem; letter-spacing: 1px;">--}}
{{--                        KalomUz — Bosh Sahifa--}}
{{--                    </div>--}}
{{--                    <div class="card-body text-center">--}}
{{--                        @if (session('status'))--}}
{{--                            <div class="alert alert-success" role="alert">--}}
{{--                                {{ session('status') }}--}}
{{--                            </div>--}}
{{--                        @endif--}}

{{--                        <h2 class="mb-3" style="color: #256029;">Assalomu alaykum, {{ Auth::user()->name ?? 'Mehmon' }}!</h2>--}}
{{--                        <p class="lead mb-4">--}}
{{--                            KalomUz platformasiga xush kelibsiz!<br>--}}
{{--                            Qur'on va islomiy bilimlar, quizlar, sajda oyatlari va ko‘plab foydali manbalar shu yerda.--}}
{{--                        </p>--}}

{{--                        <a href="{{ route('quran.quiz') }}" class="btn btn-success btn-lg mb-2">--}}
{{--                            Qur'on Quizni Boshlash--}}
{{--                        </a>--}}
{{--                        <a href="{{ route('sajda.ayahs') }}" class="btn btn-outline-secondary btn-lg mb-2 ms-2">--}}
{{--                            Sajda Oyatlari--}}
{{--                        </a>--}}
{{--                        <hr>--}}
{{--                        <small class="text-muted">Yana savollar yoki takliflaringiz bo‘lsa, <b>Aloqa</b> bo‘limi orqali yuboring.</small>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
@endsection
