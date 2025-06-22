// Quran Quiz - FULL JS CODE

document.addEventListener("DOMContentLoaded", function() {
    const quizTypeSelect = document.getElementById('quiz-type');
    const quizJuzPanel = document.getElementById('quiz-juz-panel');
    const quizJuzSelect = document.getElementById('quiz-juz');

// Juz panelini test turi asosida ko‘rsatish:
    function updateJuzPanel() {
        if (quizTypeSelect.value !== 'juz') {
            quizJuzPanel.style.display = '';
        } else {
            quizJuzPanel.style.display = 'none';
        }
    }
    quizTypeSelect.addEventListener('change', updateJuzPanel);
    updateJuzPanel(); // Sahifa yuklanganda

// ----------------------- GLOBAL STATE
    let username = "";
    let quizType = "translate";
    let quizCount = 5;
    let questions = [];
    let questionIndexes = [];
    let currentIdx = 0;
    let score = 0;
    let isAnswered = false;

    const ayahCount = 6236;

// DOM elements
    const startPanel = document.getElementById('start-panel');
    const quizBox = document.getElementById('quiz-box');
    const quizFinish = document.getElementById('quiz-finish');
    const answersDiv = document.getElementById('answers');
    const resultMessage = document.getElementById('result-message');
    const quizScore = document.getElementById('quiz-score');
    const quizProgress = document.getElementById('quiz-progress');
    const quizUser = document.getElementById('quiz-user');
    // const ayahImage = document.getElementById('ayah-image');
    const ayahArabic = document.getElementById('ayah-arabic');
    const ayahAudio = document.getElementById('ayah-audio');
    const quizQuestion = document.getElementById('quiz-question');

    const prevBtn = document.getElementById('prev-btn');
    const nextBtn = document.getElementById('next-btn');
    const helpBtn = document.getElementById('help-btn');
    const showAnswerBtn = document.getElementById('show-answer-btn');

// Boshlash
    document.getElementById('quiz-start-btn').onclick = async function() {
        username = document.getElementById('quiz-username').value.trim();
        quizType = document.getElementById('quiz-type').value;
        quizCount = parseInt(document.getElementById('quiz-count').value);
        // --- yangi kod:
        let juzValue = quizJuzSelect ? quizJuzSelect.value : 'all';

        if (!username) {
            alert("Iltimos, ismingizni kiriting!");
            return;
        }

        score = 0;
        currentIdx = 0;
        questions = [];
        // yangi: getUniqueIndexes() endi tanlangan juzni hisobga oladi
        questionIndexes = getUniqueIndexes(quizCount);

        startPanel.style.display = "none";
        quizFinish.style.display = "none";
        quizBox.style.display = "block";
        quizUser.textContent = username + " uchun";

        await loadQuestions();
        showQuestion(currentIdx);
    };


// Qayta boshlash
    document.getElementById('quiz-restart-btn').onclick = function() {
        quizFinish.style.display = "none";
        startPanel.style.display = "block";
    };

// Oldingi/Keyingi tugmalar
    prevBtn.onclick = function() {
        if (currentIdx > 0) {
            currentIdx--;
            showQuestion(currentIdx);
        }
    };
    nextBtn.onclick = function() {
        if (currentIdx < questions.length - 1) {
            currentIdx++;
            showQuestion(currentIdx);
        } else {
            finishQuiz();
        }
    };
// Yordam: 50/50
    helpBtn.onclick = function() {
        const q = questions[currentIdx];
        if (q.answered) return;
        let btns = answersDiv.querySelectorAll("button");
        let toDisable = [];
        for (let i = 0; i < btns.length; i++) {
            if (i !== q.correctOption && toDisable.length < 1) {
                toDisable.push(i);
            }
        }
        toDisable.forEach(i => {
            btns[i].disabled = true;
            btns[i].style.textDecoration = "line-through";
        });
        q.helpUsed = true; // flag
    };


// Javobni ko‘rsatish
    showAnswerBtn.onclick = function() {
        const q = questions[currentIdx];
        if (!q.answered) {
            if (!q.shownByShowAnswer) {
                if (score > 0) score--;
                quizScore.textContent = "Ball: " + score;
                q.shownByShowAnswer = true;
            }
        }
        selectAnswer(q.correctOption);
    };



// ----------------------- SAVOLLARNI YARATISH
    function getUniqueIndexes(count) {
        let indexes = new Set();
        let juzValue = quizJuzSelect ? quizJuzSelect.value : 'all';

        // Har bir Juz uchun oyat oraliqlari (alquran.cloud tartibi bo‘yicha)
        let juzRanges = [
            [1, 141], [142, 252], [253, 385], [386, 516], [517, 640], [641, 750], [751, 892], [893, 1041], [1042, 1200], [1201, 1326],
            [1327, 1481], [1482, 1648], [1649, 1802], [1803, 2064], [2065, 2214], [2215, 2483], [2484, 2624], [2625, 2786], [2787, 2937], [2938, 3214],
            [3215, 3385], [3386, 3563], [3564, 3725], [3726, 4086], [4087, 4264], [4265, 4510], [4511, 4705], [4706, 5105], [5106, 5242], [5243, 5672], [5673, 6236]
        ];
        let from = 1, to = 6236;
        if (juzValue === 'random') {
            let r = Math.floor(Math.random() * 30);
            [from, to] = juzRanges[r];
        } else if (juzValue === 'all') {
            from = 1; to = 6236;
        } else if (!isNaN(juzValue)) {
            [from, to] = juzRanges[parseInt(juzValue) - 1];
        }
        while (indexes.size < count) {
            let idx = Math.floor(Math.random() * (to - from + 1)) + from;
            indexes.add(idx);
        }
        return Array.from(indexes);
    }

// Savolni yuklash
    async function loadQuestions() {
        questions = [];
        for (let n of questionIndexes) {
            let q = await generateQuestion(n, quizType);
            questions.push(q);
        }
    }

// Savol tuzuvchi asosiy funksiya
    async function generateQuestion(num, type) {
        const main = await getAyah(num);

        // Faqat tarjima so'rovini oldindan chaqiramiz (surah va h.k. uchun)
        let surahNames = window._surahNames || null;
        if (!surahNames) {
            surahNames = await fetchSurahNames();
            window._surahNames = surahNames;
        }

        // Variantlarni tayyorlash
        let options = [], correctOption = 0, questionText = "";
        if (type === "translate") {
            // To'g'ri tarjima + 3 random tarjima
            options = [main.translation];
            while (options.length < 4) {
                let idx = Math.floor(Math.random() * ayahCount) + 1;
                let wrong = await getAyah(idx);
                if (options.includes(wrong.translation)) continue;
                options.push(wrong.translation);
            }
            shuffle(options);
            correctOption = options.indexOf(main.translation);
            questionText = "Quyidagi oyatning tarjimasini toping:";
        } else if (type === "surah") {
            // To'g'ri sura + 3 random sura nomi
            options = [main.surah.englishName];
            while (options.length < 4) {
                let idx = Math.floor(Math.random() * 114) + 1;
                let name = surahNames[idx];
                if (options.includes(name)) continue;
                options.push(name);
            }
            shuffle(options);
            correctOption = options.indexOf(main.surah.englishName);
            questionText = "Quyidagi oyat qaysi suraga tegishli?";
        } else if (type === "next") {
            // To'g'ri keyingi oyat matni + 3 random
            let keyingi = num < ayahCount ? await getAyah(num + 1) : null;
            options = [keyingi ? keyingi.text : "Oxirgi oyat"];
            while (options.length < 4) {
                let idx = Math.floor(Math.random() * ayahCount) + 1;
                let opt = await getAyah(idx);
                if (options.includes(opt.text)) continue;
                options.push(opt.text);
            }
            shuffle(options);
            correctOption = keyingi ? options.indexOf(keyingi.text) : 0;
            questionText = "Quyidagi oyatdan so‘ng keladigan oyatni tanlang:";
        } else if (type === "prev") {
            // To'g'ri oldingi oyat matni + 3 random
            let oldingi = num > 1 ? await getAyah(num - 1) : null;
            options = [oldingi ? oldingi.text : "Birinchi oyat"];
            while (options.length < 4) {
                let idx = Math.floor(Math.random() * ayahCount) + 1;
                let opt = await getAyah(idx);
                if (options.includes(opt.text)) continue;
                options.push(opt.text);
            }
            shuffle(options);
            correctOption = oldingi ? options.indexOf(oldingi.text) : 0;
            questionText = "Quyidagi oyatdan oldin kelgan oyatni tanlang:";
        } else if (type === "juz") {
            // To'g'ri Juz + 3 random Juz
            options = [main.juz];
            while (options.length < 4) {
                let idx = Math.floor(Math.random() * ayahCount) + 1;
                let opt = (await getAyah(idx)).juz;
                if (options.includes(opt)) continue;
                options.push(opt);
            }
            shuffle(options);
            correctOption = options.indexOf(main.juz);
            questionText = "Quyidagi oyat qaysi Juzga tegishli?";
        }

        return {
            ...main,
            options,
            correctOption,
            questionText,
            answered: false,
            correctGiven: false,
            helpUsed: false,
            wrongGiven: null, // index yoki null
            shownByShowAnswer: false
        };
    }

// API-dan oyat
    async function getAyah(num) {
        // Main info (arabic, surah, audio, juz)
        const resp = await fetch(`https://api.alquran.cloud/v1/ayah/${num}/ar.alafasy`);
        const data = await resp.json();
        if (data.status !== "OK") throw new Error("Ayah not found");
        const ayah = data.data;

        // Translation
        const transResp = await fetch("https://cdn.jsdelivr.net/gh/fawazahmed0/quran-api@1/editions/uzb-muhammadsodikmu.json");
        const transData = await transResp.json();
        const translated = transData.quran.find(item =>
            item.chapter === ayah.surah.number && item.verse === ayah.numberInSurah
        );

        // Ayah image
        // const imageUrl = `https://cdn.islamic.network/quran/images/high-resolution/${ayah.surah.number}_${ayah.numberInSurah}.png`;

        return {
            number: num,
            text: ayah.text,
            audio: ayah.audio,
            surah: ayah.surah,
            numberInSurah: ayah.numberInSurah,
            translation: translated ? translated.text : "Tarjima topilmadi.",
            juz: ayah.juz
        };
    }

// Surah names - EnglishName
    async function fetchSurahNames() {
        const resp = await fetch("https://api.alquran.cloud/v1/surah");
        const data = await resp.json();
        let names = {};
        data.data.forEach(s => names[s.number] = s.englishName);
        return names;
    }

// Shuffle helper
    function shuffle(arr) {
        for (let i = arr.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [arr[i], arr[j]] = [arr[j], arr[i]];
        }
    }

// ----------------------- SAVOL KO'RINISHI
    function showQuestion(idx) {
        const q = questions[idx];
        ayahArabic.textContent = q.text;
        ayahAudio.src = q.audio;
        quizQuestion.textContent = q.questionText;

        answersDiv.innerHTML = "";
        q.options.forEach((opt, i) => {
            const btn = document.createElement("button");
            btn.type = "button";
            btn.className = "btn btn-outline-dark mb-2";
            btn.style.width = "100%";
            btn.textContent = (quizType === "juz") ? "Juz " + opt : opt;
            btn.onclick = () => selectAnswer(i);

            // Noto‘g‘ri variant uchun danger
            if (q.wrongGiven !== null && q.wrongGiven === i) {
                btn.classList.add("btn-danger");
            }
            // To‘g‘ri variant uchun success
            if (q.answered && i === q.correctOption) {
                btn.classList.add("btn-success");
            }
            // Yordam ishlatilgan bo‘lsa, 50:50 qismlarini disable qilamiz
            if (q.helpUsed && q.answered === false && i !== q.correctOption) {
                btn.disabled = true;
                btn.style.opacity = 0.5;
            }
            // Yoki, savolga javob berilgan bo‘lsa, barcha tugmalarni block qilamiz
            if (q.answered) btn.disabled = true;

            answersDiv.appendChild(btn);
        });

        // Javob statusini ko‘rsatamiz
        if (q.answered) {
            if (q.correctGiven) {
                resultMessage.textContent = "To'g'ri javob! ✅";
            } else if (q.wrongGiven !== null) {
                resultMessage.textContent = "Noto‘g‘ri. To'g'ri javob: " +
                    (quizType === "juz" ? "Juz " + q.options[q.correctOption] : q.options[q.correctOption]);
            } else if (q.shownByShowAnswer) {
                resultMessage.textContent = "To‘g‘ri javob ko‘rsatildi";
            }
        } else {
            resultMessage.textContent = "";
        }

        quizScore.textContent = "Ball: " + score;
        quizProgress.textContent = (idx + 1) + " / " + questions.length;
        prevBtn.disabled = (idx === 0);
        nextBtn.textContent = (idx === questions.length - 1) ? "Yakunlash" : "Keyingi";
        helpBtn.disabled = !!q.answered;
    }



// Javobni belgilash va baholash
    function selectAnswer(idx) {
        const q = questions[currentIdx];
        if (q.answered) return;

        const btns = answersDiv.querySelectorAll("button");
        q.answered = true;

        // Ball faqat foydalanuvchi O‘ZI to‘g‘ri variantni bosganda (showAnswer emas) qo‘shiladi:
        if (idx === q.correctOption) {
            // btns[idx].classList.add("btn-success");
            btns[idx].style.color = "green";
            resultMessage.textContent = "To'g'ri javob! ✅";
            // Ball faqat agar q.shownByShowAnswer YO‘Q bo‘lsa va q.correctGiven YO‘Q bo‘lsa qo‘shiladi
            if (!q.correctGiven && !q.shownByShowAnswer) {
                score++;
                q.correctGiven = true;
                quizScore.textContent = "Ball: " + score;
            }
        } else {
            // btns[idx].classList.add("btn-danger");
            btns[idx].style.color = "red";
            // btns[q.correctOption].classList.add("btn-success");
            btns[q.correctOption].style.color = "green";
            let wrongMessage = "Noto‘g‘ri. "
            wrongMessage.style.color = "red"
            resultMessage.textContent = wrongMessage + "To'g'ri javob: " +
                (quizType === "juz" ? "Juz " + q.options[q.correctOption] : q.options[q.correctOption]);
            q.wrongGiven = idx; // noto'g'ri variantni eslab qolamiz
        }
        btns.forEach(b => b.disabled = true);
    }



// Test yakunlash
    function finishQuiz() {
        quizBox.style.display = "none";
        quizFinish.style.display = "block";
        document.getElementById('quiz-finish-msg').innerHTML =
            `<strong>${username}</strong>, sizning natijangiz: <b>${score} / ${questions.length}</b>`;
    }

});
