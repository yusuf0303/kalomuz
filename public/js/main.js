// Loader
window.addEventListener('load', function () {
    const loader = document.getElementById('custom-loader');
    if (loader) {
        loader.style.opacity = '0';
        setTimeout(() => loader.style.display = 'none', 300);
    }
});


// === NAVIGATION MENU ===
const hamburger = document.getElementById('hamburger');
const navMenu = document.getElementById('nav-menu');

hamburger?.addEventListener('click', () => {
    navMenu.classList.toggle('show');
});

const links = document.querySelectorAll(".nav-links a");
links.forEach(link => {
    link.addEventListener("click", function () {
        links.forEach(l => l.classList.remove("active"));
        this.classList.add("active");
    });
});

// === QUR'ON HERO & AUDIO PLAYER ===

// Typewriter effekt
const phrases = [
    "📖 Qur’on bilan qalbingizni nurlantiring",
    "🎧 Ilm va imon sari birgalikda",
    "🕋 Har bir oyat – hayotingizga nur",
    "🕌 Tinglang, o‘qing, tushuning",
    "❤️ Iymon yurakdan boshlanadi",
    "📖 Qur’on – hayot dasturidir",
    "🌟 Oyatlar bilan ruhingizni oziqlantiring",
    "🕋 Iymon kaliti – Qur’on o‘qish",
    "💬 Qur’on – Allohning sizga murojaati",
    "💡 Har bir oyat – qalbga nur",
    "🧠 Ilm sari ilk qadam Qur’ondan boshlanadi",
    "🧭 Oyatlarda hayotning ma’nosi yashiringan",
    "🎧 Tinglang – yuragingiz javob beradi",
    "🌅 Qur’on bilan har kuningiz boshqacha bo‘lsin",
    "🤲 Duo va Qur’on – musulmon qalbining quvvati",
    "📚 O‘qing, tushuning, yashang",
    "🚶‍♂️ Yaxshi niyat, to‘g‘ri yo‘l – Qur’on bilan",
    "🧘‍♀️ Oyatlar – dilingizga tinchlik olib keladi",
    "🏆 Har bir tilovat – savob, har bir harf – ajr",
    "👤 O‘zingizga Qur’on bilan do‘st bo‘ling"
];
let currentPhrase = Math.floor(Math.random() * phrases.length);
let currentLetter = 0;
let isDeleting = false;
const typeEl = document.getElementById("typewriter");

function type() {
    if (!typeEl) return;
    const text = phrases[currentPhrase];
    const shownText = isDeleting ? text.substring(0, currentLetter--) : text.substring(0, currentLetter++);
    typeEl.textContent = shownText;

    if (!isDeleting && currentLetter === text.length + 1) {
        isDeleting = true;
        setTimeout(type, 1500);
    } else if (isDeleting && currentLetter === 0) {
        isDeleting = false;
        currentPhrase = (currentPhrase + 1) % phrases.length;
        setTimeout(type, 500);
    } else {
        setTimeout(type, isDeleting ? 40 : 100);
    }
}
type();

// --- Qur’on audio player asosiy elementlar ---
const audio = document.getElementById("audio");
const nextBtn = document.getElementById("next");
const prevBtn = document.getElementById("prev");
const repeat = document.getElementById("repeat");
const saved = document.getElementById("saved");
const toggleBtn = document.getElementById("togglePlay");
const icon = toggleBtn?.querySelector("i");
const ayahInfo = document.getElementById("ayah-info");
const ayahImage = document.getElementById("ayah-image");
const sajdaBadge = document.getElementById("sajda-indicator");
const selectSurah = document.getElementById("selectSurah");
const selectAyah = document.getElementById("selectAyah");

let surahData = [];
let translationData = [];
let surahNameMap = {};
let currentAyah = Math.floor(Math.random() * 6236) + 1;
let lastLoadedAyah = null;
let isRepeatEnabled = false;

// ==== INITIALIZATION ====

