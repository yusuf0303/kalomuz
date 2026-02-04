<section class="hero two-column" id="hero">
{{--    <audio id="audio_onLoad" src="display: hidden;" controls hidden></audio>--}}
    <div class="overlay"></div>
    <div class="hero-container fade-up show">

        <!-- Chap qism: matn -->
        <div class="hero-content">
            <h1 id="typewriter">Islomiy bilimlarga yo'l</h1>
            <p>Muqaddas qur'on va ilm bilan tanishing</p>
            <a href="#footer-side" class="btn-hero">Xizmatlar</a>
        </div>

        <!-- O'ng qism: audio player -->
            <div class="quran-player-wrapper">
                <div class="quran-player">
                    <div class="player-header">
                        <div class="header-left">
                            <button id="saved_list" class="btn-icon" title="Saqlanganlar">
                                <i class="fa-regular fa-bookmark"></i>
                            </button>
                            <div class="player-title">
                                <h3>Qur'on Tinglang</h3>
                            </div>
                        </div>
                        <div class="header-right">
                            <div class="info-container">
                                <i class="fa-solid fa-circle-info info-icon"></i>
                                <div class="info-tooltip">
                                    <ul id="surah-info-list">
                                        <li>Yuklanmoqda...</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="player-selectors">
                        <div class="custom-dropdown" id="surah-dropdown">
                            <div class="dropdown-trigger" id="surah-trigger">
                                <span class="selected-text">Sura</span>
                                <i class="fas fa-chevron-down"></i>
                            </div>
                            <div class="dropdown-options" id="surah-options">
                                <!-- JS populate -->
                            </div>
                        </div>
                        <div class="custom-dropdown disabled" id="ayah-dropdown">
                            <div class="dropdown-trigger" id="ayah-trigger">
                                <span class="selected-text">Oyat</span>
                                <i class="fas fa-chevron-down"></i>
                            </div>
                            <div class="dropdown-options" id="ayah-options">
                                <!-- JS populate -->
                            </div>
                        </div>
                    </div>

                    <div class="player-body">
                        <div class="ayah-display">
                            <img id="ayah-image" src="" alt="Oyat" class="ayah-img" style="display: none;"/>
                            <div class="ayah-text-container">
                                <span id="sajda-indicator" class="sajda-badge" style="display: none;">
                                    <i class="fas fa-person-praying me-1"></i> Sajda
                                </span>
                                <p id="ayah-info" class="ayah-translation">Oyatni tanlang va tinglang...</p>
                            </div>
                        </div>
                    </div>

                    <div class="player-footer">
                        <div class="audio-controls-wrapper">
                            <audio id="audio"></audio>
                            <div class="main-controls">
                                <button id="saved" class="btn-control" title="Saqlash"><i class="fa-regular fa-heart"></i></button>
                                <button id="prev" class="btn-control" title="Oldingi"><i class="fas fa-step-backward"></i></button>
                                <button id="togglePlay" class="btn-play" title="Ijro/Pauza"><i class="fas fa-play"></i></button>
                                <button id="next" class="btn-control" title="Keyingi"><i class="fas fa-step-forward"></i></button>
                                <button id="repeat" class="btn-control" title="Takrorlash"><i class="fas fa-repeat"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


    </div>
</section>
