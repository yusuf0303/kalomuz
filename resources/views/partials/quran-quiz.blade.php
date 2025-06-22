@if(Auth::guest())
    <script>window.location = "{{ route('login') }}";</script>
@endif

@extends('layouts.app')

@section('content')
    <div class="container" id="quran-quiz-app" style="margin:40px auto;max-width:650px;">

        <h1 class="text-center my-4">Qur'on Quiz</h1>

        <!-- 1. Boshlash paneli -->
        <div id="start-panel" class="mb-4">
            <div class="mb-3">
                <label for="quiz-username" class="form-label">Ismingiz:</label>
                <input type="text" id="quiz-username" class="form-control" placeholder="Ismingizni kiriting" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Test turi:</label>
                <select id="quiz-type" class="form-select">
                    <option value="translate">Oyat tarjimasini topish</option>
                    <option value="surah">Oyat surasini topish</option>
                    <option value="next">Keyingi oyatni topish</option>
                    <option value="prev">Oldingi oyatni topish</option>
                    <option value="juz">Juzni topish</option>
                </select>
            </div>
            <!-- Juz tanlash paneli -->
            <div class="mb-3" id="quiz-juz-panel" style="display:none;">
                <label class="form-label">Juz tanlang:</label>
                <select id="quiz-juz" class="form-select">
                    <option value="all" selected>Barcha Juzlar</option>
                    <option value="random">Tasodifiy Juz</option>
                    @for($i=1; $i<=30; $i++)
                        <option value="{{ $i }}">Juz {{ $i }}</option>
                    @endfor
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Savollar soni:</label>
                <select id="quiz-count" class="form-select">
                    <option value="3">3</option>
                    <option value="5" selected>5</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                    <option value="30">30</option>
                </select>
            </div>
            <button class="btn btn-success w-100" id="quiz-start-btn">Testni boshlash</button>
        </div>


        <!-- 2. Test oynasi -->
        <div id="quiz-box" class="quiz-box" style="display:none;">
            <div class="mb-2 text" style="display: flex; justify-content: space-evenly">
                <span id="quiz-user"></span>
                <div>
                    <span id="quiz-score">Ball: 0</span>
                    <span id="quiz-progress" class="ms-4">0 / 0</span>
                </div>
            </div>

            <div class="d-flex justify-content-between mt-4 gap-2 flex-wrap">
                <button type="button" class="btn btn-secondary" id="prev-btn">Oldingi</button>
                <button type="button" class="btn btn-info" id="help-btn">Yordam</button>
                <button type="button" class="btn btn-warning" id="show-answer-btn">Javobni ko'rsatish</button>
                <button type="button" class="btn btn-primary" id="next-btn">Keyingi</button>
            </div><br>

            <div id="ayah-arabic" class="text-center fs-4 mb-2" style="font-family:'Scheherazade',serif;"></div>
            <div class="text-center mb-3">
                <audio id="ayah-audio" controls style="width:100%;max-width:350px;"></audio>
            </div>
            <div id="quiz-question" class="mb-2"></div>
            <form id="quiz-form" class="mt-3">
                <div id="answers" class="d-grid gap-2"></div>
            </form>
            <div id="result-message" class="mt-2 text-center fw-bold"></div>

        </div>

        <!-- 3. Finish sahifasi -->
        <div id="quiz-finish" class="text-center" style="display:none;">
            <h2>Test yakunlandi!</h2>
            <p id="quiz-finish-msg"></p>
            <button class="btn btn-success" id="quiz-restart-btn">Qayta boshlash</button>
        </div>

    </div>
@endsection
