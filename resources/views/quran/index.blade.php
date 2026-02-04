@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold text-gradient">Suralar</h1>
        <p class="text-muted">Qur'oni Karim suralari ro'yxati</p>
    </div>

    <div class="row g-4" id="surah-grid">
        @foreach($surahs as $surah)
        <div class="col-md-4 col-lg-3">
            <a href="{{ route('quran.show', $surah['number']) }}" class="text-decoration-none">
                <div class="surah-card glass-morphism p-4 h-100 transition-up">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="surah-number">{{ $surah['number'] }}</span>
                        <span class="arabic-text-sm">{{ $surah['name'] }}</span>
                    </div>
                    <h5 class="fw-bold mb-1">{{ $surah['englishName'] }}</h5>
                    <p class="text-muted small mb-0">{{ $surah['englishNameTranslation'] }} • {{ $surah['numberOfAyahs'] }} oyat</p>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>

<style>
.text-gradient {
    background: linear-gradient(45deg, #2ecc71, #27ae60);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.glass-morphism {
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 20px;
    color: white;
}

.surah-card {
    transition: all 0.3s ease;
}

.surah-card:hover {
    background: rgba(255, 255, 255, 0.1);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
}

.transition-up:hover {
    transform: translateY(-5px);
}

.surah-number {
    width: 40px;
    height: 40px;
    background: #2ecc71;
    color: white;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    transform: rotate(45deg);
}

.surah-number span {
    transform: rotate(-45deg);
}

.arabic-text-sm {
    font-family: 'Traditional Arabic', serif;
    font-size: 1.2rem;
    color: #2ecc71;
}

[data-bs-theme="dark"] .text-muted {
    color: #adb5bd !important;
}
</style>
@endsection
