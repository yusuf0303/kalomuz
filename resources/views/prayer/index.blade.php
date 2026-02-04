@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row mb-5">
        <div class="col-lg-8 mx-auto text-center">
            <h1 class="display-4 fw-bold text-gradient mb-3">Namoz Vaqtlari</h1>
            <p class="text-muted mb-4">Butun O'zbekiston bo'ylab aniq namoz vaqtlari</p>
            
            <form action="{{ route('prayer.region') }}" method="POST" class="d-flex justify-content-center gap-2">
                @csrf
                <select name="region" class="form-select glass-morphism w-auto border-0" onchange="this.form.submit()">
                    @foreach($regions as $r)
                        <option value="{{ $r }}" {{ $region == $r ? 'selected' : '' }}>{{ $r }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-success rounded-pill px-4">O'zgartirish</button>
            </form>
        </div>
    </div>

    @if($dayData && isset($dayData['times']))
    <!-- Bugungi Vaqtlar -->
    <div class="row g-4 mb-5">
        @php
            $times = [
                ['name' => 'Bomdod', 'time' => $dayData['times']['tong_saharlik'] ?? '--:--', 'icon' => 'fa-sun', 'bg' => 'linear-gradient(135deg, #1e3c72 0%, #2a5298 100%)'],
                ['name' => 'Quyosh', 'time' => $dayData['times']['quyosh'] ?? '--:--', 'icon' => 'fa-sun', 'bg' => 'linear-gradient(135deg, #fceeb5 0%, #f9d423 100%)'],
                ['name' => 'Peshin', 'time' => $dayData['times']['peshin'] ?? '--:--', 'icon' => 'fa-sun', 'bg' => 'linear-gradient(135deg, #f2994a 0%, #f2c94c 100%)'],
                ['name' => 'Asr', 'time' => $dayData['times']['asr'] ?? '--:--', 'icon' => 'fa-cloud-sun', 'bg' => 'linear-gradient(135deg, #4facfe 0%, #00f2fe 100%)'],
                ['name' => 'Shom', 'time' => $dayData['times']['shom_iftor'] ?? '--:--', 'icon' => 'fa-moon', 'bg' => 'linear-gradient(135deg, #6a11cb 0%, #2575fc 100%)'],
                ['name' => 'Xufton', 'time' => $dayData['times']['hufton'] ?? '--:--', 'icon' => 'fa-moon', 'bg' => 'linear-gradient(135deg, #0f2027 0%, #203a43 50%, #2c5364 100%)']
            ];
        @endphp

        @foreach($times as $time)
        <div class="col-6 col-md-4 col-lg-2">
            <div class="prayer-time-card glass-morphism p-3 text-center transition-up h-100" style="background: {{ $time['bg'] }}1a; border-top: 3px solid {{ $time['bg'] }}">
                <div class="mb-2" style="color: {{ $time['bg'] }}">
                    <i class="fas {{ $time['icon'] }} fa-2x"></i>
                </div>
                <h6 class="fw-bold mb-1 text-white">{{ $time['name'] }}</h6>
                <div class="h3 fw-bold text-white mb-0">{{ $time['time'] }}</div>
            </div>
        </div>
        @endforeach
    </div>

    @if(!empty($weekData))
    <!-- Haftalik Vaqtlar -->
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <div class="glass-morphism p-4">
                <h4 class="fw-bold text-white mb-4"><i class="fas fa-calendar-alt me-2"></i> Haftalik Taquim</h4>
                <div class="table-responsive">
                    <table class="table table-dark table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Sana</th>
                                <th>Kun</th>
                                <th>Bomdod</th>
                                <th>Peshin</th>
                                <th>Asr</th>
                                <th>Shom</th>
                                <th>Xufton</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($weekData as $day)
                            <tr>
                                <td>{{ $day['date'] ?? '-' }}</td>
                                <td>{{ $day['weekday'] ?? '-' }}</td>
                                <td>{{ $day['times']['tong_saharlik'] ?? '--:--' }}</td>
                                <td>{{ $day['times']['peshin'] ?? '--:--' }}</td>
                                <td>{{ $day['times']['asr'] ?? '--:--' }}</td>
                                <td>{{ $day['times']['shom_iftor'] ?? '--:--' }}</td>
                                <td>{{ $day['times']['hufton'] ?? '--:--' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif
    @else
    <div class="text-center py-5">
        <div class="glass-morphism p-5 d-inline-block">
            <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
            <h4 class="text-white">Ma'lumot topilmadi</h4>
            <p class="text-muted">Hozirda namoz vaqtlarini olishda muammo yuzaga keldi. Iltimos keyinroq urinib ko'ring.</p>
        </div>
    </div>
    @endif
</div>

<style>
.prayer-time-card {
    border-radius: 15px;
}

.table-dark {
    background: transparent;
}

.table-dark th {
    background: rgba(255, 255, 255, 0.05);
    border-color: rgba(255, 255, 255, 0.1);
}

.table-dark td {
    background: transparent;
    border-color: rgba(255, 255, 255, 0.05);
}

.glass-morphism select option {
    background: #222;
    color: white;
}
</style>
@endsection