// Barcha sura va tarjimalarni yuklash
async function initSurahDropdowns() {
    // Suralar
    const surahRes = await fetch("https://api.alquran.cloud/v1/surah");
    const surahJson = await surahRes.json();
    if (surahJson.status === "OK") {
        surahData = surahJson.data;
        surahData.forEach(surah => {
            surahNameMap[surah.number] = surah.englishName;
            const option = document.createElement("option");
            option.value = surah.number;
            option.textContent = `${surah.number}. ${surah.englishName}`;
            selectSurah.appendChild(option);
        });
    }
    // Tarjimalar
    const transRes = await fetch("https://cdn.jsdelivr.net/gh/fawazahmed0/quran-api@1/editions/uzb-muhammadsodikmu.json");
    const transJson = await transRes.json();
    translationData = transJson.quran;
}

// Global ayah raqamini hisoblash
function getGlobalAyahNumber(surah, ayah) {
    const counts = [
        7,286,200,176,120,165,206,75,129,109,123,111,43,52,99,128,111,110,98,135,
        112,78,118,64,77,227,93,88,69,60,34,30,73,54,45,83,182,88,75,85,54,53,89,
        59,37,35,38,29,18,45,60,49,62,55,78,96,29,22,24,13,14,11,11,18,12,12,30,
        52,52,44,28,28,20,56,40,31,50,40,46,42,29,19,36,25,22,17,19,26,30,20,15,
        21,11,8,8,19,5,8,8,11,11,8,3,9,5,4,7,3,6,3,5,4,5,6
    ];
    return counts.slice(0, surah - 1).reduce((a, b) => a + b, 0) + ayah;
}

// Biror oyatni yuklash va ko‘rsatish
async function loadAyah(ayahNumber) {
    await loadSurahNames();
    selectAyah.disabled = false;
    try {
        const response = await fetch(`https://api.alquran.cloud/v1/ayah/${ayahNumber}/ar.alafasy`);
        const data = await response.json();
        if (data.status === "OK") {
            const surahNumber = data.data.surah.number;
            // const surahEnglishName = data.data.surah.number;
            const ayahId = data.data.numberInSurah;

            // Ayah image
            ayahImage.src = `https://cdn.islamic.network/quran/images/high-resolution/${surahNumber}_${ayahId}.png`;
            ayahImage.style.display = "block";
            const ayahImageUrl = `https://cdn.islamic.network/quran/images/high-resolution/${surahNumber}_${ayahId}.png`;
            // check sajda status
            const isSajdaAyah = data.data.sajda === true || typeof data.data.sajda === "object";

            lastLoadedAyah = {
                number: ayahNumber,
                surah: surahNumber,
                verse: ayahId,
                ayahImage: ayahImageUrl,
                sajda: isSajdaAyah,
                audio: data.data.audio
            };

            audio.src = data.data.audio;
            audio.load();

	    // Arabcha matnni DOMga chiqarish (agar mavjud bo‘lsa)
            const arabicText = data.data.text;
            const ayahArabicEl = document.getElementById("ayah-arabic");
            if (ayahArabicEl) ayahArabicEl.textContent = arabicText;

            // Translation
            const translationRes = await fetch("https://cdn.jsdelivr.net/gh/fawazahmed0/quran-api@1/editions/uzb-muhammadsodikmu.json");
            const translationData = await translationRes.json();
            const translatedAyah = translationData.quran.find(item => item.chapter === surahNumber && item.verse === ayahId);

            const surahName = surahNameMap[surahNumber] || `Surah ${surahNumber}`;

            if (translatedAyah) {
                ayahInfo.textContent = translatedAyah.text;
                sajdaBadge.style.display = isSajdaAyah ? "inline-block" : "none";
            } else {
                ayahInfo.textContent = `${surahName}, Oyat ${ayahId}: Tarjima topilmadi.`;
                sajdaBadge.style.display = "none";
            }
        } else {
            ayahInfo.textContent = "Audio yoki rasm topilmadi.";
            ayahImage.style.display = "none";
        }
    } catch (error) {
        console.error("Xatolik:", error);
        ayahInfo.textContent = "Ma'lumotlarni olishda xatolik yuz berdi.";
        ayahImage.style.display = "none";
    }
    updateSavedButtonColor(ayahNumber);
    updateDropdownsFromAyah(currentAyah);
}


