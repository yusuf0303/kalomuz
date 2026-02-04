@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="surah-header glass-morphism p-5 mb-5 text-center position-relative overflow-hidden">
        <div class="header-content position-relative z-index-1">
            <h1 class="display-3 fw-bold mb-2">{{ $surah['englishName'] }}</h1>
            <h2 class="arabic-display mb-4">{{ $surah['name'] }}</h2>
            <div class="d-flex justify-content-center gap-3">
                <span class="badge bg-success p-2 px-3">{{ $surah['englishNameTranslation'] }}</span>
                <span class="badge bg-primary p-2 px-3">{{ $surah['revelationType'] }}</span>
                <span class="badge bg-info p-2 px-3">{{ $surah['numberOfAyahs'] }} oyat</span>
            </div>
        </div>
        <div class="header-bg-decoration"></div>
    </div>

    <div class="ayah-list">
        @foreach($surah['ayahs'] as $index => $ayah)
        <div class="ayah-card glass-morphism p-4 mb-4 transition-up">
            <div class="d-flex justify-content-between align-items-start mb-4">
                <div class="ayah-number-circle">{{ $ayah['numberInSurah'] }}</div>
                <div class="ayah-actions d-flex gap-2">
                    <button class="btn btn-outline-success btn-sm btn-audio" data-audio="{{ $ayah['audio'] }}">
                        <i class="fas fa-play"></i>
                    </button>
                    <button class="btn btn-outline-primary btn-sm btn-save-ayah" data-id="{{ $ayah['number'] }}">
                        <i class="far fa-bookmark"></i>
                    </button>
                    <button class="btn btn-outline-secondary btn-sm btn-share-ayah">
                        <i class="fas fa-share-alt"></i>
                    </button>
                </div>
            </div>
            
            <div class="arabic-text text-end mb-4" dir="rtl">
                {{ $ayah['text'] }}
            </div>
            
            <div class="translation-text text-muted">
                {{ $translation['ayahs'][$index]['text'] }}
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Audio Player Fixed Bottom -->
<div class="audio-player-container fixed-bottom p-3 d-none">
    <div class="container">
        <div class="glass-morphism p-3 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-success rounded-circle p-3" id="main-play-btn">
                    <i class="fas fa-play"></i>
                </button>
                <div>
                    <h6 class="mb-0 text-white" id="playing-ayah-title">Oyat tinglanmoqda...</h6>
                    <small class="text-muted" id="playing-ayah-info">{{ $surah['englishName'] }}: <span id="ayah-num">0</span></small>
                </div>
            </div>
            <div class="player-controls d-flex align-items-center gap-3 flex-grow-1 mx-5">
                <span class="text-white small" id="current-time">0:00</span>
                <input type="range" class="form-range player-progress" id="audio-progress" value="0">
                <span class="text-white small" id="total-time">0:00</span>
            </div>
            <div class="volume-control d-flex align-items-center gap-2">
                <i class="fas fa-volume-up text-white"></i>
                <input type="range" class="form-range" id="volume-slider" style="width: 100px;">
            </div>
        </div>
    </div>
</div>

<audio id="global-audio-player"></audio>

<style>
.surah-header {
    border-radius: 30px;
    background: linear-gradient(135deg, rgba(46, 204, 113, 0.2), rgba(39, 174, 96, 0.4));
}

.arabic-display {
    font-family: 'Traditional Arabic', serif;
    font-size: 3.5rem;
    color: #2ecc71;
}

.arabic-text {
    font-family: 'Traditional Arabic', serif;
    font-size: 2.2rem;
    line-height: 1.8;
    color: #e0e0e0;
}

.ayah-card {
    border-radius: 20px;
    border-left: 4px solid transparent;
    transition: all 0.3s ease;
}

.ayah-card:hover {
    border-left: 4px solid #2ecc71;
    background: rgba(255, 255, 255, 0.08);
}

