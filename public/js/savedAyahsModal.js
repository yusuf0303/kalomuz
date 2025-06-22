// // --- MODAL OCHISH/YOPISH ---
// const savedAyahsContainer = document.getElementById('savedAyahsContainer');
// const closeSavedBtn = document.getElementById('closeSaved');
// const savedListBtn = document.getElementById('saved_list'); // Saqlanganlar ro‘yxatini ochish tugmasi
// alert("Working");
// savedListBtn.addEventListener('click', () => {
//     savedAyahsContainer.style.display = "flex";
//     renderSavedAyahs();
// });
// closeSavedBtn.addEventListener('click', () => {
//     savedAyahsContainer.style.display = "none";
// });
//
// // --- LOCAL STORAGE DAN SAQLANGAN OYATLARNI OQISH ---
// function getSavedAyahs() {
//     return JSON.parse(localStorage.getItem('savedAyahs') || "[]");
// }
//
// // --- SAQLANGAN OYATLARNI RENDER QILISH ---
// function renderSavedAyahs() {
//     const list = document.getElementById('savedAyahList');
//     const filter = document.getElementById('filter').value;
//     let savedAyahs = getSavedAyahs();
//
//     // SARALASH (filter) TURIGA QARAB
//     switch (filter) {
//         case "surah-asc": savedAyahs.sort((a, b) => a.surah - b.surah); break;
//         case "surah-desc": savedAyahs.sort((a, b) => b.surah - a.surah); break;
//         case "ayah-asc": savedAyahs.sort((a, b) => a.ayah - b.ayah); break;
//         case "ayah-desc": savedAyahs.sort((a, b) => b.ayah - a.ayah); break;
//         case "recent-last": savedAyahs.reverse(); break;
//         case "recent-first": /* Tashlab ketamiz (default) */ break;
//     }
//
//     list.innerHTML = "";
//     if (savedAyahs.length === 0) {
//         list.innerHTML = `<li style="text-align:center;color:#aaa">Saqlangan oyatlar yo‘q.</li>`;
//         return;
//     }
//     savedAyahs.forEach((item, idx) => {
//         list.innerHTML += `
//             <li>
//                 <strong>${item.surah}:${item.ayah}</strong>
//                 <p style="margin:0.2em 0;">${item.text || ''}</p>
//                 <!-- Info icon va tooltip -->
//                 <div class="info-container">
//                     <i class="fa-solid fa-circle-info info-icon"></i>
//                     <div class="info-tooltip">
//                         <ul id="surah-info-list">
//                             <li>Loading...</li>
//                         </ul>
//                     </div>
//                 </div>
//                 <button class="remove" onclick="removeSavedAyah(${idx})">
//                     <i class="fa-solid fa-trash"></i>
//                 </button>
//             </li>
//         `;
//     });
// }
//
// // --- BARCHASINI O‘CHIRISH ---
// document.getElementById('removeAll').onclick = function () {
//     if (confirm("Barcha saqlangan oyatlarni o‘chirilsinmi?")) {
//         localStorage.removeItem('savedAyahs');
//         renderSavedAyahs();
//     }
// }
//
// // --- BITTA OYATNI O‘CHIRISH ---
// function removeSavedAyah(idx) {
//     let ayahs = getSavedAyahs();
//     ayahs.splice(idx, 1);
//     localStorage.setItem('savedAyahs', JSON.stringify(ayahs));
//     renderSavedAyahs();
// }
//
// // --- FILTER O‘ZGARGANDA QAYTA RENDER ---
// document.getElementById('filter').onchange = renderSavedAyahs;
