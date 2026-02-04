@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-4">
            <!-- Profile Card -->
            <div class="glass-morphism p-4 text-center mb-4 transition-up">
                <div class="profile-avatar mb-3 mx-auto">
                    <div class="avatar-placeholder rounded-circle mx-auto d-flex align-items-center justify-content-center bg-success-gradient" style="width: 120px; height: 120px;">
                        <span class="h1 text-white mb-0">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                    </div>
                </div>
                <h3 class="text-white fw-bold mb-1">{{ $user->name }} {{ $user->last_name }}</h3>
                <p class="text-muted">{{ $user->email }}</p>
                <div class="bg-success-gradient rounded-pill px-3 py-1 d-inline-block text-white small mb-3">
                    Faol ishtirokchi
                </div>
                <hr class="border-secondary opacity-25">
                <div class="row text-center mt-3">
                    <div class="col-6">
                        <h5 class="text-white mb-0">{{ $user->savedAyahs()->count() }}</h5>
                        <small class="text-muted">Saqlanganlar</small>
                    </div>
                    <div class="col-6">
                        <h5 class="text-white mb-0">{{ $points }}</h5>
                        <small class="text-muted">Ballar</small>
                    </div>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="glass-morphism p-3 mb-4">
                <div class="list-group list-group-flush">
                    <a href="{{ route('saved.ayahs') }}" class="list-group-item list-group-item-action bg-transparent text-white border-0 py-3">
                        <i class="fas fa-bookmark me-3 text-success"></i> Saqlangan oyatlar
                    </a>
                    <a href="{{ route('notifications.index') }}" class="list-group-item list-group-item-action bg-transparent text-white border-0 py-3">
                        <i class="fas fa-bell me-3 text-warning"></i> Bildirishnomalar
                    </a>
                    <a href="{{ route('messages.index') }}" class="list-group-item list-group-item-action bg-transparent text-white border-0 py-3">
                        <i class="fas fa-envelope me-3 text-info"></i> Xabarlar
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <!-- Edit Profile Form -->
            <div class="glass-morphism p-4 mb-4">
                <h4 class="text-white fw-bold mb-4"><i class="fas fa-user-edit me-2"></i> Profilni tahrirlash</h4>

                @if(session('success'))
                    <div class="alert alert-success border-0 bg-success bg-opacity-10 text-success">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted">Ism</label>
                            <input type="text" name="name" class="form-control glass-input" value="{{ old('name', $user->name) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted">Familiya</label>
                            <input type="text" name="last_name" class="form-control glass-input" value="{{ old('last_name', $user->last_name) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted">Username (unikal)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-end-0 text-muted" style="border: 1px solid rgba(255,255,255,0.1); border-radius: 10px 0 0 10px;">@</span>
                                <input type="text" name="username" class="form-control glass-input" value="{{ old('username', $user->username) }}" placeholder="foydalanuvchi_nomi" style="border-top-left-radius: 0; border-bottom-left-radius: 0;">
                            </div>
                            @error('username')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted">Email</label>
                            <input type="email" name="email" class="form-control glass-input" value="{{ old('email', $user->email) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted">Telefon</label>
                            <input type="text" name="phone" class="form-control glass-input" value="{{ old('phone', $user->phone) }}">
                        </div>
                        
                        <div class="col-12 mt-4">
                            <h5 class="text-white border-bottom border-light border-opacity-10 pb-2">Parolni yangilash</h5>
                            <p class="text-muted small">Parolni o'zgartirmoqchi bo'lsangizgina quyidagilarni to'ldiring</p>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-muted">Yangi parol</label>
                            <input type="password" name="password" class="form-control glass-input">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted">Parolni tasdiqlash</label>
                            <input type="password" name="password_confirmation" class="form-control glass-input">
                        </div>

                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-success rounded-pill px-5 py-2">
                                Saqlash <i class="fas fa-save ms-2"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.bg-success-gradient {
    background: linear-gradient(135deg, #2ecc71 0%, #27ae60 100%);
}

.glass-input {
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.1);
    color: white;
    padding: 12px 15px;
    border-radius: 10px;
}

.glass-input:focus {
    background: rgba(255, 255, 255, 0.08);
    border-color: #2ecc71;
    color: white;
    box-shadow: none;
}

.list-group-item:hover {
    background: rgba(46, 204, 113, 0.1) !important;
}

.avatar-placeholder {
    box-shadow: 0 10px 30px rgba(46, 204, 113, 0.3);
}
</style>
@endsection
