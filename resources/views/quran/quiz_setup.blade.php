@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="glass-morphism p-5 text-center mb-5">
                <h1 class="display-4 fw-bold text-gradient mb-3">Quiz Yaratish</h1>
                <p class="text-muted">Bilimingizni sinab ko'ring va konkursda ballar yig'ing!</p>
            </div>

            <div class="glass-morphism p-5">
                <form action="{{ route('quran.quiz.generate') }}" method="POST">
                    @csrf
                    
                    <div class="mb-5">
                        <label class="form-label text-white fw-bold mb-3 d-block h5">Juzlarni tanlang:</label>
                        <div class="row g-2">
                            @for($i = 1; $i <= 30; $i++)
                            <div class="col-2 col-md-1">
                                <input type="checkbox" class="btn-check" name="juzs[]" value="{{ $i }}" id="juz{{ $i }}" {{ $i == 1 ? 'checked' : '' }}>
                                <label class="btn btn-outline-success w-100 rounded-3 p-2" for="juz{{ $i }}">{{ $i }}</label>
                            </div>
                            @endfor
                        </div>
                        <div class="mt-3">
                            <button type="button" class="btn btn-sm btn-outline-info rounded-pill" onclick="toggleAllJuz(true)">Barchasini tanlash</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill" onclick="toggleAllJuz(false)">Hammasini bekor qilish</button>
                        </div>
                    </div>

                    <div class="row g-4 mb-5">
                        <div class="col-md-6">
                            <label class="form-label text-white fw-bold h5">Savollar soni:</label>
                            <select name="count" class="form-select glass-input border-0 p-3">
                                <option value="5">5 ta</option>
                                <option value="10" selected>10 ta</option>
                                <option value="15">15 ta</option>
                                <option value="20">20 ta</option>
                                <option value="30">30 ta</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-white fw-bold h5">Vaqt limiti (har bir savol uchun):</label>
                            <select name="time" class="form-select glass-input border-0 p-3">
                                <option value="15">15 sek</option>
                                <option value="30" selected>30 sek</option>
                                <option value="45">45 sek</option>
                                <option value="60">60 sek</option>
                            </select>
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-success btn-lg rounded-pill px-5 py-3 shadow-lg pulse-green">
                            <i class="fas fa-play me-2"></i> Quizni Boshlash
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.glass-input {
    background: rgba(255, 255, 255, 0.05);
    color: white;
    backdrop-filter: blur(10px);
}

.form-select option {
    background: #222;
    color: white;
}

.pulse-green {
    animation: pulse-green 2s infinite;
}

@keyframes pulse-green {
    0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(46, 204, 113, 0.7); }
    70% { transform: scale(1.05); box-shadow: 0 0 0 10px rgba(46, 204, 113, 0); }
    100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(46, 204, 113, 0); }
}
</style>

<script>
function toggleAllJuz(state) {
    document.querySelectorAll('input[name="juzs[]"]').forEach(cb => cb.checked = state);
}
</script>
@endsection
