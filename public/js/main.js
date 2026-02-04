// Loader
window.addEventListener('load', function () {
    const loader = document.getElementById('custom-loader');
    if (loader) {
        loader.style.opacity = '0';
        setTimeout(() => loader.style.display = 'none', 300);
    }
});


// === NAVIGATION MENU & PROFILE DROPDOWN ===
document.addEventListener("DOMContentLoaded", () => {
    const hamburger = document.getElementById('hamburger');
    const navMenu = document.getElementById('nav-menu');
    const navbar = document.querySelector('.navbar');

    hamburger?.addEventListener('click', () => {
        const isOpen = navMenu?.classList.toggle('show');
        navbar?.classList.toggle('active');
        document.body.classList.toggle('menu-active');

        // Toggle Icon
        const icon = hamburger.querySelector('i');
        if (icon) {
            icon.classList.toggle('fa-bars', !isOpen);
            icon.classList.toggle('fa-xmark', isOpen);
        }
    });

    const links = document.querySelectorAll(".nav-links a, .dropdown-item");
    links.forEach(link => {
        link.addEventListener("click", function () {
            // Update active state
            links.forEach(l => l.classList.remove("active"));
            this.classList.add("active");

            navMenu?.classList.remove('show');
            navbar?.classList.remove('active');
            document.body.classList.remove('menu-active');

            const icon = hamburger?.querySelector('i');
            if (icon) {
                icon.classList.add('fa-bars');
                icon.classList.remove('fa-xmark');
            }
        });
    });

    // Profile Dropdown
    const profileBtn = document.getElementById('userProfileBtn');
    const profileMenu = document.getElementById('profileMenu');

    if (profileBtn && profileMenu) {
        profileBtn.addEventListener("click", (e) => {
            e.stopPropagation();
            profileMenu.classList.toggle("active");
        });

        document.addEventListener("click", () => {
            profileMenu.classList.remove("active");
        });

        profileMenu.addEventListener("click", (e) => {
            e.stopPropagation();
        });
    }
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

// Custom Dropdowns
const surahDropdown = document.getElementById("surah-dropdown");
const surahTrigger = document.getElementById("surah-trigger");
const surahOptions = document.getElementById("surah-options");

const ayahDropdown = document.getElementById("ayah-dropdown");
const ayahTrigger = document.getElementById("ayah-trigger");
const ayahOptions = document.getElementById("ayah-options");

let surahData = [];
let translationData = [];
let surahNameMap = {};
let currentAyah = Math.floor(Math.random() * 6236) + 1;
let lastLoadedAyah = null;
let isRepeatEnabled = false;

// Helpers for Custom Dropdowns
function setupDropdown(dropdown, trigger, optionsContainer) {
    if (!trigger) return;
    trigger.addEventListener("click", (e) => {
        e.stopPropagation();
        if (dropdown.classList.contains("disabled")) return;
        document.querySelectorAll(".custom-dropdown").forEach(d => {
            if (d !== dropdown) d.classList.remove("active");
        });
        dropdown.classList.toggle("active");
    });
}

function closeAllDropdowns() {
    document.querySelectorAll(".custom-dropdown").forEach(d => d.classList.remove("active"));
}

document.addEventListener("click", closeAllDropdowns);

function populateCustomOptions(container, items, onSelect, currentVal) {
    if (!container) return;
    container.innerHTML = "";
    items.forEach(item => {
        const option = document.createElement("div");
        option.className = "dropdown-option";
        if (item.value == currentVal) option.classList.add("selected");
        option.textContent = item.label;
        option.addEventListener("click", (e) => {
            e.stopPropagation();
            onSelect(item.value, item.label);
            closeAllDropdowns();
        });
        container.appendChild(option);
    });
}

// Barcha sura va tarjimalarni yuklash
async function initSurahDropdowns() {
    if (!surahDropdown) return;
    try {
        const surahRes = await fetch("https://api.alquran.cloud/v1/surah");
        const surahJson = await surahRes.json();
        if (surahJson.status === "OK") {
            surahData = surahJson.data;
            const surahItems = surahData.map(surah => {
                surahNameMap[surah.number] = surah.englishName;
                return { value: surah.number, label: `${surah.number}. ${surah.englishName}` };
            });

            populateCustomOptions(surahOptions, surahItems, (val, label) => {
                surahTrigger.querySelector(".selected-text").textContent = label;
                handleSurahChange(parseInt(val));
            });
        }
        const transRes = await fetch("https://cdn.jsdelivr.net/gh/fawazahmed0/quran-api@1/editions/uzb-muhammadsodikmu.json");
        const transJson = await transRes.json();
        translationData = transJson.quran;
    } catch (e) { console.error("Error loading surahs:", e); }

    setupDropdown(surahDropdown, surahTrigger, surahOptions);
    setupDropdown(ayahDropdown, ayahTrigger, ayahOptions);
}

function handleSurahChange(surahNumber) {
    const surah = surahData.find(s => s.number === surahNumber);
    if (!surah) return;

    ayahDropdown.classList.remove("disabled");
    const ayahItems = [];
    for (let i = 1; i <= surah.numberOfAyahs; i++) {
        ayahItems.push({ value: i, label: `${i}-oyat` });
    }

    populateCustomOptions(ayahOptions, ayahItems, (val, label) => {
        ayahTrigger.querySelector(".selected-text").textContent = label;
        handleAyahChange(surahNumber, parseInt(val));
    });

    currentAyah = getGlobalAyahNumber(surahNumber, 1);
    loadAyah(currentAyah).then(() => audio.play());
}

function handleAyahChange(surahNumber, ayahNumber) {
    currentAyah = getGlobalAyahNumber(surahNumber, ayahNumber);
    loadAyah(currentAyah).then(() => audio.play());
}

function getGlobalAyahNumber(surah, ayah) {
    const counts = [7, 286, 200, 176, 120, 165, 206, 75, 129, 109, 123, 111, 43, 52, 99, 128, 111, 110, 98, 135, 112, 78, 118, 64, 77, 227, 93, 88, 69, 60, 34, 30, 73, 54, 45, 83, 182, 88, 75, 85, 54, 53, 89, 59, 37, 35, 38, 29, 18, 45, 60, 49, 62, 55, 78, 96, 29, 22, 24, 13, 14, 11, 11, 18, 12, 12, 30, 52, 52, 44, 28, 28, 20, 56, 40, 31, 50, 40, 46, 42, 29, 19, 36, 25, 22, 17, 19, 26, 30, 20, 15, 21, 11, 8, 8, 19, 5, 8, 8, 11, 11, 8, 3, 9, 5, 4, 7, 3, 6, 3, 5, 4, 5, 6];
    return counts.slice(0, surah - 1).reduce((a, b) => a + b, 0) + ayah;
}

async function loadAyah(ayahNumber) {
    if (!audio) return;
    try {
        const response = await fetch(`https://api.alquran.cloud/v1/ayah/${ayahNumber}/ar.alafasy`);
        const data = await response.json();
        if (data.status === "OK") {
            const surahNumber = data.data.surah.number;
            const ayahId = data.data.numberInSurah;

            ayahImage.src = `https://cdn.islamic.network/quran/images/high-resolution/${surahNumber}_${ayahId}.png`;
            ayahImage.style.display = "block";
            const isSajdaAyah = data.data.sajda === true || typeof data.data.sajda === "object";

            lastLoadedAyah = {
                number: ayahNumber,
                surah: surahNumber,
                verse: ayahId,
                ayahImage: ayahImage.src,
                sajda: isSajdaAyah,
                audio: data.data.audio
            };

            audio.src = data.data.audio;
            audio.load();

            const ArabicRes = await fetch(`https://api.alquran.cloud/v1/ayah/${ayahNumber}`);
            const ArabicData = await ArabicRes.json();
            const ArabicText = ArabicData.data.text;

            const translatedAyah = translationData.find(item => item.chapter === surahNumber && item.verse === ayahId);
            const surahName = surahNameMap[surahNumber] || `Surah ${surahNumber}`;

            if (translatedAyah && ayahInfo) {
                ayahInfo.textContent = translatedAyah.text;
                sajdaBadge.style.display = isSajdaAyah ? "inline-block" : "none";
            } else if (ayahInfo) {
                ayahInfo.textContent = `${surahName}, Oyat ${ayahId}: Tarjima topilmadi.`;
                sajdaBadge.style.display = "none";
            }
        }
    } catch (error) { console.error("Error loading ayah:", error); }
    updateSavedButtonColor(ayahNumber);
    updateDropdownsFromAyah(ayahNumber);
}
function updateDropdownsFromAyah(ayahNumber) {
    if (!surahDropdown || !ayahDropdown) return;
    let total = 0, surah = 1;
    const counts = [7, 286, 200, 176, 120, 165, 206, 75, 129, 109, 123, 111, 43, 52, 99, 128, 111, 110, 98, 135, 112, 78, 118, 64, 77, 227, 93, 88, 69, 60, 34, 30, 73, 54, 45, 83, 182, 88, 75, 85, 54, 53, 89, 59, 37, 35, 38, 29, 18, 45, 60, 49, 62, 55, 78, 96, 29, 22, 24, 13, 14, 11, 11, 18, 12, 12, 30, 52, 52, 44, 28, 28, 20, 56, 40, 31, 50, 40, 46, 42, 29, 19, 36, 25, 22, 17, 19, 26, 30, 20, 15, 21, 11, 8, 8, 19, 5, 8, 8, 11, 11, 8, 3, 9, 5, 4, 7, 3, 6, 3, 5, 4, 5, 6];

    let currentSum = 0;
    for (let i = 0; i < counts.length; i++) {
        if (ayahNumber <= currentSum + counts[i]) {
            surah = i + 1;
            total = currentSum;
            break;
        }
        currentSum += counts[i];
    }
    const ayah = ayahNumber - total;

    const surahName = surahNameMap[surah] || `Surah ${surah}`;
    surahTrigger.querySelector(".selected-text").textContent = `${surah}. ${surahName}`;

    const surahObj = surahData.find(s => s.number === surah);
    if (surahObj) {
        ayahDropdown.classList.remove("disabled");
        const ayahItems = [];
        for (let i = 1; i <= surahObj.numberOfAyahs; i++) {
            ayahItems.push({ value: i, label: `${i}-oyat` });
        }
        populateCustomOptions(ayahOptions, ayahItems, (val, label) => {
            ayahTrigger.querySelector(".selected-text").textContent = label;
            handleAyahChange(surah, parseInt(val));
        }, ayah);

        ayahTrigger.querySelector(".selected-text").textContent = `${ayah}-oyat`;
    }
}

function updateSavedButtonColor(ayahNumber) {
    if (!saved) return;
    const savedAyahs = JSON.parse(localStorage.getItem("savedAyahs") || "[]");
    const isSaved = savedAyahs.some(item => item.number === ayahNumber);
    saved.style.color = isSaved ? "red" : "white";
    const heartIcon = saved.querySelector("i");
    if (heartIcon) {
        heartIcon.classList.toggle("fa-solid", isSaved);
        heartIcon.classList.toggle("fa-regular", !isSaved);
    }
}

// --- Audio Control Event Listeners ---
toggleBtn?.addEventListener("click", () => {
    if (audio.paused) {
        audio.play();
        icon?.classList.replace("fa-play", "fa-pause");
    } else {
        audio.pause();
        icon?.classList.replace("fa-pause", "fa-play");
    }
});

repeat?.addEventListener("click", () => {
    isRepeatEnabled = !isRepeatEnabled;
    repeat.style.color = isRepeatEnabled ? "#29d33c" : "#fff";
});

nextBtn?.addEventListener("click", async () => {
    currentAyah++;
    await loadAyah(currentAyah);
    audio.play();
});

prevBtn?.addEventListener("click", async () => {
    if (currentAyah > 1) {
        currentAyah--;
        await loadAyah(currentAyah);
        audio.play();
    }
});

audio?.addEventListener("ended", async () => {
    if (isRepeatEnabled) {
        audio.currentTime = 0;
        audio.play();
    } else {
        currentAyah++;
        await loadAyah(currentAyah);
        audio.play();
    }
});

saved?.addEventListener("click", function () {
    if (!lastLoadedAyah) return;

    // Save to server
    fetch("/save-ayah", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')?.getAttribute("content")
        },
        body: JSON.stringify({
            surah: lastLoadedAyah.surah,
            ayah: lastLoadedAyah.verse,
            ayah_image: lastLoadedAyah.ayahImage,
            text: ayahInfo?.textContent,
            sajda: lastLoadedAyah.sajda,
            audio: lastLoadedAyah.audio
        })
    })
        .then(res => res.json())
        .then(data => {
            if (data.status === "ok") {
                alert("Oyat muvaffaqiyatli saqlandi!");
            }
        })
        .catch(err => console.error("Error saving ayah:", err));

    // Also save to localStorage for offline access/quick view
    let savedAyahs = JSON.parse(localStorage.getItem("savedAyahs") || "[]");
    const exists = savedAyahs.some(item => item.number === lastLoadedAyah.number);
    if (exists) {
        savedAyahs = savedAyahs.filter(item => item.number !== lastLoadedAyah.number);
    } else {
        savedAyahs.push(lastLoadedAyah);
    }
    localStorage.setItem("savedAyahs", JSON.stringify(savedAyahs));
    updateSavedButtonColor(lastLoadedAyah.number);
});


