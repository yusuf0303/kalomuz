@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h1 class="display-4 fw-bold text-gradient mb-0">Saqlangan Oyatlar</h1>
            <p class="text-muted">Sizning sevimli va saqlab qo'yilgan oyatlaringiz to'plami</p>
        </div>
        <a href="{{ route('quran.index') }}" class="btn btn-outline-success rounded-pill px-4">
            <i class="fas fa-plus me-2"></i> Yangi saqlash
        </a>
    </div>

    @if($savedAyahs->isEmpty())
        <div class="text-center py-5">
            <div class="glass-morphism p-5 d-inline-block">
                <i class="fas fa-bookmark fa-4x text-muted mb-4 opacity-25"></i>
                <h3 class="text-white">Hozircha hech narsa yo'q</h3>
                <p class="text-muted">Qur'on o'qish jarayonida o'zingizga yoqqan oyatlarni saqlab qo'yishingiz mumkin.</p>
                <a href="{{ route('quran.index') }}" class="btn btn-success rounded-pill mt-3 px-5">Suralarni ko'rish</a>
            </div>
        </div>
    @else
        <div class="row g-4">
            @foreach($savedAyahs as $ayah)
                <div class="col-12" id="ayah-card-{{ $ayah->id }}">
                    <div class="glass-morphism p-4 transition-up position-relative overflow-hidden">
                        <!-- Background decoration -->
                        <div class="position-absolute end-0 top-0 p-3 opacity-10">
                            <i class="fas fa-quran fa-6x"></i>
                        </div>

                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="badge bg-success bg-opacity-25 text-success rounded-pill px-3 py-2 me-3">
                                        Surah {{ $ayah->surah }}, Ayah {{ $ayah->ayah }}
                                    </div>
                                    <small class="text-muted">{{ $ayah->created_at->diffForHumans() }}</small>
                                </div>
                                
                                @if($ayah->text)
                                    <div class="ayah-text-arabic text-end mb-3" style="font-family: 'Amiri', serif; font-size: 1.8rem; line-height: 2.5; color: #f5f5dc;">
                                        {{ $ayah->text }}
                                    </div>
                                @endif

                                @if($ayah->audio)
                                    <div class="d-flex align-items-center gap-3">
                                        <button class="btn btn-primary rounded-circle play-audio-btn" data-audio="{{ $ayah->audio }}" style="width: 50px; height: 50px;">
                                            <i class="fas fa-play"></i>
                                        </button>
                                        <div class="flex-grow-1">
                                            <div class="progress bg-white bg-opacity-10" style="height: 4px;">
                                                <div class="progress-bar bg-primary" role="progressbar" style="width: 0%"></div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-4 text-center mt-4 mt-md-0">
                                @if($ayah->ayah_image)
                                    <div class="ayah-image-container glass-morphism p-2 rounded-3 inline-block">
                                        <img src="{{ $ayah->ayah_image }}" alt="Ayah" class="img-fluid rounded" style="max-height: 150px;">
                                    </div>
                                @endif
                                
                                <div class="mt-3">
                                    <button class="btn btn-outline-danger btn-sm rounded-pill px-3 delete-ayah-btn" data-id="{{ $ayah->id }}">
                                        <i class="fas fa-trash-alt me-2"></i> O'chirish
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<audio id="global-audio-player"></audio>

<style>
.ayah-text-arabic {
    text-shadow: 0 2px 10px rgba(0,0,0,0.3);
}

.ayah-image-container {
    background: rgba(255,255,255,0.02);
    border: 1px solid rgba(255,255,255,0.05);
}

.bg-success-gradient {
    background: linear-gradient(135deg, #2ecc71 0%, #27ae60 100%);
}
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const audioPlayer = document.getElementById('global-audio-player');
    let currentBtn = null;

    document.querySelectorAll('.play-audio-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const url = this.dataset.audio;
            
            if (currentBtn === this && !audioPlayer.paused) {
                audioPlayer.pause();
                this.innerHTML = '<i class="fas fa-play"></i>';
                return;
            }

            if (currentBtn) {
                currentBtn.innerHTML = '<i class="fas fa-play"></i>';
                const oldBar = currentBtn.closest('.row').querySelector('.progress-bar');
                if(oldBar) oldBar.style.width = '0%';
            }

            currentBtn = this;
            audioPlayer.src = url;
            audioPlayer.play();
            this.innerHTML = '<i class="fas fa-pause"></i>';
        });
    });

    audioPlayer.addEventListener('timeupdate', function() {
        if (currentBtn) {
            const bar = currentBtn.closest('.row').querySelector('.progress-bar');
            if (bar) {
                const percent = (audioPlayer.currentTime / audioPlayer.duration) * 100;
                bar.style.width = percent + '%';
            }
        }
    });

    audioPlayer.addEventListener('ended', function() {
        if (currentBtn) {
            currentBtn.innerHTML = '<i class="fas fa-play"></i>';
            const bar = currentBtn.closest('.row').querySelector('.progress-bar');
            if (bar) bar.style.width = '0%';
        }
    });

    // Delete functionality
    document.querySelectorAll('.delete-ayah-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            if (!confirm('Haqiqatdan ham o\'chirmoqchimisiz?')) return;

            const id = this.dataset.id;
            fetch(`/saved-ayahs/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'deleted') {
                    document.getElementById(`ayah-card-${id}`).remove();
                }
            });
        });
    });
});
</script>
@endpush
@endsection
