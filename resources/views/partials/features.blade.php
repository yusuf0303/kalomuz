<section class="py-5" id="services">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold text-white">Xizmatlarimiz</h2>
            <div class="bg-success mx-auto" style="height: 4px; width: 60px; border-radius: 2px;"></div>
        </div>

        <div class="row g-4">
            <!-- Quran Reader -->
            <div class="col-md-4">
                <a href="{{ route('quran.index') }}" class="text-decoration-none">
                    <div class="glass-morphism h-100 p-4 transition-up feature-card">
                        <div class="icon-box mb-4">
                            <i class="fas fa-quran fa-3x text-success"></i>
                        </div>
                        <h4 class="text-white">Qur'on Suralari</h4>
                        <p class="text-muted">Barcha suralarni arabcha matni, o'zbekcha tarjimasi va go'zal qiroatlar bilan tinglang.</p>
                    </div>
                </a>
            </div>

            <!-- Prayer Times -->
            <div class="col-md-4">
                <a href="{{ route('prayer.index') }}" class="text-decoration-none">
                    <div class="glass-morphism h-100 p-4 transition-up feature-card">
                        <div class="icon-box mb-4">
                            <i class="fas fa-clock fa-3x text-info"></i>
                        </div>
                        <h4 class="text-white">Namoz Vaqtlari</h4>
                        <p class="text-muted">Hududingizga mos aniq namoz vaqtlarini kundalik va haftalik ko'rinishda kuzatib boring.</p>
                    </div>
                </a>
            </div>

            <!-- Quran Quiz -->
            <div class="col-md-4">
                <a href="{{ route('quran.quiz') }}" class="text-decoration-none">
                    <div class="glass-morphism h-100 p-4 transition-up feature-card">
                        <div class="icon-box mb-4">
                            <i class="fas fa-brain fa-3x text-warning"></i>
                        </div>
                        <h4 class="text-white">Qur'an Quiz</h4>
                        <p class="text-muted">Islomiy bilimingizni sinab ko'ring va Ramazon konkursida sovrinlar uchun ballar jamlang.</p>
                    </div>
                </a>
            </div>

            <!-- Mosque Finder -->
            <div class="col-md-4">
                <a href="{{ route('mosques.index') }}" class="text-decoration-none">
                    <div class="glass-morphism h-100 p-4 transition-up feature-card">
                        <div class="icon-box mb-4">
                            <i class="fas fa-mosque fa-3x text-primary"></i>
                        </div>
                        <h4 class="text-white">Masjidlar</h4>
                        <p class="text-muted">Yaqiningizdagi masjidlarni xarita orqali oson toping va masofasini aniqlang.</p>
                    </div>
                </a>
            </div>

            <!-- Sajda Ayahs -->
            <div class="col-md-4">
                <a href="{{ route('quran.sajda') }}" class="text-decoration-none">
                    <div class="glass-morphism h-100 p-4 transition-up feature-card">
                        <div class="icon-box mb-4">
                            <i class="fas fa-person-praying fa-3x text-danger"></i>
                        </div>
                        <h4 class="text-white">Sajda Oyatlari</h4>
                        <p class="text-muted">Qur'ondagi barcha sajda qilinishi lozim bo'lgan oyatlar haqida batafsil ma'lumot oling.</p>
                    </div>
                </a>
            </div>

            <!-- Ramadan Contest -->
            <div class="col-md-4">
                <a href="{{ route('contest.index') }}" class="text-decoration-none">
                    <div class="glass-morphism h-100 p-4 transition-up feature-card">
                        <div class="icon-box mb-4">
                            <i class="fas fa-star-and-crescent fa-3x text-warning"></i>
                        </div>
                        <h4 class="text-white">Konkurs Leaderboard</h4>
                        <p class="text-muted">Eng bilimli ishtirokchilar ro'yxatida o'z o'rningizni ko'ring va natijalarni kuzating.</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>

<style>
.feature-card {
    border: 1px solid rgba(255,255,255,0.05);
}
.feature-card:hover {
    background: rgba(255,255,255,0.05);
    border-color: rgba(46, 204, 113, 0.4);
}
.icon-box {
    height: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>
