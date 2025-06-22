let surahNamesMap = {};

async function loadSurahNames() {
    try {
        const res = await fetch("https://api.alquran.cloud/v1/surah");
        const data = await res.json();
        if (data.status === "OK") {
            data.data.forEach(surah => {
                surahNamesMap[surah.number] = {
                    en: surah.englishName,
                    ar: surah.name
                };
            });
        }
    } catch (err) {
        console.error("Sura nomlarini olishda xatolik:", err);
    }
}

async function loadSajdaDropdown() {
    const tbody = document.querySelector("#sajda-table tbody");
    tbody.innerHTML = "<tr><td colspan='4'>Yuklanmoqda...</td></tr>";

    await loadSurahNames(); // Sura nomlari tayyor bo'lishi kerak

    try {
        const res = await fetch("https://api.alquran.cloud/v1/sajda/quran-uthmani");
        const data = await res.json();
        const ayahs = data.data.ayahs;

        const transRes = await fetch("https://cdn.jsdelivr.net/gh/fawazahmed0/quran-api@1/editions/uzb-muhammadsodikmu.json");
        const transData = await transRes.json();

        tbody.innerHTML = "";

        ayahs.forEach((ay, i) => {
            const sur = ay.surah.number;
            const aya = ay.numberInSurah;
            const found = transData.quran.find(it => it.chapter === sur && it.verse === aya);
            const text = found ? found.text : "Tarjima topilmadi.";
            const img = `https://cdn.islamic.network/quran/images/high-resolution/${sur}_${aya}.png`;

            const surahNameObj = surahNamesMap[sur];
            const surahDisplay = `${sur} - ${surahNameObj?.en || "Unknown"} (${surahNameObj?.ar || ""})`;

            const mainRow = document.createElement("tr");
            mainRow.innerHTML = `
                <td>${i + 1}</td>
                <td>${surahDisplay}</td>
                <td>${aya}</td>
                <td><button class="toggle-btn"><i class="fa-solid fa-chevron-down"></i></button></td>
            `;

            const detailRow = document.createElement("tr");
            detailRow.className = "detail-row";
            detailRow.innerHTML = `
        <td colspan="4">
          <div class="detail-content">
            <img src="${img}" alt="${sur}:${aya}" />
            <div class="detail-text">
              <p>${text}</p>
              <audio controls src="https://cdn.islamic.network/quran/audio/128/ar.alafasy/${ay.number}.mp3"></audio>
            </div>
          </div>
        </td>
      `;

            tbody.append(mainRow, detailRow);

            // ▼ Tugma — individual toggle
            const toggleBtn = mainRow.querySelector(".toggle-btn");
            const icon = toggleBtn.querySelector("i");

            mainRow.addEventListener("click", (e) => {
                // Agar boshqa joy bosilsa ham ishlasin
                const isInsideBtn = e.target.closest("button.toggle-btn");

                // Toggle faqat 1 marta ishlashi uchun (ikon yoki td)
                if (!isInsideBtn || e.target === toggleBtn || e.target === icon) {
                    const isActive = detailRow.classList.contains("active");
                    detailRow.classList.toggle("active", !isActive);
                    toggleBtn.classList.toggle("active", !isActive);
                }
            });

        });

        // ✅ Hammasini ochish / yopish tugmasi ishlashi
        const toggleAllBtn = document.getElementById("toggle-all");

        toggleAllBtn.addEventListener("click", () => {
            const isOpen = toggleAllBtn.classList.contains("active");
            const detailRows = document.querySelectorAll(".detail-row");
            const toggleBtns = document.querySelectorAll(".toggle-btn:not(#toggle-all)");

            detailRows.forEach(row => {
                row.classList.toggle("active", !isOpen);
            });

            toggleBtns.forEach(btn => {
                btn.classList.toggle("active", !isOpen);
            });

            toggleAllBtn.classList.toggle("active", !isOpen);
        });


    } catch (err) {
        tbody.innerHTML = `<tr><td colspan="4">Xatolik yuz berdi: ${err.message}</td></tr>`;
        console.error(err);
    }

}

window.addEventListener("DOMContentLoaded", loadSajdaDropdown);