.ayah-number-circle {
    width: 35px;
    height: 35px;
    background: rgba(46, 204, 113, 0.2);
    color: #2ecc71;
    border: 1px solid #2ecc71;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 0.9rem;
}

.translation-text {
    font-size: 1.1rem;
    line-height: 1.6;
}

.audio-player-container {
    z-index: 1050;
    margin-bottom: 20px;
}

.player-progress {
    height: 6px;
}

.player-progress::-webkit-slider-thumb {
    background: #2ecc71;
}

.header-bg-decoration {
    position: absolute;
    top: -50%;
    right: -10%;
    width: 400px;
    height: 400px;
    background: radial-gradient(circle, rgba(46, 204, 113, 0.1) 0%, transparent 70%);
    border-radius: 50%;
}

.transition-up:hover {
    transform: translateY(-5px);
}
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const audioPlayer = document.getElementById('global-audio-player');
    const playerContainer = document.querySelector('.audio-player-container');
    const playBtn = document.getElementById('main-play-btn');
    const progress = document.getElementById('audio-progress');
    const currentTimeEl = document.getElementById('current-time');
    const totalTimeEl = document.getElementById('total-time');
    const ayahNumEl = document.getElementById('ayah-num');
    const volumeSlider = document.getElementById('volume-slider');

    let currentAyahBtn = null;

    document.querySelectorAll('.btn-audio').forEach(btn => {
        btn.addEventListener('click', function() {
            const audioSrc = this.dataset.audio;
            const ayahNum = this.closest('.ayah-card').querySelector('.ayah-number-circle').textContent;
            
            if (audioPlayer.src === audioSrc && !audioPlayer.paused) {
                audioPlayer.pause();
                updatePlayIcons(false);
            } else {
                audioPlayer.src = audioSrc;
                audioPlayer.play();
                playerContainer.classList.remove('d-none');
                ayahNumEl.textContent = ayahNum;
                currentAyahBtn = this;
                updatePlayIcons(true);
            }
        });
    });

    playBtn.addEventListener('click', () => {
        if (audioPlayer.paused) {
            audioPlayer.play();
            updatePlayIcons(true);
        } else {
            audioPlayer.pause();
            updatePlayIcons(false);
        }
    });

    audioPlayer.addEventListener('timeupdate', () => {
        const percent = (audioPlayer.currentTime / audioPlayer.duration) * 100;
        progress.value = percent || 0;
        currentTimeEl.textContent = formatTime(audioPlayer.currentTime);
    });

    audioPlayer.addEventListener('loadedmetadata', () => {
        totalTimeEl.textContent = formatTime(audioPlayer.duration);
    });

    progress.addEventListener('input', () => {
        const time = (progress.value / 100) * audioPlayer.duration;
        audioPlayer.currentTime = time;
    });

    volumeSlider.addEventListener('input', () => {
        audioPlayer.volume = volumeSlider.value / 100;
    });

    function updatePlayIcons(isPlaying) {
        const icon = isPlaying ? 'fa-pause' : 'fa-play';
        playBtn.querySelector('i').className = `fas ${icon}`;
        if (currentAyahBtn) {
            currentAyahBtn.querySelector('i').className = `fas ${icon}`;
        }
    }

    function formatTime(seconds) {
        const min = Math.floor(seconds / 60);
        const sec = Math.floor(seconds % 60);
        return `${min}:${sec < 10 ? '0' : ''}${sec}`;
    }

    // Save ayah functionality
    document.querySelectorAll('.btn-save-ayah').forEach(btn => {
        btn.addEventListener('click', async function() {
            const ayahId = this.dataset.id;
            try {
                const response = await fetch('/save-ayah', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ ayah_id: ayahId })
                });
                if (response.ok) {
                    this.querySelector('i').className = 'fas fa-bookmark text-success';
                    alert('Oyat saqlandi!');
                } else {
                    alert('Xatolik yuz berdi. Balki tizimga kirmagandirsiz?');
                }
            } catch (error) {
                console.error('Error:', error);
            }
        });
    });
});
</script>
@endpush
@endsection
