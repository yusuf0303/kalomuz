{{--@if(Auth::guest())--}}
{{--    <script>window.location = "{{ route('login') }}";</script>--}}
{{--@endif--}}

<div class="container sajda-container mt-3">
    <div class="section-header">
        <h2 class="section-title">📿 Sajda Oyatlari Ro'yxati</h2>
        <p class="section-subtitle">
            Qur'oni Karimda 15 ta sajda oyati mavjud bo‘lib, ularni o‘qigan yoki eshitgan paytda sajda qilish vojib hisoblanadi.
            Quyida ushbu oyatlarning tarjimasi, rasmiy ko‘rinishi va tilovati bilan tanishishingiz mumkin.
        </p>
        <small style="color: #999; font-style: italic;">
            *Eslatma: Sajda oyatlarini o‘qigan yoki eshitgan paytda sajda qilish vojibdir, farz emas.*
        </small>
    </div>
    <div class="table-wrapper">
        <table id="sajda-table" class="table table-striped table-dark table-hover">
            <thead>
            <tr>
                <th>№</th>
                <th>Sura</th>
                <th>Oyat</th>
                <th>
                    <button id="toggle-all" class="toggle-btn">
                        <i class="fa-solid fa-chevron-down"></i>
                    </button>
                </th>
            </tr>
            </thead>
            <tbody>
            <!-- JS orqali satrlar to‘ldiriladi -->
            </tbody>
        </table>
    </div>

</div>
