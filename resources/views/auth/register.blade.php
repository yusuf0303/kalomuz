@extends('layouts.app')

@section('content')
    <div class="bg-image-overlay"></div>
    <div class="login-bg-kalomuz">
        <div class="login-blur-container">
            <h2 class="mb-4" style="color:#2f7d3a;">Ro‘yxatdan o‘tish</h2>
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-floating mb-3">
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                           name="name" value="{{ old('name') }}" required autofocus placeholder="Ism">
                    <label for="name">Ism</label>
                    @error('name')
                    <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                           id="last_name" name="last_name" placeholder="Familiya"
                           value="{{ old('last_name') }}" required>
                    <label for="last_name">Familiya</label>
                    @error('last_name')
                    <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="form-floating mb-3">
                    <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror"
                           name="phone" value="{{ old('phone') }}" required placeholder="Telefon raqam">
                    <label for="phone">Telefon raqam</label>
                    @error('phone')
                    <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="form-floating mb-3">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                           name="email" value="{{ old('email') }}" required placeholder="Email">
                    <label for="email">Email</label>
                    @error('email')
                    <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="form-floating mb-3">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                           name="password" required placeholder="Parol">
                    <label for="password">Parol</label>
                    @error('password')
                    <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="form-floating mb-3">
                    <input id="password_confirmation" type="password" class="form-control"
                           name="password_confirmation" required placeholder="Parolni tasdiqlang">
                    <label for="password_confirmation">Parolni tasdiqlang</label>
                </div>


                <button type="submit" class="btn btn-success w-100 mb-2">Ro‘yxatdan o‘tish</button>

                <div class="mt-3 text-center">
                    <span>Hisobingiz bormi? <a href="{{ route('login') }}" class="text-success fw-bold">Kirish</a></span>
                </div>

{{--                <div class="social-login">--}}
{{--                    <a href="" class="btn-social btn-google"> --}}{{--{{ route('social.login', ['provider' => 'google']) }}--}}
{{--                        <i class="fab fa-google"></i> Google--}}
{{--                    </a>--}}
{{--                    <a href="" class="btn-social btn-facebook"> --}}{{--{{ route('social.login', ['provider' => 'facebook']) }}--}}
{{--                        <i class="fab fa-facebook"></i> Facebook--}}
{{--                    </a>--}}
{{--                    --}}{{-- Agar Instagram (yoki boshqa) ham sozlansa --}}
{{--                    --}}{{-- <a href="{{ route('social.login', ['provider' => 'instagram']) }}" class="btn-social btn-instagram">--}}
{{--                        <i class="fab fa-instagram"></i> Instagram orqali kirish--}}
{{--                    </a> --}}
{{--                </div>--}}

            </form>
        </div>
    </div>
@endsection