// Dropdownlarni holatini oyat raqamiga ko‘ra yangilash
function updateDropdownsFromAyah(ayahNumber) {
    let total = 0, surah = 1;
    const counts = [
        7,286,200,176,120,165,206,75,129,109,123,111,43,52,99,128,111,110,98,135,
        112,78,118,64,77,227,93,88,69,60,34,30,73,54,45,83,182,88,75,85,54,53,89,
        59,37,35,38,29,18,45,60,49,62,55,78,96,29,22,24,13,14,11,11,18,12,12,30,
        52,52,44,28,28,20,56,40,31,50,40,46,42,29,19,36,25,22,17,19,26,30,20,15,
        21,11,8,8,19,5,8,8,11,11,8,3,9,5,4,7,3,6,3,5,4,5,6
    ];

    for (let i = 0; i < counts.length; i++) {
        if (ayahNumber <= total + counts[i]) {
            surah = i + 1;
            break;
        }
        total += counts[i];
    }
    const ayah = ayahNumber - getGlobalAyahNumber(surah, 1) + 1;

    selectSurah.value = surah.toString();
    const surahObj = surahData.find(s => s.number === surah);
    if (surahObj) {
        selectAyah.innerHTML = "";
        for (let i = 1; i <= surahObj.numberOfAyahs; i++) {
            const option = document.createElement("option");
            option.value = i;
            option.textContent = `${i}-oyat`;
            selectAyah.appendChild(option);
        }
        selectAyah.value = ayah.toString();
    }
}

// Saqlangan oyatlar tugmasi rangi
function updateSavedButtonColor(ayahNumber) {
    const savedAyahs = JSON.parse(localStorage.getItem("savedAyahs") || "[]");
    const isSaved = savedAyahs.some(item => item.number === ayahNumber);
    saved.style.color = isSaved ? "red" : "white";
}

// --- EVENTLAR ---

toggleBtn?.addEventListener("click", () => {
    if (audio.paused) {
        audio.play();
        icon.classList.replace("fa-play", "fa-pause");
    } else {
        audio.pause();
        icon.classList.replace("fa-pause", "fa-play");
    }
});
repeat?.addEventListener("click", () => {
    isRepeatEnabled = !isRepeatEnabled;
    repeat.style.color = isRepeatEnabled ? "#29d33c" : "#fff";
});
nextBtn?.addEventListener("click", () => {
    currentAyah++;
    loadAyah(currentAyah);
});
prevBtn?.addEventListener("click", () => {
    if (currentAyah > 1) {
        currentAyah--;
        loadAyah(currentAyah);
    }
});
audio?.addEventListener("ended", () => {
    if (isRepeatEnabled) {
        audio.currentTime = 0;
        audio.play();
    } else {
        currentAyah++;
        loadAyah(currentAyah);
    }
});
// Oyat saqlashda
document.getElementById("saved").addEventListener("click", function () {
    if (!lastLoadedAyah) return;

    fetch("/save-ayah", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
        },
        body: JSON.stringify({
            surah: lastLoadedAyah.surah,
            ayah: lastLoadedAyah.verse,
            image: lastLoadedAyah.ayahImage,
            text: ayahInfo.textContent,
            sajda: lastLoadedAyah.sajda,
            audio: lastLoadedAyah.audio
        })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert("Oyat saqlandi!");
        } else {
            alert("Xatolik: " + data.message);
        }
    })
    .catch(err => {
        console.error("Saqlashda xatolik:", err);
        alert("Saqlashda muammo yuz berdi.");
    });
});



// saved?.addEventListener("click", () => {
//     if (lastLoadedAyah) {
//         let savedAyahs = JSON.parse(localStorage.getItem("savedAyahs") || "[]");
//         const exists = savedAyahs.some(item => item.number === lastLoadedAyah.number);
//         if (exists) {
//             savedAyahs = savedAyahs.filter(item => item.number !== lastLoadedAyah.number);
//             saved.style.color = "white";
//         } else {
//             savedAyahs.push(lastLoadedAyah);
//             saved.style.color = "red";
//         }
//         localStorage.setItem("savedAyahs", JSON.stringify(savedAyahs));
//     }
// });
selectSurah?.addEventListener("change", () => {
    const surahNumber = parseInt(selectSurah.value);
    const surah = surahData.find(s => s.number === surahNumber);
    selectAyah.innerHTML = "";
    selectAyah.disabled = false;
    for (let i = 1; i <= surah.numberOfAyahs; i++) {
        const option = document.createElement("option");
        option.value = i;
        option.textContent = `${i}-oyat`;
        selectAyah.appendChild(option);
    }
    currentAyah = getGlobalAyahNumber(surahNumber, 1);
    loadAyah(currentAyah);
});
selectAyah?.addEventListener("change", () => {
    const surahNumber = parseInt(selectSurah.value);
    const ayahNumber = parseInt(selectAyah.value);
    currentAyah = getGlobalAyahNumber(surahNumber, ayahNumber);
    loadAyah(currentAyah);
});

