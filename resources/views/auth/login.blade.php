@extends('layouts.app')

@section('content')
    <div class="bg-image-overlay"></div>
    <div class="login-bg-kalomuz">
        <div class="login-blur-container">
            <h2 class="mb-4" style="color:#2f7d3a;">Kirish</h2>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-floating mb-3">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                           name="email" value="{{ old('email') }}" required placeholder="Email">
                    <label for="email">Email</label>
                    @error('email')
{{--                    <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>--}}
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

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                        {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">
                        Eslab qolish
                    </label>
                </div>

                <button type="submit" class="btn btn-success w-100 mb-2">Kirish</button>

                @if (Route::has('password.request'))
                    <a class="btn btn-link p-0" href="{{ route('password.request') }}">
                        Parolni unutdingizmi?
                    </a>
                @endif

                <div class="mt-3 text-center">
                    <span>Hisobingiz yo‘qmi? <a href="{{ route('register') }}" class="text-success fw-bold">Ro‘yxatdan o‘tish</a></span>
                </div>
            </form>
        </div>
    </div>
@endsection
