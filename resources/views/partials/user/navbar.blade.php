<header>
    <!-- Logo -->
    <img src="{{ $logoUrl }}" alt="Logo HMTI" class="logo">

    <nav>
        <ul>
            <li class="{{ request()->is('/') || request()->is('user/beranda') ? 'active' : '' }}"><a href="{{ route('user.beranda') }}">HOME</a></li>
            <li class="{{ request()->is('user/divisi*') ? 'active' : '' }}"><a href="{{ route('user.divisi') }}">DIVISI</a></li>
            <li class="{{ request()->routeIs('user.profil') ? 'active' : '' }}"><a href="{{ route('user.profil') }}">PROFIL</a></li>
            <li class="{{ request()->is('user/berita*') ? 'active' : '' }}"><a href="{{ route('user.berita') }}">BERITA</a></li>
            <li class="{{ request()->is('user/pendaftaran') ? 'active' : '' }}"><a href="{{ route('user.pendaftaran') }}">PENDAFTARAN</a></li>
            <li class="{{ request()->is('user/prestasi') ? 'active' : '' }}"><a href="{{ route('user.prestasi') }}">PRESTASI MAHASISWA</a></li>
            <li class="{{ request()->is('user/bermasalah') ? 'active' : '' }}"><a href="{{ route('user.bermasalah') }}">PENGADUAN</a></li>
            <li class="{{ request()->is('user/aspirasi') ? 'active' : '' }}"><a href="{{ route('user.aspirasi') }}">KOTAK ASPIRASI</a></li>
        </ul>
    </nav>

    @guest
        <a class="login-button" href="{{ route('login') }}">LOGIN</a>
    @endguest

    @auth
        <div class="dropdown">
            <button class="login-button dropdown-toggle" type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="display: flex; align-items: center; gap: 8px;">
                <img src="{{ Auth::user() ? Auth::user()->photo_url : asset('assets/image/profil.png') }}" alt="Avatar" style="width: 30px; height: 30px; border-radius: 50%;">
                <span>{{ Str::limit(Auth::user()->name, 10) }}</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                <li><a class="dropdown-item" href="{{ route('user.profil.edit') }}">Pengaturan Profil</a></li>
                @if(Auth::user()->role === 'admin' || Auth::user()->role === 'pengurus')
                <li><hr class="dropdown-divider"></li>
                @endif
                @if(Auth::user()->role === 'admin')
                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                @elseif(Auth::user()->role === 'pengurus')
                    <li><a class="dropdown-item" href="{{ route('pengurus.dashboard') }}">Dashboard</a></li>
                @endif
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}" onsubmit="return confirm('Apakah Anda yakin ingin keluar?');">
                        @csrf
                        <button type="submit" class="dropdown-item">Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    @endauth
</header>
