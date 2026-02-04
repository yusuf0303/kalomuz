@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold text-gradient">Sajda Oyatlari</h1>
        <p class="text-muted">Qur'oni Karimdagi sajda qilish vojib yoki mustahab bo'lgan oyatlar</p>
    </div>

    <div class="row">
        <div class="col-lg-10 mx-auto">
            @foreach($ayahs as $ayah)
            <div class="ayah-card glass-morphism p-4 mb-4 transition-up position-relative overflow-hidden">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="surah-badge bg-success p-2 px-3 rounded-pill small">
                            {{ $ayah['surah']['englishName'] }} • {{ $ayah['numberInSurah'] }}-oyat
                        </div>
                        <span class="badge bg-danger rounded-pill pulse">Sajda</span>
                    </div>
                </div>

                <div class="arabic-text text-end mb-4" dir="rtl">
                    {{ $ayah['text'] }}
                </div>

                <div class="translation-text mb-4">
                    <span class="text-success fw-bold me-2">Tarjima:</span>
                    {{ $ayah['translation'] }}
                </div>

                <div class="audio-player mb-4">
                    <audio controls class="w-100 sajda-audio">
                        <source src="{{ $ayah['audio'] }}" type="audio/mpeg">
                    </audio>
                </div>
                
                <div class="sajda-info p-3 bg-white-5 rounded-3 italic small">
                    <i class="fas fa-info-circle me-2 text-info"></i> Bu oyat o'qilganda yoki eshitilganda sajda qilish tavsiya etiladi.
                </div>
                
                <div class="card-bg-icon">
                    <i class="fas fa-pray"></i>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<style>
.sajda-audio {
    filter: invert(1) hue-rotate(90deg) brightness(1.2);
    height: 40px;
}

.translation-text {
    line-height: 1.6;
    color: #e0e0e0;
    border-left: 3px solid #28a745;
    padding-left: 15px;
}

.bg-white-5 {
    background: rgba(255, 255, 255, 0.05);
}

.italic {
    font-style: italic;
}

.pulse {
    animation: pulse-red 2s infinite;
}

@keyframes pulse-red {
    0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.7); }
    70% { transform: scale(1); box-shadow: 0 0 0 10px rgba(220, 53, 69, 0); }
    100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(220, 53, 69, 0); }
}

.card-bg-icon {
    position: absolute;
    bottom: -20px;
    right: -20px;
    font-size: 8rem;
    opacity: 0.03;
    color: white;
    transform: rotate(-15deg);
    pointer-events: none;
}
</style>
@endsection
