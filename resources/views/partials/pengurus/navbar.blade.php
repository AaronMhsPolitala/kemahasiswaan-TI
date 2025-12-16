{{-- resources/views/partials/pengurus/navbar.blade.php --}}
<header class="topbar">
  <div class="user-profile">
    <span>Hi, {{ Auth::user()->name ?? 'Pengurus' }}</span>
    <img src="{{ Auth::user() ? Auth::user()->photo_url : asset('assets/image/profil.png') }}" alt="User">
  </div>
</header>
