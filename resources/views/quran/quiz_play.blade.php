@extends('layouts.app')

@section('content')
<div class="container py-5" id="quiz-container">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <!-- Progress Info -->
            <div class="d-flex justify-content-between align-items-center mb-4 text-white">
                <h5 class="mb-0">Savol: <span id="current-q">1</span>/{{ count($questions) }}</h5>
                <div class="h4 mb-0 text-success fw-bold" id="timer">{{ $timeLimit }}</div>
            </div>

            <!-- Quiz Card -->
            <div class="quiz-card glass-morphism p-4 p-md-5 position-relative overflow-hidden">
                <div class="progress mb-4" style="height: 6px; background: rgba(255,255,255,0.1);">
                    <div class="progress-bar bg-success" id="quiz-progress" style="width: 0%"></div>
                </div>

                <div id="question-area">
                    <div class="text-center mb-4">
                        <button class="btn btn-success rounded-circle p-4 shadow-lg mb-3" id="audio-play-btn">
                            <i class="fas fa-play fa-2x"></i>
                        </button>
                        <p class="text-muted small">Oyatni eshitish uchun bosing</p>
                    </div>

                    <div class="arabic-text text-center mb-4" id="arabic-display" dir="rtl"></div>
                    
                    <div class="translation-text text-center mb-5 text-muted fst-italic" id="translation-display"></div>

                    <div class="row g-3" id="options-container">
                        <!-- Options will be here -->
                    </div>
                </div>

                <!-- Results Area (Hidden by default) -->
                <div id="results-area" class="d-none text-center py-5">
                    <h2 class="display-3 fw-bold text-white mb-3">Yakunlandi!</h2>
                    <div class="h1 fw-bold text-success mb-4" id="final-score">0/0</div>
                    <p class="text-muted mb-5">Barakalloh! Bilimingiz ziyoda bo'lsin.</p>
                    <div class="d-flex justify-content-center gap-3 mt-4">
                        <a href="{{ route('quran.quiz') }}" class="btn btn-success rounded-pill px-4 py-2">Yana o'ynash</a>
                        <a href="/" class="btn btn-outline-light rounded-pill px-4 py-2">Bosh sahifa</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<audio id="quiz-audio"></audio>

<style>
.quiz-card {
    min-height: 500px;
    border-radius: 30px;
}

.arabic-text {
    font-size: 1.8rem;
    line-height: 1.6;
    color: #e0e0e0;
}

.option-btn {
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.1);
    color: white;
    padding: 1.2rem;
    border-radius: 15px;
    text-align: left;
    transition: all 0.3s ease;
    width: 100%;
}

.option-btn:hover {
    background: rgba(255, 255, 255, 0.1);
    transform: translateX(10px);
}

.option-btn.correct {
    background: #27ae60 !important;
    border-color: #2ecc71 !important;
}

.option-btn.wrong {
    background: #c0392b !important;
    border-color: #e74c3c !important;
}

.transition-up {
    transition: transform 0.3s ease;
}

[data-bs-theme="dark"] .text-muted {
    color: #adb5bd !important;
}
</style>

<script>
const QUESTIONS = @json($questions);
const TIME_LIMIT = {{ $timeLimit }};
let currentIdx = 0;
let score = 0;
let timer = null;
let timeLeft = TIME_LIMIT;

const audioPlayer = document.getElementById('quiz-audio');
const timerEl = document.getElementById('timer');
const currentQEl = document.getElementById('current-q');
const arabicEl = document.getElementById('arabic-display');
const transEl = document.getElementById('translation-display');
const optionsEl = document.getElementById('options-container');
const progressEl = document.getElementById('quiz-progress');
const audioBtn = document.getElementById('audio-play-btn');

function loadQuestion() {
    if (currentIdx >= QUESTIONS.length) {
        showResults();
        return;
    }

    const q = QUESTIONS[currentIdx];
    currentQEl.textContent = currentIdx + 1;
    arabicEl.textContent = q.arabic;
    transEl.textContent = q.translation;
    audioPlayer.src = q.audio;
    
    optionsEl.innerHTML = '';
    q.options.forEach((opt, idx) => {
        const col = document.createElement('div');
        col.className = 'col-md-6';
        col.innerHTML = `
            <button class="option-btn transition-up" onclick="selectOption(${idx})">
                ${opt}
            </button>
        `;
        optionsEl.appendChild(col);
    });

    timeLeft = TIME_LIMIT;
    timerEl.textContent = timeLeft;
    clearInterval(timer);
    startTimer();
    
    progressEl.style.width = `${(currentIdx / QUESTIONS.length) * 100}%`;
    audioPlayer.play();
}

function startTimer() {
    timer = setInterval(() => {
        timeLeft--;
        timerEl.textContent = timeLeft;
        if (timeLeft <= 0) {
            clearInterval(timer);
            selectOption(-1); // Time out
        }
    }, 1000);
}

function selectOption(selectedIdx) {
    clearInterval(timer);
    const q = QUESTIONS[currentIdx];
    const btns = optionsEl.querySelectorAll('.option-btn');

    if (selectedIdx !== -1) {
        if (selectedIdx === q.correct) {
            score++;
            btns[selectedIdx].classList.add('correct');
        } else {
            btns[selectedIdx].classList.add('wrong');
            btns[q.correct].classList.add('correct');
        }
    } else {
        btns[q.correct].classList.add('correct');
    }

    // Disable all buttons
    btns.forEach(btn => btn.disabled = true);

    setTimeout(() => {
        currentIdx++;
        loadQuestion();
    }, 2000);
}

function showResults() {
    document.getElementById('question-area').classList.add('d-none');
    document.getElementById('results-area').classList.remove('d-none');
    document.getElementById('final-score').textContent = `${score}/${QUESTIONS.length}`;
    progressEl.style.width = '100%';

    // Send score to backend
    fetch("{{ route('quran.quiz.record') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ score: score })
    })
    .then(response => response.json())
    .then(data => {
        if (data.points_added) {
            const msg = document.createElement('p');
            msg.className = 'text-success fw-bold mt-3';
            msg.textContent = `+${data.points_added} ball konkurs hisobiga qo'shildi!`;
            const resultsArea = document.getElementById('results-area');
            const actionDiv = resultsArea.querySelector('.d-flex');
            if (actionDiv) {
                resultsArea.insertBefore(msg, actionDiv);
            } else {
                resultsArea.appendChild(msg);
            }
        }
    });
}

audioBtn.addEventListener('click', () => audioPlayer.play());

window.onload = loadQuestion;
</script>
@endsection