// --- SAQLANGAN OYATLAR MODALI, FILTR, O‘CHIRISH va boshqalar siz kiritganidek qoldirildi ---

// --- MODAL OCHISH/YOPISH ---
const savedAyahsContainer = document.getElementById('savedAyahsContainer');
const closeSavedBtn = document.getElementById('closeSaved');
const savedListBtn = document.getElementById('saved_list'); // Saqlanganlar ro‘yxatini ochish tugmasi

savedListBtn.addEventListener('click', () => {
    savedAyahsContainer.style.display = "flex";
    renderSavedAyahs();
});
closeSavedBtn.addEventListener('click', () => {
    savedAyahsContainer.style.display = "none";
});

// --- LOCAL STORAGE DAN SAQLANGAN OYATLARNI OQISH ---
function getSavedAyahs() {
    return JSON.parse(localStorage.getItem('savedAyahs') || "[]");
}

function renderSavedAyahs() {
    const list = document.getElementById('savedAyahList');
    const filter = document.getElementById('filter').value;
    let savedAyahs = getSavedAyahs();

    // Filtrlash/saralash qismi o‘zida qolsin
    switch (filter) {
        case "surah-asc": savedAyahs.sort((a, b) => a.surah - b.surah); break;
        case "surah-desc": savedAyahs.sort((a, b) => b.surah - a.surah); break;
        case "ayah-asc": savedAyahs.sort((a, b) => a.ayah - b.ayah); break;
        case "ayah-desc": savedAyahs.sort((a, b) => b.ayah - a.ayah); break;
        case "recent-last": savedAyahs.reverse(); break;
    }

    list.innerHTML = "";
    if (savedAyahs.length === 0) {
        list.innerHTML = `<li style="text-align:center;color:#aaa">Saqlangan oyatlar yo‘q.</li>`;
        return;
    }

    // Modalni render qilganda
    savedAyahs.forEach((item, idx) => {
        // surahNameMap’dan sura nomini olamiz
        const surahName = surahNameMap[item.surah] || item.surah;
        list.innerHTML += `
        <li class="saved-ayah-item" style="position:relative;">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <strong>${surahName} [ ${item.surah} | ${item.ayah} ]</strong>
                    <button class="btn btn-sm btn-link" type="button" onclick="toggleDropdown('dropdown-${idx}')">
                        <i class="fa-solid fa-chevron-down"></i>
                    </button>
                </div>
                <div style="display:flex; align-items:center; gap:5px;">
                    ${
            item.sajda
                ? `<span class="sajda-icon" title="Sajda oyati">
                            <i class="fa-solid fa-mosque" style="color:#facc15;font-size:1.2em;"></i> Sajda Oyati
                        </span>`
                : ""
        }
                    <button class="remove" onclick="removeSavedAyah(${idx})" title="O‘chirish">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </div>
            </div>
            <!-- Dropdown qismi o‘zida qolsin -->
            <div id="dropdown-${idx}" class="dropdown-ayah-content" style="display:none; margin-top:8px; border-radius:8px; background:#222; padding:14px;">
                ${item.ayahImage ? `<img src="${item.ayahImage}" alt="Oyat rasmi" class="saved-ayah-img">` : ""}
                <div style="margin-bottom:6px;">${item.text || ""}</div>
                ${item.audio ? `<audio controls style="width:100%"><source src="${item.audio}"></audio>` : ""}
            </div>
        </li>
    `;
    });



}

