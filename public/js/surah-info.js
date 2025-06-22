function fillSurahInfo(surahNumber) {
    // surahData massivida sura ma’lumotini toping
    const surah = surahData.find(s => s.number === surahNumber);
    const surahInfoList = document.getElementById("surah-info-list");
    if (surah && surahInfoList) {
        surahInfoList.innerHTML = `
            <li><b>${surah.englishName} (${surah.englishNameTranslation})</b></li>
            <li>Sura raqami: ${surah.number}</li>
            <li>Oyatlar soni: ${surah.numberOfAyahs}</li>
            <li>Tur: ${surah.revelationType === "Meccan" ? "Makkiy" : "Madaniy"}</li>
        `;
    } else if (surahInfoList) {
        surahInfoList.innerHTML = `<li>Ma'lumot topilmadi</li>`;
    }
}

// Masalan, modalda sura har safar ochilganda yoki renderda:
const infoIcons = document.querySelectorAll('.info-icon');
infoIcons.forEach((icon, idx) => {
    icon.onmouseover = () => {
        const item = getSavedAyahs()[idx];
        fillSurahInfo(item.surah);
    };
});