// --- SAQLANGAN OYATLAR MODALI ---
const savedAyahsContainer = document.getElementById('savedAyahsContainer');
const closeSavedBtn = document.getElementById('closeSaved');
const savedListBtn = document.getElementById('saved_list');

// Filter Dropdown elements
const filterDropdown = document.getElementById("filter-dropdown");
const filterTrigger = document.getElementById("filter-trigger");
const filterOptions = document.getElementById("filter-options");
let currentFilter = "surah-asc";

savedListBtn?.addEventListener('click', () => {
    if (savedAyahsContainer) {
        savedAyahsContainer.style.display = "flex";
        renderSavedAyahs();
    }
});
closeSavedBtn?.addEventListener('click', () => {
    if (savedAyahsContainer) savedAyahsContainer.style.display = "none";
});

function renderSavedAyahs() {
    const list = document.getElementById('savedAyahList');
    if (!list) return;

    let savedAyahs = JSON.parse(localStorage.getItem('savedAyahs') || "[]");

    switch (currentFilter) {
        case "surah-asc": savedAyahs.sort((a, b) => a.surah - b.surah); break;
        case "surah-desc": savedAyahs.sort((a, b) => b.surah - a.surah); break;
        case "ayah-asc": savedAyahs.sort((a, b) => a.verse - b.verse); break;
        case "ayah-desc": savedAyahs.sort((a, b) => b.verse - a.verse); break;
        case "recent-last": savedAyahs.reverse(); break;
    }

    list.innerHTML = "";
    if (savedAyahs.length === 0) {
        list.innerHTML = `<li style="text-align:center;color:#aaa;padding:40px;">Saqlangan oyatlar yo‘q.</li>`;
        return;
    }

    savedAyahs.forEach((item, idx) => {
        const surahName = surahNameMap[item.surah] || `Surah ${item.surah}`;
        const itemId = `saved-item-${idx}`;
        const contentId = `saved-content-${idx}`;

        const card = document.createElement("li");
        card.className = "saved-ayah-item";
        card.id = itemId;
        card.innerHTML = `
            <div class="item-header">
                <div class="surah-tag">
                    <i class="fa-solid fa-book-quran"></i> ${surahName} [ ${item.surah}:${item.verse} ]
                </div>
                <div class="item-actions">
                    ${item.sajda ? `<span class="sajda-icon-sm" title="Sajda oyati"><i class="fa-solid fa-mosque" style="color:#facc15;"></i></span>` : ""}
                    <button class="btn-action btn-expand" onclick="toggleSavedDetail('${contentId}')" title="Batafsil">
                        <i class="fa-solid fa-chevron-down"></i>
                    </button>
                    <button class="btn-action btn-remove" onclick="removeSavedAyah(${idx})" title="O‘chirish">
                        <i class="fa-solid fa-trash-can"></i>
                    </button>
                </div>
            </div>
            <div id="${contentId}" class="dropdown-ayah-content">
                ${item.ayahImage ? `<img src="${item.ayahImage}" alt="Oyat" class="saved-ayah-img">` : ""}
                <div class="ayah-text-preview">${item.text || ""}</div>
                ${item.audio ? `<audio controls class="card-audio"><source src="${item.audio}"></audio>` : ""}
            </div>
        `;
        list.appendChild(card);
    });
}

