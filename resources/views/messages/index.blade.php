@extends('layouts.app')

@section('content')
<div class="container py-5 mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="d-flex justify-content-between align-items-center mb-5 flex-wrap gap-4">
                <div>
                    <h1 class="display-4 fw-bold text-gradient mb-0">Xabarlar</h1>
                    <p class="text-muted">Foydalanuvchilar bilan suhbatlashing</p>
                </div>
                <div class="search-user position-relative flex-grow-1" style="max-width: 400px;">
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0 text-muted" style="border: 1px solid rgba(255,255,255,0.1); border-radius: 20px 0 0 20px;">@</span>
                        <input type="text" id="userSearchInput" class="form-control glass-input" placeholder="Ism yoki username orqali qidirish..." style="border-top-left-radius: 0; border-bottom-left-radius: 0; border-top-right-radius: 20px; border-bottom-right-radius: 20px; width: 300px;">
                    </div>
                    <!-- Real-time results dropdown -->
                    <div id="searchResults" class="glass-morphism position-absolute w-100 mt-2 d-none shadow-lg" style="z-index: 1000; max-height: 300px; overflow-y: auto;">
                        <!-- Results will be injected here -->
                    </div>
                </div>
            </div>

            @if(session('error'))
                <div class="alert alert-danger border-0 bg-danger bg-opacity-10 text-danger mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <div class="chat-list">
                @forelse($chats as $chatUser)
                    <a href="{{ route('messages.chat', $chatUser->id) }}" class="chat-item-link text-decoration-none">
                        <div class="glass-morphism p-3 mb-3 transition-up d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-3">
                                <div class="chat-avatar rounded-circle bg-success-gradient d-flex align-items-center justify-content-center text-white fw-bold" style="width: 50px; height: 50px;">
                                    {{ strtoupper(substr($chatUser->name, 0, 1)) }}
                                </div>
                                <div>
                                    <h5 class="text-white mb-0">{{ $chatUser->name }}</h5>
                                    <small class="text-muted">@ {{ $chatUser->username ?? 'foydalanuvchi' }}</small>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                @if(isset($chatUser->unread_count) && $chatUser->unread_count > 0)
                                    <span class="badge bg-success rounded-pill px-2">{{ $chatUser->unread_count }}</span>
                                @endif
                                <i class="fas fa-chevron-right text-muted opacity-50"></i>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="text-center py-5">
                        <div class="glass-morphism p-5 d-inline-block">
                            <i class="fas fa-comments fa-4x text-muted mb-4 opacity-25"></i>
                            <h3 class="text-white">Suhbatlar hali mavjud emas</h3>
                            <p class="text-muted">Yuqoridagi qidiruv orqali foydalanuvchilarni toping va suhbatni boshlang.</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('userSearchInput');
    const searchResults = document.getElementById('searchResults');
    let timeout = null;

    searchInput.addEventListener('input', function() {
        clearTimeout(timeout);
        const query = searchInput.value.trim();

        if (query.length < 2) {
            searchResults.classList.add('d-none');
            return;
        }

        timeout = setTimeout(() => {
            fetch(`{{ route('messages.live-search') }}?query=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(users => {
                    if (users.length > 0) {
                        searchResults.innerHTML = users.map(user => `
                            <a href="/messages/chat/${user.id}" class="d-block p-3 text-white text-decoration-none border-bottom border-light border-opacity-10 hover-bg">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded-circle bg-success-gradient d-flex align-items-center justify-content-center" style="width: 35px; height: 35px; font-size: 0.8rem;">
                                        ${user.name.charAt(0).toUpperCase()}
                                    </div>
                                    <div>
                                        <div class="fw-bold">${user.name}</div>
                                        <small class="text-muted">@ ${user.username || 'foydalanuvchi'}</small>
                                    </div>
                                </div>
                            </a>
                        `).join('');
                        searchResults.classList.remove('d-none');
                    } else {
                        searchResults.innerHTML = '<div class="p-4 text-center text-muted">Foydalanuvchi topilmadi</div>';
                        searchResults.classList.remove('d-none');
                    }
                });
        }, 300);
    });

    // Close results when clicking outside
    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
            searchResults.classList.add('d-none');
        }
    });
});
</script>

<style>
.hover-bg:hover {
    background: rgba(46, 204, 113, 0.1);
}
/* ... existing styles ... */

.bg-success-gradient {
    background: linear-gradient(135deg, #2ecc71 0%, #27ae60 100%);
}

.glass-input {
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.1);
    color: white;
    padding: 10px 15px;
}

.glass-input:focus {
    background: rgba(255, 255, 255, 0.08);
    border-color: #2ecc71;
    color: white;
    box-shadow: none;
}
</style>
@endpush
