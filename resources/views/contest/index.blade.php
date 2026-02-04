@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row g-4">
        <!-- Main Info -->
        <div class="col-lg-8">
            <div class="glass-morphism p-5 text-center mb-4 overflow-hidden position-relative">
                <div class="position-absolute top-0 end-0 p-4 opacity-10">
                    <i class="fas fa-moon fa-10x"></i>
                </div>
                <h1 class="display-3 fw-bold text-gradient mb-3">Ramazon Konkursi</h1>
                <p class="h4 text-white mb-5">Bilimingizni oshiring va qimmatbaho sovg'alarni yutib oling!</p>
                
                @if(!$contestUser)
                <form action="{{ route('contest.join') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success btn-lg rounded-pill px-5 py-3 pulse-green border-0 shadow-lg">
                        Konkursga Qo'shilish <i class="fas fa-arrow-right ms-2"></i>
                    </button>
                    <p class="text-muted mt-3">+10 ball bonus bilan boshlang!</p>
                </form>
                @else
                <div class="row g-3 justify-content-center">
                    <div class="col-md-4">
                        <div class="stats-card glass-morphism p-4 border-success">
                            <h2 class="fw-bold text-success mb-0">{{ $contestUser->points }}</h2>
                            <small class="text-muted">Umumiy ballar</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stats-card glass-morphism p-4 border-info">
                            <h2 class="fw-bold text-info mb-0">{{ $contestUser->referrals_count }}</h2>
                            <small class="text-muted">Referallar</small>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Rules / How to earn points -->
            <div class="glass-morphism p-4 mb-4">
                <h4 class="text-white mb-4 border-bottom border-white border-opacity-10 pb-2">Ballar qanday to'planadi?</h4>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center gap-3 p-3 rounded-4 bg-white bg-opacity-5">
                            <div class="h3 mb-0 text-success">1</div>
                            <div>
                                <h6 class="text-white mb-0">Qur'an Quiz</h6>
                                <small class="text-muted">Hamma to'g'ri javob uchun 1 ball</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-center gap-3 p-3 rounded-4 bg-white bg-opacity-5">
                            <div class="h3 mb-0 text-info">10</div>
                            <div>
                                <h6 class="text-white mb-0">Referal tizimi</h6>
                                <small class="text-muted">Har bir yangi do'stingiz uchun 10 ball</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Referral Link -->
            @if($contestUser)
            <div class="glass-morphism p-4">
                <h5 class="text-white mb-3 text-center">Do'stlaringizni taklif qiling:</h5>
                <div class="input-group">
                    <input type="text" class="form-control glass-input border-0 py-3" value="{{ url('/register?ref=' . Auth::id()) }}" id="ref-link" readonly>
                    <button class="btn btn-success px-4" onclick="copyRef()">Nusxa olish</button>
                </div>
            </div>
            @endif
        </div>

        <!-- Leaderboard -->
        <div class="col-lg-4">
            <div class="glass-morphism p-4 h-100">
                <h4 class="text-white mb-4 text-center">Top 10 Leaderboard</h4>
                <div class="leaderboard-list">
                    @foreach($leaderboard as $index => $leader)
                    <div class="leader-item d-flex align-items-center justify-content-between p-3 mb-2 rounded-4 {{ $index < 3 ? 'bg-success bg-opacity-10 border-success border-opacity-25' : 'bg-white bg-opacity-5' }}">
                        <div class="d-flex align-items-center gap-3">
                            <span class="fw-bold {{ $index == 0 ? 'text-warning' : ($index == 1 ? 'text-light' : ($index == 2 ? 'text-secondary' : 'text-muted')) }}">
                                #{{ $index + 1 }}
                            </span>
                            <span class="text-white">{{ $leader->name }}</span>
                        </div>
                        <span class="fw-bold text-success">{{ $leader->points }} b.</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.stats-card {
    border: 1px solid rgba(255,255,255,0.1);
    transition: transform 0.3s ease;
}
.stats-card:hover {
    transform: translateY(-5px);
}
.glass-input {
    background: rgba(255, 255, 255, 0.05);
    color: #fff;
}
.leader-item {
    border: 1px solid transparent;
}
</style>

<script>
function copyRef() {
    const copyText = document.getElementById("ref-link");
    copyText.select();
    document.execCommand("copy");
    alert("Referal havola nusxalandi!");
}
</script>
@endsection
