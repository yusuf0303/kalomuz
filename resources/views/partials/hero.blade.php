<section class="hero two-column" id="hero">
{{--    <audio id="audio_onLoad" src="display: hidden;" controls hidden></audio>--}}
    <div class="overlay"></div>
    <div class="hero-container fade-up show">

        <!-- Chap qism: matn -->
        <div class="hero-content">
            <h1 id="typewriter">Islomiy bilimlarga yo'l</h1>
            <p>Muqaddas qur'on va ilm bilan tanishing</p>
            <a href="#services" class="btn-hero">View Services</a>
        </div>

        <!-- O'ng qism: audio player -->
        <div class="hero-audio">
            <!-- <img src="images/backgroundpics/prayer_times.png" alt="Qur'on rasmi" /> -->
            <div class="quran-player">
                <div class="upper_quran_player">
                    <div class="bookmark">
                        <button id="saved_list"><i class="fa-regular fa-bookmark" style="color: #63E6BE;"></i></button>
                    </div>
                    <div class="listen_quran_text">
                        <h3><marquee behavior="" direction="left">Qur'on tinglang</marquee></h3>
                    </div>
                    <div class="selectors">
                        <select name="select-surah" id="selectSurah">
                            <option value="" disabled selected>Sura tanlang</option>
                        </select>

                        <select name="selectAyah" id="selectAyah" disabled>
                            <option value="" disabled selected>Oyat tanlang</option>
                        </select>

                        <!-- Info icon va tooltip -->
                        <div class="info-container">
                            <i class="fa-solid fa-circle-info info-icon"></i>
                            <div class="info-tooltip">
                                <ul id="surah-info-list">
                                    <li>Loading...</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="down-part">
                    <div class="surah-info">
                        <img id="ayah-image" src="" alt="Oyat rasmi" style="filter: brightness(1.2) invert(1) contrast(1.5); transition: filter 0.3s ease; max-width: 100%; border-radius: 8px; margin-bottom: 15px; display: none;"/>
                        <span id="sajda-indicator" class="sajda-badge" style="display: none;">🧎‍♂️ Sajda oyati</span>
                        <p id="ayah-info">Yuklanmoqda...</p>
                    </div>
                    <div class="audio-content">
                        <audio id="audio" controls class="audio-screen"></audio>
                        <div class="controls">
                            <button id="saved"><i class="fa-sharp fa-solid fa-heart"></i></button>
                            <button id="prev"><i class="fa-sharp fa-solid fa-backward-step"></i></button>
                            <button id="togglePlay"><i class="fa-sharp fa-solid fa-play"></i></button>
                            <button id="next"><i class="fa-sharp fa-solid fa-forward-step"></i></button>
                            <button id="repeat"><i class="fa-sharp fa-solid fa-repeat"></i></button>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</section>

{{--<script src="public/js/main.js" defer></script>--}}
{{--<script src="public/js/savedAyahsModal.js" defer></script>--}}