// Initialize Modal Filter Dropdown
function initFilterDropdown() {
    if (!filterTrigger) return;

    setupDropdown(filterDropdown, filterTrigger, filterOptions);

    filterOptions.querySelectorAll(".dropdown-option").forEach(option => {
        option.addEventListener("click", () => {
            currentFilter = option.getAttribute("data-value");
            filterTrigger.querySelector(".selected-text").textContent = option.textContent;

            // Mark selected
            filterOptions.querySelectorAll(".dropdown-option").forEach(opt => opt.classList.remove("selected"));
            option.classList.add("selected");

            renderSavedAyahs();
            closeAllDropdowns();
        });
    });
}

function toggleSavedDetail(id) {
    const el = document.getElementById(id);
    if (!el) return;
    const isVisible = el.style.display === "block";
    el.style.display = isVisible ? "none" : "block";

    // Rotate icon
    const btn = el.parentElement.querySelector(".btn-expand i");
    if (btn) btn.style.transform = isVisible ? "rotate(0deg)" : "rotate(180deg)";
}
window.toggleSavedDetail = toggleSavedDetail;

window.removeSavedAyah = function (idx) {
    let ayahs = JSON.parse(localStorage.getItem('savedAyahs') || "[]");
    ayahs.splice(idx, 1);
    localStorage.setItem('savedAyahs', JSON.stringify(ayahs));
    renderSavedAyahs();
    updateSavedButtonColor(currentAyah);
};