// Dropdownni ochib-yopish funksiyasi
function toggleDropdown(id) {
    const el = document.getElementById(id);
    if (!el) return;
    el.style.display = (el.style.display === "none" || !el.style.display) ? "block" : "none";
}


// --- BARCHASINI O‘CHIRISH ---
document.getElementById('removeAll').onclick = function () {
    if (confirm("Barcha saqlangan oyatlarni o‘chirilsinmi?")) {
        localStorage.removeItem('savedAyahs');
        renderSavedAyahs();
        updateSavedButtonColor(currentAyah); // <<--- QO‘SHING!
    }
}

// --- BITTA OYATNI O‘CHIRISH ---
function removeSavedAyah(idx) {
    let ayahs = getSavedAyahs();
    // O‘chirilayotgan oyat hozir ekrandagi (currentAyah) bo‘lsa, tugma rangini ham yangilash zarur
    let removed = ayahs[idx];
    ayahs.splice(idx, 1);
    localStorage.setItem('savedAyahs', JSON.stringify(ayahs));
    renderSavedAyahs();
    // Removed currentAyahga to‘g‘ri kelsa yoki har doim yangilash uchun:
    updateSavedButtonColor(currentAyah); // <<--- QO‘SHING!
}


// --- FILTER O‘ZGARGANDA QAYTA RENDER ---
document.getElementById('filter').onchange = renderSavedAyahs;


// Pastdagi kodlar hammasi joyida va to‘liq (kengaytirilgan) ishlashda davom etadi...

// Sahifa yuklanganda barcha sura, tarjima va birinchi oyatni yuklash
document.addEventListener("DOMContentLoaded", async () => {
    await initSurahDropdowns();
    await loadAyah(currentAyah);

    // Scroll fade animatsiya uchun (agar ishlatilsa)
    const fadeElements = document.querySelectorAll(".fade-up");
    const observer = new IntersectionObserver(
        entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add("show");
                }
            });
        },
        { threshold: 0.1 }
    );
    fadeElements.forEach(el => observer.observe(el));
});



function fillQuranPlayerSurahInfo() {
    // currentAyah — global hozirgi oyat raqami
    // surahData — suralar ma’lumoti massivi
    // 1. currentAyahdan surani aniqlaymiz
    let total = 0, surah = 1;
    const counts = [
        7,286,200,176,120,165,206,75,129,109,123,111,43,52,99,128,111,110,98,135,
        112,78,118,64,77,227,93,88,69,60,34,30,73,54,45,83,182,88,75,85,54,53,89,
        59,37,35,38,29,18,45,60,49,62,55,78,96,29,22,24,13,14,11,11,18,12,12,30,
        52,52,44,28,28,20,56,40,31,50,40,46,42,29,19,36,25,22,17,19,26,30,20,15,
        21,11,8,8,19,5,8,8,11,11,8,3,9,5,4,7,3,6,3,5,4,5,6
    ];
    for (let i = 0; i < counts.length; i++) {
        if (currentAyah <= total + counts[i]) {
            surah = i + 1;
            break;
        }
        total += counts[i];
    }
    const surahObj = surahData.find(s => s.number === surah);
    const infoList = document.getElementById("quran-player-info-list");
    if (surahObj && infoList) {
        infoList.innerHTML = `
            <li><b>${surahObj.englishName} (${surahObj.englishNameTranslation})</b></li>
            <li>Sura raqami: ${surahObj.number}</li>
            <li>Oyatlar soni: ${surahObj.numberOfAyahs}</li>
            <li>Tur: ${surahObj.revelationType === "Meccan" ? "Makkiy" : "Madaniy"}</li>
        `;
    } else if (infoList) {
        infoList.innerHTML = `<li>Ma'lumot topilmadi</li>`;
    }
}

// --- Info icon hover/click uchun ---
document.querySelector(".info-icon").addEventListener("mouseenter", fillQuranPlayerSurahInfo);
// Agar clickda ochilsa, uni ham qo‘shish mumkin
document.querySelector(".info-icon").addEventListener("click", function(e){
    fillQuranPlayerSurahInfo();
    // Tooltip ochiq/yopiq boshqarish uchun ixtiyoriy kod yozish mumkin
});






