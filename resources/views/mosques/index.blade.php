@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<div class="container py-5">
    <div class="row mb-5">
        <div class="col-lg-8 mx-auto text-center">
            <h1 class="display-4 fw-bold text-gradient mb-3">Masjidlar</h1>
            <p class="text-muted mb-4">O'zbekistondagi barcha masjidlar ma'lumotlari va joylashuvi</p>
            
            <form action="{{ route('mosques.index') }}" method="GET" class="row g-2 justify-content-center">
                <div class="col-md-4">
                    <select name="province_id" class="form-select glass-morphism border-0 p-3" onchange="this.form.submit()">
                        <option value="">Viloyatni tanlang</option>
                        @foreach($provinces as $p)
                            <option value="{{ $p['id'] }}" {{ $provinceId == $p['id'] ? 'selected' : '' }}>{{ $p['name'] }}</option>
                        @endforeach
                    </select>
                </div>
                @if(!empty($districts))
                <div class="col-md-4">
                    <select name="district_id" class="form-select glass-morphism border-0 p-3" onchange="this.form.submit()">
                        <option value="">Tumanni tanlang</option>
                        @foreach($districts as $d)
                            <option value="{{ $d['id'] }}" {{ $districtId == $d['id'] ? 'selected' : '' }}>{{ $d['name'] }}</option>
                        @endforeach
                    </select>
                </div>
                @endif
            </form>
        </div>
    </div>

    <div class="row g-4">
        <!-- Mosque List -->
        <div class="col-lg-4">
            <div class="glass-morphism p-3 mosque-list-container" style="max-height: 600px; overflow-y: auto;">
                <h5 class="text-white mb-3 px-2">Masjidlar ro'yxati</h5>
                @forelse($mosques as $mosque)
                <div class="mosque-item p-3 mb-2 rounded-3 transition-up cursor-pointer" 
                     onclick="focusMosque({{ $mosque['latitude'] }}, {{ $mosque['longitude'] }}, '{{ addslashes($mosque['name']) }}')">
                    <div class="d-flex align-items-center gap-3">
                        <div class="mosque-icon bg-success bg-opacity-20 p-2 rounded-circle">
                            <i class="fas fa-mosque text-success"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 text-white">{{ $mosque['name'] }}</h6>
                            <small class="text-muted">Masjid ma'lumoti</small>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-5 text-muted">
                    <i class="fas fa-search fa-3x mb-3 opacity-25"></i>
                    <p>Tumanni tanlang yoki qidirishni boshlang</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Map -->
        <div class="col-lg-8">
            <div id="mosque-map" class="glass-morphism" style="height: 600px; border-radius: 25px; overflow: hidden;"></div>
        </div>
    </div>
</div>

<style>
/* Mosque Selector & Select Styles */
.form-select.glass-morphism {
    background-color: rgba(255, 255, 255, 0.08) !important;
    color: #fff !important;
    border: 1px solid rgba(255, 255, 255, 0.1) !important;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23ffffff' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e") !important;
    cursor: pointer;
}

.form-select.glass-morphism option {
    background-color: #1a1a1a;
    color: #fff;
}

.form-select.glass-morphism:focus {
    box-shadow: 0 0 0 0.25rem rgba(46, 204, 113, 0.25);
    border-color: #2ecc71 !important;
}

.mosque-item {
    background: rgba(255, 255, 255, 0.03);
    border: 1px solid rgba(255, 255, 255, 0.05);
}

.mosque-item:hover {
    background: rgba(46, 204, 113, 0.1);
    border-color: #2ecc71;
}

.cursor-pointer {
    cursor: pointer;
}

.mosque-list-container::-webkit-scrollbar {
    width: 6px;
}

.mosque-list-container::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 10px;
}
</style>

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
let map;
let markers = [];

document.addEventListener('DOMContentLoaded', function() {
    map = L.map('mosque-map').setView([41.311081, 69.240562], 6); // Uzbekistan center

    L.tileLayer('https://{s}.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    const mosques = @json($mosques);
    if (mosques.length > 0) {
        let group = L.featureGroup();
        mosques.forEach(m => {
            if (m.latitude && m.longitude) {
                const marker = L.marker([m.latitude, m.longitude])
                    .bindPopup(`<strong>${m.name}</strong>`)
                    .addTo(map);
                group.addLayer(marker);
                markers.push({lat: m.latitude, lon: m.longitude, marker: marker});
            }
        });
        map.fitBounds(group.getBounds());
    }
});

function focusMosque(lat, lon, name) {
    map.setView([lat, lon], 16);
    markers.find(m => m.lat == lat && m.lon == lon).marker.openPopup();
}
</script>
@endpush
@endsection
