<!-- Saved Ayahs Modal -->
<div id="savedAyahsContainer" class="saved-ayahs-modal">
    <div class="modal-content">
        <button class="close-modal" id="closeSaved">&times;</button>
        <div class="filters">
            <div class="modal-title">
                <i class="fa-sharp fa-solid fa-heart-pulse title-icon"></i>
                <h3>Saqlangan Oyatlar</h3>
            </div>
            <div class="filter-controls">
                <!-- Custom Filter Dropdown -->
                <div class="custom-dropdown" id="filter-dropdown">
                    <div class="dropdown-trigger" id="filter-trigger">
                        <i class="fa-solid fa-filter icon-sm"></i>
                        <span class="selected-text">Saralash</span>
                        <i class="fa-solid fa-chevron-down"></i>
                    </div>
                    <div class="dropdown-options" id="filter-options">
                        <div class="dropdown-option" data-value="surah-asc">Sura raqami (o‘sish)</div>
                        <div class="dropdown-option" data-value="surah-desc">Sura raqami (kamayish)</div>
                        <div class="dropdown-option" data-value="recent-last">Oxirgi qo‘shilganlar</div>
                        <div class="dropdown-option" data-value="recent-first">Birinchi qo‘shilganlar</div>
                        <div class="dropdown-option" data-value="ayah-asc">Oyat raqami (o‘sish)</div>
                        <div class="dropdown-option" data-value="ayah-desc">Oyat raqami (kamayish)</div>
                    </div>
                </div>
                <button id="removeAll" class="btn-clear-all" title="Barchasini o'chirish">
                    <i class="fa-solid fa-trash-can"></i>
                </button>
            </div>
        </div>
        <div class="modal-content-scrolling">
            <ul id="savedAyahList"></ul>
        </div>
    </div>
</div>
