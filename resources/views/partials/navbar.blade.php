<header class="fixed-header">
    <div class="navbar">
        <div class="logo">
            <a href="/">
                <img src="images/brandlogo/KalomUzLogoTransparent.png" alt="KalomUz Logo" />
                <span>KalomUz📖</span>
            </a>
        </div>
        <button class="hamburger" id="hamburger">
            <i class="fa-solid fa-bars"></i>
        </button>
        <nav class="nav-links" id="nav-menu">
            <a href="/" class="{{ Request::is('/') ? 'active' : '' }}"><i class="fas fa-home me-1"></i> Bosh Sahifa</a>
            <a href="{{ route('quran.index') }}" class="{{ Request::is('surahs*') || Request::is('surah*') ? 'active' : '' }}"><i class="fas fa-book-quran me-1"></i> Suralar</a>
            <a href="{{ route('quran.sajda') }}" class="{{ Request::is('sajda-ayahs-list*') ? 'active' : '' }}"><i class="fas fa-star-and-crescent me-1"></i> Sajda Oyatlari</a>
            <a href="{{ route('prayer.index') }}" class="{{ Request::is('prayer-times*') ? 'active' : '' }}"><i class="fas fa-clock me-1"></i> Namoz Vaqtlari</a>
            <a href="{{ route('mosques.index') }}" class="{{ Request::is('mosques*') ? 'active' : '' }}"><i class="fas fa-mosque me-1"></i> Masjidlar</a>
            <a href="{{ route('contest.index') }}" class="{{ Request::is('contest*') ? 'active' : '' }}"><i class="fas fa-moon me-1"></i> Konkurs</a>
            <a href="{{ route('quran.quiz') }}" class="{{ Request::is('quiz*') ? 'active' : '' }}"><i class="fas fa-question-circle me-1"></i> Quiz</a>
            <a href="/#contact"><i class="fas fa-envelope me-1"></i> ALOQA</a>
            @auth
                @php
                    $unreadNotifications = Auth::user()->notifications()->whereNull('read_at')->count();
                    $unreadPeerMessages = \App\Models\Message::where('receiver_id', Auth::id())->where('is_read', false)->count();
                    $unreadAdminMessages = Auth::user()->userMessages()->whereNull('read_at')->count();
                    $totalUnread = $unreadNotifications + $unreadPeerMessages + $unreadAdminMessages;
                @endphp
                <div class="user-profile-dropdown" id="userProfileDropdown">
                    <div class="user-profile-name" id="userProfileBtn">
                        <i class="fa fa-user fa-regular"></i>
                        <span class="username font-bold text-blue-600">
                            {{ Auth::user()->name ?? '' }}
                        </span>
                        @if($totalUnread > 0)
                            <span class="badge rounded-pill bg-danger ms-1" style="font-size: 0.6rem;">{{ $totalUnread }}</span>
                        @endif
                        <i class="fa fa-chevron-down ml-1"></i>
                    </div>
                    <div class="profile-menu" id="profileMenu">
                        <a href="{{ route('profile') }}"><i class="fa fa-id-card mr-1"></i> Mening profilim</a>
                        
                        <a href="{{ route('saved.ayahs') }}">
                            <i class="fa fa-bookmark mr-1"></i> Saqlangan oyatlar
                        </a>

                        <a href="{{ route('notifications.index') }}" class="d-flex justify-content-between align-items-center">
                            <span><i class="fa fa-bell mr-1"></i> Bildirishnomalar</span>
                            @if($unreadNotifications > 0)
                                <span class="badge rounded-pill bg-warning text-dark">{{ $unreadNotifications }}</span>
                            @endif
                        </a>

                        <a href="{{ route('messages.index') }}" class="d-flex justify-content-between align-items-center">
                            <span><i class="fa fa-envelope mr-1"></i> Xabarlar</span>
                            @php $totalMsgUnread = $unreadPeerMessages + $unreadAdminMessages; @endphp
                            @if($totalMsgUnread > 0)
                                <span class="badge rounded-pill bg-info text-white">{{ $totalMsgUnread }}</span>
                            @endif
                        </a>

                        <hr>
                        <a href="#" class="logout-btn"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fa-solid fa-right-from-bracket mr-1"></i> Chiqish
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
            @else
                <a href="/login" class="btn-contact" title="Kirish">
                    <i class="fa fa-user fa-regular"></i>
                </a>
            @endauth


        </nav>
    </div>
</header>


