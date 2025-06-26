<header class="fixed-header">
    <div class="navbar">
        <div class="logo">
            <a href="/">
                <img src="images/brandlogo/KalomUzLogoTransparent.png" alt="KalomUz Logo" />
                <span>KalomUz📖</span>
            </a>
        </div>
        <button class="hamburger" id="hamburger">&#9776;</button>
        <nav class="nav-links" id="nav-menu">
            <a href="/" class="active">Bosh Sahifa</a>
            <div class="dropdown">
                <button type="button" class="btn btn-ctgr btn-light dropdown-toggle" data-bs-toggle="dropdown">
                    Bo'limlar
                </button>
                <ul class="dropdown-menu">
{{--                    <li><h5 class="dropdown-header">Suralar</h5></li>--}}
{{--                    <li><a class="dropdown-item" href="/#about">Sayt haqida</a></li>--}}
{{--                    <li><a class="dropdown-item" href="/#services">Xizmatlar</a></li>--}}
                    <li><h5 class="dropdown-header">Oyatlar</h5></li>
                    <li><a class="dropdown-item" href="/sajda-oyatlari">Sajda Oyatlari</a></li>
                    <li><a class="dropdown-item" href="/quiz">Qur'an Quiz</a></li>
                </ul>
            </div>
            <a href="/#contact" class="btn-contact">ALOQA</a>
            @auth
                <div class="user-profile-dropdown" id="userProfileDropdown">
                    <div class="user-profile-name" id="userProfileBtn">
                        <i class="fa fa-user fa-regular"></i>
                        <span class="username font-bold text-blue-600">
                            {{ Auth::user()->name ?? '' }} {{ Auth::user()->last_name ?? '' }}
                        </span>
                        <i class="fa fa-chevron-down ml-1"></i>
                    </div>
                    <div class="profile-menu" id="profileMenu">
                        <a href="{{ route('profile') }}"><i class="fa fa-id-card mr-1"></i> Mening profilim</a>
                        <a href="#" onclick="document.getElementById('saved_list').click(); return false;">
                            <i class="fa fa-bookmark mr-1"></i> Saqlangan oyatlar
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


