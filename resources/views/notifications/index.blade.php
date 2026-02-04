@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="d-flex justify-content-between align-items-center mb-5">
                <div>
                    <h1 class="display-4 fw-bold text-gradient mb-0">Bildirishnomalar</h1>
                    <p class="text-muted">Muhim yangiliklar va eslatmalar</p>
                </div>
            </div>

            @if($notifications->isEmpty())
                <div class="text-center py-5">
                    <div class="glass-morphism p-5 d-inline-block">
                        <i class="fas fa-bell-slash fa-4x text-muted mb-4 opacity-25"></i>
                        <h3 class="text-white">Hech qanday bildirishnoma yo'q</h3>
                        <p class="text-muted">Yangi bildirishnomalar shu yerda paydo bo'ladi.</p>
                    </div>
                </div>
            @else
                <div class="glass-morphism p-4">
                    <div class="list-group list-group-flush bg-transparent">
                        @foreach($notifications as $notification)
                            <div class="list-group-item bg-transparent border-light border-opacity-10 py-4 notification-item {{ $notification->read_at ? 'opacity-75' : 'unread' }}" data-id="{{ $notification->id }}">
                                <div class="d-flex">
                                    <div class="notification-icon me-4">
                                        @php
                                            $icon = 'info-circle';
                                            $color = 'info';
                                            if($notification->type == 'success') { $icon = 'check-circle'; $color = 'success'; }
                                            if($notification->type == 'warning') { $icon = 'exclamation-triangle'; $color = 'warning'; }
                                        @endphp
                                        <i class="fas fa-{{ $icon }} fa-2x text-{{ $color }}"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-start mb-1">
                                            <h5 class="text-white fw-bold mb-0">{{ $notification->title }}</h5>
                                            <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                        </div>
                                        <p class="text-muted mb-3">{{ $notification->message }}</p>
                                        @if($notification->link)
                                            <a href="{{ $notification->link }}" class="btn btn-outline-success btn-sm rounded-pill px-4">Batafsil</a>
                                        @endif
                                    </div>
                                    @if(!$notification->read_at)
                                        <div class="ms-3 align-self-center">
                                            <div class="bg-success rounded-circle" style="width: 12px; height: 12px;"></div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
.notification-item {
    transition: background 0.3s ease;
}
.notification-item.unread {
    background: rgba(46, 204, 113, 0.05);
}
.notification-item:hover {
    background: rgba(255, 255, 255, 0.02);
}
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.notification-item.unread').forEach(item => {
        item.addEventListener('mouseenter', function() {
            const id = this.dataset.id;
            fetch(`/notifications/${id}/read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'ok') {
                    this.classList.remove('unread');
                    this.classList.add('opacity-75');
                    const dot = this.querySelector('.bg-success.rounded-circle');
                    if(dot) dot.remove();
                }
            });
        }, { once: true });
    });
});
</script>
@endpush
@endsection
