<!-- Saved Ayahs Modal -->
<div id="savedAyahsContainer" class="saved-ayahs-modal">
    <div class="modal-content">
        <button class="close-modal" id="closeSaved">&times;</button>
        <div class="filters">
            <h3>
                <i class="fa-sharp fa-solid fa-heart" style="color: red;"></i> Saqlangan oyatlar
            </h3>
            <div class="filter-btns">
                <select name="filter" id="filter">
                    <option value="surah-asc">Sura raqami (o‘sish)</option>
                    <option value="surah-desc">Sura raqami (kamayish)</option>
                    <option value="recent-last">Oxirgi qo‘shilganlar (yangi)</option>
                    <option value="recent-first">Birinchi qo‘shilganlar (eski)</option>
                    <option value="ayah-asc">Oyat raqami (o‘sish)</option>
                    <option value="ayah-desc">Oyat raqami (kamayish)</option>
                </select>
                <i id="removeAll" class="fa-solid fa-trash fa-xl" style="color: red; cursor: pointer;"></i>
            </div>
        </div>
        <div class="modal-content-scrolling">
            <ul id="savedAyahList"></ul>
        </div>
    </div>
</div>