document.getElementById('removeAll')?.addEventListener('click', () => {
    if (confirm("Barcha saqlangan oyatlarni o‘chirilsinmi?")) {
        localStorage.removeItem('savedAyahs');
        renderSavedAyahs();
        updateSavedButtonColor(currentAyah);
    }
});


// --- SURAH INFO (Tooltips) ---
function fillSurahInfo() {
    if (!surahData.length) return;
    let total = 0, surah = 1;
    const counts = [7, 286, 200, 176, 120, 165, 206, 75, 129, 109, 123, 111, 43, 52, 99, 128, 111, 110, 98, 135, 112, 78, 118, 64, 77, 227, 93, 88, 69, 60, 34, 30, 73, 54, 45, 83, 182, 88, 75, 85, 54, 53, 89, 59, 37, 35, 38, 29, 18, 45, 60, 49, 62, 55, 78, 96, 29, 22, 24, 13, 14, 11, 11, 18, 12, 12, 30, 52, 52, 44, 28, 28, 20, 56, 40, 31, 50, 40, 46, 42, 29, 19, 36, 25, 22, 17, 19, 26, 30, 20, 15, 21, 11, 8, 8, 19, 5, 8, 8, 11, 11, 8, 3, 9, 5, 4, 7, 3, 6, 3, 5, 4, 5, 6];
    for (let i = 0; i < counts.length; i++) {
        if (currentAyah <= total + counts[i]) {
            surah = i + 1;
            break;
        }
        total += counts[i];
    }
    const surahObj = surahData.find(s => s.number === surah);
    const infoList = document.getElementById("surah-info-list");
    if (surahObj && infoList) {
        infoList.innerHTML = `
            <li><b>${surahObj.englishName} (${surahObj.englishNameTranslation})</b></li>
            <li>Sura: ${surahObj.number}, Oyatlar: ${surahObj.numberOfAyahs}</li>
            <li>Tur: ${surahObj.revelationType === "Meccan" ? "Makkiy" : "Madaniy"}</li>`;
    }
}

const infoIcon = document.querySelector(".info-icon");
if (infoIcon) {
    infoIcon.addEventListener("mouseenter", fillSurahInfo);
    infoIcon.addEventListener("click", fillSurahInfo);
}


// Start App
document.addEventListener("DOMContentLoaded", async () => {
    await initSurahDropdowns();
    initFilterDropdown(); // Initialize Saved Ayahs Filter
    await loadAyah(currentAyah);

    // Scroll Animatsiyasi
    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) entry.target.classList.add("show");
        });
    }, { threshold: 0.1 });
    document.querySelectorAll(".fade-up").forEach(el => observer.observe(el));
});






